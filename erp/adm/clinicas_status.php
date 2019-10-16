<?php
include "../sessao.php";
include "../config/connect.php";

/*Parte que trata os exames que serão excluidos*/
if( !empty($_GET[exame]) )
{
	$exame = $_GET[exame];

	$query_excluir = "DELETE FROM clinica_exame WHERE cod_exame = $exame and cod_clinica = ".$_GET['id'];
	
	$result_excluir = pg_query($connect, $query_excluir)
		or die ("Erro na query: $query_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir) {
		echo '<script> alert("O Exame foi EXCLUIDO com sucesso!");</script>';
	}
} 
/************ Fim da exclusão *************/


if($_GET['act']=="ativar"){
$sql = "UPDATE clinicas SET ativo=1 WHERE cod_clinica = ".$_GET['id'];
if(pg_query($connect, $sql)){
    echo "<script>alert('Clínica ativada!')</script>";
}else{
    echo "<script>alert('Erro ao ativar clínica!')</script>";
}
}elseif($_GET['act']=="desativar"){
$sql = "UPDATE clinicas SET ativo=0 WHERE cod_clinica = ".$_GET['id'];
if(pg_query($connect, $sql)){
    echo "<script>alert('Clínica desativada!')</script>";
}else{
    echo "<script>alert('Erro ao desativar clínica!')</script>";
}
}
$sql = "SELECT * FROM clinicas ORDER BY cod_clinica";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Clínicas Cadastradas</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>
<script>
function change_porc(valor, clinica){
    if(valor != null && clinica != ""){
       var url = "ajax_change_porc.php?valor="+valor;
       url = url + "&clinica="+clinica;
       url = url + "&cache=" + new Date().getTime();
       http.open("GET", url, true);
       http.onreadystatechange = change_porc_reply;
       http.send(null);
    }
}
function change_porc_reply(){
    if(http.readyState == 4){
        var msg = http.responseText;
    	if(msg != ""){
            window.location.reload();
            //alert(msg);
    	}
    }else{
     if (http.readyState==1){
           //waiting...
        }
    }
}

</script>
<style type="text/css" media="screen">
.excluir{
 font-family: verdana;
 color: #FF0000;
 font-size: 12px;
}
.excluir:hover{
 font-family: verdana;
 color: #fa3d3d;
 font-size: 12px;
}
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold">
    <font color="#000000">Clínicas Cadastradas</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" align=center>
<?PHP
if($_GET[act]=="list" || empty($_GET[act])){
   echo"<input name=\"btn_listar\" type=\"button\" id=\"btn_listar\" value=\"Sair\" onClick=\"javascript:location.href='index.php'\">";
}else{
   echo"<input name=\"btn_listar\" type=\"button\" id=\"btn_listar\" value=\"Voltar\" onClick=\"javascript:location.href='clinicas_status.php'\">";
}
?>
 </td>
      </tr>
    </table>
      </td>
  </tr>
</table>
<p>
<?PHP
if($_GET[act]=="list" || empty($_GET[act])){
?>
<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="221" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social</div></td>
    <td width="181" class="linhatopodir"><div align="center" class="fontebranca12"><strong>Telefone</div></td>
    <td width="127" class="linhatopodir"><div align="center" class="fontebranca12"><strong>EMail</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12"><strong>Status</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12"><strong>Ação</div></td>
  </tr>
<?PHP
   for($x=0;$x<pg_num_rows($res);$x++){
      echo "<tr>";
      echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10 linksistema\"><a href='?act=detail&id={$buffer[$x][cod_clinica]}' class=\"fontebranca10 linksistema\">{$buffer[$x]['razao_social_clinica']}</a></div></td>";
      echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['tel_clinica']}</div></td>";
      echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['email_clinica']}</div></td>";
      echo "<td class=\"linhatopodiresqbase\" align=center><div class=\"fontebranca10 linksistema\" style=\"font-height: bold;\" align=center>";
      print $buffer[$x]['ativo'] == 0 ? "<font color=red><b>Inativo</b></font>" : "<font color=green><b>Ativo</b></font>";
      echo "</div></td>";
      echo "<td class=\"linhatopodiresqbase\" align=center>
      <div class=\"linksistema\">
      <a href='clinicas_status.php?act=";
      print $buffer[$x]['ativo'] == 0 ? "ativar" : "desativar";
      echo "&id={$buffer[$x]['cod_clinica']}' class="; print $buffer[$x]['ativo'] == 0 ? "linksistema" : "linksistema";echo">";
      print $buffer[$x]['ativo'] == 0 ? "Ativar" : "Desativar";
      echo"</a>
      </div></td>";
      echo "</tr>";
   }
   echo "</table>";
}elseif($_GET['act']=='detail'){
   $_GET['id'];
   $sql = "SELECT * FROM clinicas WHERE cod_clinica = '{$_GET['id']}'";
   $res = pg_query($sql);
   $buffer = pg_fetch_array($res);
   echo '<center><b><font color=white>'.$buffer[razao_social_clinica].'</font></b><br>
         <font color=white size=1><b>CNPJ: ';
   print $buffer[cnpj_clinica] != "" ? $buffer[cnpj_clinica] : "N/D";
   echo '</b></font></center>';
   echo '<p>';
   echo '<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">';
   echo '<tr>';
   echo '    <td class=fontebranca12 width=40%><b>Endereço</b></td><td class=fontebranca12>'.$buffer[endereco_clinica].' Nº'.$buffer[num_end].'&nbsp;</td>';
   echo '</tr>';
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Bairro</b></td><td class=fontebranca12>'.$buffer[bairro_clinica].'&nbsp;</td>';
   echo '</tr>';
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Cidade/Estado</b></td><td class=fontebranca12>'.$buffer[cidade].'/'.$buffer[estado].'&nbsp;</td>';
   echo '</tr>';
   echo '<tr>';
   echo '    <td class=fontebranca12><b>CEP</b></td><td class=fontebranca12>'.$buffer[cep_clinica].'&nbsp;</td>';
   echo '</tr>';
if(!empty($buffer[referencia_clinica])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Ponto de Referência</b></td><td class=fontebranca12>'.$buffer[referencia_clinica].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[tel_clinica])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Telefone</b></td><td class=fontebranca12>'.$buffer[tel_clinica].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[fax_clinica])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Fax</b></td><td class=fontebranca12>'.$buffer[fax_clinica].'&nbsp;</td>';
   echo '</tr>';
}
   echo '<tr>';
   echo '    <td class=fontebranca12><b>E-Mail</b></td><td class=fontebranca12>'.$buffer[email_clinica].'&nbsp;</td>';
   echo '</tr>';
