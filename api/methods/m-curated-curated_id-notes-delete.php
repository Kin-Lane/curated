<?php																							
$route = '/curated/:curated_id/notes/:note_id';
$app->delete($route, function ($curated_id,$note_id)  use ($app){

   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);
	$note_id = prepareIdIn($note_id,$host);

	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	

	$DeleteQuery = "DELETE FROM curated_note WHERE ID = " . trim($note_id) . " AND Curated_ID = " . trim($curated_id);
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$curated_id = prepareIdOut($curated_id,$host);
	$note_id = prepareIdOut($note_id,$host);

	$F = array();
	$F['curated_id'] = $curated_id;	
	$F['note_id'] = $note_id;
	$F['type'] = '';
	$F['note'] = '';
	
	array_push($ReturnObject, $F);	

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));
	
	});			
?>