<?php
/* --------------------------------------------------------------------

  CFMS �Ǘ���� ��p �֐����C�u����

	2007.04.13	01	cms

-------------------------------------------------------------------- */



// ------------------------------------------------------------------------------------------ [���]

	// �� �ϐ��̃e�X�g�o��
	// ---------------------------------------------------------------------------
	function test ($val){	trace($val);}

// ------------------------------------------------------------------------------------------ [/���]




	// �� notice�̏�������
	// ---------------------------------------------------------------------------
	function fcn_spdb_notice_entry ($con,$_POST){

		if(empty($_POST[content])){	fcn_error_print ("�{�����󗓂ł��B");}	//�K�{����
		$Post = fcn_post_opt_DB($_POST);	//������

		//���[�h����
		switch ($Post[flag]){
			//���e
		 	case "add":
				$date_c	=	date("Y-m-d H:i:s");
				$sql		=	"insert into "._TABLE_NOT_." set "
								.	"date_c"			."='$date_c',"
								.	"app_id"			."='$Post[app_id]',"
								.	"subject"			."='$Post[subject]',"
								.	"content"			."='$Post[content]',"
								.	"type"				."='$Post[type]',"
								.	"adm_flag"		."='$Post[adm_flag]'";
				break;
			//�ҏW
		 	case "edit":
				$sql		=	"update "	 		._TABLE_NOT_." set "
								.	"subject"			."='$Post[subject]',"
								.	"content"			."='$Post[content]' "
								.	"where id="		.$_POST[tid];
				break;
		}

		$Rslt	=	fcn_sql_exec ($con,$sql);
		return $Post;
	}



	// �� list �\�����̔w�i�F�̃R���g���[��
	// ---------------------------------------------------------------------------
	function fcn_list_bgc ($flag){
		switch($flag){
			case 'ACTIVE':	return '#ffffff';	break;
			case 'LEAVE':		return '#dddddd';	break;
			case 'FIX':			return '#dddddd';	break;
		}
	}


?>