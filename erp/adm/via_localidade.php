<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";



if($_GET['del']){
$sql = "DELETE FROM viabilidade_localidade WHERE id = ".$_GET['del'];
if(pg_query($connect, $sql)){
    echo "<script>alert('Localidade excluída!')</script>";
}else{
    echo "<script>alert('Erro ao excluir localidade!')</script>";
}

}




$query="select * from cidade";
$sql = "SELECT * FROM viabilidade_localidade";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);




?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Viabilidade de Localidades</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>

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
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold">
    <font color="#000000">Viabilidade de Localidades</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" align=center>
<?PHP
if($act!="add"){
?>
        <input name="btn_incluir" type="button" id="btn_incluir" value="Incluir" onClick="javascript:location.href='via_localidade.php?act=add'">
       <!-- <td class="fontebranca12"><input name="btn_excluir" type="submit" id="btn_excluir" value="Excluir" onClick="enviar('E')"></td>-->
        <input name="btn_voltar" type="button" id="btn_voltar" onClick="javascript:location.href='index.php'" value="&lt;&lt; Voltar">

<?PHP
}else{
?>
        <input name="btn_listar" type="button" id="btn_listar" value="Voltar" onClick="javascript:location.href='via_localidade.php'">
<?PHP
}
?>
 </td>
      </tr>
    </table>
      </td>
  </tr>
</table>   <p>

<?PHP
if($act!="add"){
?>

<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="121" class="linhatopodiresq"><div align="center" class="fontebranca12">Bairro</div></td>
    <td width="181" class="linhatopodir"><div align="center" class="fontebranca12">Rua</div></td>
    <td width="127" class="linhatopodir"><div align="center" class="fontebranca12">Cidade/Estado</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12">CEP</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12">Lado</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12">Excluir</div></td>
  </tr>
<?PHP
for($x=0;$x<pg_num_rows($res);$x++){
    echo "<tr>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['bairro']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['rua']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['cidade']}/{$buffer[$x]['estado']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['cep']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"  align=center><div class=\"fontebranca10\" align=center>";
        print $buffer[$x]['lado']== 0 ? "A" : "B";
    echo"</div></td>";
    echo "<td class=\"linhatopodiresqbase\" align=center>
    <div class=\"fontebranca10\">
    <a href='via_localidade.php?del={$buffer[$x]['id']}' onClick=\"javascript:return confirm('Tem certeza que deseja excluir esta localização?');\" class=excluir>X</a>
    </div></td>";
    echo "</tr>";
}
?>

  
  <?php
}else{//ACT = ADD
echo "
<form action=\"via_localidade.php?act=add\" method=\"post\">
<table width=500 border=1 align=center cellpadding=5 cellspacing=0>
<tr>
    <!--<td class=linhatopodir><div align=center class=fontebranca12>CEP</div></td>-->
    <td class=linhatopodir><div align=center class=fontebranca12>Bairro</div></td>
    <td class=linhatopodir><div align=center class=fontebranca12>Rua</div></td>
    <td class=linhatopodir><div align=center class=fontebranca12>Cidade</div></td>
    <td class=linhatopodir><div align=center class=fontebranca12>Estado</div></td>
    <td class=linhatopodir><div align=center class=fontebranca12>Lado</div></td>
</tr>";
echo "<tr>";
//    echo "<td><input type=text name=cep id=cep maxlength=9 size=9 onChange=\"showDataCliente();\" onkeypress=\"return MM_formtCep(event,this,'#####-###');\"></td>";
    echo "<td><input type=text name=bairro id=bairro size=15></td>";
    echo "<td><input type=text name=endereco id=endereco size=20></td>";
    echo "<td><input type=text name=municipio id=municipio size=10></td>";
    echo "<td><input type=text name=estado id=estado size=10></td>";
    echo "<td><select name=lado id=lado>
    <option value='0'>Lado A</option>
    <option value='1'>Lado B</option>
    </select></td>";
echo "</tr>";
echo "</table>";

if($_POST){
/*$sql = "SELECT * FROM viabilidade_localidade WHERE
 cep = '{$_POST['cep']}'";
$res = pg_query($connect, $sql);

if(pg_num_rows($res)>0){
    echo "<script>alert('CEP já cadastrado!')</script>";
}else{*/
$sql = "INSERT INTO viabilidade_localidade (bairro, rua, cep, status, cidade, estado, lado)
VALUES
('".addslashes($_POST['bairro'])."','".addslashes($_POST['endereco'])."','00000-000',0,'".addslashes($_POST['municipio'])."','".addslashes($_POST['estado'])."','{$_POST['lado']}')";

if(pg_query($connect, $sql)){
    echo "<script>alert('Localidade Cadastrada!')</script>";
}else{
    echo "<script>alert('Erro ao Cadastrar Localidade!')</script>";
//}
}
//print_r($_POST);
}
echo "<center><input name=\"btn_add\" type=\"submit\" id=\"btn_add\" value=\"Adicionar\">";

}
  ?>



</table>
</form>
</body>
</html>
