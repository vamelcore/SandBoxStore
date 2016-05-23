<?php

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Пользователи</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitadm'];?>">Назад в админку...</a></td><td><a class="like_button" href="users.php">Пользователи</a></td><td><a class="like_button" href="prava.php">Привилегии</a></td><td><a class="like_button" href="magazinu.php">Магазины</a></td><td><a class="like_button" href="timezone.php">Время</a></td><td><a class="like_button_use" href="backuper.php">Бэкап</a></td><td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><iframe src="/dumper/" width="586" height="462" frameborder="0" style="margin:0;"></iframe></td>
</tr>

  </table>
</div>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>