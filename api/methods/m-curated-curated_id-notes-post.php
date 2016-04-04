<?php
$route = '/curated/:curated_id/notes/';
$app->post($route, function ($curated_id)  use ($app){

   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);

	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($param['Type']) && isset($param['Note']))
		{
		$Type = trim(mysql_real_escape_string($param['Type']));
		$Note = trim(mysql_real_escape_string($param['Note']));

		$query = "INSERT INTO curated_notes(Curated_ID,Type,Note) VALUES(" . $curated_id . "," . $Type . "," . $Note . "); ";
		mysql_query($query) or die('Query failed: ' . mysql_error());					
		$note_id = mysql_insert_id();		
			
		$F = array();
		$F['curated_id'] = $curated_id;
		$F['note_id'] = $note_id;
		$F['type'] = $Type;
		$F['note'] = $Note;
		
		array_push($ReturnObject, $F);

		}		

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>