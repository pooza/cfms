<?php
define("DEBUG", false);

define("DB_HOST", "cmsdb2");
define("DB_USER", "cfms");
define("DB_PWD", "");
define("DB_NAME", "druid3");

define("HTTP_HOST", "cfms.commons.co.jp");
define("ROOT_URL", "https://cfms.commons.co.jp/");
define("ROOT_PATH", "/home/commons/sites/cfms.commons.co.jp/");

define("MTA_HOST", "localhost");
define("MTA_TZ", "+0900");
define("ADMIN_EMAIL", "webmaster@commons.co.jp");

define("MAX_FILE_SIZE", 60); // ファイルサイズの上限
define("NEW_DATE", 2); // New!を表示する日数
define("STORAGE_PATH", "/usr/local/cfms/"); // ファイル格納場所

$arrayBlankClass = array("JPG", "PNG", "GIF", "TXT", "PDF");
$arrayThumbClass = array("JPG", "GIF");
