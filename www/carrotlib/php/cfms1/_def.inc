<?php
ini_set("include_path", ".:..:/usr/local/lib/php:carrotlib/php/cfms1");
define("DBMS", "_class/mysql.inc");
require_once(DBMS);
require_once($_SERVER['SERVER_NAME'] . ".inc");
require_once("_func.inc");
require_once("_class/log.inc");
require_once("_class/app.inc");

define("APP_NAME", "COMMONS ファイル管理システム ");
define("APP_NAME_E", "COMMONS File Management System");
define("APP_VER", "1.1.10 (2011-10-13)");

$db = new Database();
$app = new Application();

define("THUMBNAIL_SIZE", 150);

function p ($var) {
	if (!headers_sent()) {
		header('Content-Type: text/html; charset=utf-8');
	}
	if (extension_loaded('xdebug')) {
		var_dump($var);
	} else {
		print("<div align=\"left\"><pre>\n");
		print_r($var);
		print("</pre></div>\n");
	}
}
