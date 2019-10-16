<?php
include "sessao.php";
include "config/connect.php";
$sql = "SELECT * FROM site_avaliacao_ambiental";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

if($_GET['del']){
   $sql = "DELETE FROM site_avaliacao_ambiental WHERE id='{$_GET['cod']}'";
   if(pg_query($sql)){
      echo "<script>
      alert('Substância excluida!');
      location.href='sim_avaliacao_ambiental.php';
      </script>";
   }else{
      echo "<script>
      alert('Erro ao escluir substância!');
      location.href='sim_avaliacao_ambiental.php';
      </script>";
   }
}

?>
<html>
<head>
<title>Simulador de Avaliação Ambiental</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="ab.js"></script>
<script language="javascript" src="screen.js"></script>
</head>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
td.black{
color: #000000;
}
</style>
<div id=migraaa style="display: none; color: #000000; background-color: #cccccc; position: absolute;">
   <table width=100% border=0>
   <tr>
      <td class=black align=center><b>Migrar para cadastro de produtos</b></td>
      <td class=black width=10 onclick="document.getElementById('migraaa').style.display = 'none';return false;" style="cursor:pointer;">
      <b>[X]</b></td>
   </tr>
   </table>
   <br>
   <table border=0 width=100%>
   <tr>
      <td class=black><b>Substância:</b> </td><td class=black><span id=mName></span></td>
   </tr>
   <tr>
      <td class=black><b>Valor:</b> </td><td><input id=mValor name=mValor type=text onkeypress="return FormataReais(this, '.', ',', event);"></td>
   </tr>
   <tr>
      <td class=black><b>Resumo:</b> </td><td><textarea id=mResumo name=mResumo></textarea></td>
   </tr>
   <tr>
      <td class=black><b>Detalhado:</b> </td><td><textarea id=mDetalhado name=mDetalhado></textarea></td>
   </tr>
   </table>
   <input type=hidden id=mId name=mId>
   <center><input type=button value="Cadastrar" onclick="migrar_bb();">
</div>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="12" class="linhatopodiresq" bgcolor="#009966"><br>SIMULADOR DE AVALIAÇÃO AMBIENTAL<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="12">
			<br>&nbsp;
			<?PHP
            if($_GET){
               echo "<input name=\"btn_sair\" type=\"button\" id=\"btn_sair\" onClick=\"MM_goToURL('parent','./sim_avaliacao_ambiental.php'); return document.MM_returnValue\" value=\"Voltar\" style=\"width:100;\">";
            }else{
               echo "<input name=\"btn_sair\" type=\"button\" id=\"btn_sair\" onClick=\"MM_goToURL('parent','./tela_principal.php'); return document.MM_returnValue\" value=\"Sair\" style=\"width:100;\">";
            }
			?>
				<input name="btnNovo" type="button" id="btnNovo" onClick="location.href='sim_avaliacao_ambiental.php?new=do';" value="Nova Substância" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="12" class="linhatopodiresq">&nbsp;
<?PHP
if(!$_GET && !$_POST){
?>
<table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente();">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
</table>

     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
<?PHP
}
function normalizar_valor($valor){
  if(strlen(strstr($valor, ","))>0){
   $valor = str_replace(".", "", $valor);
   $valor = str_replace(",", ".", $valor);
   return $valor;//number_format($valor, 2, '', '.');
  }else{
   return $valor;// number_format($valor, 2, '', '.');
  }
}

/***********************************************************************************************/
// EDITAR ORCAMENTO - SUBSTÂNCIAS
/***********************************************************************************************/
if($_GET['act']=="delorcamento"){
$sql = "DELETE FROM site_orc_aa_produto WHERE cod_orcamento = '{$_GET['orcamento']}'";
if(pg_query($sql)){
   $sql = "DELETE FROM site_orc_aa_info WHERE cod_orcamento = '{$_GET['orcamento']}'";
   if(pg_query($sql)){
      echo "<script>alert('Orçamento excluido!');location.href='sim_avaliacao_ambiental.php';</script>";
   }
}else{
   echo "<script>alert('Erro ao excluir orçamento!');</script>";
}
}

