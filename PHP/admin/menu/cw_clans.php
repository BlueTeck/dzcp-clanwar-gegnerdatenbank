<?php
/////////// ADMINNAVI \\\\\\\\\
// Typ:       contentmenu
// Rechte:    permission('clanwars')
///////////////////////////////
if(_adminMenu != 'true') exit;

    $where = $where.': '._clans_head;
    if(!permission("clanwars"))
    {
      $show = error(_error_wrong_permissions, 1);
    } else {
      $wysiwyg = '_word';
      if($_GET['do'] == "add")
      {
		  
		  
        $show = show($dir."/form_clans", array("head" => _clans_add_head,
                                                "what" => _button_value_add,
                                                "clantag" => _cw_admin_clantag,
												"gegner" => _cw_head_gegner,
												"url" => _url,
												"e_clantag" => "",
                                                "e_gegner" => "",
                                                "e_url" => "",
												"logo" => _cw_logo,
												"country" => _cw_admin_head_country,
  									            "countrys" => show_countrys(),
                                                "lang" => $language,
                                                "ja" => _yes,
                                                "nein" => _no,
                                                "error" => "",
												"do" => "addsite"));
      } elseif($_GET['do'] == "addsite") {
        if(empty($_POST['clantag']) || empty($_POST['gegner']))
        {
          if(empty($_POST['clantag'])) $error = _empty_clantag;
          elseif(empty($_POST['gegner'])) $error = _empty_gegner;
          
          $error = show("errors/errortable", array("error" => $error));

          $show = show($dir."/form_clans", array("head" => _clans_edit_head,
                                                "what" => _button_value_edit,
                                                "lang" => $language,
                                                "clantag" => _cw_admin_clantag,
												"gegner" => _cw_head_gegner,
												"url" => _url,
												"logo" => _cw_logo,
												"e_clantag" => re($_POST['clantag']),
                                                "e_gegner" => re($_POST['gegner']),
                                                "e_url" => re($_POST['url']),
												"country" => _cw_admin_head_country,
  									            "countrys" => show_countrys($_POST['country']),
                                                "ja" => _yes,
                                                "nein" => _no,
                                                "error" => "",
                                                "do" => "addsite"));
        } else {
			
		if($_POST['land'] == "lazy") $kid = "";
  		    else $kid = "`country` = '".$_POST['land']."',";	
			
          $qry = db("INSERT INTO ".$sql_prefix."clans 
                     SET ".$kid."
					 `clantag` = '".up($_POST['clantag'])."',
					 	`gegner` = '".up($_POST['gegner'])."',
                         `url`  = '".links($_POST['url'])."'");
						 
		          $tmp = $_FILES['logo']['tmp_name'];
          $type = $_FILES['logo']['type'];
          $end = explode(".", $_FILES['logo']['name']);
          $end = strtolower($end[count($end)-1]);
          
          if(!empty($tmp))
          {
            $img = @getimagesize($tmp);
						if($img1[0])
            {
              @copy($tmp, basePath."/inc/images/clanwars/".mysql_insert_id()."_logo.".strtolower($end));
              @unlink($tmp);
            }
          }				 

          $show = info(_clans_added, "?admin=cw_clans");
        }
      } elseif($_GET['do'] == "edit") {

        $qrys = db("SELECT * FROM ".$sql_prefix."clans 
                    WHERE id = '".intval($_GET['id'])."'");
        $gets = _fetch($qrys);

        $show = show($dir."/form_clans", array("head" => _clans_edit_head,
                                                "what" => _button_value_edit,
                                                "lang" => $language,
                                                "clantag" => _cw_admin_clantag,
												"gegner" => _cw_head_gegner,
												"url" => _url,
												"logo" => _cw_logo,
												"e_clantag" => re($gets['clantag']),
                                                "e_gegner" => re($gets['gegner']),
                                                "e_url" => re($gets['url']),
												"country" => _cw_admin_head_country,
  									            "countrys" => show_countrys($gets['country']),
                                                "ja" => _yes,
                                                "nein" => _no,
                                                "error" => "",
                                                "do" => "editsite&amp;id=".$_GET['id'].""));
      } elseif($_GET['do'] == "editsite") {
        if(empty($_POST['clantag']) || empty($_POST['gegner']))
        {
          if(empty($_POST['clantag'])) $error = _empty_clantag;
          elseif(empty($_POST['gegner'])) $error = _empty_gegner;

          $error = show("errors/errortable", array("error" => $error));
          
          $show = show($dir."/form_clans", array("head" => _clans_edit_head,
                                                "what" => _button_value_edit,
                                                "lang" => $language,
                                                "clantag" => _cw_admin_clantag,
												"gegner" => _cw_head_gegner,
												"url" => _url,
												"logo" => _cw_logo,
												"e_clantag" => re($_POST['clantag']),
                                                "e_gegner" => re($_POST['gegner']),
                                                "e_url" => re($_POST['url']),
												"country" => _cw_admin_head_country,
  									            "countrys" => show_countrys($_POST['country']),
                                                "ja" => _yes,
                                                "nein" => _no,
                                                "error" => "",
                                                "do" => "editsite&amp;id=".$_GET['id'].""));
        } else {
			
			if($_POST['land'] == "lazy") $kid = "";
  		    else $kid = "`country` = '".$_POST['land']."',";	
			
          $qry = db("UPDATE ".$sql_prefix."clans 
                     SET ".$kid."
					 `clantag` = '".up($_POST['clantag'])."',
					 	`gegner` = '".up($_POST['gegner'])."',
                         `url`  = '".links($_POST['url'])."'
                     WHERE id = '".intval($_GET['id'])."'");

//IMG Upload         
		            $tmp = $_FILES['logo']['tmp_name'];
          $type = $_FILES['logo']['type'];
          $end = explode(".", $_FILES['logo']['name']);
          $end = strtolower($end[count($end)-1]);
          
          if(!empty($tmp))
          {
            $img = @getimagesize($tmp);
						foreach($picformat AS $end1)
            {
              if(file_exists(basePath.'/inc/images/clanwars/'.intval($_GET['id']).'_logo.'.$end1))
              {
                @unlink(basePath.'/inc/images/clanwars/'.intval($_GET['id']).'_logo.'.$end1);
                break;
              }
            }
            if($img[0])
            {
              copy($tmp, basePath."/inc/images/clanwars/".intval($_GET['id'])."_logo.".strtolower($end));
              @unlink($tmp);
            }
          }
		 
          $show = info(_clans_edited, "?admin=cw_clans");
        }
      } elseif($_GET['do'] == "delete") {
	  
        $qry = db("DELETE FROM ".$sql_prefix."clans 
                   WHERE id = '".intval($_GET['id'])."'");

        $show = info(_clans_deleted, "?admin=cw_clans");
		
	   } else {
		  
        $qry = db("SELECT * FROM ".$sql_prefix."clans ORDER BY clantag");
        while($get = _fetch($qry))
        {
          $class = ($color % 2) ? "contentMainSecond" : "contentMainFirst"; $color++;
          $edit = show("page/button_edit_single", array("id" => $get['id'],
                                                        "action" => "admin=cw_clans&amp;do=edit",
                                                        "title" => _button_title_edit));
          $delete = show("page/button_delete_single", array("id" => $get['id'],
                                                            "action" => "admin=cw_clans&amp;do=delete",
                                                            "title" => _button_title_del,
                                                            "del" => convSpace(_confirm_del_clans)));
			
		$show_ .= show($dir."/clans_show", array("clantag" => re($get['clantag']),
													"gegner" => re($get['gegner']),
													"id" => re($get['id']),
													"flagge" => flag($get['country']),
                                                    "del" => $delete,
                                                    "edit" => $edit,
                                                    "class" => $class));
        }

        $show = show($dir."/clans", array("head" => _clans_head,
                                           "show" => $show_,
                                           "add" => _clans_add_head,
                                           "edit" => _editicon_blank,
                                           "del" => _deleteicon_blank,
                                           "name" => _clans_titel));
      }
    }
?>