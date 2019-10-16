<?php
include "../sessao.php";
include "../config/connect.php";

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
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
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
</style>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="10" class="linhatopodiresq" bgcolor="#009966"><br>SIMULADOR DE AVALIAÇÃO AMBIENTAL<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="10">
			<br>&nbsp;
			<?PHP
            if($_GET){
               echo "<input name=\"btn_sair\" type=\"button\" id=\"btn_sair\" onClick=\"MM_goToURL('parent','./sim_avaliacao_ambiental.php'); return document.MM_returnValue\" value=\"Voltar\" style=\"width:100;\">";
            }else{
               echo "<input name=\"btn_sair\" type=\"button\" id=\"btn_sair\" onClick=\"MM_goToURL('parent','./index.php'); return document.MM_returnValue\" value=\"Sair\" style=\"width:100;\">";
            }
			?>
				<input name="btnNovo" type="button" id="btnNovo" onClick="location.href='sim_avaliacao_ambiental.php?new=do';" value="Novo" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="10" class="linhatopodiresq">
<?PHP

function normalizar_valor($valor){
  if(strlen(strstr($valor, ","))>0){
   $valor = str_replace(".", "", $valor);
   $valor = str_replace(",", ".", $valor);
   return $valor;//number_format($valor, 2, '', '.');
  }else{
   return $valor;// number_format($valor, 2, '', '.');
  }
}

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
   custo_lab, sedex, cassete, ciclone)
   VALUES
   ('".addslashes($_POST['substancia'])."','".normalizar_valor($_POST['bomba'])."',
   '".normalizar_valor($_POST['relatorio'])."',
   '".normalizar_valor($_POST['dia_prof'])."',
   '".normalizar_valor($_POST['custo_lab'])."',
   '".normalizar_valor($_POST['sedex'])."',
   '".normalizar_valor($_POST['cassete'])."',
   '".normalizar_valor($_POST['ciclone'])."')";
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
         </table>
         <br>
         <center>
            <input type=submit value="Cadastrar">
         </center>
         </form>
<?PHP
}


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
   ciclone = '".normalizar_valor($_POST['ciclone'])."'
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
    <th colspan="10" class="linhatopodiresq" bgcolor="#009966">
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

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Relatório</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Profissional</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Laboratório</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Sedex</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Cassete</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Ciclone</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Total</strong></div></td>


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
	
        <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="?act=edit&cod=<?php echo $buffer[$x]['id']?>">
       &nbsp;<?php echo number_format($buffer[$x]['relatorio'], 2, ',','.');?></a>
	  </div>
	</td>
	
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
       &nbsp;<?php
       $total = $buffer[$x]['relatorio']+$buffer[$x]['bomba']+$buffer[$x]['diaria_prof']+
       $buffer[$x]['custo_lab']+$buffer[$x]['sedex']+$buffer[$x]['cassete']+$buffer[$x]['ciclone'];
       
       echo "R$".number_format($total, 2, ',','.');

       ?></a>
	  </div>
	</td>





  </tr>
<?php
  }
  }
?>
  <tr>
    <td bgcolor="#009966" colspan=10 class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
