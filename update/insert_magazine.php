<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

if (isset($_POST['vozvrat'])) {$vozvrat = 1;} else {$vozvrat = 0;}

if (isset($_POST['perv_prod'])) {$perv_prod = 1;} else {$perv_prod = 0;}

if (isset($_POST['terminal'])) {$terminal = $_POST['terminal']; if ($terminal == '') {unset($terminal);}}
//echo $terminal; die();
if ((isset($_POST['edit'])) && (isset($_SESSION['id_edit_magazina']))) {
	$tab_show = $vozvrat;
	$res=mysql_query("UPDATE magazinu SET tab_show = '$tab_show', perv_prod = '$perv_prod', terminal = '$terminal' WHERE ID = '{$_SESSION['id_edit_magazina']}'",$db);
	unset($_SESSION['id_edit_magazina']);
	}
else {	
if (isset($id)) {
	$result = mysql_query("SELECT * FROM sklad_tovaru WHERE `ID_magazina` = '$id'",$db);	
	if (mysql_num_rows($result) > 0) {?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Еще есть товары, которые привязаны к этому магазину на Остаткие. Его пока нельзя удалить <a href="../sklad.php">На Остатки</a> || <a href="../magazinu.php">Назад</a></p>
</body>
</html>			
			
<?php		die();}	
		
	else {
		
   $res_mag = mysql_query("SELECT `ID` FROM magazinu ORDER BY ID ASC",$db);
   $myr_mag = mysql_fetch_array($res_mag);

$no = 0;
do {
	if  ($myr_mag['ID'] == $id) {$number_mag = $no;}
$no++;
}
while($myr_mag = mysql_fetch_array($res_mag));

    $res_user = mysql_query("SELECT `ID`, `storepriv` FROM users",$db);
    $myr_user = mysql_fetch_array($res_user);
    
    do {
    	$myr_user['storepriv'] = substr_replace($myr_user['storepriv'], '', $number_mag, 1);
    	$res_user_update = mysql_query("UPDATE `users` SET `storepriv` = '{$myr_user['storepriv']}' WHERE `ID` = '{$myr_user['ID']}'",$db);
    	} while ($myr_user = mysql_fetch_array($res_user));

		
		$res = mysql_query("DELETE FROM magazinu WHERE ID = '$id'",$db); $res_pl = mysql_query("DELETE FROM plan WHERE ID_magazina = '$id'",$db);}
}

else {
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
      
$res=mysql_query("INSERT INTO magazinu SET name = '$magazine', tab_show = '1', perv_prod = '0', terminal = 'no'",$db);
    $res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM magazinu",$db);
	$myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);
	$ind = $myr_max['ID'];
$res_plan=mysql_query("INSERT INTO plan SET ID_magazina = '$ind', naimenov = 'Терминалы',name = 'term', plane = '0'",$db);
$res_plan=mysql_query("INSERT INTO plan SET ID_magazina = '$ind', naimenov = 'Аксесуары',name = 'acses', plane = '0'",$db);
$res_plan=mysql_query("INSERT INTO plan SET ID_magazina = '$ind', naimenov = 'Подключения',name = 'podkl', plane = '0'",$db);
$res_plan=mysql_query("INSERT INTO plan SET ID_magazina = '$ind', naimenov = 'Стартовые',name = 'starpak', plane = '0'",$db);
$res_plan=mysql_query("INSERT INTO plan SET ID_magazina = '$ind', naimenov = 'Бонус к выполнению плана',name = 'bonus', plane = '0'",$db);

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y H:i:s', mktime ($hours));

$res_kassa=mysql_query("INSERT INTO kassa SET data = '$dat', magazine = '$magazine', vkasse = '0', inkas = '----' ",$db);	
}
}


header("Location: ../magazinu.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>