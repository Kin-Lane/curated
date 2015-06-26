<?php
$route = '/curated/:curated_id/';	
$app->delete($route, function ($curated_id) use ($app){
	
	$Add = 1;
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	

	$query = "DELETE FROM blog WHERE slug = '" . $curated_id . "'";
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());	

	});
?>