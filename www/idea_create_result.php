<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");
require_once("_class/idea.inc");

// IEのSSL関連バグ対応
header("Pragma: private");
header("Cache-Control: private");

$proj = new CommonsProject($_SESSION["p"]);
$group = new CommonsGroup($_POST["group"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $group->Error->ErrorLevel) {
	$group->Error->Show();
} else if ((MAX_FILE_SIZE * 1024 * 1024) < $_FILES["file"]["size"]) {
	$err = new Error("ファイルが大き過ぎます。", 1);
	$err->Show();
} else if ($_FILES["file"]["error"] != "") {
	$err = new Error("アップロード中にエラーが発生しました。", 1);
	$err->Show();
}

// 拡張子を取得し、クラスを設定
mb_eregi("\.([a-z0-9]+)$", $_FILES["file"]["name"], $arrayMatch);
$class = new IdeaClass($arrayMatch[1]);
if (0 < $class->Error->ErrorLevel) {
	$class = new IdeaClass("FILE");
}

$idea = $group->CreateIdea($_FILES["file"]["name"], "", $class, $app->LoginUser);
if (0 < $idea->ErrorLevel) {
	$err = new Error("アップロードする権限がありません。", 1);
	$err->Show();
}

$idea->Summary = $_POST["summary"];
$idea->Body = CleanStr($_FILES["file"]["name"]);
$idea->Update();
$db->query($strSQL);

move_uploaded_file($_FILES["file"]["tmp_name"], $idea->GetPath()); 

header("Location: project.php");
