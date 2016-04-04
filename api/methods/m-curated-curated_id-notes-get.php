<?php
$route = '/curated/:curated_id/notes/';
$app->get($route, function ($curated_id)  use ($app){

   $host = $_SERVER['HTTP_HOST'];
   $curated_id = prepareIdIn($curated_id,$host);

	$ReturnObject = array();
		
	$Query = "SELECT ID,Curate_ID,Type,Note  from curated_notes cn";
	$Query .= " WHERE cn.Curated_ID = " . $curated_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$note_id = $Database['ID'];
		$Type = $Database['Type'];
		$Note = $Database['Note'];

		$curated_id = prepareIdOut($curated_id,$host);
		$note_id = prepareIdOut($note_id,$host);

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