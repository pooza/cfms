<?php

/* -----------------------------------------------------------------------------

	CFMS �Ǘ���� ��{�ݒ�

	2009.08.18	01	cms	���Lver.���ꕔ����
	2007.04.13	01	cms

----------------------------------------------------------------------------- */


// ini set

		ini_set('include_path',	'.:..:_inc:../_inc:../../_inc:../../../_inc');
		ini_set('display_errors',					1);
		ini_set('display_startup_errors',	1);


// include

		require_once('xcmd.inc');
		require_once('xfcn.inc');


// �ݒu��T�C�g�֘A�̐ݒ�

		define('_SITE_NAME_',			'COMMONS�t�@�C���Ǘ��V�X�e��');
		define('_SITE_NAME_S_',		'CFMS');
		define('_SITE_URL_',			'https://cfms.commons.co.jp/');
		define('_SITE_URL_2_',		'http://cfms.commons.co.jp/');


// �f�[�^�x�[�X�֘A�̐ݒ�
	
		define('_DB_HOST_',				'cmsdb3');
		define('_DB_USER_',				'cfms');
		define('_DB_PASS_',				'ZF64T8W747');
		define('_DB_NAME_',				'cfms1');


// �Ǘ��҂Ɋւ���ݒ�

		define('_ADM_NAME_',			'Masakazu Kaneko');
		define('_ADM_NAME_S_',		'm-kaneko');
		define('_ADM_MAIL_',			'm-kaneko@commons.co.jp');
		define('_ADM_PASS_',			'zukasama');


//�� CFMS �Ǘ���� �֘A�̒萔 --------------------------------------------------

		define('_ADMIN_NAME_',		_SITE_NAME_.' �Ǘ����');
		define('_ADMIN_NAME_S_',	_SITE_NAME_S_.' �Ǘ����');
		define('_ADMIN_URL_',			_SITE_URL_.'admin2/');
		define('_ADMIN_VER_',			'0.7.5');


		// �o�[�W���j���O��F
		// -------------------------------------------------------------------------
		// 0.7.0.0		���[�U�Ǘ��@�\	priv�ǉ��E�ҏW�C���[�Ustatus�ҏW
		// 0.8.0.0		���[�U�Ǘ��@�\	(�����@�\�̏[��)�C�p�X���[�h���̎�������
		// 0.9.0.0		�Č��Ǘ��@�\		�Č��ǉ��C�Č����̉{���E�ҏW
		// 1.0.0.0		�S�̓I�Ȋ����x�̌���C�����l�̊Ǘ��҃��O�C��


//�� CFMS �w���v �֘A�̒萔 --------------------------------------------------

		define('_HELP_NAME_',			_SITE_NAME_		.	' �w���v');
		define('_HELP_NAME_S_',		_SITE_NAME_S_	.	' �w���v');
		define('_HELP_URL_',			_SITE_URL_2_	.	'help/');
		define('_HELP_VER_',			'0.9.1.0');


?>