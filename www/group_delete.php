<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");
require_once("_class/idea.inc");

$proj = new CommonsProject($_SESSION["p"]);
$group = new CommonsGroup($_GET["group"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Close();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $group->Error->ErrorLevel) {
	$group->Error->Show();
} else if ($group->IsEnable("WRITE", $app->LoginUser) == false) {
	$err = new Error("フォルダ情報を更新する権限はありません。", 1);
	$err->Show();
}

// 各ファイルの削除権限のチェック
$rs = $group->Ideas();
while ($rec = $rs->FetchRecord()) {
	$idea = new Idea($rec->id);
	if ($idea->IsEnable("WRITE", $app->LoginUser) == false) {
		$err = new Error("フォルダを削除する権限はありません。", 1);
		$err->Show();
	}
}

// 各ファイルの削除
$rs = $group->Ideas();
while ($rec = $rs->FetchRecord()) {
	$idea = new Idea($rec->id);
	$idea->Delete($app->LoginUser);
}

// グループ自体の削除
$err = $group->Delete($app->LoginUser);

header("Location: project.php");
