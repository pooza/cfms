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
	}

	$hashOrderSQL = array(
		"NAME" => "idea.name",
		"CREATE" => "idea.create_date,idea.name",
		"CREATED" => "idea.create_date DESC,idea.name",
		"UPDATE" => "idea.update_date,idea.name",
		"UPDATED" => "idea.update_date DESC,idea.name",
		"TERM" => "idea.term_date,idea.name",
		"TERMD" => "idea.term_date DESC,idea.name",
		"POINTD" => "idea.name");
	$arrayCriteria = array();
	$arrayCriteria[] = "(status<>'DELETE')";
	$rsIdea = $group->Ideas(join(" AND ", $arrayCriteria), $hashOrderSQL[$group->SortMethod]);
	if ($rsIdea->NumRows == 0) {
		$err = new Error("このフォルダにはファイルがありません。", 1);
		$err->Show();
	}

	$group->Touch();
	include("_header.inc");	
?>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr>
		<td width='50'><img src='carrotlib/images/cfms1/group.gif' height='39' width='48' border='0'></td>
		<td valign='middle' width='590'><font class='emphasis'>フォルダ内ファイルの一覧</font></td>
		<td class='gray' align='right' width='100'>[<a href='project.php'>戻る</a>]</td>
	</tr>
	<tr>
		<td colspan='3' height='10'></td>
	</tr>
	<tr>
		<td colspan='3' height='10' class='mono'>
<?php
	$rsGroup = $proj->Groups();
	$hashGroup = $rsGroup->Hash();
?>
			<form name='frmGroup' method='get'>
				<?= $proj->GetLabel() ?> &gt;&gt;
				<?= FormatSelect("group", $hashGroup, $group->ID, "frmGroup.submit()") ?>&nbsp;
			</form>
		</td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr align='left' valign='top'>

<?php
	$intColumn = 0;
	while ($recIdea = $rsIdea->FetchRecord()) {
		$idea = new Idea($recIdea->id);
		$file = $idea->GetFile();
		if ($idea->IsEnable("READ", $app->LoginUser)) {
			$intColumn ++;
			if (3 < $intColumn) {
				$intColumn = 1;
?>
	</tr>
	<tr>
		<td height='10' colspan='6'></td>
	</tr>
	<tr align='left' valign='top'>
<?			} ?>

		<td align='center' bgcolor='white' width='200'>
			<table border='0' cellspacing='0' cellpadding='6'>
				<tr align='middle' valign='top'>
					<td nowrap height='10'></td>
				</tr>
				<tr align='middle' valign='top'>
					<td align='center' width='200' height='140'>
<?			if (in_array($idea->Class->ID, $arrayThumbClass)) { ?>
						<a href='idea_open.php?idea=<?= $idea->ID ?>' target='_blank'><img src='idea_thumb.php?idea=<?= $idea->ID ?>' height='<?= THUMBNAIL_SIZE ?>' width='<?= THUMBNAIL_SIZE ?>' border='0'></a>
<?			} else { ?>
						<table>
							<tr>
								<td height='150' width='150' bgcolor='gray' class='emphasis' align='center'>No Image</td>
							</tr>
						</table>
<?			}?>
					</td>
				</tr>
				<tr align='middle' valign='top'>
					<td nowrap height='10'></td>
				</tr>
				<tr align='left' valign='top'>
					<td class='mono'>
						<a href='idea_open.php?idea=<?= $idea->ID ?>' target='<?= bool2str(in_array($idea->Class->ID, $arrayBlankClass), "_blank", "_self") ?>'><?= $idea->Name ?></a>
<?			if ($idea->IsNew()) { ?>
						<font class='emphasis' color='red'>New!</font>
<?			} ?>
						<?= $file->FormatSize() ?><br>
<?			if (in_array($idea->Class->ID, $arrayThumbClass)) { ?>
						<?= $idea->FormatImageSize() ?>
<?			}?>
					</td>
				</tr>
			</table>
		</td>
		<td nowrap width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>

<?		} ?>
<?	} ?>

<?	for ($i = $intColumn ; $i < 3 ; $i ++) {?>
		<td align='center' nowrap bgcolor='white' width='200'></td>
		<td nowrap width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
<?	} ?>

	</tr>
	<tr align='left' valign='top' height='10'>
		<td colspan='6' nowrap height='10'></td>
	</tr>
</table>

<?php
	include("_footer.inc");
?>
