<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
if($nome_atividade!=""){
$query_incluir="INSERT into classificacao_atividade (nome_atividade, descricao_atividade)
				values ('$nome_atividade', '$descricao_atividade')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('classificação de Atividade Incluído com Sucesso!');</script>";
header("location: classificacao_atividade_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>
<title>Cadastro de Atividade</title><body bgcolor="#006633">
<form name="form1" method="post" action="classificacao_atividade_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Classifica&ccedil;&atilde;o da Atividade</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="194" class="fontebranca12">Classifica&ccedil;&atilde;o da atividade</td>
            <td width="305"><input name="nome_atividade" type="text" id="nome_atividade" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao_atividade" cols="40" rows="5" class="camposform" id="descricao_atividade"></textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir"></td>
		  </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

