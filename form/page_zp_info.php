<?php include ("../config.php");
header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['id'])) {$id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT * FROM prodaja WHERE ID = '$id'",$db);
$myrow = mysql_fetch_array($result);

?>

<h1 class='contact-title'>Подробная информация:</h1>
 <form>
 <table width="100%" align="center">
                                <tbody>
										<tr>
                                        <th class="lable">Дата:</th>
                                        <td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['data'];?>"></td></tr>
										<tr>
                                		<th class="lable">Магазин:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo $myrow['magazin'];?>"></td></tr>
                              			<tr>
                                		<th class="lable">Категория:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['kategoria']);?>"></td></tr>
                               			<tr>
                                  		<th class="lable">Бренд:</th>
                                  		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['brend']);?>"></td></tr>
								  		<tr>
                                		<th class="lable">Номер модели:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['nomer_mod']);?>"></td></tr>
										<tr>
                                		<th class="lable">Размер:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['razmer']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Цвет:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['cvet']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Материал:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['material']);?>"></td></tr>										
										<tr>
                                		<th class="lable">Количество, шт:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['kolichestvo']);?>"></td></tr>                                												
										<tr>
                                		<th class="lable">Цена, грн:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['cena']);?>"></td></tr>                                		
										<tr>
                                		<th class="lable">Сумма, грн:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['summa']);?>"></td></tr>																														
										<tr>
                                		<th class="lable">Вознаг, грн:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['voznag']);?>"></td></tr>                          		
                                  		<tr>
                                		<th class="lable">Процент, грн:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['procent']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">ФИО покупателя:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['FIO']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Контактний номер телефона:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['kontakt_nomer_tel']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Скидка:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['skidka']);?>"></td></tr>                                		
                                  		<tr>
                                		<th class="lable">Примечание:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['add']);?>"></td></tr>
                                		<tr>
                                		<th class="lable">Кем продано:</th>
                                		<td class="input"><input readonly="readonly" size="30" maxlength="30" class="input" type="text" value="<?php echo htmlspecialchars($myrow['user']);?>"></td></tr>                                		                               
                                		<tr>
                                		<td align="center" colspan="2">
                                			<table width="100%">
											<tr><td height="10px"><br></td></tr>
                                			<tr>
                                			<td width="100%" align="center"><input style="width: 100px;" type="button" value="Закрыть" onclick="top.location.href='../zarplata.php'"></td>	
                                			</tr>
                                			</table>
                                		</td>                                  
                                		</tr>
                        	</tbody>
</table>
</form>