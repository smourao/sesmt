<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "ltda", "av", "rj", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "ltda,", "av,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(ltda)", "(av)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "ltda.", "av.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>2){
        $at[$x] = ucwords($at[$x]);
    }
	$temp .= $at[$x]." ";
}
return $temp;
}


$sql = "
(SELECT DISTINCT TRIM(both ' ' from lower(to_ascii(cliente.bairro))) as bairro FROM cliente WHERE bairro <> '')
UNION
(SELECT DISTINCT TRIM(both ' ' from lower(to_ascii(cliente_comercial.bairro))) as bairro FROM cliente_comercial  WHERE bairro <> '')
";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Clientes por Localidade</title>
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
    <font color="#000000">Lista de Clientes por Localidade</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" align=center>
        <form method="POST">
        <?PHP
            echo "<select name=search>";
            for($x=0;$x<pg_num_rows($res);$x++){
               echo "<option value='{$buffer[$x]['bairro']}'"; print $buffer[$x]['bairro'] == $_POST['search'] ? "SELECTED" : ""; echo ">".convertwords($buffer[$x]['bairro'])."</option>";
            }
            echo "</select>";
        ?>
        <input name="btn_listar" type="submit" id="btn_listar" value="Pesquisar" onClick="">
        <p>
        <input name="voltar" type="button" id="voltar" value="Voltar" onClick="javascript:location.href='index.php'">
        </form>
 </td>
      </tr>
    </table>
      </td>
  </tr>
</table>   <p>

<?PHP
if($_POST){
$sql = "
(SELECT razao_social, telefone, email, endereco, num_end, estado FROM cliente WHERE TRIM(both ' ' from lower(to_ascii(bairro))) = '{$_POST['search']}' ORDER BY razao_social)
UNION
(SELECT razao_social, telefone, email, endereco, num_end, estado FROM cliente_comercial WHERE TRIM(both ' ' from lower(to_ascii(bairro))) = '{$_POST['search']}' ORDER BY razao_social)
";
$result = pg_query($sql);
$data = pg_fetch_all($result);




?>

<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="10" class="linhatopodiresq"><div align="center" class="fontebranca12">Nº</div></td>
    <td class="linhatopodiresq"><div align="center" class="fontebranca12">Razão Social</div></td>
    <td width="100" class="linhatopodir"><div align="center" class="fontebranca12">Telefone</div></td>
    <td width="127" class="linhatopodir"><div align="center" class="fontebranca12">E-mail</div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12">Endereço</div></td>
  </tr>
<?PHP
for($x=0;$x<pg_num_rows($result);$x++){
    echo "<tr>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">".($x+1)."</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$data[$x]['razao_social']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$data[$x]['telefone']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$data[$x]['email']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$data[$x]['endereco']} {$data[$x]['num_end']} - {$data[$x]['estado']}</div></td>";
    echo "</tr>";
}
?>


  <?php
}
  ?>



</table>
</form>
</body>
</html>

