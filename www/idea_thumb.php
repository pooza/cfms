<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/cms_group.inc");
require_once("_class/cms_project.inc");
require_once("_class/file.inc");
require_once("_class/idea.inc");

if (isset($_GET["idea"]))
	$_SESSION["i"] = $_GET["idea"];

$proj = new CommonsProject($_SESSION["p"]);
$idea = new Idea($_SESSION["i"]);

if (!isset($app->LoginUser->ID)) {
	$err = new Error("不正なユーザーです。", 2);
	$err->Show();
} else if (0 < $proj->Error->ErrorLevel) {
	$proj->Error->Show();
} else if (0 < $idea->Error->ErrorLevel) {
	$idea->Error->Show();
} else if ($idea->IsEnable("READ", $app->LoginUser) == false) {
	$err = new Error("ファイルを閲覧する権限はありません。", 1);
	$err->Show();
}

switch ($idea->Class->ID) {
	case "JPG":
		$imgSrc = ImageCreateFromJPEG($idea->GetPath());
		break;
	case "PNG":
		$imgSrc = ImageCreateFromPNG($idea->GetPath());
		break;
	case "GIF":
		$imgSrc = ImageCreateFromGIF($idea->GetPath());
		break;
}

$intSrcW = $idea->GetW();
$intSrcH = $idea->GetH();
$img = ImageCreateTrueColor(THUMBNAIL_SIZE, THUMBNAIL_SIZE);

if (1 > ($intSrcW / $intSrcH)) { // 縦横比を求める
	$intSrcX = floor(($intSrcW - $intSrcH) / 2);
	ImageCopyResampled($img, $imgSrc, 0, 0, $intSrcX, 0, THUMBNAIL_SIZE, THUMBNAIL_SIZE, $intSrcH, $intSrcH);
} else {
	$intSrcY = floor(($intSrcH - $intSrcW) / 2);
	ImageCopyResampled($img, $imgSrc, 0, 0, 0, $intSrcY, THUMBNAIL_SIZE, THUMBNAIL_SIZE, $intSrcW, $intSrcW);
}

mb_http_output("pass");
header("Content-type: image/jpeg");
ImageJPEG($img);
