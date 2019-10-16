<html>
<head>
<title>Ordem de Servi&ccedil;o</title>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0" class='text roundborderselected'>
<tr>
	<th  height="50"  colspan="4">
		<input name="btn_listar" type="button" id="btn_listar" onClick="location.href='?action=list'" value="Listar O.S." style="width:100;" class='btn'>
		<input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new'" value="Nova O.S." style="width:100;" class='btn'>
        <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='index.php'" value="Sair" style="width:100;" class='btn'>

      </th>
</tr>
<tr>
	<th>
		<?PHP
			$p = "./".$_GET['action'].'.php';
			if(file_exists($p)){
				include($p);
			}else{
				include('list.php');
			}
		?>
	</th>
</tr>

</table>

<br>
</body>
</html>