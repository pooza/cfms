<?php
	require_once("carrotlib/php/cfms1/_def.inc");
	require_once("_class/cms_project.inc");

	if (!isset($app->LoginUser->ID)) {
		$err = new Error("不正なユーザーです。", 2);
		$err->Close();
	}

	$arrayCriteria[] = "(project.status<>'FIX')";
	$arrayCriteria[] = "(priv.class_id<>'GROUP')";
	$rsProj = $app->LoginUser->Projects(join(" AND ", $arrayCriteria));

	include("_header.inc");
?>

<h2><?= APP_NAME ?></h2>

<?	if (file_exists("news.txt")) { ?>
<table cellspacing='1' cellpadding='2' bgcolor='gray'>
	<tr>
		<td class='gray' bgcolor='white' width='650'>
			【お知らせ】<br>
			<?= nl2br(file_get_contents("news.txt")) ?>
		</td>
	</tr>
</table>

<?	} ?>

<img src='carrotlib/images/cfms1/_spacer.gif' height='10' width='100%'>

<h2><font color='#3366cc'>■ <?= $app->LoginUser->Company ?> <?= $app->LoginUser->Name ?> 様の担当案件一覧</font></h2>

<img src='carrotlib/images/cfms1/_spacer.gif' height='10' width='100%'>

<table cellspacing='1' cellpadding='2' bgcolor='gray'>
	<tr>
		<th class='mono' bgcolor='white' width='150' align='center'>更新日付</th>
		<th class='mono' bgcolor='white' width='300' align='center'>案件名</th>
		<th class='mono' bgcolor='white' width='60' align='center'>状態</th>
		<th class='mono' bgcolor='white' width='60' align='center'>案件番号</th>
		<th bgcolor='white' width='60'>&nbsp;</th>
	</tr>

<?php
	while ($recProj = $rsProj->FetchRecord()) {
		$proj = new CommonsProject($recProj->id);
?>

	<tr>
		<td class='gray' align='center' bgcolor='white' width='150'><?= $proj->UpdateDate->Format("Y/m/d H:i:s") ?></td>
		<td class='gray' bgcolor='white' width='300'>
				<a href='project.php?proj=<?= $proj->ID ?>'><?= $proj->GetLabel() ?></a>
		</td>
		<td class='gray' bgcolor='white' width='60' align='center'><?= $hashProjectStatus[$proj->Status] ?></td>
		<td class='gray' bgcolor='white' width='60' align='center'><?= $proj->OrderID ?></td>
		<td class='gray' bgcolor='white' width='60' align='center'>
			[<a href='project.php?proj=<?= $proj->ID ?>'>編集</a>]
		</td>
	</tr>

<?	} ?>

</table>

<?php
	include("_footer.inc");
?>
