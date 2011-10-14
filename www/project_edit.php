<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_project.inc");

	if (isset($_GET["proj"]))
		$_SESSION["p"] = $_GET["proj"];

	$proj = new CommonsProject($_SESSION["p"]);

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	} else if (0 < $proj->Error->ErrorLevel) {
		$proj->Error->Show();
	}

	$proj->Touch();

	include("_header.inc");	
?>

<script type='text/javascript' language='JavaScript'><!--
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
		<td valign='middle' width='590'><font class='emphasis'>案件属性の編集</font></td>
		<td class='gray' align='right' width='100'>[<a href='javascript:history.back()'>戻る</a>]</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<form action='project_edit_result.php' method='post' name='frm'>
	<table class='white' width='640' border='0' cellspacing='0' cellpadding='30'>
		<tr align='left' valign='top'>
			<td width='640'>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td nowrap><font class='emphasis' color='#3366cc'>案件名称</font></td>
						<td nowrap width='20'><img src='carrotlib/images/cfms1/_spacer.gif' alt='' height='1' width='1'></td>
						<td>
							<input name='name' value='<?= $proj->Name ?>' size='50' maxlength='64'>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>作成日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $proj->CreateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>更新日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $proj->UpdateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>納品日</font></td>
						<td width='20'><img src='carrotlib/images/cfms1/_spacer.gif' alt='' height='1' width='1'></td>
						<td valign='middle'>
<?	if ($proj->TermDate->IsInit()) { ?>
							<input type='text' name='term_y' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth) ?> /
							<?= FormatSelect("term_d", $hashDay) ?><br>
<?	} else { ?>
							<input type='text' name='term_y' value='<?= $proj->TermDate->Y ?>' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth, $proj->TermDate->M) ?> /
							<?= FormatSelect("term_d", $hashDay, $proj->TermDate->D) ?><br>
<?	} ?>
							<input onclick='ClearDate()' type='button' value='クリア'>
							<input onclick='SetDate()' type='button' value='今日'>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>状態</font></td>
						<td width='20'></td>
						<td valign='middle'>
							<?= FormatSelect("status", $hashProjectStatus, $proj->Status) ?>&nbsp;
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>備考</font></td>
						<td width='20'></td>
						<td valign='middle'>
							<textarea name='summary' cols='50' rows='5'><?= $proj->Summary ?></textarea>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td nowrap><font class='emphasis' color='#3366cc'>案件番号<br><small>（制作依頼）</small></font></td>
						<td nowrap width='20'><img src='carrotlib/images/cfms1/_spacer.gif' alt='' height='1' width='1'></td>
						<td>
							<input name='order' value='<?= $proj->OrderID ?>' size='6' maxlength='4'>
						</td>
					</tr>
				</table>
				<div align='right'>
					<br>
					<input type='submit' value=' O K '>
				</div>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>メンバー</font></td>
						<td width='20'></td>
						<td class='mono'>
<?php
	$rs = $proj->Users();
	while ($rec = $rs->FetchRecord()) {
		$user = new User($rec->id);
?>
							<?= $user->Format(true) ?><br>
<?	} ?>
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
