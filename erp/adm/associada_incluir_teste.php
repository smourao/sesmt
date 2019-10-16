<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

if($nome!=""){
$query_incluir="INSERT into unidade (cod_unidade, nome_unidade, responsavel_unidade, tel_unidade, fax_unidade, endereco_unidade, 							 				bairro_unidade, cod_cidade, cod_estado, cep_unidade, cod_status) 
			values 
				($cod_unidade, '$nome_unidade', '$responsavel_unidade', '$tel_unidade', '$fax_unidade', '$endereco_unidade', 		 				'$bairro_unidade', $cod_cidade, $cod_estado, $cep_unidade, $cod_status)";
				
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Associada Incluído com Sucesso!');</script>";
header("location: associada_adm_teste.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Sistema SESMT - Cadastro de Associada</title><body bgcolor="#006633">
<form action="associada_incluir_teste.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Associada SESMT </font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
	  	<?
			$query_max = "SELECT max(cod_unidade) as cod_unidade FROM unidade";
		
			$result_max = pg_query($query_max) 
				or die ("Erro na busca da tabela unidade. ==> " . pg_last_error($connect)); 
		
			$row_max = pg_fetch_array($result_max); 
		?>
		  <tr>
		  	<td width="97" class="fontebranca12">Código</td>
			<td width="303"><input name="cod_unidade" type="text" id="cod_unidade" size="5" value="<?=($row_max[cod_unidade] + 1)?>" readonly="true"></td>
		  </tr>
          <tr>
            <td width="97" class="fontebranca12">Nome </td>
            <td width="303"><input name="nome" type="text" id="nome" size="40"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Respons&aacute;vel</td>
            <td><input name="responsavel" type="text" id="responsavel" size="15"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">telefone</td>
            <td width="303"><input name="telefone" type="text" id="telefone" size="15"></td>
          </tr>
          <tr>
            <td class="fontebranca12">FAX</td>
            <td><input name="fax" type="text" id="fax" size="15"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">Endere&ccedil;o</td>
            <td width="303"><input name="endereco" type="text" id="endereco" size="15"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Bairro</td>
            <td><input name="bairro" type="text" id="bairro" size="30"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">Cidade</td>
            <td width="303"><input name="cidade" type="text" id="cidade" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Estado</td>
            <td class="fontebranca10"><span >
        <select name="estado" class="camposform" id="Estado">
          <option value="AL" <?php if($row[estado]=='AL'){echo "selected";}?>>Alagoas</option>
          <option value="AC" <?php if($row[estado]=='AC'){echo "selected";}?>>Acre</option>
          <option value="AP" <?php if($row[estado]=='AP'){echo "selected";}?>>Amapa</option>
          <option value="AM" <?php if($row[estado]=='AM'){echo "selected";}?>>Amazonas</option>
          <option value="BA" <?php if($row[estado]=='BA'){echo "selected";}?>>Bahia</option>
          <option value="CE" <?php if($row[estado]=='CE'){echo "selected";}?>>Cear&aacute;</option>
          <option value="DF" <?php if($row[estado]=='DF'){echo "selected";}?>>Distrito Federal</option>
          <option value="ES" <?php if($row[estado]=='ES'){echo "selected";}?>>Esp&iacute;rito Santo</option>
          <option value="GO" <?php if($row[estado]=='GO'){echo "selected";}?>>Goi&aacute;s</option>
          <option value="MA" <?php if($row[estado]=='MA'){echo "selected";}?>>Maranh&atilde;o</option>
          <option value="MT" <?php if($row[estado]=='MT'){echo "selected";}?>>Mato Grosso</option>
          <option value="MS" <?php if($row[estado]=='MS'){echo "selected";}?>>Mato Grosso do Sul</option>
          <option value="MG" <?php if($row[estado]=='MG'){echo "selected";}?>>Minas Gerais</option>
          <option value="PA" <?php if($row[estado]=='PA'){echo "selected";}?>>Par&aacute;</option>
          <option value="PB" <?php if($row[estado]=='PB'){echo "selected";}?>>Para&iacute;ba</option>
          <option value="PR" <?php if($row[estado]=='PR'){echo "selected";}?>>Paran&aacute;</option>
          <option value="PE" <?php if($row[estado]=='PE'){echo "selected";}?>>Pernambuco</option>
          <option value="PU" <?php if($row[estado]=='PU'){echo "selected";}?>>Piau&iacute;</option>
          <option value="RJ" <?php if($row[estado]=='RJ' ||$row[estado]==''){echo "selected";}?>>Rio de Janeiro</option>
          <option value="RS" <?php if($row[estado]=='RS'){echo "selected";}?>>Rio Grande do Sul</option>
          <option value="RN" <?php if($row[estado]=='RN'){echo "selected";}?>>Rio Grande do Norte</option>
          <option value="RO" <?php if($row[estado]=='RO'){echo "selected";}?>>Rond&ocirc;nia</option>
          <option value="RR" <?php if($row[estado]=='RR'){echo "selected";}?>>Roraima</option>
          <option value="SC" <?php if($row[estado]=='SC'){echo "selected";}?>>Santa Catrina</option>
          <option value="SP" <?php if($row[estado]=='SP'){echo "selected";}?>>S&atilde;o Paulo</option>
          <option value="SE" <?php if($row[estado]=='SE'){echo "selected";}?>>Sergipe</option>
        </select>
      </span></td>
          </tr>
          <tr>
            <td class="fontebranca12">CEP</td>
            <td><input name="cep" type="text" id="cep" size="12"></td>
          </tr>
		  <tr>
            <td class="fontebranca12">Status</td>
            <td><select name="status" id="status">
        		<option value="ativo" <?php if($row[status]=="ativo"){echo "selected";} ?>>ativo</option>
        		<option value="inativo" <?php if($row[status]=="inativo"){echo "selected";} ?>>inativo</option>
      			</select>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<td colspan="4" class="fontebranca12">
			<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
            <td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','associada_adm_teste.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
          </tr>
		  </table></td>
      </table></td>
    </tr>
  </table>
</form>

<html>

