<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['id'])) {$id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT * FROM diff_cena WHERE ID_tovara = '$id' ORDER BY ID_magazina",$db);

if (mysql_num_rows($result) > 0) {

$flag = true;
$myarray_diff_c = array(); $index_c = 0;
while ($myr_diff_c = mysql_fetch_assoc($result)) {
foreach($myr_diff_c as $key => $value) {
$myarray_diff_c[$key][$index_c] = $value;
}
$index_c++;
}

}
//print_r($myarray_diff_c);
$result_tov = mysql_query("SELECT * FROM prase WHERE ID = '$id'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
?>

<h1 class='contact-title'>Цены для: <?php printf("%s / %s / %s / %s",$myrow_tov['nomer_mod'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material'])?></h1>
<br>
<form action="./form/update_diff_cena.php" method="post">
 <table width="100%">
                                <tbody>
								<tr>
                                        <th class="headert" style="width:55%;">Магазин</th>
                                        <th class="headert" style="width:15%;">Цена</th>
										<th class="headert" style="width:15%;">Вознаг.</th>
										<th class="headert" style="width:15%;">Удалить</th>
                                </tr>
								<tr><th><br></th><td><br></td><td><?php printf("<input type=\"hidden\" name=\"id_tov\" value=\"%s\">",$id) ?></td></tr>
<?php 

$result_mag = mysql_query("SELECT ID, name FROM magazinu ORDER BY ID ASC",$db);

while ($myrow_mag = mysql_fetch_array($result_mag)) {

$id_diff_cena = '0';
$diff_cena = '';
$diff_bonus = '';

if ($flag == true) {

for ($no=0; $no<=$index_c; $no++) {
if ($myarray_diff_c['ID_magazina'][$no] == $myrow_mag['ID']) {
$id_diff_cena = $myarray_diff_c['ID'][$no];
$diff_cena = $myarray_diff_c['new_cena'][$no];
$diff_bonus = $myarray_diff_c['new_bonus'][$no];
}}
//echo $id_diff_cena.' '.$diff_cena.' '.$diff_bonus.'<br>';
}
printf("<tr>
  <th class=\"lable\"><p style=\"text-align:left\">%s</p></th>
  <td class=\"input\"><input style=\"width:75px\" type=\"text\" name=\"new_cena_%s\" value=\"%s\"></td>
  <td class=\"input\"><input style=\"width:75px\" type=\"text\" name=\"new_bonus_%s\" value=\"%s\"></td>
  <td class=\"lable\"><p style=\"text-align:center\"><input type=\"checkbox\" name=\"delete_diff_%s\"></p><input type=\"hidden\" name=\"id_diff_c_%s\" value=\"%s\"></td>
</tr>",$myrow_mag["name"],$myrow_mag["ID"],$diff_cena,$myrow_mag["ID"],$diff_bonus,$myrow_mag["ID"],$myrow_mag["ID"],$id_diff_cena);
}

?>
                                <tr><th><br></th><td><br></td><td><br></td></tr>                                
								<tr>
                                <td align="center" colspan="4">
                                	<table width="100%">
                                	<tr>
                                	<td width="50%" align="center"><input style="width: 100px;" type="button" value="Отмена" onclick="top.location.href='../prase.php'"></td>
									<td width="50%" align="center"><input style="width: 100px;" name="submit" type="submit" value="Сохранить"></td>	
                                	</tr>
                                	</table>
                                </td>                                  
                                </tr>
                        </tbody></table>
</form>