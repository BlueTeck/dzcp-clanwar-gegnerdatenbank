<?php
## OUTPUT BUFFER START ##
include("../inc/buffer.php");
## INCLUDES ##
include(basePath."/inc/debugger.php");
include(basePath."/inc/config.php");
include(basePath."/inc/bbcode.php");
## SETTINGS ##
$time_start = generatetime();
lang($language);
$where = "Installer";
$title = $pagetitle." - ".$where."";
## INSTALLER ##
if(isset($_POST['submit'])) {	

// alte Tabellen/Spalten löschen
		db("DROP TABLE IF EXISTS ".$sql_prefix."clans");
				
		
// neue Tabellen/Spalten anlegen
		db("CREATE TABLE ".$sql_prefix."clans (
						`id` INT( 5 ) NOT NULL AUTO_INCREMENT ,
`clantag` VARCHAR( 20 ) NOT NULL ,
`gegner` VARCHAR( 100 ) NOT NULL ,
`url` VARCHAR( 249 ) NOT NULL ,
`country` VARCHAR( 20 ) NOT NULL DEFAULT 'de',
						PRIMARY KEY  (`id`)) ");	

db("ALTER TABLE ".$sql_prefix."clanwars ADD `cid` int(5) NOT NULL default '0'");							

$qry = db("SELECT id,clantag,gegner,url,gcountry FROM ".$sql_prefix."clanwars ORDER BY id");
        while($get = _fetch($qry))
        {
		db("INSERT INTO ".$sql_prefix."clans (id,clantag,gegner,url,country) VALUES 
		('".$get["id"]."',
		'".$get["clantag"]."',
		'".$get["gegner"]."',
		'".$get["url"]."',
		'".$get["gcountry"]."')");
		
		
		db("UPDATE ".$sql_prefix."clanwars SET `cid` = ".$get["id"]."  WHERE id = ".$get["id"]);
		
		}

	  

						
// Check ob Install i.O. velief		
		if(cnt($sql_prefix."clans") > '0') {
    $show = '<tr>
               <td class="contentHead" align="center"><span class="fontGreen"><b>Installation erfolgreich!</b></span></td>
             </tr>
             <tr>
               <td class="contentMainFirst"  align="center">
                 Die ben&ouml;tigten Tabellen konnten erfolgreich erstellt werden.<br>
                 <br>
                 <b>L&ouml;sche unbedingt den installer-Ordner!</b>
               </td>
             </tr>
             <tr>
               <td class="contentBottom"></td>
             </tr>';
  } else {
    $show = '<tr>
               <td class="contentHead" align="center"><span class="fontWichtig"><b>FEHLER</b></span></td>
             </tr>
             <tr>
               <td class="contentMainFirst" align="center">
                 Bei der Installation des Mods ist ein Fehler aufgetreten. Bitte &uuml;berpr&uuml;fe deine Datenbank auf Sch&auml;den und versuche die Installation erneut.
               </td>
             </tr>
             <tr>
               <td class="contentBottom"></td>
             </tr>';
  }
} else {
  $show = '<tr>
             <td class="contentHead" align="center"><b>ClanauswahlMod - Installation</b></td>
           </tr>
           <tr>
             <td class="contentMainFirst" align="center">
               Hallo und herzlichen Dank, dass du diese Modifikation gekauft hast. Dieser Installer soll dir die Arbeit abnehmen, die ben&ouml;tigten Tabellen in der Datenbank manuell erstellen zu m&uuml;ssen.<b>
               <br /><br />
               <b><span style="text-align:center"><u>!!!! WICHTIG !!!!</u></span><br />Erstell vor dem ausf&uuml;hren des Installers ein Datenbank BackUp. Wir haften f&uuml;r keine Sch&auml;den!</b><br />
               <br />
             </td>
           </tr>
           <tr>
             <td class="contentBottom" align="center">
               <form action="?action=install" method="POST">
                 <input class="submit" type="submit" name="submit" value="Tabellen anlegen">
               </form>
             </td>
           </tr>';
}
## SETTINGS ##
$time_end = generatetime();
$time = round($time_end - $time_start,4);
page($show, $title, $where,$time);
?>
