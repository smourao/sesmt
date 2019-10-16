<?php
include "sessao.php";
include "../config/connect.php";
if ($_GET){
	$funcao = $_GET[funcao];
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
		<td colspan="2" align="center" bgcolor="#009966"><br><h2>Dados Gerais da Função:</h2></td>
	</tr>
<?php
/*$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao, funcao_epi, funcao_medi, funcao_exame, funcao_curso FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
*/
$sql = "SELECT * FROM funcao WHERE cod_funcao={$funcao}";
$result_row = pg_query($connect, $sql);
$row = pg_fetch_all($result_row);

$sql = "SELECT * FROM funcao_epi WHERE cod_epi = {$funcao}";
$result_epi = pg_query($connect, $sql);
$epi = pg_fetch_all($result_epi);

$sql = "SELECT * FROM funcao_medi WHERE cod_medi = {$funcao}";
$result_medi = pg_query($connect, $sql);
$medi = pg_fetch_all($result_medi);

$sql = "SELECT * FROM funcao_exame WHERE cod_exame = {$funcao}";
$result_exa = pg_query($connect, $sql);
$exa = pg_fetch_all($result_exa);

$sql = "SELECT * FROM funcao_curso WHERE cod_curso = {$funcao}";
$result_curso = pg_query($connect, $sql);
$curso = pg_fetch_all($result_curso);

$sql = "SELECT * FROM funcao_ambiental WHERE cod_funcao = {$funcao}";
$result_ambi = pg_query($connect, $sql);
$ambi = pg_fetch_all($result_ambi);

$sql = "SELECT * FROM funcao_programas WHERE cod_funcao = {$funcao}";
$result_prog = pg_query($connect, $sql);
$prog = pg_fetch_all($result_prog);
?>
<tr>
		<th colspan="2" bgcolor="#FFFFFF"><h3><font color="#000000"> FUNÇÃO </font> </h3></th>
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<td valign="top" align=center width=50% >
        <table border=1 width=100% cellpadding="1" cellspacing="1" valign=top class=sample>
           <tr><td align=center width=50%><b>Função</b></td></tr>
          <tr>
          <td bgcolor="#009966">
          <?PHP echo $row[0]['nome_funcao'];?>
          </td>
          </tr>
          </table>
          
        </td>
        <td valign="top" align=center>
          <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
           <tr><td align=center><b>Dinâmica da Função</b></td></tr>
          <tr>
          <td bgcolor="#009966">
          <?PHP echo $row[0]['dsc_funcao'];?>
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
        <tr><td align=center><b>Equipamentos indicados para a Função</b></td></tr>
        <tr>
          <td bgcolor="#009966">
        <?PHP
          for($x=0;$x<pg_num_rows($result_epi);$x++){
              echo "".($x+1)." - {$epi[$x]['descricao']}<br>";
          }
        ?>     </td>
          </tr>

          </table>
        </td>
        
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Medicamentos indicados para a Função</b></td></tr>
        <tr>
          <td bgcolor="#009966">
          <?PHP
          for($x=0;$x<pg_num_rows($result_medi);$x++){
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
        <tr><td align=center><b>Exames indicados para a Função</b></td></tr>
        <tr>
          <td bgcolor="#009966">
          <?PHP
          for($x=0;$x<pg_num_rows($result_exa);$x++){
              echo "".($x+1)." - {$exa[$x]['descricao']}<br>";
          }
        ?>    </td>
          </tr>
          </table>
        </td>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Cursos indicados para a Função</b></td></tr>
        <tr>    <td align=left bgcolor="#009966">
          <?PHP
          for($x=0;$x<pg_num_rows($result_curso);$x++){
              echo "
          ".($x+1)." - {$curso[$x]['descricao']}<br>
          ";
          }
        ?> </td>
        </tr>
          </table>
          
        </td>
	</tr>
	<tr>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Avaliações indicadas para a Função</b></td></tr>
        <tr>
          <td bgcolor="#009966">
          <?PHP
          for($x=0;$x<pg_num_rows($result_ambi);$x++){
              echo "".($x+1)." - {$ambi[$x]['descricao']}<br>";
          }
        ?>    </td>
          </tr>
          </table>
        </td>
		<td valign="top" align=center>

        <table border=1 width=100% cellpadding=\"1\" cellspacing=\"1\" valign=top class=sample>
        <tr><td align=center><b>Programas indicados para a Função</b></td></tr>
        <tr>    <td align=left bgcolor="#009966">
          <?PHP
          for($x=0;$x<pg_num_rows($result_prog);$x++){
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
			<input type="button" name="voltar" value="&lt;&lt; &nbsp; Voltar" onClick="MM_goToURL('parent','funcao_curso.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_medi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_funcao.php'); return document.MM_returnValue" value=" Concluir" style="width:100;">
			<br>&nbsp;
		</td>
	</tr>

</table>
</body>
</html>
