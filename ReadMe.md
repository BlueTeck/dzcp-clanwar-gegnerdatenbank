# Clanwar Gegnerdatenbank - ReadMe 

Mit diesem Mod, müssen Clandaten bei wiederholtem War (zum Beispiel in Ligen) nicht immer wieder eingegeben werden.

Im Admin Menü ist es jetzt möglich einen/den Clan anzulegen. Beim erstellen oder bearbeiten eines Clanwars ist die Clanauswahl dann per Dropdown-Box auszuwählen. Die festen Clandaten sind das Clankürzel, Clanname, Website, Land und Logo.

Außerdem gibt es eine Übersicht, auf der alle Gegnerclans angezeigt werden. Bei Aufruf einzelner Clans, werden die Clandetails angezeigt, sowie alle Spiele die der Gegner gegen euch gespielt hat.

Am besten guckt ich euch die Screenshots an, oder besucht die Demoseite.

Hierfür werden einige neuen Dateien auf euren Website gespielt und einige modifiziert, bzw. überschrieben. Hierzu findet sich weiter unten ein Dateiverzeichnis.

Bei Problemen, Fehlern, Anregungen oder Fragen, wendet euch gerne an mich.
 
## Copyright & Haftungsausschluss 
Wir übernehmen keinerlei Verantwortung, für Schäden die durch das einbinden der Mod/des Addons entstehen. Das einbinden und nutzen erfolgt demnach auf eigene Gefahr.

 Vor den einbinden der Mod/des Addons sollte eine Datenbanksicherung durchgeführt werden. Des Weiteren empfehlen wir, von allen Dateien welche geändert werden müssen (unter „Benötigte Dateien“ aufgelistet), ebenfalls eine Sicherheitskopie anzufertigen.  
   
## Benötigte Dateien 
Folgende Dateien werden für dieses Addon modifiziert(überschrieben):
* admin/menu/cw.php
* clanwars/index.php
* inc/menu-functions/kalender.php
* inc/menu-functions/l_wars.php
* inc/menu-functions/n_wars.php
* inc/menu-functions/top_match.php
* kalender/index.php
* user/index.php
* inc/_templates_/**Template**/admin/form_cw.html
 
Folgende Dateien sind komplett neu:
* _install/install.php
* clans/index.php
* admin/menu/cw_clans.php
* admin/menu/cw_clans.gif
* inc/_templates_/**Template**/clans/list.html
* inc/_templates_/**Template**/clans/list_row.html
* inc/_templates_/**Template**/clans/show.html
* inc/_templates_/**Template**/clans/wars.html
* inc/_templates_/**Template**/admin/clans.html
* inc/_templates_/**Template**/admin/clans_show.html
* inc/_templates_/**Template**/admin/form_clans.html
* inc/additional-languages/deutsch/Clans_by_BlueTeck.php
 
## Installation 
Entpackt das Archiv in einen beliebigen Ordner. Wenn Ihr es entpackt habt, findet Ihr in den entpackten Ordner 3 weitere Ordner (_install, PHP und Template).

Damit es zu keinen Fehler kommt, müssen zuerst die Tabellen in der Datenbank angelegt werden. Hierfür haben wir einen kleinen Installer geschrieben, welchen sich im Ordner _install befindet. Ladet diesen Ordner in das Hauptverzeichnis eures deV!L'z Clanportals.

Ruft anschliesend eure Seite auf und fügt hinter die Adresse folgendes ein:

```
/_install/install.php
```

 Wenn die Installation erfolgreich verlief löscht zur Sicherheit den Installer-Ordner von euren Webspace.


Falls ihr andere Mods installiert habt, die sich in den Dateien mit diesem Mod überschreiben, müsst ihr alle Dateien manuell ändern. In diesem Fall empfehle ich die Zusatzleistung bei mir zu kaufen, dann habt ihr weniger Arbeit.


Nun müssen die restlichen Dateien hochgeladen werden. Den Inhalt aus dem "PHP Ordner"  müsst Ihr in das Hauptverzeichnis des deV!L'z Clanportal hochladen. Das Hauptverzeichnis ist das oberste Verzeichnis des deV!L'z Clanportals in welchen sich unter anderen die Dateien __readme.html, antispam.php, index.php, popup.html und die ganzen Ordner der einzelnen Bereiche befinden.

