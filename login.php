<?php include ("config.php");

$super_query = "SELECT * FROM `sysconfig` WHERE `param` = 'site_redirect' LIMIT 1";
$super_request = mysql_query($super_query);
$super_result = mysql_fetch_array($super_request);
if ($super_result['enabled'] == 'yes') {
	header("Location: ".$super_result['value']);
	die();
	}
        
session_start();

header('Content-Type: text/html; charset=utf-8');

function escape_inj ($text) {
  $text = strtolower($text); // Приравниваем текст параметра к нижнему регистру
  if (
    !strpos($text, "select") && //
    !strpos($text, "union") && //
    !strpos($text, "select") && //
    !strpos($text, "order") && // Ищем вхождение слов в параметре
    !strpos($text, "where") && //
    !strpos($text, "char") && //
    !strpos($text, "from") //
  ) {
    return true; // Вхождений нету - возвращаем true
  } else {
    return false; // Вхождения есть - возвращаем false
  }
}

function defender_xss($arr){
    $filter = array("<",">","=","(",")",";","/","&","?"); 
     foreach($arr as $num=>$xss){
        $xss=htmlspecialchars(strip_tags($xss));
        $arr[$num]=str_replace($filter, "|", $xss);
     }
       return $arr;
}
function defender_sql($arr){
    $counter= 0;
    $copy_arr = $arr;
    $filter = array("update","select","group by","from","where","into","set","union","char","order"); 
     foreach($copy_arr as $num=>$xss){
     	  $xss=mysql_real_escape_string($xss);
     	  $xss = strtolower($xss);
        $copy_arr[$num]=str_replace($filter, "WARNING_SQL_INGECT_WORD", $xss, $counter);
     }
     if ($counter == 0) {
     	     foreach($arr as $num=>$xss){
           $arr[$num]=mysql_real_escape_string($xss);
           }
     return $arr;
     }
     else {return $copy_arr;}      
} 
//используйте  функцию перед обработкой входящих данных:
$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['username']) && isset($_POST['password']))
{
    $login = mysql_real_escape_string($_POST['username']);
    $password = md5($_POST['password']);


if (!escape_inj ($login)) { echo "Это SQL-инъекция."; exit();  die();}
else {

    // делаем запрос к БД
    // и ищем юзера с таким логином и паролем

    $query = "SELECT `id`, `login`, `AED`, `storepriv`, `allpriv`, `kassapriv`, `rollpriv`, `adminpriv`, `rootpriv`, `fio_usera`, `stavka`
              FROM `users`
              WHERE `login`='{$login}' AND `password`='{$password}'
              LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());

    // если такой пользователь нашелся
    if (mysql_num_rows($sql) == 1) {
        // то мы ставим об этом метку в сессии (допустим мы будем ставить ID пользователя)

        $row = mysql_fetch_assoc($sql);
		$aed_priv = $row['AED'];
		$storepriv = $row['storepriv'];	 
		$allprivforstore = $row['allpriv'];
		$adminpriv = $row['adminpriv'];
		$rootpriv = $row['rootpriv'];
		$kassapriv = $row['kassapriv'];
		$rollpriv = $row['rollpriv'];
        
		$_SESSION['user_id'] = $row['id'];
        $_SESSION['login'] = $row['login'];
		$_SESSION['fio'] = $row['fio_usera'];
        $_SESSION['stavka'] = $row['stavka'];
		     
		
		
$res = mysql_query("SELECT `ID`, `name`, `tab_show`, `perv_prod` FROM magazinu ORDER BY ID ASC",$db);
$myr = mysql_fetch_array($res);

$no = 0;
do {
$id[$no] = $myr['ID'];
$name[$no] = $myr['name'];
$tab_show[$no] = $myr['tab_show'];
$perv_prod[$no] = $myr['perv_prod'];
$no = $no +1;
}
while($myr = mysql_fetch_array($res));

unset($_SESSION['id_mag']);
unset($_SESSION['name_mag']);
unset($_SESSION['tabl_st_show']);
unset($_SESSION['perv_prod']);

$no = 0; $i = 1;
do {
	if ($storepriv[$no] == 1) {
		
	$_SESSION['id_mag'][$i] = $id[$no];
	$_SESSION['name_mag'][$i] = $name[$no];
	$_SESSION['tabl_st_show'][$i] = $tab_show[$no];
	$_SESSION['perv_prod'][$i]	= $perv_prod[$no];
	$i = $i +1;
	
	}	
$no = $no +1;
}
while($no < strlen($storepriv));
if ($allprivforstore == '1') {
	$_SESSION['id_mag'][$i] = 'all';
	$_SESSION['name_mag'][$i] = 'Все';
	$_SESSION['tabl_st_show'][$i] = '111';
	$_SESSION['perv_prod'][$i]	= '0';
	$_SESSION['count_mag'] = $i;	
}
else {$_SESSION['count_mag'] = $i - 1;}
				
		unset($_SESSION['add_priv_ost']);
		unset($_SESSION['ed_priv_ost']);
		unset($_SESSION['add_priv_pro']);
		unset($_SESSION['ed_priv_pro']);
		unset($_SESSION['add_priv_zar']);
		unset($_SESSION['ed_priv_zar']);
		unset($_SESSION['add_priv_voz']);
		unset($_SESSION['ed_priv_voz']);		

		unset($_SESSION['admin_priv']);
		unset($_SESSION['root_priv']);
		unset($_SESSION['kassapriv']);
		unset($_SESSION['rollpriv']);
				
		$_SESSION['add_priv_ost'] = $aed_priv[0];
		$_SESSION['ed_priv_ost'] = $aed_priv[1];
		$_SESSION['add_priv_pro'] = $aed_priv[2];
		$_SESSION['ed_priv_pro'] = $aed_priv[3];
		$_SESSION['add_priv_zar'] = $aed_priv[4];
		$_SESSION['ed_priv_zar'] = $aed_priv[5];
		$_SESSION['add_priv_voz'] = $aed_priv[6];
		$_SESSION['ed_priv_voz'] = $aed_priv[7];
				
		$_SESSION['admin_priv'] = $adminpriv;
		$_SESSION['root_priv'] = $rootpriv;
		$_SESSION['kassapriv'] = $kassapriv;
		$_SESSION['rollpriv'] = $rollpriv;
		
$timez = mysql_query("SELECT `time_zone` FROM `timezone` WHERE ID = '1'",$db);
$timez_row = mysql_fetch_array($timez);

if ($timez_row['time_zone'] == 'winter') {$_SESSION['time_zone'] = '8';} else {$_SESSION['time_zone'] = '9';}

//header("Location: page.php");
    // не забываем, что для работы с сессионными данными, у нас в каждом скрипте должно присутствовать session_start();
    }
    else { ?>
    	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<p align="center">Такой логин с паролем не найдены в базе данных. <a href="index.php">На страницу входа</a>.</p>
</body>
</html>
<?php
        die();
    }
    }
};

if ((isset($_SESSION['user_id'])) && (mysql_num_rows($sql) == 1)) {
	
$supsecvar = $_SERVER['REMOTE_ADDR'].$row['id'].session_id().'6891'; 
$_SESSION['password_secret_id_string'] = md5($supsecvar);
	 header("Location: page.php"); 
}
else {
header("Location: index.php");
die();	
	 }
 ?>
 