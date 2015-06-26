<?php
$route = '/curated/tags/:tag/build/';
$app->get($route, function ($tag)  use ($app){

	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();		

	$Query = "SELECT DISTINCT c.* from tags t";
	$Query .= " JOIN curated_tag_pivot ctp ON t.Tag_ID = ctp.Tag_ID";
	$Query .= " JOIN curated c ON ctp.Curated_ID = c.Curated_ID";
	$Query .= " WHERE (Github_Build NOT LIKE '%" . $tag . "%' OR Github_Build IS NULL) AND Tag = '" . $tag . "' ORDER BY Item_date ASC LIMIT 5 ";
	//echo $Query;
	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$Curated_ID = $Database['Curated_ID'];
		$title = $Database['Title'];
		$Link = $Database['Link'];
		$Item_Date = $Database['Item_Date'];
		$Original_Date = $Database['Original_Date'];
		$Details = $Database['Details'];
		$Status = $Database['Status'];
		$Public_Comment = $Database['Public_Comment'];	
		$Author = $Database['Author'];		
		$Domain = $Database['Domain'];
		$Screenshot_URL = $Database['Screenshot_URL'];
		$Resolved_URL = $Database['Resolved_URL'];
		$Weekly_Summary = $Database['Weekly_Summary'];
		$Weekly_Roundup = $Database['Weekly_Roundup'];
		$Processed = $Database['Processed'];
		$Github_Build = $Database['Github_Build'];
				
		// manipulation zone
		
		$F = array();
		$F['curated_id'] = $Curated_ID;
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
		
		$TagQuery = "SELECT t.tag_id, t.tag from tags t";
		$TagQuery .= " INNER JOIN curated_tag_pivot ctp ON t.tag_id = ctp.tag_id";
		$TagQuery .= " WHERE ctp.Curated_ID = " . $Curated_ID;
		$TagQuery .= " ORDER BY t.tag DESC";
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

		if(strlen($Github_Build) > 1) 
			{
			$Github_Build .= "," . $tag;
			}
		else
			{
			$Github_Build .= $tag;
			}

		$UpdateQuery = "UPDATE curated SET Github_Build = '" . $Github_Build . "' WHERE Curated_ID = " . $Curated_ID;	
		$UpdateResult = mysql_query($UpdateQuery) or die('Query failed: ' . mysql_error());	  		
		
		array_push($ReturnObject, $F);	
			
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>