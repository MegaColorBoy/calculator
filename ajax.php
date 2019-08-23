<?php
function fact($x) {
    $factvar = 1;
    for ($i = 1; $i <= $x; $i++) {
        $factvar *= $i;
    }
    return $factvar;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	extract($_POST);

	if($action == "calculateResult")
	{
		eval('echo ' . $expr. ';');
	}
}
?>