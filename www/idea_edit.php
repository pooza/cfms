<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_group.inc");
	require_once("_class/cms_project.inc");
	require_once("_class/idea.inc");

	if (isset($_GET["idea"]))
		$_SESSION["i"] = $_GET["idea"];

	$proj = new CommonsProject($_SESSION["p"]);
	$idea = new Idea($_SESSION["i"]);

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	} else if (0 < $proj->Error->ErrorLevel) {
		$proj->Error->Show();
	} else if (0 < $idea->Error->ErrorLevel) {
		$idea->Error->Show();
	} else if ($idea->IsEnable("READ", $app->LoginUser) == false) {
		$err = new Error("ファイルを閲覧する権限はありません。", 1);
		$err->Show();
	}

	$idea->Touch(false);
	include("_header.inc");	
?>

<script type='text/javascript' language='JavaScript'><!--
function ConfirmDelete () {
	if (confirm("ファイル「<?= $idea->Name ?>」を削除します。"))
		location.href = "idea_delete.php?idea=" + <?= $idea->ID ?>
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
		<td valign='middle' width='590'><font class='emphasis'>ファイル属性の編集</font></td>
		<td class='gray' align='right' width='100'>[<a href='project.php'>戻る</a>]</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<form action='idea_edit_result.php' method='post' name='frm'>
	<table class='white' width='640' border='0' cellspacing='0' cellpadding='30'>
		<tr align='left' valign='top'>
			<td>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>名称</font></td>
						<td nowrap width='20'><spacer height='1' type='block' width='1'></td>
						<td>
							<input type='text' name='name' value='<?= htmlspecialchars($idea->Name, ENT_QUOTES) ?>' size='50' maxlength='64'>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>フォルダ</font></td>
						<td width='20'></td>
						<td>
<?php
	$rsGroup = $proj->Groups();
	$hashGroup = $rsGroup->Hash();

	// このアイデアのグループを取得
	$rsMyGroup = $idea->Groups();
	$recGroup = $rsMyGroup->FetchRecord();
	$group = new CommonsGroup($recGroup->id);
?>
							<?= FormatSelect("group", $hashGroup, $group->ID) ?>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>コメント</font></td>
						<td width='20'><spacer height='1' type='block' width='1'></td>
						<td nowrap><textarea name='summary' rows='5' cols='50'><?= $idea->Summary ?></textarea></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>作成日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $idea->CreateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>更新日</font></td>
						<td width='20'></td>
						<td class='mono'><?= $idea->UpdateDate->Format("Y年 n月j日(w) H:i:s") ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>作成者</font></td>
						<td width='20'></td>
						<td class='mono'><?= $idea->Owner->Format() ?></td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>納品日</font></td>
						<td width='20'></td>
						<td nowrap>
<?	if ($idea->TermDate->IsInit()) { ?>
							<input type='text' name='term_y' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth) ?> /
							<?= FormatSelect("term_d", $hashDay) ?><br>
<?	} else { ?>
							<input type='text' name='term_y' value='<?= $idea->TermDate->Y ?>' size='6' maxlength='4'> /
							<?= FormatSelect("term_m", $hashMonth, $idea->TermDate->M) ?> /
							<?= FormatSelect("term_d", $hashDay, $idea->TermDate->D) ?><br>
<?	} ?>
							<input onclick='ClearDate()' type='button' value='クリア'>
							<input onclick='SetDate()' type='button' value='今日'>
						</td>
					</tr>
				</table>
				<div align='right'>
					<br>
					<input type='submit' value=' O K '>
					<input onclick='location.href=&quot;idea_open.php?download=1&quot;' type='button' value='このファイルをダウンロード...'>
					<input onclick='ConfirmDelete()' type='button' value='このファイルを削除...'>
				</div>
			</td>
		</tr>
	</table>
</form>

<?php
	include("_footer.inc");
?>
