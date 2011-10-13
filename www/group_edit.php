<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_group.inc");
	require_once("_class/cms_project.inc");

	if (isset($_GET["group"]))
		$_SESSION["g"] = $_GET["group"];

	$proj = new CommonsProject($_SESSION["p"]);
	$group = new CommonsGroup($_SESSION["g"]);

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	} else if (0 < $proj->Error->ErrorLevel) {
		$proj->Error->Show();
	} else if (0 < $group->Error->ErrorLevel) {
		$group->Error->Show();
	} else if ($group->IsEnable("READ", $app->LoginUser) == false) {
		$err = new Error("フォルダを閲覧する権限はありません。", 1);
		$err->Show();
	}

	$group->Touch();
	include("_header.inc");	
?>

<script type='text/javascript' language='JavaScript'><!--
function ConfirmDelete () {
	if (confirm("フォルダ「<?= $group->Name ?>」を削除します。\n（フォルダ内のファイルも削除されます！）"))
		location.href = "group_delete.php?group=" + <?= $group->ID ?>
}

function ClearDate() {
	frm.term_y.value = ""
	frm.term_m.selectedIndex = 0
	frm.term_d.selectedIndex = 0
}

function SetDate() {
	date = new Date
	frm.term_y.value = date.getFullYear()
	frm.term_m.selectedIndex = date.getMonth() + 1
	frm.term_d.selectedIndex = date.getDate()
}
// -->
</script>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='50'><img src='carrotlib/images/cfms1/group.gif' height='39' width='48' border='0'></td>
		<td valign='middle' width='590'><font class='emphasis'>フォルダ属性の編集</font></td>
		<td class='gray' align='right' width='100'>[<a href='project.php'>戻る</a>]</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<form action='group_edit_result.php' method='post' name='frm'>
	<table class='white' width='640' border='0' cellspacing='0' cellpadding='30'>
		<tr align='left' valign='top'>
			<td width='640'>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td nowrap><font class='emphasis' color='#3366cc'>フォルダ名称</font></td>
						<td nowrap width='20'><img src='carrotlib/images/cfms1/_spacer.gif' alt='' height='1' width='1'></td>
						<td>
							<input name='name' value='<?= $group->Name ?>' size='50' maxlength='64'>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>作成日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $group->CreateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>更新日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $group->UpdateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td rowspan='2' nowrap><font class='emphasis' color='#3366cc'>納品日</font></td>
						<td rowspan='2' nowrap width='20'><img src='carrotlib/images/cfms1/_spacer.gif' alt='' height='1' width='1'></td>
						<td valign='middle'>
<?	if ($group->TermDate->IsInit()) { ?>
							<input type='text' name='term_y' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth) ?> /
							<?= FormatSelect("term_d", $hashDay) ?><br>
<?	} else { ?>
							<input type='text' name='term_y' value='<?= $group->TermDate->Y ?>' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth, $group->TermDate->M) ?> /
							<?= FormatSelect("term_d", $hashDay, $group->TermDate->D) ?><br>
<?	} ?>
							<input onclick='ClearDate()' type='button' value='クリア'>
							<input onclick='SetDate()' type='button' value='今日'>
						</td>
					</tr>
				</table>
				<div align='right'>
					<br>
				</div>
			</td>
		</tr>
	</table>
</form>

<?php
	include("_footer.inc");
?>
