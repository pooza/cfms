<?php

//�� �N��
// -----------------------------------------------------------------------------
		require_once('xdef.admin.inc');
		// fcn_basic_auth();
		$con = fcn_db_connect();
// -----------------------------------------------------------------------------


// �A�N�Z�X����
		if(!isset($_COOKIE['cfms_admin2']))	error('�s���ȃA�N�Z�X�ł��B','close');


//�� ���[�h����
// ------------------------------------------------------------------------------------------------- [mode]
		$mode	=	fcn_verify_getprm ($_GET['mode']);
		switch($mode){


			// �Č��̒ǉ� ------------------------------------------------------------ [�ǉ�]
			case 'add':

				fcn_header_admin ('�Č��̒ǉ�');
				include_once('admin.tab.project.2.php');
				spacer(20);
		
				print "<div class='notice'>�H����</div>\n";
				break;


			// �Č����烆�[�U�𒊏o -------------------------------------------------- [���[�U���o]
			case 'proj-user':

				if(!isset($_GET[tid]))	error('�s�K�؂ȃA�N�Z�X�ł��B','close');
				$tid = trim($_GET[tid]);

				fcn_header_admin ('�Č����烆�[�U�𒊏o');
				include_once('admin.tab.project.3.php');
				spacer(20);

				// SQL
				$sql	=	"select "
							.	"user.name as name, user.status as status, priv.user_id as id, user.password as pw, user.company as company "
							.	"from priv,user "
							.	"where priv.user_id=user.id and priv.project_id=$tid "
							. "order by user.company, user.section, user.id";
				$Rslt	=	fcn_sql_exec ($con,$sql);

				$rows	= mysql_num_rows ($Rslt);	// �\���A�C�e����

				if($rows==0){
					error('���̈Č��Ɋ֌W���郆�[�U�͂��܂���B','back');
				}else{
					$title = fcn_sql_sa("select name from project where id=".$tid);
					print "<div class='plain'>"
							.	"�Č�&nbsp;<font color='red'>$title</font>&nbsp;�ɂ́A"
							.	"<font color='red'>$rows</font>�l�̃��[�U���o�^����Ă��܂��B"
							.	"</div>\n";
					spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>���[�U��</td>
<td class='plain'>ID</td>
<td class='plain'>PW</td>
<td class='plain'>��Ж�</td>
<td class='plain'>�Č�</td>
<td class='plain'>�ē�</td>
</tr>
<?				while ($Rec = mysql_fetch_array($Rslt)){	include	('admin.list.project.php');	}		?>
</table>
<?			}
				break;


			// ���[�U����Č��𒊏o -------------------------------------------------- [�Č����o]
			case 'user-proj':
			
				$tid	=	fcn_verify_getprm ($_GET['tid']);
				fcn_header_admin ('���[�U����Č��𒊏o');
				include_once('admin.tab.project.3.php');
				spacer(20);
				$user_name	=	fcn_get_username($tid);
				include_once('admin.form.priv.entry.php');

				break;


			// �ē��p�̕\�� ---------------------------------------------------------- [�ē�]
			case 'user-info':

				$tid	=	fcn_verify_getprm ($_GET['tid']);
				fcn_header_admin ('�ē��p�̕\��');
				include_once('admin.tab.project.3.php');
				spacer(20);

				// --------------------------------------------------------------------- SQL
				$sql	=	'select '
							.	'user.name as name, user.id as id, user.password as pw, user.company as company '
							.	'from user '
							.	"where user.id='$tid'";
				$Rslt	=	fcn_sql_exec ($con,$sql);
				$Rec	=	mysql_fetch_array($Rslt);
				// --------------------------------------------------------------------- /

				// �c����؂�o��
				$Name	=	explode(' ',$Rec['name']);	$fam_name	=	$Name['0'];

				$HTML[]	= '<textarea name=guide rows=20 cols=70>';
				if($Rec['company'] !='(�t���[)')	$HTML[]	= $Rec['company'];
				$HTML[]	= $fam_name.' �l';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '���Ђ́uCOMMONS�t�@�C���Ǘ��V�X�e���v��';
				$HTML[]	= '���[�U�o�^�������܂����B';
				$HTML[]	= '';
				$HTML[]	= '���V�X�e���ł́A�v���W�F�N�g�̃����o�[�Ԃ�';
				$HTML[]	= '���S�Ƀt�@�C�������L���邱�Ƃ��ł��܂��B';
				$HTML[]	= '���Ђ����p���������B';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= _SITE_NAME_;
				$HTML[]	= _SITE_URL_;
				$HTML[]	= _SITE_NAME_	.' �w���v';
				$HTML[]	= _SITE_URL_	.'help/';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '�����O�C�����';
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= '���O�C��ID�F�@'.$Rec['id'];
				$HTML[]	= '�p�X���[�h�F�@'.$Rec['pw'];
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= '';
				$HTML[]	= '';
				// --------------------------------------------------------------------- SQL
				$sql	=	"select project.name as name from project,priv "
							.	"where project.id=priv.project_id and priv.user_id='$tid' "
							.	"order by priv.project_id desc";
				$Rslt	=	fcn_sql_exec ($con,$sql);
				// --------------------------------------------------------------------- /
				$HTML[]	= '���A�N�Z�X�\�ȈČ�(�v���W�F�N�g)';
				$HTML[]	= '--------------------------------------------------';
				while	($Rec	=	mysql_fetch_array($Rslt)){
				$HTML[]	=	'�E'.$Rec['name'];
				}
				$HTML[]	= '--------------------------------------------------';
				$HTML[]	= '';
				$HTML[]	= '';
				$HTML[]	= '�ȏ�A��낵�����肢�������܂��B';
				$HTML[]	= '�@';
				$HTML[]	= '</textarea>';
	
				print implode("\n",$HTML);
				break;


			// �Č��̈ꗗ ------------------------------------------------------------ [�ꗗ]
			case 'list':

				fcn_header_admin ('�Č��ꗗ');
				include_once('admin.tab.project.1.php');
				spacer(20);

				// SQL
				$sql	=	"select project.id, project.name, project.owner, project.status, project.access_date as a_date,"
							.	" count(priv.user_id) as users "
							.	"from"
							.	" project,priv "
							.	"where"
						//.	" project.id = priv.project_id and"
							.	" project.id = priv.project_id "
							.	"group by priv.project_id "
							.	"order by project.id desc";
				$Rslt	=	fcn_sql_exec ($con,$sql);
	
				$recs	=	fcn_sql_sa ('select count(id) from project');	// ���A�C�e��
				$rows	= mysql_num_rows ($Rslt);	// �\���A�C�e����

				if($rows==0){
					if($recs==0){
						error('�܂��Č����o�^����Ă��܂���B','back');
					}else{
						error('���̃��[�U�Ɋ֌W����Č��͂���܂���','back');
					}
				}else{
					print "<div class='plain'>�S<font color='red'>$recs</font>���̈Č����o�^����Ă��܂��B</div>\n";
					spacer(15);
?>
<table cellspacing='1' cellpadding='4' border='0' bgcolor='#cccccc'>
<tr bgcolor='#ccccff'>
<td class='plain'>ID</td>
<td class='plain'>�Č���</td>
<td class='plain'>�I�[�i�[</td>
<td class='plain'>�ŏI�A�N�Z�X</td>
<td class='plain'>���[�U��</td>
</tr>
<?				while	($Rec = mysql_fetch_array($Rslt)){	include	('admin.list.project.php');	}	?>
</table>
<?			}
				break;
		}
// ------------------------------------------------------------------------------------------------- [/mode]


//�� �t�b�^�o��
// -----------------------------------------------------------------------------
		spacer(20);
		include_once('admin.submenu.projects.php');
		include_once('_footer.admin.php');
// -----------------------------------------------------------------------------
?>