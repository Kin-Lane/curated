<?php
$route = '/curated/:curated_id/tags/';
$app->post($route, function ($curated_id)  use ($app){

   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);

	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($param['tag']))
		{
		$tag = trim(mysql_real_escape_string($param['tag']));
			
		$CheckTagQuery = "SELECT Tag_ID FROM tags where Tag = '" . $tag . "'";
		$CheckTagResults = mysql_query($CheckTagQuery) or die('Query failed: ' . mysql_error());		
		if($CheckTagResults && mysql_num_rows($CheckTagResults))
			{
			$Tag = mysql_fetch_assoc($CheckTagResults);		
			$Tag_ID = $Tag['Tag_ID'];
			}
		else
			{

			$query = "INSERT INTO tags(Tag) VALUES('" . trim($_POST['Tag']) . "'); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());	
			$tag_id = mysql_insert_id();			
			}

		$CheckTagPivotQuery = "SELECT * FROM curated_tag_pivot where Tag_ID = " . trim($tag_id) . " AND Curated_ID = " . trim($curated_id);
		$CheckTagPivotResult = mysql_query($CheckTagPivotQuery) or die('Query failed: ' . mysql_error());
		
		if($CheckTagPivotResult && mysql_num_rows($CheckTagPivotResult))
			{
			$CheckTagPivot = mysql_fetch_assoc($CheckTagPivotResult);		
			}
		else
			{
			$query = "INSERT INTO curated_tag_pivot(Tag_ID,Curated_ID) VALUES(" . $tag_id . "," . $curated_id . "); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());					
			}

		$curated_id = prepareIdOut($curated_id,$host);
		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $curated_id;
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['curated_count'] = 0;
		
		array_push($ReturnObject, $F);

		}		

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>