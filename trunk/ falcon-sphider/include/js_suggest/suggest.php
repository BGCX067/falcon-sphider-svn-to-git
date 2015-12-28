<?
error_reporting(0); // Any notices/warnings will cause errors in suggest javascript


require_once('../../settings/database.php'); 
require_once('../../settings/conf.php');

 //echo        urldecode($_GET['q']);
if (get_magic_quotes_gpc()==1) {
	$_GET['q'] = stripslashes($_GET['q']);
} 


$_GET['q'] = addslashes($_GET['q']);

/*
	if search string too small, do not search for keywords/phrases
*/ 
if (strlen($_GET['q'])<3)
{
	$suggest_phrases = false;
	$suggest_keywords = false;
}

/*
	check if search string is phrase
*/ 
if (!strpos($_GET['q'],' '))
{
	$suggest_phrases = false;
}


/* 
	searches from saved queries (query_log table)
*/

if ($suggest_history && $_GET['q']!='"')
{
    //$_GET['q']=mb_convert_encoding($_GET['q'],"UTF-8",'auto');
  //echo mb_detect_encoding($_GET['q'], "auto");
    //  echo $_GET['q'];
     // echo "\n";
      //echo        urldecode($_GET['q']);
      
     //echo $_GET['q']=iconv("ASCII","utf-8",$_GET['q']);
         
	$result = mysql_query($sql = "
	SELECT 	query as keyword, max(results) as results
	FROM {$mysql_table_prefix}query_log 
	WHERE results > 0 AND (query LIKE '{$_GET['q']}%' OR query LIKE '\"{$_GET['q']}%') 
	GROUP BY query ORDER BY results DESC
	LIMIT $suggest_rows
	");
 // echo $sql;
	if($result && mysql_num_rows($result))
	{
	    while($row = mysql_fetch_array($result))
	    {
	        $values[$row['keyword']] = $row['results'];
	    }    
	}
}

/* 
	phrase search
	!! LOCATE: in MySQL 3.23 this function is case sensitive, while in 4.0 it's only case-sensitive if either argument is a binary string
*/

if ($suggest_phrases) 
{
	$_GET['q'] = strtolower( str_replace('"','',$_GET['q'] ));
	$_words = substr_count($_GET['q'],' ') + 1; 
	
	$result = mysql_query($sql = "
	SELECT count(link_id) as results, SUBSTRING_INDEX(SUBSTRING(fulltxt,LOCATE('{$_GET['q']}',LOWER(fulltxt))), ' ', '$_words') as keyword FROM {$mysql_table_prefix}links where fulltxt like '%{$_GET['q']}%' 
	GROUP BY SUBSTRING_INDEX( SUBSTRING( fulltxt, LOCATE( '{$_GET['q']}', LOWER(fulltxt) ) ) , ' ', '$_words' ) LIMIT $suggest_rows
	");
	if($result && mysql_num_rows($result))
	{
	    while($row = mysql_fetch_array($result))
	    {
	    	//$row['keyword'] = preg_replace("/[^\s\w]/ims",'',$row['keyword']);//array('.',',','?')$row['keyword']);
	         $values[$row['keyword']] = $row['results'];
	    }    
	}
}

/* 
	keyword search
*/

elseif ($suggest_keywords)
{
	for ($i=0;$i<=15; $i++) {
		$char = dechex($i);
		$result = mysql_query($sql = "
		SELECT keyword, count(keyword) as results 
		FROM {$mysql_table_prefix}keywords INNER JOIN {$mysql_table_prefix}link_keyword$char USING (keyword_id) 
		WHERE keyword LIKE '{$_GET['q']}%'  
		GROUP BY keyword 
		ORDER BY results desc
		LIMIT $suggest_rows
		");
		if($result && mysql_num_rows($result)) {		
		    while($row = mysql_fetch_array($result)) {
		        $values[$row['keyword']] = $row['results'];
		    }    
		}
	}
	arsort($values);
	$values = array_slice($values, 0, $suggest_rows);
}

if (is_array($values))
{
	arsort($values); 
	if (is_array($values)) foreach ($values as $_key => $_val) {
		$js_array[] = 'new Array("' .str_replace('"','\"',$_key)  . '", " <small> <b id=\"key\">' . $_val . '</b> 结果</small>")';
//\"color:#008000;font-weight:bold\"
	}
	print ("new Array(" . implode(", ", $js_array) . ")");  //不用utf8_encode
}

?>