Den Inhalt des "Templates" Ordner müsst Ihr in das Verzeichnis eures Templates hochladen (Pfad: inc/_templates_/TEMPLATE).


In eure Navigation in eurem Template müsst/könnt ihr nun noch folgende Seite verlinken

```
../clans/index.php
```

Also http://deine-clanseite.de/clans/


 Nun ist der Mod auf eurem Webspace funktionsfähig, und alle Clans aus bisherigen Clanwars sollten in die Datenbank übertragen sein.
 
## Manuelle Anpassung 
### admin/menu/cw.php 
Such nach (~Zeile 18-24):

```
while($get = _fetch($qry))
 {
 $squads .= show(_cw_add_select_field_squads, array("name" => re($get['name']),
 "game" => re($get['game']),
 "id" => $get['id'],
 "icon" => $get['icon']));
 }
```

Und füge darunter folgendes ein:
```
//Clans Mod 
 $qry = db("SELECT * FROM ".$sql_prefix."clans ORDER BY gegner ASC");
 while($clansqry = _fetch($qry))
 {
 $clans .= show(_cw_add_select_field_clans, array("gegner" => re($clansqry['gegner']),
 "clantag" => re($clansqry['clantag']),
 "id" => $clansqry['id']));
 }
```

Ein paar Zeilen darunter hinter

```
$show = show($dir."/form_cw", array(
```

fügst du folgendes ein:
```
"clans" => $clans,
```
Danach suchst du folgendes (~Teile 103-113):
```
while($gets = _fetch($qrym))
 {
 if($get['squad_id'] == $gets['id']) $sel = "selected=\"selected\"";
 else $sel = "";
 $squads .= show(_cw_edit_select_field_squads, array("id" => $gets['id'],
 "name" => re($gets['name']),
 "game" => re($gets['game']),
 "sel" => $sel,
 "icon" => $gets['icon']));
 }
``` 

Und fügest danach folgendes ein
```
//Clans Mod
 $qryc = db("SELECT * FROM ".$sql_prefix."clans ORDER BY gegner");
 while($clansqry = _fetch($qryc))
 {
 if($get['cid'] == $clansqry['id']) $sel = "selected=\"selected\"";
 else $sel = "";
 $clans .= show(_cw_edit_select_field_clans, array("id" => $clansqry['id'],
 "gegner" => re($clansqry['gegner']),
 "clantag" => re($clansqry['clantag']),
 "sel" => $sel));
 } 
``` 

Und erneut ein paar Zeilen tiefer hinter
```
$show = show($dir."/form_cw", array(
```
fügst du dies ein
```
"clans" => $clans,
```
Und dann suchen wir nocheinmal nach:
```
$class = ($color % 2) ? "contentMainSecond" : "contentMainFirst"; $color++;
```
Und fügen darunter folgendes hinzu:
```
//Clans Mod
 $clandetailssql = db("SELECT clantag, gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql); 
```
Und ein paar Zeilen darunter muss
```
"cw" => re($get['clantag'])." - ".re($get['gegner']),
```
in folgendes abgeändert werden
```
"cw" => re($clans['clantag'])." - ".re($clans['gegner']),
Jetzt müssen noch die DB Daten angepasst werden, suche nach: 
INSERT INTO ".$db['cw']."
 SET
und füge dahinter dies ein 
`cid` = '".((int)$_POST['cid'])."',
und hinter 
UPDATE ".$db['cw']."
 SET
kommt 
`cid` = '".((int)$_POST['cid'])."',
Und folgendes muss gelöscht werden 
empty($_POST['gegner']) || empty($_POST['clantag'])
```
 
