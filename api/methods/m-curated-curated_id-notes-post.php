<?php
$route = '/curated/:curated_id/notes/';
$app->post($route, function ($Curated_ID)  use ($app){


	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($param['Type']) && isset($param['Note']))
		{
		$Type = trim(mysql_real_escape_string($param['Type']));
		$Note = trim(mysql_real_escape_string($param['Note']));

		$query = "INSERT INTO curated_notes(Curated_ID,Type,Note) VALUES(" . $Curated_ID . "," . $Type . "," . $Note . "); ";
		mysql_query($query) or die('Query failed: ' . mysql_error());					
		$Note_ID = mysql_insert_id();		
			
		$F = array();
		$F['note_id'] = $Note_ID;
		$F['type'] = $Type;
		$F['note'] = $Note;
		
		array_push($ReturnObject, $F);

		}		

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>