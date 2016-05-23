<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kateg=$_REQUEST['kateg']; $brend=$_REQUEST['brend']; $mod=$_REQUEST['mod']; $razm=$_REQUEST['razm']; $cvet=$_REQUEST['cvet'];
if (($kateg <> '') && ($brend <> '') && ($mod <> '') && ($razm <> '') && ($cvet <> '')) {
$result = mysql_query("SELECT DISTINCT `material` FROM `prase` WHERE `ID_kategorii`='$kateg' AND `ID_brenda`='$brend' AND `nomer_mod` = '$mod' AND `razmer` = '$razm' AND `cvet` = '$cvet' ORDER BY `material` ASC",$db);

printf("<option value=''>Выберите материал</option>");
 while ($myrow = mysql_fetch_array($result)) {
     printf (" <option value='%s'>%s</option>" , $myrow["material"], $myrow["material"]);
    }
}
else {
   	printf("<option value=''></option>");
   	session_start();

   	unset($_SESSION['sklad_add_cvet']);
   	unset($_SESSION['sklad_add_mater']);	
	}
}

?>