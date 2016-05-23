<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kateg=$_REQUEST['kateg']; $brend=$_REQUEST['brend']; $mod=$_REQUEST['mod']; $razm=$_REQUEST['razm'];
if (($kateg <> '') && ($brend <> '') && ($mod <> '') && ($razm <> '')) {
$result = mysql_query("SELECT DISTINCT `cvet` FROM `prase` WHERE `ID_kategorii`='$kateg' AND `ID_brenda`='$brend' AND `nomer_mod` = '$mod' AND `razmer` = '$razm' ORDER BY `cvet` ASC",$db);

printf("<option value=''>Выберите цвет</option>");
 while ($myrow = mysql_fetch_array($result)) {
     printf (" <option value='%s'>%s</option>" , $myrow["cvet"], $myrow["cvet"]);
    }
}
else {
   	printf("<option value=''></option>");
   	session_start();
 
   	unset($_SESSION['sklad_add_razmer']);
   	unset($_SESSION['sklad_add_cvet']);
   	unset($_SESSION['sklad_add_mater']);	
	}
}

?>