<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_project.inc");

$proj = new CommonsProject($_SESSION["p"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
}

$proj->SortMethod = $_POST["sort_method"];
$err = $proj->Update();
if (0 < $err->ErrorLevel)
	$err->Show();

header("Location: project.php");
