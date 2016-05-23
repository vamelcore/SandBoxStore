<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=defender_sql($_POST);		
//Получение всех переменных.			
if (isset($_POST['data_priema'])) {$data_priema = $_POST['data_priema'];if ($data_priema == '') {unset ($data_priema);}}

if (isset($_POST['magazine'])) {
      		$magazine = $_POST['magazine'];
         if ($magazine == '') {unset ($magazine);}
         else {
         	$res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazine'",$db);
           $myr_mag=mysql_fetch_array($res_mag);
         	}
}

if (isset($_POST['kategory'])) {
	        $kategory = $_POST['kategory'];
	        if ($kategory == '') {unset($kategory);}
	        else {
	        		$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
	           $myr_kat = mysql_fetch_array($res_kat);      	
	        	}
}
      
if (isset($_POST['brend'])) {$brend = $_POST['brend'];if ($brend == '') {unset($brend);}}
      
if (isset($_POST['nomer_mod'])) {$nomer_mod = $_POST['nomer_mod'];if ($nomer_mod == '') {unset($nomer_mod);}}

if (isset($_POST['razmer'])) {$razmer = $_POST['razmer'];if ($razmer == '') {unset($razmer);}}

if (isset($_POST['cvet'])) {$cvet = $_POST['cvet'];if ($cvet == '') {unset($cvet);}}

if (isset($_POST['material'])) {$material = $_POST['material'];if ($material == '') {unset($material);}}

if (isset($_POST['data_pokupki'])) {$data_pokupki = $_POST['data_pokupki'];if ($data_pokupki == '') {unset($data_pokupki);}}	  
	  
if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset($kolichestvo);}}
	  
if (isset($_POST['cena'])) {$cena = $_POST['cena'];if ($cena == '') {unset ($cena);}}
      
if (isset($_POST['skidka'])) {$skidka = $_POST['skidka'];if ($skidka == '') {unset($skidka);}}
      
if (isset($_POST['prichina_vozv'])) {$prichina_vozv = $_POST['prichina_vozv'];if ($prichina_vozv == '') {unset($prichina_vozv);}}
      
if (isset($_POST['per14dn'])) {$per14dn = $_POST['per14dn'];if ($per14dn == '') {unset($per14dn);}}

if (isset($_POST['dvozv'])) {$dvozv = $_POST['dvozv'];if ($dvozv == '') {unset($dvozv);}}	  
	  
if (isset($_POST['obmen_brend'])) {
	        $obmen_brend = $_POST['obmen_brend'];
         if ($obmen_brend == '') {unset($obmen_brend);}
         else {
         $res_br = mysql_query("SELECT `brend` FROM `sklad_brendu` WHERE `ID` = '$obmen_brend'",$db);
         $myr_br = mysql_fetch_array($res_br);
         }
}

if (isset($_POST['obmen_mod'])) {$obmen_mod = $_POST['obmen_mod'];if ($obmen_mod == '') {unset($obmen_mod);}}

if (isset($_POST['obmen_raz'])) {$obmen_raz = $_POST['obmen_raz'];if ($obmen_raz == '') {unset($obmen_raz);}}

if (isset($_POST['obmen_cv'])) {$obmen_cv = $_POST['obmen_cv'];if ($obmen_cv == '') {unset($obmen_cv);}}

if (isset($_POST['obmen_mat'])) {$obmen_mat = $_POST['obmen_mat'];if ($obmen_mat == '') {unset($obmen_mat);}}

if (isset($_POST['tovar_id'])) {$obmen_tovar_id = $_POST['tovar_id'];if ($obmen_tovar_id == '') {unset($obmen_tovar_id);}}	

if (isset($_POST['obmen_skidka'])) {$obmen_skidka = $_POST['obmen_skidka'];if ($obmen_skidka == '') {unset($obmen_skidka);}}	

if (isset($_POST['daln_dvizhen'])) {$daln_dvizhen = $_POST['daln_dvizhen'];if ($daln_dvizhen == '') {unset($daln_dvizhen);}}

if (isset($_POST['primechanie'])) {$primechanie = $_POST['primechanie'];if ($primechanie == '') {unset($primechanie);}}

