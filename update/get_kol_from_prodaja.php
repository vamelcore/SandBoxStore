<?php

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$kol = $_REQUEST['kolichestvo'];

if ($kol <> '') {

printf("<select name=\"kolichestvo\" id=\"kolich_vozv\">");
$i = 1;
while ($i <= $kol) {
printf("<option value=\"%s\">%s шт.</option>",$i,$i);
$i++;
}

printf("</select>");
 }

}
?>