/***********************************************************************************************/
// EDITAR ORCAMENTO - SUBSTÂNCIAS
/***********************************************************************************************/
if($_GET['act']=="editorcamento"){
   echo "<center>";
   echo "<input name=btnDel type=button id=btnDel onClick=\"location.href='?act=delorcamento&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento={$_GET['orcamento']}';\" value=\"Excluir\" style=\"width:100;\">";
   echo "</center>";
}

/***********************************************************************************************/
// NOVO ORCAMENTO - SUBSTÂNCIAS
/***********************************************************************************************/
if($_GET['act']=="orcamento"){
   $sql = "SELECT MAX(cod_orcamento)as cod_orcamento FROM site_orc_info";
   $r = pg_query($sql);
   $max = pg_fetch_array($r);

   $sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM orcamento";
   $r2 = pg_query($sql);
   $max2 = pg_fetch_array($r2);
   
   $sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM site_orc_aa_info";
   $r3 = pg_query($sql);
   $max3 = pg_fetch_array($r3);

   $row_cod[cod_orcamento] = 0;

   if($max[cod_orcamento] > $max2[cod_orcamento]){
      $row_cod[cod_orcamento] = $max[cod_orcamento]+1;
   }else{
      $row_cod[cod_orcamento] = $max2[cod_orcamento]+1;
   }
   
   if($max3[cod_orcamento] >= $row_cod[cod_orcamento]){
      $row_cod[cod_orcamento] = $max3[cod_orcamento]+1;
   }else{
      $row_cod[cod_orcamento] = $row_cod[cod_orcamento];
   }
   

   $sql = "INSERT INTO site_orc_aa_info
   (cod_cliente, cod_filial, cod_orcamento, data_criacao, vendedor_id)
   VALUES
   ('".$_GET['cod_cliente']."', '{$_GET['cod_filial']}', '{$row_cod[cod_orcamento]}', '".date("Y-m-d")."',{$_SESSION['usuario_id']})
   ";
   $result = pg_query($sql);

   if($result){
      header("Location: ?act=editorcamento&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento=".$row_cod[cod_orcamento]."");
   }else{
      echo "<script>alert('Erro ao adicionar novo orçamento! Por favor, tente novamente.');</script>";
   }


   echo $row_cod[cod_orcamento];
   

}//END ACT = ORCAMENTO
/***********************************************************************************************/
// NOVO ITEM - SUBSTÂNCIAS
/***********************************************************************************************/
if($_GET['new']){

if($_POST){
/*
$_POST['bomba'] = normalizar_valor($_POST['bomba']);
$_POST['relatorio'] = normalizar_valor($_POST['relatorio']);
$_POST['dia_prof'] = normalizar_valor($_POST['dia_prof']);
$_POST['custo_lab'] = normalizar_valor($_POST['custo_lab']);
$_POST['sedex'] = normalizar_valor($_POST['sedex']);
$_POST['cassete'] = normalizar_valor($_POST['cassete']);
$_POST['ciclone'] = normalizar_valor($_POST['ciclone']);
*/

if(empty($_POST['substancia'])){
   echo "<script>alert('Campo substância incorreto!');</script>";
}else{
if($_POST['bomba'] == "")$_POST['bomba'] = '0,00';
if($_POST['relatorio'] == "")$_POST['relatorio'] = '0,00';
if($_POST['dia_prof'] == "")$_POST['dia_prof'] = '0,00';
if($_POST['custo_lab'] == "")$_POST['custo_lab'] = '0,00';
if($_POST['sedex'] == "")$_POST['sedex'] = '0,00';
if($_POST['cassete'] == "")$_POST['cassete'] = '0,00';
if($_POST['ciclone'] == "")$_POST['ciclone'] = '0,00';
if($_POST['certificado'] == "")$_POST['certificado'] = '0,00';
if($_POST['aac'] == "")$_POST['aac'] = '0,00';

$sql = "SELECT * FROM site_avaliacao_ambiental WHERE
substancia = '{$_POST['substancia']}' AND
bomba = '".normalizar_valor($_POST['bomba'])."' AND
relatorio= '".normalizar_valor($_POST['relatorio'])."' AND
diaria_prof = '".normalizar_valor($_POST['dia_prof'])."' AND
custo_lab = '".normalizar_valor($_POST['custo_lab'])."' AND
sedex = '".normalizar_valor($_POST['sedex'])."' AND
cassete = '".normalizar_valor($_POST['cassete'])."' AND
ciclone = '".normalizar_valor($_POST['ciclone'])."'
";
$result = pg_query($sql);

if(pg_num_rows($result) <=0){

   $sql = "INSERT INTO site_avaliacao_ambiental (substancia, bomba, relatorio, diaria_prof,
   custo_lab, sedex, cassete, ciclone, certificado, aac)
   VALUES
   ('".addslashes($_POST['substancia'])."','".normalizar_valor($_POST['bomba'])."',
   '".normalizar_valor($_POST['relatorio'])."',
   '".normalizar_valor($_POST['dia_prof'])."',
   '".normalizar_valor($_POST['custo_lab'])."',
   '".normalizar_valor($_POST['sedex'])."',
   '".normalizar_valor($_POST['cassete'])."',
   '".normalizar_valor($_POST['ciclone'])."',
   '".normalizar_valor($_POST['certificado'])."',
   '".normalizar_valor($_POST['aac'])."'
   )";
   if(pg_query($sql)){
      echo "<script>alert('Substância adicionada!');</script>";
   }else{
      echo "<script>alert('Erro ao aidicionar Substância!');</script>";
   }
}else{
   //fail
   echo "<script>alert('Substância já existente!');</script>";
}

}
}//empty
?>
         <form method=post>
         <table width=100% border=0 align=center>
         <tr>
            <td width=200 align=left class="fontebranca12"><b>Substância</b></td>
            <td align=left class="fontebranca12">
            <input type=text name=substancia value="<?PHP echo $_POST['substancia'];?>" size=25>
            </td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Bomba</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=bomba value="<?PHP echo $_POST['bomba'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Relatório</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=relatorio value="<?PHP echo $_POST['relatorio'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Diária Profissional</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=dia_prof value="<?PHP echo $_POST['dia_prof'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Custo Laboratório</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=custo_lab value="<?PHP echo $_POST['custo_lab'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Sedex</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=sedex value="<?PHP echo $_POST['sedex'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Cassete</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=cassete value="<?PHP echo $_POST['cassete'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Ciclone</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=ciclone value="<?PHP echo $_POST['ciclone'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Certificado</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=certificado value="<?PHP echo $_POST['certificado'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Amostra Analizada Condicionada</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=aac value="<?PHP echo $_POST['aac'];?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         </table>
         <br>
         <center>
            <input type=submit value="Cadastrar">
         </center>
         </form>
<?PHP
}

/***********************************************************************************************/
// EDITAR ITEM - SUBSTÂNCIAS
/***********************************************************************************************/
if($_GET[act] == "edit"){
if($_POST){
   $sql = "UPDATE site_avaliacao_ambiental
   SET
   substancia = '".addslashes($_POST['substancia'])."',
   bomba = '".normalizar_valor($_POST['bomba'])."',
   relatorio = '".normalizar_valor($_POST['relatorio'])."',
   diaria_prof = '".normalizar_valor($_POST['dia_prof'])."',
   custo_lab = '".normalizar_valor($_POST['custo_lab'])."',
   sedex = '".normalizar_valor($_POST['sedex'])."',
   cassete = '".normalizar_valor($_POST['cassete'])."',
   ciclone = '".normalizar_valor($_POST['ciclone'])."',
   certificado = '".normalizar_valor($_POST['certificado'])."',
   aac = '".normalizar_valor($_POST['aac'])."'
   WHERE id = '{$_GET['cod']}'";
   if(pg_query($sql)){
      echo "<script>alert('Substância alterada!');</script>";
   }else{
      echo "<script>alert('Erro ao alterar Substância!');</script>";
   }
}
$sql = "SELECT * FROM site_avaliacao_ambiental WHERE id='{$_GET['cod']}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);


?>
         <form method=post>
         <table width=100% border=0 align=center>
         <tr>
            <td width=200 align=left class="fontebranca12"><b>Substância</b></td>
            <td align=left class="fontebranca12">
            <input type=text name=substancia value="<?PHP echo $data['substancia'];?>" size=25>
            </td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Bomba</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=bomba value="<?PHP echo number_format($data['bomba'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Relatório</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=relatorio value="<?PHP echo number_format($data['relatorio'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Diária Profissional</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=dia_prof value="<?PHP echo number_format($data['diaria_prof'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Custo Laboratório</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=custo_lab value="<?PHP echo number_format($data['custo_lab'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Sedex</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=sedex value="<?PHP echo number_format($data['sedex'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Cassete</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=cassete value="<?PHP echo number_format($data['cassete'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Ciclone</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=ciclone value="<?PHP echo number_format($data['ciclone'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Certificado</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=certificado value="<?PHP echo number_format($data['certificado'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         <tr>
            <td align=left class="fontebranca12"><b>Amostra Analizada Condicionada</b></td>
            <td align=left class="fontebranca12">R$ <input type=text name=aac value="<?PHP echo number_format($data['aac'], 2, ',','.');?>" size=10 onkeypress="return FormataReais(this, '.', ',', event);"></td>
         </tr>
         </table>
         <br>
         <center>
            <input type=submit value="Salvar">
            <input type=button value="Excluir" onclick="if(confirm('Tem certeza que deseja excluir esta substância?')){location.href='sim_avaliacao_ambiental.php?del=do&cod=<?PHP echo $_GET['cod'];?>';}">
         </center>
         </form>
<?PHP
}
?>
	 </td>
    </tr>
<?PHP
if(!$_GET){
?>
  <tr>
    <th colspan="12" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Substâncias Cadastradas</h3>
    </th>
  </tr>
  <tr>

    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Nº</strong></div></td>

    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Substância
	</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Bomba</strong></div></td>
    <!--
    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Relatório</strong></div></td>
    -->
    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Prof.</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Lab.</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Sedex</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Cassete</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Ciclone</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Certificado</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>AAC</strong></div></td>


    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Total</strong></div></td>
    
    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Migrar</strong></div></td>


  </tr>
<?php

for($x=0;$x<pg_num_rows($result);$x++){
?>
  <tr>

    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo str_pad($x+1, 3, "0", ST_PAD_LEFT);?></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo $buffer[$x]['substancia'];?></a>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['bomba'], 2, ',','.');?></a>
	  </div>
	</td>
	 <!--
        <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php //echo $buffer[$x]['id']?>">
       &nbsp;<?php //echo number_format($buffer[$x]['relatorio'], 2, ',','.');?></a>
	  </div>
	</td>
	-->
	
	    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['diaria_prof'], 2, ',','.');?></a>
	  </div>
	</td>


        <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['custo_lab'], 2, ',','.');?></a>
	  </div>
	</td>


        <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['sedex'], 2, ',','.');?></a>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['cassete'], 2, ',','.');?></a>
	  </div>
	</td>

   <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['ciclone'], 2, ',','.');?></a>
	  </div>
	</td>


    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['certificado'], 2, ',','.');?></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['aac'], 2, ',','.');?></a>
	  </div>
	</td>


       <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php
       $total = $buffer[$x]['relatorio']+$buffer[$x]['bomba']+$buffer[$x]['diaria_prof']+
       $buffer[$x]['custo_lab']+$buffer[$x]['sedex']+$buffer[$x]['cassete']+
       $buffer[$x]['ciclone']+$buffer[$x]['certificado']+$buffer[$x]['aac'];
       
       echo "R$".number_format($total, 2, ',','.');

       ?></a>
	  </div>
	</td>
	
	<td class="linhatopodiresq">
	  <div align="center" class="linksistema" id="mig<?PHP echo $buffer[$x]['id'];?>">
	  <?PHP
	   if($buffer[$x]['migrado']==0){
	    //echo "<a href=\"javascript:migrar_aa({$buffer[$x]['id']});\">$buffer[$x]['migrado']</a>";
	    echo "<input type=button value='Migrar' onclick=\"if(confirm('Tem certeza que deseja migrar [{$buffer[$x][substancia]}] para o cadastro de produtos?')){migrar_aa({$buffer[$x]['id']});}\">";
       }else{
        echo "<font size=1><b>Migrado!</b></font>";
       }
       ?>
	  </div>
	</td>

	
  </tr>
<?php
  }
?>
<!--
    <tr>
    <th colspan="12" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Orçamentos Cadastrados</h3>
    </th>
  </tr>
  <tr>
     <td width="80" colspan=1 bgcolor="#009966" class="linhatopodiresq">
     <div align="center" class="fontebranca12"><strong>Cod. Cliente</strong></div></td>
     
     <td width="80" colspan=6 bgcolor="#009966" class="linhatopodiresq">
     <div align="center" class="fontebranca12"><strong>Razao Social</strong></div></td>
     
     <td colspan=1 bgcolor="#009966" class="linhatopodiresq">
     <div align="center" class="fontebranca12"><strong>Nº Orç.</strong></div></td>
     
     <td width="80" colspan=2 bgcolor="#009966" class="linhatopodiresq">
     <div align="center" class="fontebranca12"><strong>Data Criação</strong></div></td>
     
     <td width="100" colspan=2 bgcolor="#009966" class="linhatopodiresq">
     <div align="center" class="fontebranca12"><strong>Valor</strong></div></td>
  </tr>
-->
<?PHP
/*
$sql = "SELECT i.*, c.razao_social FROM site_orc_aa_info i, cliente c
WHERE
i.cod_cliente = c.cliente_id";

$result = pg_query($sql);
$lista = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
   $sql = "SELECT * FROM site_orc_aa_produto WHERE cod_orcamento = '{$lista[$x]['cod_orcamento']}'";
   $r = pg_query($sql);
   $pdata = pg_fetch_all($r);
   $total = 0;
   for($i=0;$i<pg_num_rows($r);$i++){
      $sub = $pdata[$i]['cod_substancia'];
      
      $sql = "SELECT * FROM site_avaliacao_ambiental WHERE id = $sub";
      $rs = pg_query($sql);
      $a = pg_fetch_array($rs);
      
      $total += ($a[bomba]*$pdata[$i][qnt_bomba])+($a[diaria_prof]*$pdata[$i][qnt_profissional])+
      ($a[relatorio])+($a[custo_lab])+($a[sedex])+($a[cassete])+($a[ciclone])+
      ($a[certificado])+($a[aac]);
      $total *= $pdata[$i][quantidade];
   }
   echo "<tr>";
   echo "<td class='fontebranca12 linksistema' align=center><a href='?act=editorcamento&cod_cliente={$lista[$x]['cod_cliente']}&cod_filial={$lista[$x]['cod_filial']}&orcamento={$lista[$x]['cod_orcamento']}'>{$lista[$x]['cod_cliente']}</a></td>";
   echo "<td colspan=6 class='fontebranca12 linksistema' align=left><a href='?act=editorcamento&cod_cliente={$lista[$x]['cod_cliente']}&cod_filial={$lista[$x]['cod_filial']}&orcamento={$lista[$x]['cod_orcamento']}'>{$lista[$x]['razao_social']}</a></td>";
   echo "<td class='fontebranca12 linksistema' align=center><a href='?act=editorcamento&cod_cliente={$lista[$x]['cod_cliente']}&cod_filial={$lista[$x]['cod_filial']}&orcamento={$lista[$x]['cod_orcamento']}'>{$lista[$x]['cod_orcamento']}</a></td>";
   echo "<td colspan=2 class='fontebranca12 linksistema' align=center><a href='?act=editorcamento&cod_cliente={$lista[$x]['cod_cliente']}&cod_filial={$lista[$x]['cod_filial']}&orcamento={$lista[$x]['cod_orcamento']}'>".date("d/m/Y", strtotime($lista[$x]['data_criacao']))."</a></td>";
   echo "<td colspan=2 class='fontebranca12 linksistema' align=center><a href='?act=editorcamento&cod_cliente={$lista[$x]['cod_cliente']}&cod_filial={$lista[$x]['cod_filial']}&orcamento={$lista[$x]['cod_orcamento']}'>R$ ".number_format($total, 2, ',','.')."</a></td>";
   echo "</tr>";
}
*/
}//END - IF NOT GET
?>
  <tr>
    <td bgcolor="#009966" colspan=12 class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