if (isset($_POST['kto_pvinyal'])) {$kto_pvinyal = $_POST['kto_pvinyal'];if ($kto_pvinyal == '') {unset($kto_pvinyal);}}

 if (isset($_POST['user'])) {$user = $_POST['user'];if ($user == '') {unset($user);}}
 if (isset($_POST['voznag'])) {$voznag = $_POST['voznag'];if ($voznag == '') {$voznag='0';}} 
 if (isset($_POST['procent'])) {$procent = $_POST['procent'];if ($procent == '') {$procent='0';}}
 if (isset($_POST['ID_prodaja'])) {$ID_prodaja = $_POST['ID_prodaja'];if ($ID_prodaja == '') {unset($ID_prodaja);}} 		  

if (isset($_POST['sec_data'])) {$second_data = $_POST['sec_data'];if ($second_data == '') {unset($second_data);}}

if (isset($_POST['kolich_all'])) {$kolich_all = $_POST['kolich_all'];if ($kolich_all == '') {unset($kolich_all);}}
if (isset($_POST['summa_all'])) {$summa_all = $_POST['summa_all'];if ($summa_all == '') {unset($summa_all);}}
if (isset($_POST['skidka_all'])) {$skidka_all = $_POST['skidka_all'];if ($skidka_all == '') {unset($skidka_all);}}
		
//Скрипты обработки
if (isset($_SESSION['id_vozvrat'])) {
	
	 if ($_SESSION['ed_priv_voz'] == 1) {
		
	$id = $_SESSION['id_vozvrat'];
	unset ($_SESSION['id_vozvrat']);
    if ($id == '') {unset ($id);}
//Удаление записи в возвратах!!!    
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM `vozvratu` WHERE `ID`='$id'",$db); unset ($_POST['delete']);}

     else {
//Обновление записи

if (isset($_POST['kategory_ed'])) {
	$kategory_ed = $_POST['kategory_ed'];
	if ($kategory_ed == '') {unset($kategory_ed);}
	else {
		$res_kat_ed=mysql_query("SELECT `kateg` FROM `sklad_kategorii` WHERE `ID` = '$kategory_ed'",$db);
	 $myr_kat_ed = mysql_fetch_array($res_kat_ed);
	 $myr_kat['ID'] = $kategory_ed;
		}
	}
if (isset($_POST['brend_ed'])) {
	$brend_ed = $_POST['brend_ed'];
	if ($brend_ed == '') {unset($brend_ed);}
	else {
	 $res_br_ed = mysql_query("SELECT `brend` FROM `sklad_brendu` WHERE `ID` = '$brend_ed'",$db);
  $myr_br_ed = mysql_fetch_array($res_br_ed);
  $brend = mysql_real_escape_string($myr_br_ed['brend']);
		}	
	}
if (isset($_POST['nomer_mod_ed'])) {$nomer_mod_ed = $_POST['nomer_mod_ed'];if ($nomer_mod_ed == '') {unset($nomer_mod_ed);}}

if (isset($_POST['obmen'])) {$obmen = $_POST['obmen'];if ($obmen == '') {unset($obmen);}}

$res=mysql_query("UPDATE `vozvratu` SET `magazin` = '{$myr_mag['name']}', `data` = '$data_priema', `kategoria` = '{$myr_kat_ed['kateg']}', `brend` = '{$myr_br_ed['brend']}', `nomer_mod` = '$nomer_mod_ed', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', `kolichestvo` = '$kolichestvo', `data_pokupki` = '$data_pokupki', `stoimost` = '$cena', skidka = '$skidka', `prichina_vozvrata` = '$prichina_vozv', `per_14_dney` = '$per14dn', `obmen_na` = '$obmen', `daln_dvijenie` = '$daln_dvizhen', `primechanie` = '$primechanie', `kto_pvinyal` = '$kto_pvinyal' WHERE `ID`='$id'",$db);
	$sec_dat = $second_data;
	$ind = $id;
}
}
}
else {
//Добавление записи о возврате	
  if ($_SESSION['add_priv_voz'] == 1) {
  
if (isset($_SESSION['myarray_tovar'])) {unset($_SESSION['myarray_tovar']);}
if (isset($_SESSION['myarray_tovar_ind'])) {unset($_SESSION['myarray_tovar_ind']);}
	
$hours = date('H') + $_SESSION['time_zone'];
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours)); 
$sec_dat = date ('m.Y', mktime ($hours));


