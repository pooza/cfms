<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");

$proj = new CommonsProject($_SESSION["p"]);
$group = new CommonsGroup($_POST["group"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $group->Error->ErrorLevel) {
	$group->Error->Show();
}

$group->SortMethod = $_POST["sort_method"];
$err = $group->Update();
if (0 < $err->ErrorLevel)
	$err->Show();

header("Location: project.php");
