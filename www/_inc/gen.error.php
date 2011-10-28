<?
require_once("xdef.inc");
?>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=Shift_JIS">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title><?=_SITE_NAME_?>　エラー</title>
<style>
a{color:#2e8b57;font-size:12px;line-height:14px;text-decoration:none;margin:0px;padding:0px}
a:active{color:#2e8b57;text-decoration:none;background-color:navy;text-align:left}
a:hover{color:#f0fff0;text-decoration:none;background-color:#2e8b57;text-align:left}
.notice{font-family:sans-serif;color:#f00;font-size:11px;text-decoration:none;text-align:left;}
</style>
</head>

<table height="30" cellspacing="0" cellpadding="0" border="0">
<tr>
<td class="notice"><b>エラー&nbsp;:</b></td>
</tr>
</table>

<table cellspacing="5" cellpadding="5" border="0" bgcolor="#ccff99">
<tr>
<td bgcolor="#ffffff"><span class="notice"><?=$alert?></span></td>
</tr>
</table>

<table width="100" height="10" cellspacing="0" cellpadding="0" border="0">
<tr>
<td></td>
</tr>
</table>

<a href="Javascript:history.back()">【戻る】</a><br>

<table width="100" height="50" cellspacing="0" cellpadding="0" border="0">
<tr>
<td></td>
</tr>
</table>

</body>
</html>