<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($numero_empregados!=""){
$query_incluir="INSERT into cipa (grupo, numero_empregados, numero_membros_cipa, efetivo, suplente, numero_representante_empregador, maior) values ('$grupo_cipa', '$numero_empregados', '$numero_membros_cipa', '$efetivo', '$suplente', '2', '$maior')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('CIPA Incluído com Sucesso!');</script>";
//header("location: cnae_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<title>Cadastro de Cipeiros</title><body bgcolor="#006633">
<form name="form1" method="post" action="cipa_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Cipa</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="206" class="fontebranca12">Grupo</td>
            <td width="293"><select name="grupo_cipa" id="grupo_cipa">
			<?php
			$query_grupo="select grupo_cipa from cnae group by grupo_cipa";
			$result_grupo=pg_query($query_grupo)or die("Erro na consulta de grupo".pg_last_error($conect));
			while($row_grupo=pg_fetch_array($result_grupo)){
			?>
              <option value="<?=$row_grupo[grupo_cipa]?>"><?=$row_grupo[grupo_cipa]?></option>
     		<?php
			}
			?>
            </select></td>
          </tr>
		            <tr>
            <td width="206" class="fontebranca12">Numero de Empregados  </td>
            <td width="293"><input name="numero_empregados" type="text" id="numero_empregados" size="15"></td>
		            </tr>
		            <tr>
            <td width="206" class="fontebranca12">Numero de Efetivos </td>
            <td width="293"><input name="numero_membros_cipa" type="text" id="numero_membros_cipa" size="15"></td>
          </tr>
		           <tr>
            <td width="206" class="fontebranca12">Numero de Suplente</td>
            <td width="293"><input name="suplente" type="text" id="suplente" size="15"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Numero de Representantes do Empregador </td>
            <td class="fontebranca12"><b>2</b></td>
          </tr>
		        <tr>
            <td bgcolor="#009933" class="fontebranca12">Acima de 10.000 para cada grupo de 2.500 acrescentar</td>
            <td bgcolor="#009933" class="fontebranca12"><input name="maior" type="text" id="maior" size="15"></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir &amp; Repetir">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','cipa_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

