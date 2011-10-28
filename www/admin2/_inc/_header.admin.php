<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html lang='ja'>
<head>
<meta name='robots' content='noindex, nofollow'>
<meta http-equiv='Content-Type' content='text/html; charset=Shift_JIS'>
<meta http-equiv='Content-Script-Type' content='text/javascript'>
<meta http-equiv='Content-Style-Type' content='text/css'>
<title><?
if(empty($subtitle)){
	print _APP_NAME_;
}else{
	print _APP_NAME_." - ".$subtitle;
}
?></title>
<link rel='stylesheet' href='<?=_SITE_URL_?>css/main.css' type='text/css'>
<script language='JavaScript' src='js/admin.js'></script>
<style>
a{
font-family:sans-serif;
font-size:12px;
color:#063;
text-decoration:none;
margin:1px;
}

a:active{
font-family:sans-serif;
font-size:12px;
color:#063;
background-color:#fff;
text-decoration:none;
}

a:hover{
font-family:sans-serif;
font-size:12px;
color:#f0fff0;
background-color:#063;
text-decoration:none;
}
</style>
</head>

<!-- <?=_APP_NAME_?>  version: <?=_APP_VER_?> -->
