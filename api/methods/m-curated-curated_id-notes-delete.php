<?php																							
$route = '/curated/:curated_id/notes/:note_id';
$app->delete($route, function ($Curated_ID,$Note_ID)  use ($app){


	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	

	$DeleteQuery = "DELETE FROM curated_note WHERE ID = " . trim($Note_ID) . " AND Curated_ID = " . trim($Curated_ID);
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$F = array();
	$F['note_id'] = $Note_ID;
	$F['type'] = '';
	$F['note'] = '';
	
	array_push($ReturnObject, $F);	

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	
	});			
?>