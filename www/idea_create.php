<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_group.inc");
	require_once("_class/cms_project.inc");

	$proj = new CommonsProject($_SESSION["p"]);

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	} else if (0 < $proj->Error->ErrorLevel) {
		$proj->Error->Show();
	}

	include("_header.inc");	
?>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='50'><img src='carrotlib/images/cfms1/idea_add.gif' height='44' width='38' border='0'></td>
		<td valign='middle' width='590'><font class='emphasis'>新規ファイルの追加</font></td>
		<td class='gray' align='right' width='100'>[<a href='project.php'>戻る</a>]</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<form action='idea_create_result.php' method='post' enctype='multipart/form-data'>
	<input type='hidden' name='MAX_FILE_SIZE' value='<?= MAX_FILE_SIZE * 1024 * 1024 ?>'>
	<table class='white' width='640' border='0' cellspacing='0' cellpadding='30'>
		<tr align='left' valign='top'>
			<td>
				<table border='0' cellspacing='0' cellpadding='2'>
					<tr align='left' valign='top'>
						<td rowspan='2' nowrap><font class='emphasis' color='#3366cc'>アップロード</font></td>
						<td rowspan='2' nowrap width='20'><spacer height='1' type='block' width='1'></td>
						<td>
							<input type='file' name='file' size='40'>
							<input type='submit' value=' O K '>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td class='mono'>
							+ <?= MAX_FILE_SIZE ?>MBまでの書類をアップできます。<br>
							+ <?= join(",", $arrayThumbClass) ?> ファイルのみ、サムネールが生成されます。<br>
							+ 下記のファイルタイプはアイコンで表されます：<br>
<?php
	$rs = $app->IdeaClasses("(isfile='TRUE') and (id<>'file')");
	while ($rec = $rs->FetchRecord()) {
		$class = new IdeaClass($rec->id);
?>
							　<b>.<?= strtolower($class->ID) ?></b>: <?= $class->Description ?><br>
<?	} ?>
							+ アップするファイルには適切な拡張子をおつけ下さい。
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td><font class='emphasis' color='#3366cc'>フォルダ</font></td>
						<td width='20'></td>
						<td>
<?php
	$rsGroup = $proj->Groups();
	$hashGroup = $rsGroup->Hash();
?>
							<?= FormatSelect("group", $hashGroup) ?>
						</td>
					</tr>
					<tr align='left' valign='top'>
						<td rowspan='2'><font class='emphasis' color='#3366cc'>コメント</font></td>
						<td nowrap width='20'><spacer height='1' type='block' width='1'></td>
						<td><textarea name='summary' rows='5' cols='50'></textarea></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<?php
	include("_footer.inc");
?>
