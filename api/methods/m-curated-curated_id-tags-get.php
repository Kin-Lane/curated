<?php
$route = '/curated/:curated_id/tags/';
$app->get($route, function ($curated_id)  use ($app){

   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);

	$ReturnObject = array();
		
	$Query = "SELECT t.Tag_ID, t.Tag, count(*) AS Curated_Count from tags t";
	$Query .= " JOIN curated_tag_pivot ctp ON t.Tag_ID = ctp.Tag_ID";
	$Query .= " WHERE ctp.Curated_ID = " . $curated_id;
	$Query .= " GROUP BY t.Tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['Tag_ID'];
		$tag = $Database['Tag'];
		$curated_count = $Database['Curated_Count'];

		$curated_id = prepareIdOut($curated_id,$host);
		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['curated_id'] = $curated_id;
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['curated_count'] = $curated_count;
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>