<?php
include "sessao.php";
include "../config/connect.php";
if ($_GET){
	$funcao = $_GET[setor];
}else{
	$funcao = $_POST[funcao];
}
?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table align="center" width="800" border="0" cellpadding="4" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br><h2>Dados Gerais do Setor:</h2></td>
	</tr>
<?php
$sql = "SELECT * FROM setor WHERE cod_setor={$funcao}";
$result = pg_query($connect, $sql);
$row = pg_fetch_all($result);

$sql = "SELECT * FROM setor_epi WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$epi = pg_fetch_all($result);

$sql = "SELECT * FROM setor_medi WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$medi = pg_fetch_all($result);

$sql = "SELECT * FROM setor_exame WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$exa = pg_fetch_all($result);

$sql = "SELECT * FROM setor_curso WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$curso = pg_fetch_all($result);

$sql = "SELECT * FROM setor_ambiental WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$ambi = pg_fetch_all($result);

$sql = "SELECT * FROM setor_programas WHERE cod_setor = {$funcao}";
$result = pg_query($connect, $sql);
$prog = pg_fetch_all($result);

?>
<tr>
		<th colspan="2" bgcolor="#FFFFFF"><h3><font color="#000000"> SETOR </font> </h3></th>
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<td valign="top" align=center width=50% >
        <table border=1 width=100% cellpadding="1" cellspacing="1" valign=top class=sample>
           <tr><td align=center width=50%><b>Setor</b></td></tr>
          <tr>
          <td bgcolor="#009966">
          <?PHP echo $row[0]['nome_setor'];?>
          </td>
          </tr>
          </table>
          
        </td>
        <td valign="top" align=center>
          <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
           <tr><td align=center><b>Descrição do Setor</b></td></tr>
          <tr>
          <td bgcolor="#009966">
          <?PHP echo $row[0]['desc_setor'];?>
          </td>
          </tr>
          </table>
          
        </td>
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<td valign="top" align=center>
        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Equipamentos indicados para o Setor</b></td></tr>
        <tr>
          <td bgcolor="#009966">
        <?PHP
          for($x=0;$x<count($epi);$x++){
              echo "".($x+1)." - {$epi[$x]['descricao']}<br>";
          }
        ?>     </td>
          </tr>

          </table>
        </td>
        
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Medicamentos indicados para o Setor</b></td></tr>
        <tr>
          <td bgcolor="#009966">
          <?PHP
          for($x=0;$x<count($medi);$x++){
              echo "".($x+1)." - {$medi[$x]['descricao']}<br>";
          }
        ?>
        </td>
          </tr>
          </table>

       </td>
       
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Exames indicados para o Setor</b></td></tr>
        <tr>
          <td bgcolor="#009966">
          <?PHP
          for($x=0;$x<count($exa);$x++){
              echo "".($x+1)." - {$exa[$x]['descricao']}<br>";
          }
        ?>    </td>
          </tr>
          </table>
        </td>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Avaliações indicados para o Setor</b></td></tr>
        <tr>    <td align=left bgcolor="#009966">
          <?PHP
          for($x=0;$x<count($ambi);$x++){
              echo "
          ".($x+1)." - {$ambi[$x]['descricao']}<br>
          ";
          }
        ?> </td>
        </tr>
          </table>
          
        </td>
	</tr>
	<tr>
		<td valign="top" align=center>
        </td>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Programas indicados para o Setor</b></td></tr>
        <tr>    <td align=left bgcolor="#009966">
          <?PHP
          for($x=0;$x<count($prog);$x++){
              echo "
          ".($x+1)." - {$prog[$x]['descricao']}<br>
          ";
          }
        ?> </td>
        </tr>
          </table>
          
        </td>
	</tr>
	
	<tr><td>&nbsp;</td></tr>

	<tr>
		<td align="center" colspan="2" bgcolor="#009966" ><br>
			<input type="button" name="voltar" value="&lt;&lt; &nbsp; Voltar" onClick="location.href='setor_exame.php?setor=<?php echo $funcao; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_medi_funcao" type="button" id="btn_novo" onClick="location.href='lista_setor.php';" value=" Concluir" style="width:100;">
			<br>&nbsp;
		</td>
	</tr>

</table>
</body>
</html>
