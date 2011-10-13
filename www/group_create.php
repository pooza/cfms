<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_group.inc");
	require_once("_class/cms_project.inc");
	require_once("_class/idea.inc");

	$proj = new CommonsProject($_SESSION["p"]);

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	} else if (0 < $proj->Error->ErrorLevel) {
		$proj->Error->Show();
	} else if ($proj->IsEnable("WRITE", new IdeaClass("@GROUP"), $app->LoginUser) == false) {
		$err = new Error("フォルダを作成する権限はありません。", 1);
		$err->Show();
	}

	include("_header.inc");	
?>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='50'><img src='carrotlib/images/cfms1/group_add.gif' height='39' width='48' border='0'></td>
		<td valign='middle' width='590'><font class='emphasis'>フォルダ追加</font></td>
		<td class='gray' align='right' width='100'>[<a href='project.php'>戻る</a>]</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<form action='group_create_result.php' method='post'>
	<table class='white' width='640' border='0' cellspacing='0' cellpadding='30'>
		<tr align='left' valign='top'>
			<td>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td nowrap>
							<font class='emphasis' color='#3366cc'>フォルダ名称　</font>
							<input name='name' size='40' maxlength='64'>
							<input type='submit' value=' O K '>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<?php
	include("_footer.inc");
?>
