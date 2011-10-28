<?php

/* -----------------------------------------------------------------------------

	CFMS 管理画面 基本設定

	2009.08.18	01	cms	下記ver.を一部改訂
	2007.04.13	01	cms

----------------------------------------------------------------------------- */


// ini set

		ini_set('include_path',	'.:..:_inc:../_inc:../../_inc:../../../_inc');
		ini_set('display_errors',					1);
		ini_set('display_startup_errors',	1);


// include

		require_once('xcmd.inc');
		require_once('xfcn.inc');


// 設置先サイト関連の設定

		define('_SITE_NAME_',			'COMMONSファイル管理システム');
		define('_SITE_NAME_S_',		'CFMS');
		define('_SITE_URL_',			'https://cfms.commons.co.jp/');
		define('_SITE_URL_2_',		'http://cfms.commons.co.jp/');


// データベース関連の設定
	
		define('_DB_HOST_',				'cmsdb3');
		define('_DB_USER_',				'cfms');
		define('_DB_PASS_',				'ZF64T8W747');
		define('_DB_NAME_',				'cfms1');


// 管理者に関する設定

		define('_ADM_NAME_',			'Masakazu Kaneko');
		define('_ADM_NAME_S_',		'm-kaneko');
		define('_ADM_MAIL_',			'm-kaneko@commons.co.jp');
		define('_ADM_PASS_',			'zukasama');


//■ CFMS 管理画面 関連の定数 --------------------------------------------------

		define('_ADMIN_NAME_',		_SITE_NAME_.' 管理画面');
		define('_ADMIN_NAME_S_',	_SITE_NAME_S_.' 管理画面');
		define('_ADMIN_URL_',			_SITE_URL_.'admin2/');
		define('_ADMIN_VER_',			'0.7.5');


		// バージョニング基準：
		// -------------------------------------------------------------------------
		// 0.7.0.0		ユーザ管理機能	priv追加・編集，ユーザstatus編集
		// 0.8.0.0		ユーザ管理機能	(検索機能の充実)，パスワード候補の自動生成
		// 0.9.0.0		案件管理機能		案件追加，案件情報の閲覧・編集
		// 1.0.0.0		全体的な完成度の向上，複数人の管理者ログイン


//■ CFMS ヘルプ 関連の定数 --------------------------------------------------

		define('_HELP_NAME_',			_SITE_NAME_		.	' ヘルプ');
		define('_HELP_NAME_S_',		_SITE_NAME_S_	.	' ヘルプ');
		define('_HELP_URL_',			_SITE_URL_2_	.	'help/');
		define('_HELP_VER_',			'0.9.1.0');


?>
