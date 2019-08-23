<?php
class DB_HANDLER
{
	//Connection
	private $conn;

	//Constructor
	function __construct($conn)
	{
		$this->conn = $conn;
	}

	//Reference values
	function refValues($arr)
	{
		if(strnatcmp(phpversion(),'5.3') >= 0)
		{
			$refs = array();
			foreach($arr as $key => $value)
				$refs[$key] = &$arr[$key];
			return $refs;
		}
		return $arr;
	}

	//Prepared statement
	function preparedStatement($type, $query, $params)
	{
		//Add
		if($type == "add")
		{
			$stmt = $this->conn->prepare($query);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$result = $stmt->execute();
			$stmt->close();
			return $result;
		}

		//Edit/Delete
		if($type == "edit/delete")
		{
			$stmt = $this->conn->prepare($query);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$rc = $stmt->execute();
			if ( false===$rc ) {
			  die('execute() failed: ' . htmlspecialchars($stmt->error));
			}
			$num_affected_rows = $stmt->affected_rows;
			$stmt->close();
			return $num_affected_rows > 0;
		}

		//Check
		if($type == "check")
		{
			$stmt = $this->conn->prepare($query);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$rc = $stmt->execute();
			if ( false===$rc ) {
			  die('execute() failed: ' . htmlspecialchars($stmt->error));
			}
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
			$stmt->close();
			return $num_rows > 0;
		}

		//Get
		if($type == "get")
		{
			include_once('utility.php');
			$utility_handler = new UTILITY();

			$stmt = $this->conn->prepare($query);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

			if($stmt->execute())
			{
				$arr = array();
				$row = $utility_handler->bind_result_array($stmt);

				if(!$stmt->error)
				{
					$counter = 0;
					while($stmt->fetch())
					{
						$arr[$counter] = $utility_handler->getCopy($row);
						$counter++;
					}
				}
				$stmt->close();
				return $arr;
			}
			else
			{
				return NULL;
			}
		}
	}

	//Get Custom columns
	function get_cust_cols($query)
	{
		include_once('utility.php');
		$utility_handler = new UTILITY();

		$arr = array();
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$row = $utility_handler->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$arr[$counter] = $utility_handler->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $arr;
	}

	//get id of row
	public function get_id_of_table($table_name, $table_pk, $table_param, $string2search)
	{
		include_once('utility.php');
		$utility_handler = new UTILITY();

		$query = "SELECT " . $table_pk . " FROM " . $table_name . " WHERE " . $table_param . " = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("s", $string2search);

		if($stmt->execute())
		{
			$bp_id = array();
			$row = $utility_handler->bind_result_array($stmt);
			if(!$stmt->error)
			{
				$counter = 0;
				while($stmt->fetch())
				{
					$id[$counter] = $utility_handler->getCopy($row);
					$counter++;
				}
			}
			$stmt->close();
			return $id;
		}
		else
		{
			return NULL;
		}
	}

	public function create_log($log)
	{
		$query = "INSERT INTO calculator_logs (expression) VALUES (?)";
		$params = array("s", $log);
		return $this->preparedStatement("add", $query, $params);
	}

	public function fetch_logs($type, $extra="")
	{
		switch($type)
		{
			case "today":
				$query = "SELECT * FROM calculator_logs WHERE DATE(created_at) = CURDATE()";
				break;

			case "week":
				$query = "SELECT * FROM calculator_logs WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
				break;

			case "month":
				$query = "SELECT * FROM calculator_logs WHERE MONTHNAME(created_at) = ?";
				$params = array("s", $extra);
				break;
		}

		if($type != "month")
		{
			$result = $this->get_cust_cols($query);
		}
		else
		{
			$result = $this->preparedStatement("get", $query, $params);
		}

		return $this->response_code(200, $result);
	}

	//HTTP Error messages
	public function response_code($code, $result="")
	{
		$response['HTTP Status'] = $code;

		switch($code)
		{
			case 200:
				$response['Message'] = "OK";
				break;

			case 201:
				$response['Message'] = "Created";
				break;

			case 204:
				$response['Message'] = "No Content";
				break;

			case 304:
				$response['Message'] = "Not Modified";
				break;

			case 400:
				$response['Message'] = "Bad Request";
				break;

			case 401:
				$response['Message'] = "Unauthorized";
				break;

			case 403:
				$response['Message'] = "Forbidden";
				break;

			case 404:
				$response['Message'] = "Not Found";
				break;

			case 409:
				$response['Message'] = "Conflict";
				break;

			case 410:
				$response['Message'] = "Gone";
				break;

			case 500:
				$response['Message'] = "Internal Server Error";
				break;

			case 503:
				$response['Message'] = "Service Unavailable";
				break;

			default:
				return "Nothing";
				break;
		}

		if($result != "") {
			$response['Result'] = $result;
		}

		return json_encode($response, JSON_PRETTY_PRINT);
	}
}
?>