//Обновление продажи в зависимости от параметров возврата
if ($kolichestvo == $kolich_all) {
$res_secdata_prod=mysql_query("SELECT `sec_data` FROM `prodaja` WHERE `ID`='$ID_prodaja'",$db);
$myr_secdata_prod=mysql_fetch_array($res_secdata_prod);
$new_secdata_prod = $myr_secdata_prod['sec_data'].'_rollback';
if ($dvozv == 'dengi') {$deystvie = 'Возврат денег за товар!'; $obmen_value = 'Возврат денег';}
elseif ($dvozv == 'obmen') {$deystvie = 'Обмен этого товара!'; $obmen_value = 'Обмен на: '.$myr_br['brend'].' / '.$obmen_mod.' / '.$obmen_raz.' / '.$obmen_cv.' / '.$obmen_mat;}
$res_prodaja_after_vozv=mysql_query("UPDATE `prodaja` SET `add` = '$deystvie', `sec_data` = '$new_secdata_prod' WHERE `ID`='$ID_prodaja'",$db);
}
else {
$new_kolich = $kolich_all - $kolichestvo;
$new_summa = $summa_all - $cena;
$new_voznag = $voznag*(1 - $kolichestvo/$kolich_all);
$new_procent = $procent*(1 - $kolichestvo/$kolich_all);
$new_skidka = $skidka_all - $skidka;
if ($dvozv == 'dengi') {$deystvie = 'Возврат денег за '.$kolichestvo.' шт.!'; $obmen_value = 'Возврат денег';}
elseif ($dvozv == 'obmen') {$deystvie = 'Обмен '.$kolichestvo.' шт.!'; $obmen_value = 'Обмен на: '.$myr_br['brend'].' / '.$obmen_mod.' / '.$obmen_raz.' / '.$obmen_cv.' / '.$obmen_mat;}
$res_prodaja_after_vozv=mysql_query("UPDATE `prodaja` SET `kolichestvo` = '$new_kolich', `summa` = '$new_summa', `voznag` = '$new_voznag', `procent` = '$new_procent', `skidka` = '$new_skidka', `add` ='$deystvie' WHERE `ID`='$ID_prodaja'",$db);
}


//echo $new_kolich.' -> kolich<br>';
//echo $summa_all.' -> summa_all<br>';
//echo $cena.' -> cena<br>';
//echo $skidka_all.' -> skidka_all<br>';
//echo $skidka.' -> skidka<br>';
//
//die();


$obmen_value=defender_sql($obmen_value);


//Добавление новой записи в таблице возвратов
$res=mysql_query("INSERT INTO `vozvratu` SET `magazin` = '{$myr_mag['name']}', `data` = '$data_priema', `kategoria` = '$kategory', `brend` = '$brend', `nomer_mod` = '$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', `kolichestvo` = '$kolichestvo', `data_pokupki` = '$data_pokupki', `stoimost` = '$cena', `skidka` = '$skidka', `prichina_vozvrata` = '$prichina_vozv', `per_14_dney` = '$per14dn', `obmen_na` = '$obmen_value', `daln_dvijenie` = '$daln_dvizhen', `primechanie` = '$primechanie', `sec_data` = '$sec_dat', kto_pvinyal = '$kto_pvinyal'",$db);

//Получение зарплатной информации о предыдущем продавце
$res_usr = mysql_query("SELECT `ID`, `bonus_stavka`, `proc_stavka` FROM `users` WHERE `login` = '$user'",$db);
$myr_usr = mysql_fetch_array($res_usr);

