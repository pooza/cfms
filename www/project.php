<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_group.inc");
	require_once("_class/cms_project.inc");
	require_once("_class/idea.inc");

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

	$rs = $proj->Users();
	while ($rec = $rs->FetchRecord()) {
		$user = new User($rec->id);
		if ($user->ID == $proj->Owner->ID) {
			$hashMember = array_merge(
				array($user->Company . " " . $user->Name . " （リーダー）"),
				(array)$hashMember
			);
		} else {
			$hashMember[] = $user->Company . " " . $user->Name;
		}
	}
	$hashMember = array_merge(array("メンバー..."), $hashMember);

	include("_header.inc");	
?>

<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr valign='bottom'>
		<td width='30' rowspan='2'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
		<td class='plain'>
			<h1><?= $proj->GetLabel() ?></h1>
			<div class='gray'>納品日: <?= $proj->TermDate->Format("Y-m-d") ?></div>
			<hr noshade size='6' width='100%' color='#666569'>
			<?= FormatSelect("member", $hashMember, null, "member.selectedIndex=0") ?>&nbsp;
			[<a href='project_edit.php'>案件属性</a>]
			[<a href='project_list.php'>案件一覧</a>]
			[<a href='logout.php'>ログアウト</a>]
		</td>
		<td nowrap width='14' rowspan='2'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
		<td class='gray' nowrap width='50' rowspan='2'>
			<form action='project_sort.php' method='post' name='frmSortGroup'>
				<?= FormatSelect("sort_method", $hashOrder, $proj->SortMethod, "frmSortGroup.submit()") ?>&nbsp;
			</form>
			<img src='carrotlib/images/cfms1/_spacer.gif' height='5' width='10'>
		</td>
		<td nowrap width='10' rowspan='2'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
		<td valign='bottom' width='48' rowspan='2'>
			<a href='group_create.php'><img src='carrotlib/images/cfms1/group_add.gif' alt='新規フォルダの追加' border='0'></a><br>
			<img src='carrotlib/images/cfms1/_spacer.gif' height='8' width='10'>
		</td>
		<td nowrap width='10' rowspan='2'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
		<td valign='bottom' width='38' rowspan='2'>
			<a href='idea_create.php'><img src='carrotlib/images/cfms1/idea_add.gif' alt='新規ファイルの追加' border='0'></a><br>
			<img src='carrotlib/images/cfms1/_spacer.gif' height='8' width='10'>
		</td>
		<td width='10' rowspan='2'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
	</tr>
</table>
<img src='carrotlib/images/cfms1/_spacer.gif' height='30' width='100%'><br>


<table border='0' cellspacing='0' cellpadding='10' class='white'>
	<tr>
		<td>

<?php
	$rsGroup = $proj->Groups("igroup.id IS NOT NULL", $hashProjOrder[$proj->SortMethod]);
	while ($recGroup = $rsGroup->FetchRecord()) {
		$group = new CommonsGroup($recGroup->id);
?>

			<table border='0' cellspacing='0' cellpadding='0' bgcolor='#ffffff' height='50'>
				<tr>
					<td align='center' width='50'>
						<a href='group_browse.php?group=<?= $group->ID ?>'><img src='carrotlib/images/cfms1/group.gif' border='0'></a>
					</td>
					<td width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td class='mono' width='625'>
						<a href='group_browse.php?group=<?= $group->ID ?>'><?= $group->GetLabel() ?></a>
					</td>
					<td class='gray' align='right' width='135'>
						<form name='frmSortIdea<?= $group->ID ?>' method='post' action='group_sort.php'>
							<input type='hidden' name='group' value='<?= $group->ID ?>'>
							納品日: <?= bool2str($group->TermDate->IsValid(), $group->TermDate->Format("Y-m-d"), "未設定") ?><br>
							<?= FormatSelect("sort_method", $hashOrder, $group->SortMethod, "frmSortIdea" . $group->ID .".submit()") ?>&nbsp;
						</form>
					</td>
					<td width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td class='mono' width='60'>
						[<a href='group_edit.php?group=<?= $group->ID ?>''>編集</a>]
					</td>
				</tr>
				<tr>
					<td width='50'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td colspan='4'><hr noshade size='6' width='100%' color='<?= $group->GetColor() ?>'></td>
				</tr>
			</table>
			<img src='carrotlib/images/cfms1/_spacer.gif' height='10' width='100%'><br>

<?php
		$arrayCriteria = array();
		$arrayCriteria[] = "(status<>'DELETE')";
		$rsIdea = $group->Ideas(join(" AND ", $arrayCriteria), $hashGroupOrder[$group->SortMethod]);
		while ($recIdea = $rsIdea->FetchRecord()) {
			$idea = new Idea($recIdea->id);
			$file = $idea->GetFile();
			if ($idea->IsEnable("READ", $app->LoginUser)) {
?>
			<table border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='15'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td bgcolor='<?= $group->GetColor("idea") ?>' width='30' height='36' nowrap><a href='idea_open.php?idea=<?= $idea->ID ?>' target='<?= bool2str(in_array($idea->Class->ID, $arrayBlankClass), "_blank", "_self") ?>'><img src='carrotlib/images/cfms1/idea/<?= strtolower($idea->Class->ID) ?>.gif' border='0'></a></td>
					<td width='15'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td class='gray' width='620'>
						<a href='idea_open.php?idea=<?= $idea->ID ?>'><?= $idea->Name ?></a>
						<span class='gray'><?= $file->FormatSize() ?></span><br>
						<span class='gray'>(<?= $idea->Class->Description ?>)</span>

<?				if ($idea->IsNew()) { ?>
						<font class='emphasis' color='red'>New!</font>
<?				} ?>

					</td>
					<td class='gray' width='140'>
						登録日: <?= $idea->CreateDate->Format("Y-m-d") ?><br>
						納品日: <?= bool2str($idea->TermDate->IsValid(), $idea->TermDate->Format("Y-m-d"), "未設定") ?>&nbsp;
					</td>
					<td width='10'><img src='carrotlib/images/cfms1/_spacer.gif' height='1' width='1'></td>
					<td class='mono' width='60'>
						[<a href='idea_edit.php?idea=<?= $idea->ID ?>''>編集</a>]
					</td>
				</tr>
				<tr>
					<td colspan='3'></td>
					<td class='plain' colspan='4'>
						<img src='carrotlib/images/cfms1/_spacer.gif' height='5' width='100%'><br>
						<?= OmitStr($idea->Summary, 64) ?>&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan='3'></td>
					<td colspan='4'><hr noshade size='1' width='100%' color='#d3d3d3'></td>
				</tr>
			</table>

<?			} ?>
<?		} ?>

			<img src='carrotlib/images/cfms1/_spacer.gif' height='40' width='100%'>

<?	} ?>

		</td>
	</tr>
</table>

<?php
	include("_footer.inc");
?>
