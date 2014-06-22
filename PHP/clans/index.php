<?php
## OUTPUT BUFFER START ##
include("../inc/buffer.php");
## INCLUDES ##
include(basePath."/inc/config.php");
include(basePath."/inc/bbcode.php");
## SETTINGS ##
$time_start = generatetime();
lang($language);
$where = _clans_list;
$title = $pagetitle." - ".$where."";
$dir = "clans";
## SECTIONS ##
if(!isset($_GET['action'])) $action = "";
else $action = $_GET['action'];

switch ($action):
default:

$qry = db("SELECT * FROM ".$sql_prefix."clans ORDER BY clantag");
        while($get = mysql_fetch_array($qry))
  {
$class = ($color % 2) ? "contentMainSecond" : "contentMainFirst"; $color++;    

$wars = db("SELECT id FROM ".$sql_prefix."clanwars WHERE cid LIKE ".$get['id']);
$wars = mysql_num_rows($wars);

$row .= show($dir."/list_row", array("clantag" => $get["clantag"],
									"class" => $class,
									"id" => $get["id"],
									"wars" => _cw.": ".$wars,
									"flagge" => flag($get['country']),
									"gegner" => $get["gegner"]));  
  }
$index = show($dir."/list", array("head" => _clans_list,
									"row" => $row,
									"foot" => ""));
									
break;
//#####################################################################################################
case 'show';
 $qry = db("SELECT * FROM ".$sql_prefix."clans WHERE id LIKE ".$_GET[id]);
        while($get = _fetch($qry))
		{ 

$logo_gegner = '_defaultlogo.jpg';
foreach($picformat AS $end)
  {
       if(file_exists('../inc/images/clanwars/'.$get['id'].'_logo.'.$end)) $logo_gegner = $get['id'].'_logo.'.$end;
   }

//Wars start   
$qry = db("SELECT s1.id,s1.datum,s1.xonx,s1.liga,s1.punkte,s1.gpunkte,s1.squad_id,s1.gametype,s2.icon,s2.name
             FROM ".$db['cw']." AS s1
             LEFT JOIN ".$db['squads']." AS s2 ON s1.squad_id = s2.id
             WHERE s1.cid LIKE ".$get["id"]." 
             ORDER BY s1.datum DESC");
    while($getm = _fetch($qry))
    {
      $img = squad($getm['icon']);
      
      $details = show(_clans_cw_show_details, array("id" => $getm['id']));
      $class = ($color % 2) ? "contentMainSecond" : "contentMainFirst"; $color++;

if($getm['datum'] < mktime()) {
	$result = cw_result_nopic($getm['gpunkte'], $getm['punkte']);
} else { $result = "-:-"; }

      $wars .= show($dir."/wars", array("datum" => date("d.m.y", $getm['datum']),
  	                        										 "squad" => $img." ".$getm["name"],
				  							                         "gegner" => $gegner,
                                                 "xonx" => re($getm['xonx']),
                                                 "liga" => re($getm['liga']),
								  			                         "gametype" => re($getm['gametype']),
                                                 "class" => $class,
                                                 "result" => $result,
											                           "details" => $details));
    }
//Wars Ende
																		
  $index = show($dir."/show", array("head" => $get["clantag"]." - ".$get["gegner"], 
									"foot"=> "",
									"logo" => "<img src=\"../inc/images/clanwars/".$logo_gegner."\">",
									"clantag" => $get["clantag"],
									"tag" => _cw_admin_clantag,
									"land" => _cw_admin_head_country,
									"name" => _cw_head_gegner,
									"web" => _url,
									"gegner" => $get["gegner"],
									"flagge" => flag($get['country'])." - ". $get["country"],
									"website" => "<a href=\"".$get["url"]."\" target=\"_blank\">".$get["url"]."</a>",
									"wars" => $wars,
									"t_datum" => _cw_head_datum,
									"t_squad" => _cw_head_gegner,
									"t_liga" => _cw_head_liga,
									"t_xonx" => _cw_head_xonx,
									"t_result" => _cw_head_result,
									"t_details" => _cw_head_details_show)); 
									 }
break;
endswitch;
## SETTINGS ##
$time_end = generatetime();
$time = round($time_end - $time_start,4);
page($index, $title, $where,$time);
## OUTPUT BUFFER END ##
gz_output();
?>