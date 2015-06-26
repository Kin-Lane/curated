<?php
$route = '/curated/';	
$app->post($route, function () use ($app){
	
	$Add = 1;
	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($_POST['title'])){ $title = $param['title']; } else { $title = ''; }
	if(isset($_POST['link'])){ $link = $param['link']; } else { $link = ''; }
	if(isset($_POST['item_date'])){ $item_date = $param['item_date']; } else { $item_date = ''; }
	if(isset($_POST['details'])){ $details = $param['details']; } else { $details = ''; }		
	if(isset($_POST['status'])){ $status = $param['status']; } else { $status = ''; }
	if(isset($_POST['public_comment'])){ $public_comment = $param['public_comment']; } else { $public_comment = ''; }
	if(isset($_POST['author'])){ $author = $param['author']; } else { $author = ''; }
	if(isset($_POST['domain'])){ $domain = $param['domain']; } else { $domain = ''; }
	if(isset($_POST['screenshot_url'])){ $screenshot_url = $param['screenshot_url']; } else { $screenshot_url = ''; }
	if(isset($_POST['resolved_url'])){ $resolved_url = $param['resolved_url']; } else { $resolved_url = ''; }
	if(isset($_POST['weekly_summary'])){ $weekly_summary = $param['weekly_summary']; } else { $weekly_summary = ''; }
	if(isset($_POST['weekly_roundup'])){ $weekly_roundup = $param['weekly_roundup']; } else { $weekly_roundup = ''; }
	if(isset($_POST['processed'])){ $processed = $param['processed']; } else { $processed = ''; }

  	$Query = "SELECT * FROM curated WHERE link = '" . $link . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());
	
	if($Database && mysql_num_rows($Database))
		{	
		$ThisItem = mysql_fetch_assoc($Database);	
		}
	else 
		{
		$Query = "INSERT INTO curated(name,description,url,tags,slug) VALUES('" . mysql_real_escape_string($name) . "','" . mysql_real_escape_string($description) . "','" . mysql_real_escape_string($url) . "','" . mysql_real_escape_string($tags) . "','" . mysql_real_escape_string($curated_id) . "')";
		//echo $query . "<br />";
		mysql_query($Query) or die('Query failed: ' . mysql_error());			
		}

	$F = array();
	$F['name'] = $name;
	$F['url'] = $url;
	$F['tags'] = $tags;
	$F['slug'] = $curated_id;
	
	array_push($ReturnObject, $F);
		
	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>