$res_max_zap = mysql_query("SELECT `k_oplate` FROM `zarplata` WHERE `ID_usera` = '{$myr_usr['ID']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_max_zap = mysql_fetch_array($res_max_zap);


//Определение суммы изьятой у продавца после возврата
$back_voznag = $voznag*($kolichestvo/$kolich_all);
$back_procent = $procent*($kolichestvo/$kolich_all);
$myr_max_zap['k_oplate'] = $myr_max_zap['k_oplate'] - $back_voznag - $back_procent;


//Обновление зарплатной информации предыдущего продавца
$res_zar = mysql_query("INSERT INTO `zarplata` SET `ID_prodaja` = '0', `ID_magazina` = '$magazine', `ID_usera` = '{$myr_usr['ID']}', `data` = '$dat', `vremya` = '$vremya', `polniy_den` = '----', `polov_dnya` = '----', `prodaja` = '-$back_voznag', `procent` = '-$back_procent', `k_oplate` = '{$myr_max_zap['k_oplate']}', `vudano` = '----', `shtraf` = '----', `bonus` = '----', `user` = '{$_SESSION['login']}: Возврат!'",$db);


//Рассчет кассы и ее обновление

//$res_prod_from_kassa = mysql_query("SELECT * FROM `kassa` WHERE `ID_prodaja` = '$ID_prodaja'",$db);
//if (mysql_num_rows($res_prod_from_kassa) > 0) {
$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse = mysql_fetch_array($res_vkasse);
$summa_vkasse = $myr_vkasse['vkasse'] - $cena + $skidka;
$summa_inkass = $cena - $skidka;
$res_kassa = mysql_query("INSERT INTO `kassa` SET `ID_prodaja` = '0', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `vkasse` = '$summa_vkasse', `inkas` = '-$summa_inkass', `user` = '{$_SESSION['login']}: Возврат!' ",$db);
//}
//else {
//$res_prod_from_beznal = mysql_query("SELECT * FROM `beznal` WHERE `ID_prodaja` = '$ID_prodaja'",$db);
//if (mysql_num_rows($res_prod_from_beznal) > 0) {
//$res_naschetu = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);  
//$myr_naschetu = mysql_fetch_array($res_naschetu);
//$summa_naschetu = $myr_naschetu['summa'] - $cena + $skidka; $izmen = $cena - $skidka;
//$res_naschetu = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '0', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `summa` = '$summa_naschetu', `izmenenie` = '-$izmen', `user` = '{$_SESSION['login']}: Отмена продажи'",$db);
//}
//}


//Если был выбран обмен
if ((isset($dvozv)) && ($dvozv == 'obmen')) {

//Находится товар из таблицы товаров
//$res_tov = mysql_query("SELECT * FROM `prase` WHERE ID = '$obmen'",$db); Вверху, в переменных
//$myr_tov = mysql_fetch_array($res_tov);

//Получение информации о заменяемом товаре
$res_tov_obm_diff = mysql_query("SELECT `new_cena`, `new_bonus` FROM `diff_cena` WHERE `ID_magazina` = '$magazine' AND `ID_tovara` = '$obmen_tovar_id'",$db);
if (mysql_num_rows($res_tov_obm_diff) > 0) {
$myr_tov_obm_diff = mysql_fetch_array($res_tov_obm_diff);
$myr_tov_obm = array();
$myr_tov_obm['cena'] = $myr_tov_obm_diff['new_cena'];
$myr_tov_obm['voznag'] = $myr_tov_obm_diff['new_bonus'];
}
else {
$res_tov_obm = mysql_query("SELECT `cena`, `voznag` FROM `prase` WHERE `ID` = '$obmen_tovar_id'",$db);
$myr_tov_obm = mysql_fetch_array($res_tov_obm);
}


//Находится зарплатная информация о новом продавце
$res_usr_new = mysql_query("SELECT `bonus_stavka`, `proc_stavka` FROM users WHERE ID = '{$_SESSION['user_id']}'",$db);
$myr_usr_new = mysql_fetch_array($res_usr_new);

//Рассчет зарплаты для нового продавца
if ($myr_usr_new['bonus_stavka'] == 1) {$bonus_zp = $myr_tov_obm['voznag']*$kolichestvo;}	else {$bonus_zp = 0;}
$proc_zp_new = round((($myr_tov_obm['cena'] - $obmen_skidka)*($myr_usr_new['proc_stavka']/100)*$kolichestvo), 2);
$summa_obmen = $myr_tov_obm['cena']*$kolichestvo;
$skidka_obmen = $obmen_skidka*$kolichestvo;


$primechanie = "Этот товар был выдан на замену: ".$brend." / ".$nomer_mod." / ".$razmer." / ".$cvet." / ".$material.", который был продан ". $data_pokupki;
$primechanie = defender_sql($primechanie);


//Обновление продажи в соответствии с обменом на новый товар
$res_pro = mysql_query("INSERT INTO `prodaja` ( `data`, `magazin`, `kategoria`, `brend`, `nomer_mod`, `razmer`, `cvet`, `material`, `kolichestvo`, `cena`, `summa`, `voznag`, `procent`, `kontakt_nomer_tel`, `FIO`, `skidka`, `add`, `user`, `printer_ID`, `sec_data` ) SELECT '$data_priema', `magazin`, `kategoria`, '{$myr_br['brend']}', '$obmen_mod', '$obmen_raz', '$obmen_cv', '$obmen_mat', '$kolichestvo', '{$myr_tov_obm['cena']}', '$summa_obmen', '$bonus_zp', '$proc_zp_new', `kontakt_nomer_tel`, `FIO`, '$skidka_obmen', '$primechanie', '{$_SESSION['login']}', `printer_ID`, '$sec_dat' FROM `prodaja` WHERE `ID` = '$ID_prodaja'",$db);


//$res_pro = mysql_query("UPDATE `prodaja` SET `data` = '$data_priema', `brend` = '{$myr_br['brend']}', `nomer_mod` = '$obmen_mod', `razmer` = '$obmen_raz', `cvet` = '$obmen_cv', `material` = '$obmen_mat', `cena` = '{$myr_tov_obm['cena']}', `voznag` = '{$myr_tov_obm['voznag']}', `procent` = '$proc_zp_new', `skidka` = '$obmen_skidka', `add` = '$primechanie', `sec_data` = '$sec_dat', `ID` = '$max_pro_id', `user` = '{$_SESSION['login']}' WHERE `ID` = '$ID_prodaja'",$db);


//Определение максимального идентификатора таблицы продаж
$res_max_pro = mysql_query("SELECT MAX(ID) AS `ID` FROM prodaja WHERE `magazin` = '{$myr_mag['name']}'",$db);
$myr_max_pro = mysql_fetch_array($res_max_pro, MYSQL_ASSOC);
//$max_pro_id = $myr_max_pro['ID'] + 1;

//Обновление значения авто_инкримента
//$max_pro_index = $max_pro_id + 1;
//$set_auto_inc = mysql_query ("ALTER TABLE `prodaja` AUTO_INCREMENT='$max_pro_index'");


//ВЫборка для определения количества товара на складе
//$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
//$myr_kat=mysql_fetch_array($res_kat);
	
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '$magazine' AND `ID_kategorii` = '{$myr_kat['ID']}' AND `ID_brenda` = '$obmen_brend' AND `ID_tovara` = '$obmen_tovar_id'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);
//Обновление записи товара на складе
$new_kolichestvo=$myr_sklad['kolichestvo'] - $kolichestvo;
$res_sklad=mysql_query("UPDATE `sklad_tovaru` SET `kol_posl_prihoda` = '-$kolichestvo', `data_posl_prihoda` = '$data_priema', kolichestvo = '$new_kolichestvo' WHERE ID = '{$myr_sklad['ID']}' ",$db);

//Добавление записи в архив склада
$osnatok_archiv='-'.$kolichestvo.' ('.$new_kolichestvo.')';
$res_arch_sklad=mysql_query("INSERT INTO `prihodu` SET `data` = '$data_priema', `ID_magazina` = '$magazine', `ID_kategorii` = '{$myr_kat['ID']}', `ID_brenda` = '$obmen_brend', `ID_tovara` = '$obmen_tovar_id', `kol_prihoda` = '$osnatok_archiv', `primech` = 'Обмен!', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_dat'",$db);


//Обновление зарплаты нового продавца
$res_max_zap_new = mysql_query("SELECT `k_oplate` FROM `zarplata` WHERE `ID_usera` = '{$_SESSION['user_id']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_max_zap_new = mysql_fetch_array($res_max_zap_new);	
$new_zarplata = $myr_max_zap_new['k_oplate'] + $bonus_zp + $proc_zp_new;
//Вставка зарплаты для нового пользователя
$res_zar_new = mysql_query("INSERT INTO `zarplata` SET `ID_prodaja` = '{$myr_max_pro['ID']}', `ID_magazina` = '$magazine', `ID_usera` = '{$_SESSION['user_id']}', `data` = '$dat', `vremya` = '$vremya', `polniy_den` = '----', `polov_dnya` = '----', `prodaja` = '$bonus_zp', `procent` = '$proc_zp_new', `k_oplate` = '$new_zarplata', `vudano` = '----', `shtraf` = '----', `bonus` = '----', `user` = '----'",$db);


//Обновление информации о статой (уже несуществующей) продаже в таблице зарплат.
//$res_zar_old_pro = mysql_query("UPDATE `zarplata` SET `ID_prodaja` = '0' WHERE `ID_prodaja` = '$ID_prodaja'",$db);


//Обновление кассы магазина
$res_vkasse_new = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);
$myr_vkasse_new = mysql_fetch_array($res_vkasse_new);
$summa_vkasse = $myr_vkasse_new['vkasse'] + ($myr_tov_obm['cena'] - $obmen_skidka)*$kolichestvo;
$summa_inkass = ($myr_tov_obm['cena'] - $obmen_skidka)*$kolichestvo;
$res_kassa_new = mysql_query("INSERT INTO `kassa` SET `ID_prodaja` = '{$myr_max_pro['ID']}', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `vkasse` = '$summa_vkasse', `inkas` = '+$summa_inkass', `user` = '{$_SESSION['login']}: Обмен!' ",$db);
	
}

