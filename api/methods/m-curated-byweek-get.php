<?php
$route = '/curated/byweek/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	

	if(isset($_REQUEST['week'])){ $week = $params['week']; } else { $week = date('W'); }
	if(isset($_REQUEST['year'])){ $year = $params['year']; } else { $year = date('Y'); }
			
	$Query = "SELECT * FROM curated WHERE WEEK(Item_Date) = " . $week . " AND YEAR(Item_Date) = " . $year;
	$Query .= " ORDER BY Item_Date DESC, Title ASC";
	
	//echo $Query . "<br />";
	
	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$curated_id = $Database['Curated_ID'];
		$title = $Database['Title'];
		$title = str_replace(chr(34),"",$title);
		$title = str_replace(chr(39),"",$title);
		$Link = $Database['Link'];
		$Item_Date = $Database['Item_Date'];
		$Original_Date = $Database['Original_Date'];
		$Details = $Database['Details'];
		$Details = strip_tags($Details);
		$Details = str_replace(chr(34),"",$Details);
		$Details = str_replace(chr(39),"",$Details);
		$Details = str_replace(chr(9),"",$Details);
		$Details = str_replace(chr(10),"",$Details);
		$Details = str_replace(chr(11),"",$Details);
		$Details = str_replace(chr(12),"",$Details);
		$Details = str_replace(chr(13),"",$Details);
		$Details = str_replace(chr(32).chr(32),chr(32),$Details);
		$Details = str_replace(chr(32).chr(32),chr(32),$Details);
		$Details = str_replace(chr(32).chr(32),chr(32),$Details);
		$Status = $Database['Status'];
		$Public_Comment = $Database['Public_Comment'];	
		$Public_Comment = str_replace(chr(34),"",$Public_Comment);
		$Public_Comment = str_replace(chr(39),"",$Public_Comment);		
		$Author = $Database['Author'];		
		$Domain = $Database['Domain'];
		$Screenshot_URL = $Database['Screenshot_URL'];
		$Resolved_URL = $Database['Resolved_URL'];
		$Weekly_Summary = $Database['Weekly_Summary'];
		$Weekly_Roundup = $Database['Weekly_Roundup'];
		$Processed = $Database['Processed'];
		$Github_Build = $Database['Github_Build'];
						
		// manipulation zone

		$TagQuery = "SELECT t.tag_id, t.tag from tags t";
		$TagQuery .= " INNER JOIN curated_tag_pivot ctp ON t.tag_id = ctp.tag_id";
		$TagQuery .= " WHERE ctp.Curated_ID = " . $curated_id;
		$TagQuery .= " ORDER BY t.tag DESC";

		$host = $_SERVER['HTTP_HOST'];
		$curated_id = prepareIdOut($curated_id,$host);
		
		$F = array();
		$F['curated_id'] = $curated_id;
		$F['title'] = $title;
		$F['link'] = $Link;
		$F['item_date'] = $Item_Date;
		$F['original_date'] = $Original_Date;
		//$F['details'] = $Details;
		$F['status'] = $Status;
		$F['public_comment'] = $Public_Comment;
		$F['author'] = $Author;
		$F['domain'] = $Domain;
		$F['screenshot_url'] = $Screenshot_URL;
		$F['resolved_url'] = $Resolved_URL;
		$F['weekly_summary'] = $Weekly_Summary;
		$F['weekly_roundup'] = $Weekly_Roundup;
		$F['processed'] = $Processed;
		$F['github_build'] = $Github_Build;
		
		$F['tags'] = array();

		$TagResult = mysql_query($TagQuery) or die('Query failed: ' . mysql_error());		  
		while ($Tag = mysql_fetch_assoc($TagResult))
			{
			$thistag = $Tag['tag'];
			
			$T = array();
			$T = $thistag;
			array_push($F['tags'], $T);
			//echo $thistag . "<br />";	
			if($thistag=='Archive')
				{
				$archive = 1;	
				}					
			}		
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>