if(!empty($buffer[contato_clinica])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Pessoa de Contato</b></td><td class=fontebranca12>'.$buffer[contato_clinica].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[cargo_responsavel])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Cargo Contato</b></td><td class=fontebranca12>'.$buffer[cargo_responsavel].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[tel_contato])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Tel Contato</b></td><td class=fontebranca12>'.$buffer[tel_contato].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[nextel_contato]) || !empty($buffer[id_nextel_contato])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>Nextel</b></td><td class=fontebranca12>'.$buffer[nextel_contato].' - id '.$buffer[id_nextel_contato].'&nbsp;</td>';
   echo '</tr>';
}
if(!empty($buffer[email_contato])){
   echo '<tr>';
   echo '    <td class=fontebranca12><b>E-Mail Contato</b></td><td class=fontebranca12>'.$buffer[email_contato].'&nbsp;</td>';
   echo '</tr>';
}
   echo '<tr>';
   echo "    <td class=fontebranca12><b>Porcentagem Sobre Exames</b></td><td class=fontebranca12>{$buffer[por_exames]}%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type=button name=chg id=chg value='Alterar' onclick=\"var vl = prompt('Digite o valor de porcentagem sobre cada exame: (exemplo: 5.00 para 5%)', '{$buffer[por_exames]}'); change_porc(vl, '{$_GET['id']}');return false;\"></td>";
   echo '</tr>';
   echo '<tr>';
   echo '    <td class="fontebranca12"><b>Status</b></td><td class="fontebranca12">'; print $buffer[ativo] == 0 ? "<font color=red><b>Inativo</b></font>" : "<font color=green><b>Ativo</b></font>"; echo '&nbsp;</td>';
   echo '</tr>';
   echo '</table>';
   echo '<p>';
   $sql_exame = "SELECT DISTINCT ce.cod_clinica, ce.cod_exame, e.especialidade, ce.preco_exame
				 FROM clinica_exame ce, exame e, clinicas c
				 where ce.cod_exame = e.cod_exame
				 and ce.cod_clinica = c.cod_clinica
				 and ce.cod_clinica = '{$_GET['id']}'";
   $result_exame = pg_query($sql_exame);
   $exames = pg_fetch_all($result_exame);
   echo '<center><b><font color=white>Exames Cadastrados</font></b></center>';
   echo '<p>';
   echo '<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">';
   echo '<tr>';
   echo '    <td class=fontebranca12><b>&nbsp;</b></td>';
   echo '    <td class=fontebranca12><b>Exame</b></td>';
   echo '    <td class=fontebranca12 width=80><b>Valor Clinica</b></td>';
   echo '    <td class=fontebranca12 width=80><b>% Cobrado</b></td>';
   echo '    <td class=fontebranca12 width=80><b>Valor Total</b></td>';
   echo '</tr>';
   for($x=0;$x<pg_num_rows($result_exame);$x++){
      $per = ($exames[$x]['preco_exame'] *  $buffer[por_exames])/100;
      echo '<tr>';
	  echo '	<th class=linksistema><a href="../adm/clinicas_status.php?act=detail&id='.$_GET[id].'&exame='.$exames[$x][cod_exame].'"><u>Excluir</u></a></th>';
      echo '    <td class=fontebranca12>'.$exames[$x]['especialidade'].'</td>';
      echo '    <td class=fontebranca12>R$ '.number_format(($exames[$x]['preco_exame']-$per), 2, ',','.').'</td>';
      echo '    <td class=fontebranca12>R$ '.number_format($per, 2, ',','.').'</td>';
      echo '    <td class=fontebranca12>R$ '.number_format(($exames[$x]['preco_exame']), 2, ',','.').'</td>';
      echo '</tr>';
   }
   echo '</table>';
}
?>
</form>
</body>
</html>
