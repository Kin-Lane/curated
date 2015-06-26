<?php
$route = '/curated/:curated_id/';	
$app->put($route, function ($curated_id) use ($app){
		
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();		
	
	if(isset($params['title'])){ $title = $params['title']; } else { $title = ''; }
	if(isset($params['link'])){ $link = $params['link']; } else { $link = ''; }
	if(isset($params['item_date'])){ $item_date = $params['item_date']; } else { $item_date = ''; }
	if(isset($params['details'])){ $details = $params['details']; } else { $details = ''; }		
	if(isset($params['status'])){ $status = $params['status']; } else { $status = ''; }
	if(isset($params['public_comment'])){ $public_comment = $params['public_comment']; } else { $public_comment = ''; }
	if(isset($params['author'])){ $author = $param['author']; } else { $author = ''; }
	if(isset($params['domain'])){ $domain = $params['domain']; } else { $domain = ''; }
	if(isset($params['screenshot_url'])){ $screenshot_url = $params['screenshot_url']; } else { $screenshot_url = ''; }
	if(isset($params['resolved_url'])){ $resolved_url = $params['resolved_url']; } else { $resolved_url = ''; }
	if(isset($params['weekly_summary'])){ $weekly_summary = $params['weekly_summary']; } else { $weekly_summary = ''; }
	if(isset($params['weekly_roundup'])){ $weekly_roundup = $params['weekly_roundup']; } else { $weekly_roundup = ''; }
	if(isset($params['processed'])){ $processed = $params['processed']; } else { $processed = ''; }
	if(isset($params['github_build'])){ $github_build = $params['github_build']; } else { $github_build = ''; }
	
  	$Query = "SELECT * FROM curated WHERE Curated_ID = " . $curated_id;
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$query = "UPDATE curated SET";

		$query .= " Flag = 1";
		
		if($title!='') { $query .= ", Title = '" . mysql_real_escape_string($title) . "'"; }
		if($link!='') { $query .= ", Link = '" . mysql_real_escape_string($link) . "'"; }
		if($details!='') { $query .= ", Details = '" . mysql_real_escape_string($details) . "'"; }
		if($author!='') { $query .= ", Author = '" . mysql_real_escape_string($author) . "'"; }
		if($screenshot_url!='') { $query .= ", Screenshot_URL = '" . mysql_real_escape_string($screenshot_url) . "'"; }
		if($github_build!='') { $query .= ", Github_Build = '" . mysql_real_escape_string($github_build) . "'"; }
		
		$query .= " WHERE Curated_ID = " . $curated_id;
		
		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());	
		}

	$ReturnObject['curated_id'] = $curated_id;
		
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>