### clanwars/index.php 
Suche nach: 
```
['gcountry']
```
Den ganzen Block, also $flagge und $gegner 
```
$flagge = flag($getm['gcountry']);
 $gegner = show(_cw_details_gegner, array("gegner" => re(cut($getm['clantag']." - ".$getm['gegner'], $lcwgegner)),
 "url" => '?action=details&amp;id='.$getm['id']));
``` 
ersetzt du durch 
```
//Clans Mod
 $clandetailssql = db("SELECT clantag, gegner, url, country FROM ".$sql_prefix."clans WHERE id LIKE ".$getm['cid']);
 $clans = _fetch($clandetailssql);

 $flagge = flag($clans['country']);
 $gegner = show(_cw_details_gegner, array("gegner" => re(cut($clans['clantag']." - ".$clans['gegner'], $lcwgegner)),
 "url" => '../clans/?action=show&amp;id='.$getm['id']));
```
Dies ist 5 mal der Fall, die Zeilen sind ungefähr: 109, 264, 424, 618, 1078
Jetzt müssen noch die DB abfragen angepasst werden, suche dafür nach 
```
s1.gegner
```
in den Abfragen wo dies vorkommt, löscht du 
```
s1.gegner,
```
```
s1.clantag,
```
```
s1.gcountry,
```
```
s1.url,
```
fügt stattdessen aber 
```
s1.cid,
```
hinzu. 
Dann suche noch
```
$pagetitle = re($get['name']).' vs. '.re($get['gegner']).' - '.$pagetitle;
```
Und ersetzte es durch
```
$pagetitle = re($get['name']).' vs. '.re($clans['gegner']).' - '.$pagetitle;
```
 
### inc/menu-functions/kalender.php 
Folgendes 
```
$qry = db("SELECT datum,gegner FROM ".$db['cw']."
 WHERE DATE_FORMAT(FROM_UNIXTIME(datum), '%d.%m.%Y') = '".cal($i).".".$monat.".".$jahr."'");
 if(_rows($qry))
 {
 while($get = _fetch($qry)) $infoCW .= '<img src=../inc/images/cw.gif class=icon alt= /> '.jsconvert(_kal_cw.re($get['gegner'])); $info = ' onmouseover="DZCP.showInfo(\'<tr><td>'.$infoCW.'</td></tr>\')" onmouseout="DZCP.hideInfo()"';
 $cws = '<a href="../clanwars/?action=kalender&amp;time='.$datum.'"'.$info.'><img src="../inc/images/cw.gif" alt="" /></a>';
 } else {
 $cws = "";
 }
```
muss durch folgendes ersetzt werden 
```
 $qry = db("SELECT datum,cid FROM ".$db['cw']."
 WHERE DATE_FORMAT(FROM_UNIXTIME(datum), '%d.%m.%Y') = '".cal($i).".".$monat.".".$jahr."'");
 if(_rows($qry))
 {
 while($get = _fetch($qry)) 
 //Clans Mod 
 $clandetailssql = db("SELECT gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql);

 $infoCW .= '<img src=../inc/images/cw.gif class=icon alt= /> '.jsconvert(_kal_cw.re($clans['gegner'])); $info = ' onmouseover="DZCP.showInfo(\'<tr><td>'.$infoCW.'</td></tr>\')" onmouseout="DZCP.hideInfo()"';
 $cws = '<a href="../clanwars/?action=kalender&amp;time='.$datum.'"'.$info.'><img src="../inc/images/cw.gif" alt="" /></a>';
 } else {
 $cws = "";
 }
```
 
