<?php


// �N��
// -----------------------------------------------------------------------------
		require_once ("xdef.admin.inc");
		$con = fcn_db_connect();
// -----------------------------------------------------------------------------


// ���[�U�ǉ�
// -----------------------------------------------------------------------------
		if(isset($_POST[btn_user_confirm])){
			$Post	=	fcn_user_entry ($con,$_POST);
			switch($Post[flag]){
				case "add";
					header("Location: ".$PHP_SELF."?mode=result&tid=".$Post[email]);
					break;
				case "edit";
					header("Location: ".$PHP_SELF."?mode=result&tid=".$Post[id]);
					break;
			}
		}
// -----------------------------------------------------------------------------


// �A�N�Z�X����
// -----------------------------------------------------------------------------
		if(!isset($_COOKIE[cfms_admin2])){error("�s���ȃA�N�Z�X�ł��B","close");}
// -----------------------------------------------------------------------------


// --------------------------------------------------------------------------------- ���[�h���� �J�n
if(isset($_GET[mode]) && !empty($_GET[mode])){
	switch($_GET[mode]){


	// ���[�U�ǉ����[�h ------------------------------------------------------------------------[�ǉ�]
	case "add":

		fcn_header_admin ("���[�U�ǉ�");
		include_once("admin.tab.user.2.php");
		spacer(30);
		$fcn = "add";
		include_once("admin.form.user.entry.php");
		break;


	// ���[�U�ҏW���[�h ------------------------------------------------------------------------[�ҏW]
	case "edit":

		if(!isset($_GET[tid])){error("�s�K�؂ȃA�N�Z�X�ł��B","close");}
		$tid = trim($_GET[tid]);

		fcn_header_admin ("���[�U�ҏW");
		include_once("admin.tab.user.3.php");
		spacer(30);
		$fcn = "edit";
		$user_name = fcn_get_username($tid);
		include_once("admin.form.user.entry.php");
		break;


	// ���[�U�o�^ ���ʕ\�����[�h -----------------------------------------------------------[�o�^����]
	case "result":

		if(!isset($_GET[tid])){error("�s�K�؂ȃA�N�Z�X�ł��B","close");}
		$tid = trim($_GET[tid]);

		fcn_header_admin ("���[�U�o�^����");
		include_once("admin.tab.user.3.php");
		spacer(30);
		$user_name = fcn_get_username($tid);
		print "<div class='plain'>"
				.	"���[�U&nbsp;<font color='red'>$user_name</font>&nbsp;��o�^���܂����B&nbsp;"
				.	"<span class='gray'>[<a href='user.php?mode=edit&tid=$tid'>�ĕҏW</a>]</span>&nbsp;"
				.	"<span class='gray'>[<a href='project.php?mode=user-info&tid=$tid'>�ē�</a>]</span>"
				.	"</div>\n";
		spacer(20);
		break;


	// ���[�U�������[�h ------------------------------------------------------------------------[����]
	case "list":

		fcn_header_admin ("���[�U����");
		include_once("admin.tab.user.1.php");
		spacer(20);

		$recs	=	fcn_sql_sa ("select count(id) from user");	// ���l��
		if(!$recs==0){
			print "<div class='plain'>�S<font color='red'>$recs</font>�l�̃��[�U���o�^����Ă��܂��B</div>";
			spacer(15);
			include_once("admin.form.user.search.php");
			spacer(30);
		}

		// �������s
		if(isset($_POST[fws])){
			$keyword	=	$_POST[fws];
			include_once("admin.list.user.php");
		}elseif(isset($_GET[fws])){
			$keyword	=	$_GET[fws];
			include_once("admin.list.user.php");
		}
		break;
	}
// --------------------------------------------------------------------------------- ���[�h���� �I��
	spacer(20);

	// �T�u���j���[�o��
	include_once("admin.submenu.projects.php");

	// �t�b�^�o��
	include_once("_footer.admin.php");

}else{
// -------------------------------------------------------------------------------------- ���[�h���X
	error ("�������Ȃ����@�ł��̉�ʂ��J���Ă��܂��B","back");
}
?>