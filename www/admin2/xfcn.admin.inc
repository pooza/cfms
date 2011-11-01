<?php
/* --------------------------------------------------------------------------

	CFMS �Ǘ���� ��p�֐����C�u����

	2005.04.21	01	cms

-------------------------------------------------------------------------- */



//�� ID���烆�[�U�����擾����
function fcn_get_username($id)	{
	return fcn_sql_sa("select name from user where id='".$id."'");
}



//�� ��ʃw�b�_�̏o��
function fcn_header_admin ($subtitle){
	include_once ("_header.admin.php");
	print "<body>"."\n";
	include_once ("_menu.admin.php");
	
	print "<table cellspacing='0' cellpadding='0' border='0'>"."\n";
	print "<tr>"."\n";
	print "<td valign='top' width='10'></td>"."\n";
	print "<td valign='top'>"."\n"."\n";

	spacer(5);
	print "<div class='function'>"._APP_NAME_S_."�F&nbsp;".$subtitle."</div>";
	spacer(15);
}



//�� ���[�U�o�^
function fcn_user_entry ($con,$_POST){
	$Post	=	fcn_clean_array ($_POST,'db');

	// �K�{����
	// ---------------------------------------------------------------------------
	if(empty($Post[name]))		{	error("���O����͂��Ă��������B","back");						}
	if(empty($Post[name_r]))	{	error("�����i�p��j����͂��Ă��������B","back");		}
	if(empty($Post[email]))		{	error("���[���A�h���X����͂��Ă��������B","back");	}
	//if(empty($Post[company]))	{	error("��Ж�����͂��Ă��������B","back");					}
	if(empty($Post[pw]))			{	error("�p�X���[�h����͂��Ă��������B","back");			}

	// �Ó����`�F�b�N
	// ---------------------------------------------------------------------------
	if(!fcn_validate_mail($Post[email])){	error("�s�K�؂ȃ��[���A�h���X�ł��B","back");	}
	if(mb_detect_encoding($Post[pw]) != "ASCII"){	error("�s�K�؂ȃp�X���[�h�ł��B","back");	}

	// SQL
	// ---------------------------------------------------------------------------
		$date	=	date("Y-m-d H:i:s");
		switch ($Post[flag]){

			//�� �o�^�̏ꍇ
	    case "add":
				// --------------------------------------------------------------------
				// �d���o�^�`�F�b�N
				// --------------------------------------------------------------------
				$dup_ck	=	fcn_sql_sa("select id from user where id='".$Post[email]."' group by id");
				if(!empty($dup_ck)){
					error	("�d���o�^�ł��F<br>���[���A�h���X&nbsp;".$Post[email],"back");
				}
				// ---------------------------------------------------------------------
				// ���[�U�o�^
				// ---------------------------------------------------------------------
				$sql	=	"insert into user set "
							.	"id"					."='".	$Post[email]		."',"
							.	"create_date"	."='".	$date						."',"
							.	"name"				."='".	$Post[name]			."',"
							.	"name_read"		."='".	$Post[name_r]		."',"
							.	"email"				."='".	$Post[email]		."',"
							.	"company"			."='".	$Post[company]	."',"
							.	"section"			."='".	$Post[section]	."',"
							.	"title"				."='".	$Post[title]		."',"
							.	"password"		."='".	$Post[pw]				."'";
				$Rslt =	fcn_sql_exec($con,$sql);
				// ---------------------------------------------------------------------
				// ���[�U���Č��ɃA�T�C��
				// ---------------------------------------------------------------------
				if($Post[priv] != "NULL"){
					$Priv	=	explode("/",$Post[priv]);
					asort($Priv);
					foreach ($Priv as $key => $value){
						$sql	=	"insert into priv set "
									.	"project_id"	."='".$Priv[$key]		."',"
									.	"user_id"			."='".$Post[email]	."',"
									.	"class_id"		."='"."IDEA"				."',"
									.	"priv"				."='"."ALL"					."'";
						$Rslt =	fcn_sql_exec($con,$sql);
					}
				}
				break;

			//�� �ҏW�̏ꍇ
	    case "edit":
				// ---------------------------------------------------------------------
				// [�ǉ�] �K�{����
				// ---------------------------------------------------------------------
				if(empty($Post[id])){	error("ID����͂��Ă��������B","back");}
				// ---------------------------------------------------------------------
				// [�ǉ�] �Ó����`�F�b�N
				// ---------------------------------------------------------------------
				if(mb_detect_encoding($Post[id]) != "ASCII"){	error("�s�K�؂�ID�ł��B","back");	}
				// ---------------------------------------------------------------------
				// ID�C���̏ꍇ
				// ---------------------------------------------------------------------
				$old_id	= fcn_sql_sa("select id from user where id='$Post[tid]'");
				if($Post[id] != $old_id){
					$new_id	=	$Post[id];
					fcn_sql_exec($con,"update idea set owner='$new_id' where owner='$old_id'");
					fcn_sql_exec($con,"update igroup set owner='$new_id' where owner='$old_id'");
					fcn_sql_exec($con,"update priv set user_id='$new_id' where user_id='$old_id'");
					fcn_sql_exec($con,"update project set owner='$new_id' where owner='$old_id'");
				}
				// ---------------------------------------------------------------------
				// ���[�U���̍X�V
				// ---------------------------------------------------------------------
				$sql	=	"update user set "
							.	"id"					."='".	$Post[id]				."',"
							.	"update_date"	."='".	$date						."',"
							.	"name"				."='".	$Post[name]			."',"
							.	"name_read"		."='".	$Post[name_r]		."',"
							.	"email"				."='".	$Post[email]		."',"
							.	"company"			."='".	$Post[company]	."',"
							.	"section"			."='".	$Post[section]	."',"
							.	"title"				."='".	$Post[title]		."',"
							.	"password"		."='".	$Post[pw]				."', "
							.	"status"			."='".	$Post[status]		."' "
							.	"where id"		."='".	$Post[tid]			."'";
				$Rslt =	fcn_sql_exec($con,$sql);
				// ---------------------------------------------------------------------
				// ���[�U���Č��ɃA�T�C��
				// ---------------------------------------------------------------------
				// �����̃A�T�C���ݒ���폜
				fcn_sql_exec($con,"delete from priv where user_id='$Post[tid]'");
				// �A�T�C���ݒ�
				if($Post['status'] !='LEAVE'){	// �މ�̏ꍇ�͏������܂܂ɂȂ�
					if($Post['priv'] != "NULL"){
						$Priv	=	explode("/",$Post[priv]);
						asort($Priv);
						foreach ($Priv as $key => $value){
							$sql	=	"insert into priv set "
										.	"project_id"	."='".	$Priv[$key]	."',"
										.	"user_id"			."='".	$Post[id]		."',"
										.	"class_id"		."='".	"IDEA"			."',"
										.	"priv"				."='".	"ALL"				."'";
							@mysql_query($sql);
						}
					}
				}
				break;
		}
	// ---------------------------------------------------------------------------

	return $Post;
}



