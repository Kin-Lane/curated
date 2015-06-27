<?php
$route = '/curated/:curated_id/';	
$app->delete($route, function ($curated_id) use ($app){
	
   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);

	$Add = 1;
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	

	$query = "DELETE FROM curated WHERE Curated_ID = '" . $curated_id . "'";
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());	

	});
?>