//else { 
//if ($dvozv == 'dengi'){
//$res_secdata=mysql_query("SELECT `sec_data` FROM `prodaja` WHERE `ID`='$ID_prodaja'",$db);
//$myr_secdata=mysql_fetch_array($res_secdata);
//$new_sec_data = $myr_secdata['sec_data'].'_rollback';
//$res_secdata=mysql_query("UPDATE `prodaja` SET `add` = 'Возврат денег за товар!', `sec_data` = '$new_sec_data' WHERE `ID`='$ID_prodaja'",$db);
//}
//}

  $res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM vozvratu",$db);
  $myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);
  $ind = $myr_max['ID'];
}
}

if ($daln_dvizhen == 'Поставлен на приход') {
		
$res_prih = mysql_query("SELECT `flag` FROM `vozvratu` WHERE `ID` = '$ind'",$db);	
$myr_prih = mysql_fetch_array($res_prih);

if ($myr_prih['flag'] == 'false') {
//$res_kat=mysql_query("SELECT `ID` FROM sklad_kategorii WHERE kateg = '$kategory'",$db);
//$myr_kat = mysql_fetch_array($res_kat);

$res_br_id = mysql_query("SELECT `ID` FROM `sklad_brendu` WHERE `ID_kategorii` = '{$myr_kat['ID']}' AND `brend` = '$brend'",$db);
$myr_br_id = mysql_fetch_array($res_br_id);
			
$res_tovar = mysql_query("SELECT `ID` FROM `prase` WHERE `ID_kategorii` = '{$myr_kat['ID']}' AND `ID_brenda` = '{$myr_br_id['ID']}' AND `nomer_mod` ='$nomer_mod' AND `razmer` ='$razmer' AND `cvet` = '$cvet' AND `material` = '$material'",$db);
	
if (mysql_num_rows($res_tovar) > 0) {$myr_tovar = mysql_fetch_array($res_tovar); $ind_tov = $myr_tovar['ID'];} else {
$result_tovar = mysql_query("INSERT INTO `prase` SET `ID_kategorii` = '{$myr_kat['ID']}', `ID_brenda` = '{$myr_br_id['ID']}', `nomer_mod` ='$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', `cena` ='$cena', voznag = '$voznag'",$db); 
$res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM prase",$db);
$myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);
$ind_tov = $myr_max['ID'];	}
	
$res_sklad = mysql_query("SELECT `ID`, `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '$magazine' AND `ID_kategorii` = '{$myr_kat['ID']}' AND `ID_brenda` = '{$myr_br_id['ID']}' AND `ID_tovara` = '$ind_tov'",$db); 

if (mysql_num_rows($res_sklad) > 0) {$myr_sklad = mysql_fetch_array($res_sklad); $kol = $myr_sklad['kolichestvo']+$kolichestvo; $result_sklad = mysql_query("UPDATE `sklad_tovaru` SET `kol_posl_prihoda` = '+$kolichestvo', `data_posl_prihoda` = '$data_priema', `kolichestvo` = '$kol' WHERE `ID` = '{$myr_sklad['ID']}'",$db);} 
else {$kol = $kolichestvo; $result_sklad = mysql_query("INSERT INTO `sklad_tovaru` SET `ID_magazina` = '$magazine', `ID_kategorii` = '{$myr_kat['ID']}', `ID_brenda` = '{$myr_br_id['ID']}', `ID_tovara` = '$ind_tov', `kol_posl_prihoda` = '+$kolichestvo', `data_posl_prihoda` = '$data_priema', `kolichestvo` = '$kol'",$db);}

//Добавление записи в архив склада
$kol_prihoda = '+'.$kolichestvo.' ('.$kol.')';
$res_arch_sklad=mysql_query("INSERT INTO `prihodu` SET `data` = '$data_priema', `ID_magazina` = '$magazine', `ID_kategorii` = '{$myr_kat['ID']}', `ID_brenda` = '{$myr_br_id['ID']}', `ID_tovara` = '$ind_tov', `kol_prihoda` = '$kol_prihoda', `primech` = 'Возврат!', `user` = '$kto_pvinyal', `sec_data` = '$sec_dat'",$db);

$res_prih = mysql_query("UPDATE `vozvratu` SET `flag`='true' WHERE `ID` = '$ind'",$db);	
}
}

header("Location: ../vozvratu.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>