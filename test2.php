<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<title>Untitled Document</title>
</head>

<body>
<table>
 <tr bgcolor="#dce6ee">
  	<td><p>Дата покупки:</p></td>
  	<td>
  		<select name="data_pokupki" id="pokup_vozv"><option value="1">1 шт.</option><option value="5">5 шт.</option></select>
  	</td>
 <tr bgcolor="#ecf2f6">
	<td><p>Количество:</p></td>
  	<td id="kolich"><select name="kolichestvo" id="kolich_vozv" disabled="disabled"><option value="0">0 шт.</option></select></td>
    </tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
         $("#pokup_vozv").change(function(){		 		
         
		 $("#kolich").load("./update/get_kol_from_prodaja.php", { kolichestvo: $("#pokup_vozv option:selected").val() });
});		 
});
		 </script>
		 
<script type="text/javascript">
$(document).ready(function(){
  $("#kolich").change(function(){
 
  alert('This is what an alert message looks like.');
     
  });
});
</script>
</body>
</html>
