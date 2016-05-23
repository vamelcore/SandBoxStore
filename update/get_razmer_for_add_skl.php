<?php include ("../config.php"); include ("functions.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

	  $kateg=$_REQUEST['kateg']; $brend=$_REQUEST['brend']; $mod=$_REQUEST['mod'];
	  
if (($kateg <> '') && ($brend <> '') && ($mod <> '')) {
$result = mysql_query("SELECT DISTINCT `razmer` FROM `prase` WHERE `ID_kategorii`='$kateg' AND `ID_brenda`='$brend' AND `nomer_mod` = '$mod' ORDER BY `razmer` ASC",$db);

printf("<option value=''>Выберите размер</option>");
 while ($myrow = mysql_fetch_array($result)) {
     printf (" <option value='%s'>%s</option>" , $myrow["razmer"], $myrow["razmer"]);
    }
}
else {
   	printf("<option value=''></option>");
   	session_start();

   	unset($_SESSION['sklad_add_mod']);
   	unset($_SESSION['sklad_add_razmer']);
   	unset($_SESSION['sklad_add_cvet']);
   	unset($_SESSION['sklad_add_mater']);	
	}
}

?>