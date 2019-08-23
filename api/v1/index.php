<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require_once('../includes/db_connect.php');
require_once('../includes/db_handler.php');

$db = new DB_CONNECT();
$conn = $db->connect();
$db_handler = new DB_HANDLER($conn);

//Factorial
function fact($x) {
    $factvar = 1;
    for ($i = 1; $i <= $x; $i++) {
        $factvar *= $i;
    }
    return $factvar;
}

$app = new \Slim\App;

//Base URL
$app->get('/', function(Request $request, Response $response, array $args){
	$response = json_encode("Programmer's Calculator v1.0", JSON_PRETTY_PRINT);
	echo $response;
});

$app->get("/calculate", function(Request $request, Response $response, array $args){
	echo "Math expression not found.";
});

//Get math result
$app->get("/calculate/{expr}", function(Request $request, Response $response, array $args){
	global $db_handler;
	$db_handler->create_log($args['expr']);
	eval('$mathResult= ' . $args['expr']. ';');
	echo $db_handler->response_code(200, $mathResult);
});

//Get logs - daily
$app->get("/logs/today", function(Request $request, Response $response, array $args){
	global $db_handler;
	echo $db_handler->fetch_logs("today");
});

//Get logs - weekly
$app->get("/logs/week", function(Request $request, Response $response, array $args){
	global $db_handler;
	echo $db_handler->fetch_logs("week");
});

//Get logs - monthly
$app->get("/logs/month/{monthname}", function(Request $request, Response $response, array $args){
	global $db_handler;
	echo $db_handler->fetch_logs("month", $args['monthname']);
});

$app->run();
?>