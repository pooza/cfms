<?php
require_once("carrotlib/php/cfms1/_def.inc");
require_once("_class/user.inc");

$user = new User($_POST["user"]);
if (0 < $user->Error->ErrorLevel) {
	$user->Error->Show();
} else if ($user->Auth($_POST["password"])) {
	$app->SetLoginUser($user);
	$user->Touch();
	if ($user->ID == "admin") {
		header("Location: admin/index.php");
		exit();
	} else {
		header("Location: project_list.php");
		exit();
	}
} else {
	$err = new Error("ユーザーID又はパスワードが間違っています。", 1);
	$err->Show();
}