### inc/menu-functions/l_wars.php 
Folgende Zeile 
```
global
```
muss in dieses geändert werden 
```
global $sql_prefix,
```
Dann muss in der Db Abfrage dies gelöscht werden 
```
s1.gegner,
```
```
s1.clantag,
```
Und dafür dies hinzugefügt werden
```
s1.cid,
```
Und vor
```
if($allowHover == 1 || $allowHover == 2)
```
muss dies eingefügt werden
```
$clandetailssql = db("SELECT clantag, gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql);
```
Und dann muss 
```
$get['gegner']
```
zu dem hier werden
```
$clans['gegner']
```
Und dann muss 
```
$get['clantag']
```
zu dem hier werden
```
$clans['clantag']
``` 
### inc/menu-functions/n_wars.php 
Folgende Zeile 
```
global
```
muss in dieses geändert werden 
```
global $sql_prefix,
```
Dann muss in der Db Abfrage dies gelöscht werden 
```
s1.gegner,
```
```
s1.clantag,
```
Und dafür dies hinzugefügt werden
```
s1.cid,
```
Und vor
```
if($allowHover == 1 || $allowHover == 2)
```
muss dies eingefügt werden
```
$clandetailssql = db("SELECT clantag, gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql);
```
Und dann muss 
```
$get['gegner']
```
zu dem hier werden
```
$clans['gegner']
```
Und dann muss 
```
$get['clantag']
```
zu dem hier werden
```
$clans['clantag']
``` 
### inc/menu-functions/top_match.php 
Folgende Zeile 
```
global
```
muss in dieses geändert werden 
```
global $sql_prefix,
```
Dann muss in der Db Abfrage dies gelöscht werden 
```
s1.gegner,
```
```
s1.clantag,
```
Und dafür dies hinzugefügt werden
```
s1.cid,
```
Und vor
```
$squad = '_defaultlogo.jpg'; $gegner = '_defaultlogo.jpg';
```
muss dies eingefügt werden
```
$clandetailssql = db("SELECT clantag, gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql);
```
Und dann muss 
```
if(file_exists(basePath.'/inc/images/clanwars/'.$get['id'].'_logo.'.$end)) $gegner = $get['id'].'_logo.'.$end;
```
zu dem hier werden
```
if(file_exists(basePath.'/inc/images/clanwars/'.$get['cid'].'_logo.'.$end)) $gegner = $get['cid'].'_logo.'.$end;
```
Und dann muss 
```
$get['gegner']
```
zu dem hier werden
```
$clans['gegner']
```
Und dann muss 
```
$get['clantag']
```
zu dem hier werden
```
$clans['clantag']
``` 
### kalender/index.php 
Folgende Zeile 
```
global
```
muss in dieses geändert werden 
```
global $sql_prefix,
```
Und dann muss das hier 
```
$cws = "set";
 $titlecw .= '<tr><td><img src=../inc/images/cw.gif class=icon alt= /> '.jsconvert(_kal_cw.re($get['gegner'])).'</td></tr>';
```
muss in der geändert werden
```
$clandetailssql = db("SELECT gegner FROM ".$sql_prefix."clans WHERE id LIKE ".$get['cid']);
 $clans = _fetch($clandetailssql); 
 $cws = "set";
 $titlecw .= '<tr><td><img src=../inc/images/cw.gif class=icon alt= /> '.jsconvert(_kal_cw.re($clans['gegner'])).'</td></tr>'; 
```
### user/index.php 
Suche nach 
```
$cws .= show(_user_new_cw
```
und füge davor dies ein
```
$clandetailssql = db("SELECT clantag FROM ".$sql_prefix."clans WHERE id LIKE ".$getcw['cid']);
$clans = _fetch($clandetailssql);
```
Und dann ändere 
```
"gegner" => re($getcw['clantag'])));
```
in
```
"gegner" => re($clans['clantag'])));
```

### inc/_templates_/**Template**/admin/form_cw.html 
Ersetzte dies
```
<tr>
 <td class="contentMainTop"><span class="fontBold">[clantag]:</span></td> 
 <td class="contentMainFirst" align="center">
 <input type="text" name="clantag" value="[cw_clantag]" class="inputField_dis"
 onfocus="this.className='inputField_en';" 
 onblur="this.className='inputField_dis';">
 </td>
 </tr>
 <tr>
 <td class="contentMainTop"><span class="fontBold">[gegner]:</span></td> 
 <td class="contentMainFirst" align="center">
 <input type="text" name="gegner" value="[cw_gegner]" class="inputField_dis"
 onfocus="this.className='inputField_en';" 
 onblur="this.className='inputField_dis';">
 </td>
 </tr>
 <tr>
 <td class="contentMainTop"><span class="fontBold">[country]:</span></td>
 <td class="contentMainFirst" align="center">
 [countrys]
 </td>
 </tr>
 <tr>
 <td class="contentMainTop"><span class="fontBold">[url]:</span></td> 
 <td class="contentMainFirst" align="center">
 <input type="text" name="url" value="[cw_url]" class="inputField_dis"
 onfocus="this.className='inputField_en';" 
 onblur="this.className='inputField_dis';">
 </td>
 </tr>
 <tr>
 <td class="contentMainTop"><span class="fontBold">[logo]:</span><br /><small><i>100px x 100px</i></small></td> 
 <td class="contentMainFirst" align="center">
 <input type="file" name="logo" />
 </td>
 </tr>
 ```
durch dies hier
```
<tr>
 <td class="contentMainTop"><span class="fontBold">[gegner]:</span></td>
 <td class="contentMainFirst" align="center">
 <select id="cid" name="cid" class="dropdown">
 [clans]
 </select>
 </td>
 </tr>
 ```
 
