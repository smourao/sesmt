<?php
include "../sessao.php";
include "../config/connect.php";
//include "db.php";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script language="JavaScript" type="text/javascript" src="richtext.js"></script>

<title>Administração Jornal SESMT</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<form action="" method="post" name="riscos" id="riscos">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold"><font color="#000000">Jornal SESMT </font></div></td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12"><br>
      <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12"><input name="btn_incluir" type="button" id="btn_incluir" value="Incluir" onClick="location.href='?action=new'"></td>
        <td class="fontebranca12"><input name="btn_editar" type="button" id="btn_editar" value="Editar" onClick="location.href='?action=edit'"></td>
        <td class="fontebranca12">
        <input name="btn_voltar" type="button" id="btn_voltar" onClick="location.href='index.php'" value="&lt;&lt; Voltar"></td>
      </tr>

    </table>
      <br></td>
  </tr>
</table>
</form>
<?PHP
if($_GET['action']=="new"){
   if($_POST){
      $sql = "INSERT INTO site_jornal_sesmt
      (titulo, resumo, detalhado, data, ano, mes, enviado_por, exibir)
      VALUES
      ('{$_POST['titulo']}', '{$_POST['txtResumido']}', '{$_POST['txtCompleto']}', '".date("Y-m-d")."',
      '{$_POST['ano']}', '{$_POST['mes']}', 'Pedro Henrique', 1)
      ";

      if(pg_query($sql)){
      echo "<center><span class=fontebranca12>Texto enviado com sucesso!</span></center>";
      }else{
      echo "<center><span class=fontebranca12>Erro ao enviar o texto para o banco de dados!</span></center>";
      }
      //print_r($_POST);
   }else{
echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
echo "<tr><td  class=fontebranca12>";
echo '<form name="RTEDemo" action="jornal_admin.php?action=new" method="post" onsubmit="return submitForm();">';
echo '<table border=0>
<tr>
   <td class="fontebranca12">Titulo:</td><td><input type=text name="titulo" id="titulo"></td>
</tr>
<tr>
   <td class="fontebranca12">Mes:</td>
   <td>
   <!--<input type=text name="mes" id="mes" size=2>-->
   <select name=mes>
      <option value=1>Janeiro</option>
      <option value=2>Fevereiro</option>
      <option value=3>Março</option>
      <option value=4>Abril</option>
      <option value=5>Maio</option>
      <option value=6>Junho</option>
      <option value=7>Julho</option>
      <option value=8>Agosto</option>
      <option value=9>Setembro</option>
      <option value=10>Outubro</option>
      <option value=11>Novembro</option>
      <option value=12>Dezembro</option>
   </select>
   </td>
</tr>
<tr>
<td class="fontebranca12">Ano:</td>
<td>
<!--<input type=text name="ano" id="ano" size=4>-->
   <select name=ano>
      <option>2005</option>
      <option>2006</option>
      <option>2007</option>
      <option>2008</option>
      <option selected>2009</option>
      <option>2010</option>
      <option>2011</option>
   </select>
</td>
</tr>
<table>
<p>
';

echo "<script language=\"JavaScript\" type=\"text/javascript\">
<!--
function submitForm() {
	updateRTEs();
	return true;
}
//Usage: initRTE(imagesPath, includesPath, cssFile)
initRTE(\"images/\", \"\", \"\");
//-->
</script>
<noscript><p><b>Javascript precisa estar habilitado para utilizar este formulário!</b></p></noscript>

<script language=\"JavaScript\" type=\"text/javascript\">
<!--
//writeRichText(fieldname, html, width, height, buttons, readOnly)
document.writeln('<center><b>Texto resumido</b></center><br>');
writeRichText('txtResumido', '', 520, 100, true, false);
document.writeln('<br><br>');
document.writeln('<center><b>Texto Completo</b></center><br>');
writeRichText('txtCompleto', '', 520, 200, true, false);
//-->
</script>
<p>
<center>
<input type=\"submit\" name=\"submit\" value=\"Enviar\"></p>
<input type=hidden name=conteudo id=conteudo>
</form>
";
echo "</td></tr></table>";


//print_r($_POST);

}

}



if($_GET['action']=="edit"){
   if($_GET['id']){
   
      if($_POST){
      $sql = "UPDATE site_jornal_sesmt
      SET titulo='{$_POST['titulo']}', resumo='{$_POST['txtResumido']}',
      detalhado='{$_POST['txtCompleto']}', data='".date("Y-m-d")."',
      ano='{$_POST['ano']}', mes='{$_POST['mes']}' WHERE id={$_GET['id']}";
      /*
      if(pg_query($sql)){
      echo "<center><span class=fontebranca12>Texto editado com sucesso!</span></center>";
      }else{
      echo "<center><span class=fontebranca12>Erro ao editar o texto no banco de dados!</span></center>";
      }    */
      //print_r($_POST);
      echo $sql;
      }
   
       $sql = "SELECT * FROM site_jornal_sesmt WHERE id={$_GET['id']}";
       $result = pg_query($sql);
       $buffer = pg_fetch_all($result);

echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
echo "<tr><td  class=fontebranca12>";
echo '<form name="RTEDemo" action="jornal_admin.php?action=edit&id='.$_GET['id'].'" method="post" onsubmit="return submitForm();">';
echo '<table border=0>
<tr>
   <td class="fontebranca12">Titulo:</td>
   <td><input type=text name="titulo" id="titulo" value="'.$buffer[0]['titulo'].'"></td>
</tr>
<tr>
   <td class="fontebranca12">Mes:</td>
   <td>
   <!--<input type=text name="mes" id="mes" size=2>-->
   <select name=mes>
      <option value=1>Janeiro</option>
      <option value=2>Fevereiro</option>
      <option value=3>Março</option>
      <option value=4>Abril</option>
      <option value=5>Maio</option>
      <option value=6>Junho</option>
      <option value=7>Julho</option>
      <option value=8>Agosto</option>
      <option value=9>Setembro</option>
      <option value=10>Outubro</option>
      <option value=11>Novembro</option>
      <option value=12>Dezembro</option>
   </select>
   </td>
</tr>
<tr>
<td class="fontebranca12">Ano:</td>
<td>
<!--<input type=text name="ano" id="ano" size=4>-->
   <select name=ano>
      <option>2005</option>
      <option>2006</option>
      <option>2007</option>
      <option>2008</option>
      <option selected>2009</option>
      <option>2010</option>
      <option>2011</option>
   </select>
</td>
</tr>
<table>
<p>
<input type=hidden name=texto value="dfbfb"
';
$cr = nl2br($buffer[0]['resumo']);
$cr = nl2br(str_replace("\r\n", "<br/>",$cr));

$cc = nl2br($buffer[0]['detalhado']);
$cc = nl2br(str_replace("\r\n", "<br/>",$cc));

//echo "<div style=\"border: 1px solid;\">".nl2br($buffer[0]['detalhado'])."</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\">
<!--
function submitForm() {
	updateRTEs();
	return true;
}
//Usage: initRTE(imagesPath, includesPath, cssFile)
initRTE(\"images/\", \"\", \"\");
//-->
</script>
<noscript><p><b>Javascript precisa estar habilitado para utilizar este formulário!</b></p></noscript>

<script language=\"JavaScript\" type=\"text/javascript\">
<!--
//writeRichText(fieldname, html, width, height, buttons, readOnly)
document.writeln('<center><b>Texto resumido</b></center><br>');
writeRichText('txtResumido', '".$cr."', 520, 100, true, false);
document.writeln('<br><br>');
document.writeln('<center><b>Texto Completo</b></center><br>');


writeRichText('txtCompleto', '".$cc."', 520, 200, true, false);
//-->
</script>
<p>
<center>
<input type=\"submit\" name=\"submit\" value=\"Enviar\"></p>
<input type=hidden name=conteudo id=conteudo>
</form>
";
echo "</td></tr></table>";
   
   }else{
       $sql = "SELECT * FROM site_jornal_sesmt ORDER BY ano, mes DESC";
       $result = pg_query($sql);
       $buffer = pg_fetch_all($result);
       
       echo "<table width=500 border=1 align=center class=fontebranca12>";
       echo "   <tr>";
       echo "      <td align=center><b>Ações</b></td><td align=center><b>Título</b></td>
       <td align=center><b>Resumo</b></td><td align=center><b>Mês/Ano</b></td>";
       echo "   </tr>";
          for($x=0;$x<pg_num_rows($result);$x++){
             echo "   <tr>";
             echo "
             <td align=center>
             <a href='?action=edit&id={$buffer[$x]['id']}' class=linkpadrao>Editar</a>
             <P>
             Excluir</td>
             <td>{$buffer[$x]['titulo']}</td>
             <td>{$buffer[$x]['resumo']}</td>
             <td>{$buffer[$x]['mes']}/{$buffer[$x]['ano']}</td>
             ";
             echo "   </tr>";
          }
       echo "</table>";
   }
}
?>
</body>
</html>