//�� ���j���[�����F[�Č�]
function fcn_make_sel_priv ($con,$fcn,$selected){
	$Rslt = fcn_sql_exec($con,"select id,name,owner from project order by id desc");

	switch($fcn){

	case "add":
		$HTML[]	= "<select name='Priv[]' size='10' multiple>";
		while ($Rec = mysql_fetch_array($Rslt)){
			if($Rec[id]==$selected){
				$HTML[]	= "<option value='$Rec[id]' selected>$Rec[name]</option>";
			}else{
				$HTML[]	= "<option value='$Rec[id]'>$Rec[name]</option>";
			}
		}
		break;

	case "edit":
		$HTML[]	= "<select name='Priv[]' size='20' multiple>";
		while ($Rec = mysql_fetch_array($Rslt)){
			$Rsub	=	mysql_query	("select project_id from priv where user_id='$selected' and project_id='$Rec[id]'");
			$rows	=	mysql_num_rows($Rsub);
			if($rows != 0){
				$HTML[]	= "<option value='$Rec[id]' selected>$Rec[name]</option>";
			}else{
				$HTML[]	= "<option value='$Rec[id]'>$Rec[name]</option>";
			}
		}
		break;
	}
	
	$HTML[]	= "</select>";
	print implode("\n",$HTML);
	unset ($HTML);
}



//�� ���j���[�����F[����]
function fcn_make_sel_search ($con,$type){
	switch($type){

	case "company":

		$Rslt = fcn_sql_exec($con,
						"select company from user where company is not NULL group by company order by company;");
		$HTML[]	= "<form>";
		$HTML[]	= "<select name='sel_company' size='1' onChange='location=this.options[this.selectedIndex].value'>";
		$HTML[]	= "<option value=''>��Ж��ōi�荞�� --> </option>";
		$HTML[]	= "<option value=''> ---------------- </option>";
		while ($Rec = mysql_fetch_array($Rslt)){
		$HTML[]	= "<option value='"._APP_URL_."user.php?mode=list&fws=".$Rec[company]."'>"
						.	$Rec[company]."</option>";
		}
		$HTML[]	= "</select>";
		$HTML[]	= "</form>";
		print implode("\n",$HTML);
		break;
	}
}



?>