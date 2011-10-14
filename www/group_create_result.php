<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");

$proj = new CommonsProject($_SESSION["p"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
}

$group = $proj->CreateGroup($_POST["name"], "", $app->LoginUser);
if (0 < $group->ErrorLevel) {
	$group->Show();
}

header("Location: project.php");
