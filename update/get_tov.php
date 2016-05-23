<?php include ("../config.php");

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

$kateg=$_REQUEST['kateg']; $brend=$_REQUEST['brend'];

if (($kateg <> '') && ($brend <> '')) {
$result = mysql_query("SELECT `ID`, `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID_kategorii`='$kateg' AND `ID_brenda`='$brend' ORDER BY `nomer_mod` ASC , `razmer` ASC , `cvet` ASC , `material` ASC",$db);

printf("<option value=''>Выберите товар</option>");
 while ($myrow = mysql_fetch_array($result)) {
     printf (" <option value='%s'>%s / %s / %s / %s</option>" , $myrow["ID"], $myrow["nomer_mod"],$myrow["razmer"],$myrow["cvet"],$myrow["material"]);
    }
}
}

?>