<?php
$route = '/curated/tags/byweek/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	
	
 	$request = $app->request(); 
 	$params = $request->params();	

	if(isset($_REQUEST['week'])){ $week = $params['week']; } else { $week = date('W'); }
	if(isset($_REQUEST['year'])){ $year = $params['year']; } else { $year = date('Y'); }	

	$Query = "SELECT t.Tag_ID, t.Tag, count(*) AS Curated_Count from tags t";
	$Query .= " JOIN curated_tag_pivot ctp ON t.Tag_ID = ctp.Tag_ID";
	$Query .= " JOIN curated c ON ctp.Curated_ID = c.Curated_ID";
	$Query .= " WHERE WEEK(c.Item_Date) = " . $week . " AND YEAR(c.Item_Date) = " . $year . " AND Tag <> ''";
	$Query .= " GROUP BY t.Tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['Tag_ID'];
		$tag = $Database['Tag'];
		$curated_count = $Database['Curated_Count'];

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['curated_count'] = $curated_count;
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>