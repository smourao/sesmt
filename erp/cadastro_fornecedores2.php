<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

if($valor=="gravar"){

	if($cod_fatura!=''){

		$query_fatura_cod="select fatura_id from faturass where fatura_id=$cod_fatura";
		$result_fatura_cod=pg_query($query_fatura_cod) or die ("Erro na query $query_fatura_cod".pg_last_error($connect));
		$row_fatura_cod=pg_fetch_array($result_fatura_cod);
		echo "<script>alert('".$valor."');</script>";
		$teste_fatura_cod=pg_num_rows($result_fatura_cod);
		
	}else{
		$teste_fatura_cod='erro';
	}
	if ($teste_fatura_cod < 1 || $teste_fatura_cod=="erro") {
	
		$query_fatura="insert into faturas
		(razao_social, nome_fantasia, cnpj, insc_estadual, insc_municipal, nome_responsavel, endereco, bairro, cidade, estado, cep, msn, skype, email, ddd1, telefone1, ddd2, telefone2, ddd_fax, fax, ddd_cel, celular, id_nextel, segmento ) values
		('$razao_social', '$nome_fantasia', '$cnpj', '$insc_estadual', '$insc_municipal', '$nome_responsavel', '$endereco', '$bairro', '$cidade', '$estado', '$cep', '$msn', '$skype', '$email','$ddd1', '$telefone1', '$ddd2', '$telefone2', '$ddd_fax', '$fax', '$ddd_cel', '$celular', '$id_nextel', '$segmento')";
		$result_fatura=pg_query($query_fatura)or die("Erro na query: $query_faura".pg_last_error($connect));
	
		echo '<script> alert("Fatura Cadastrada com Sucesso!");</script>';
		
		$query_fatura_cod="select fatura_id from faturas where razao_social='$razao_social' and nome_fantasia='$nome_fantasia'";
		$result_fatura_cod=pg_query($query_fatura_cod) or die ("Erro na query $query_fatura_cod".pg_last_error($connect));
		$row_fatura_cod=pg_fetch_array($result_fatura_cod);
		
		$cod_fatura=$row_fatura_cod['fatura_id'];
		
		
		
	
	}else {
		
		$query_fatura = "update faturas SET 
		razao_social='$razao_social', nome_fantasia='$nome_fantasia', cnpj='$cnpj', insc_estadual='$insc_estadual', insc_municipal='$insc_municipal', nome_responsavel='$nome_responsavel', endereco='$endereco', bairro='$bairro', cidade='$cidade', estado='$estado', cep='$cep', msn='$msn', skype='$skype', email='$email', ddd1='$ddd1', telefone1='$telefone1', ddd2='$ddd2', telefone2='$telefone2', ddd_fax='$ddd_fax', fax='$fax', ddd_cel='$ddd_cel', celular='$celular', id_nextel='$id_nextel', segmento='$segmento' where fatura_id=".$cod_fatura."";
		$result_fatura=pg_query($query_fatura)or die("Erro na query: $query_fatura".pg_last_error($connect));
		
		echo '<script> alert("fatura alterada com Sucesso!");</script>';
	}
	
	
}

if($valor=="apagar"){
	
	$query_fatura_cod="select fatura_id from faturas where fatura_id=".$cod_fatura."";
	$result_fatura_cod =pg_query($query_fatura_cod) or die ("Erro na query $query_fatura_cod".pg_last_error($connect));
	$row_fatura_cod=pg_fetch_array($result_fatura_cod);
	if ($teste_fatura_cod=pg_num_rows($result_fatura_cod) < 1) {
	
		$query_fatura_del="delete from faturas where fatura_id=".$cod_fatura."";
		pg_query($query_fatura_del)or die("Erro na query: $query_fatura_del".pg_last_error($connect));
	
		}
}

if($valor=="gravar" || $cod_fatura!=""){

		$query="select * from faturas where fatura_id=".$cod_fatura."";
		$result=pg_query($query) or die ("Erro na query $query".pg_last_error($connect));
		$row=pg_fetch_array($result);
		$cod_fatura=$row['fatura_id'];
		
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema SESMT - Cadastro de Fornecedores</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td img {display: block;}
</style>
<script>
var botoes;
function valore(botoes){
	document.cadastro.valor.value=botoes;
	}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#006633" >
<form id="cadastro" name="cadastro" method="post" action="cadastro_fornecedores2.php">
  <table width="528" border="0" align="center" cellpadding="0" cellspacing="0">
    <!-- fwtable fwsrc="Sistema_cadastro_vendedores.png" fwbase="Sistema_cadastro_vendedores.png" fwstyle="Dreamweaver" fwdocid = "424450477" fwnested="0" -->
    <tr>
      <td width="18"><img src="img/spacer.gif" width="18" height="1" border="0" alt="" /></td>
      <td width="60"><img src="img/spacer.gif" width="56" height="1" border="0" alt="" /></td>
      <td width="67"><img src="img/spacer.gif" width="63" height="1" border="0" alt="" /></td>
      <td width="23"><img src="img/spacer.gif" width="22" height="1" border="0" alt="" /></td>
      <td width="17"><img src="img/spacer.gif" width="16" height="1" border="0" alt="" /></td>
      <td width="30"><img src="img/spacer.gif" width="28" height="1" border="0" alt="" /></td>
      <td width="62"><img src="img/spacer.gif" width="58" height="1" border="0" alt="" /></td>
      <td width="10"><img src="img/spacer.gif" width="9" height="1" border="0" alt="" /></td>
      <td width="68"><img src="img/spacer.gif" width="64" height="1" border="0" alt="" /></td>
      <td width="43"><img src="img/spacer.gif" width="43" height="1" border="0" alt="" /></td>
      <td width="153"><img src="img/spacer.gif" width="151" height="1" border="0" alt="" /></td>
      <td width="1"><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="11" class="fontebranca10"><div align="center" class="fontebranca22bold">fatura</div></td>
      <td><img src="img/spacer.gif" width="1" height="44" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="11" rowspan="12" class="fontebranca10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
          <td colspan="2">Segmento <br />
              <input name="segmento" type="text" id="razao_social" value="<?=$row['segmento']?>" size="40" /></td>
          </tr>
	    <tr>
          <td>Raz&atilde;o Social <br />
              <input name="razao_social" type="text" id="razao_social" value="<?=$row['razao_social']?>" size="40" /></td>
          <td>Nome Fantasia
            <input name="nome_fantasia" type="text" id="nome_fantasia" value="<?=$row['nome_fantasia']?>" size="40" /></td>
        </tr>
        <tr>
          <td>cliente<br />
              <input name="cliente_id" type="text" id="cliente_id" value="<?=$row['cliente_id']?>" size="40" /></td>
          <td>Inscri&ccedil;&atilde;o Estadual <br />
              <input name="insc_estadual" type="text" id="insc_estadual" value="<?=$row['insc_estadual']?>" size="40" /></td>
        </tr>
        <tr>
          <td>Filial
            <input name="filial" type="text" id="filial" value="<?=$row['filial_id']?>" size="40" /></td>
          <td>Nome Respons&aacute;vel <br />
              <input name="nome_responsavel" type="text" id="nome_responsavel" value="<?=$row['nome_responsavel']?>" size="40" /></td>
        </tr>
        <tr>
          <td>Endere&ccedil;o<br />
              <input name="endereco" type="text" id="endereco" value="<?=$row['endereco']?>" size="40" /></td>
          <td>Bairro<br />
              <input name="bairro" type="text" id="bairro" value="<?=$row['bairro']?>" size="40" /></td>
        </tr>
        <tr>
          <td>Cidade<br />
              <input name="cidade" type="text" id="cidade" value="<?=$row['cidade']?>" size="40" /></td>
          <td>Estado<br />
            <span class="borda2">
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
          <td>CEP<br />
              <input name="cep" type="text" id="cep" value="<?=$row['cep']?>" size="40" /></td>
          <td>MSN<br />
              <input name="msn" type="text" id="msn" value="<?=$row['msn']?>" size="40" /></td>
        </tr>
        <tr>
          <td>Skype<br />
              <input name="skype" type="text" id="skype" value="<?=$row['skype']?>" size="40" /></td>
          <td>E-mail<br />
              <input name="email" type="text" id="email" value="<?=$row['email']?>" size="40" /></td>
        </tr>
        <tr>
          <td>DDD<br />
              <input name="ddd1" type="text" id="ddd1" value="<?=$row['ddd1']?>" size="40" /></td>
          <td>Telefone<br />
              <input name="telefone1" type="text" id="telefone1" value="<?=$row['telefone1']?>" size="40" /></td>
        </tr>
        <tr>
          <td>DDD<br />
              <input name="ddd2" type="text" id="ddd2" value="<?=$row['ddd2']?>" size="40" /></td>
          <td>Telefone<br />
              <input name="telefone2" type="text" id="telefone2" value="<?=$row['telefone2']?>" size="40" /></td>
        </tr>
        <tr>
          <td height="37">DDD - FAX<br />
              <input name="ddd_fax" type="text" id="ddd_fax" value="<?=$row['ddd_fax']?>" size="40" /></td>
          <td>FAX<br />
              <input name="fax" type="text" id="fax" value="<?=$row['fax']?>" size="40" /></td>
        </tr>
        <tr>
          <td>DDD - Celular <br />
              <input name="ddd_cel" type="text" id="ddd_cel" value="<?=$row['ddd_cel']?>" size="40" /></td>
          <td>Celular<br />
              <input name="celular" type="text" id="celular" value="<?=$row['celular']?>" size="40" /></td>
        </tr>
        <tr>
          <td>ID - Nextel <br />
              <input name="id_nextel" type="text" id="id_nextel" value="<?=$row['id_nextel']?>" size="40" /></td>
          <td><input name="valor" type="hidden" id="valor" />
            <input name="cod_fatura" type="hidden" id="cod_fatura" value="<?=$cod_fatura?>" /></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="32" border="0" alt="" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="25" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="13" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="30" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="17" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="27" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="17" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="25" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="14" border="0" alt="" /></td>
    </tr>
    <tr>
      <td height="42"><img src="img/spacer.gif" width="1" height="27" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">&nbsp;</td>
      <td colspan="9" rowspan="2" class="fontebranca10"><table width="382" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" height="12">&nbsp;</td>
          <td width="86">&nbsp;</td>
          <td width="84">&nbsp;</td>
          <td width="86">&nbsp;</td>
          <td width="40">&nbsp;</td>
          <td rowspan="2"><a href="listagem_fornecedores2.php"><img src="img/cadastro_cliente_verde_r21_c18.gif" alt="" name="cadastro_cliente_verde_r21_c18" width="41" height="58"  border="0" id="cadastro_cliente_verde_r21_c18" /></a></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="novo" type="image" id="novo" value="novo" src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0"  onclick="valore('novo');" hspace="1"/></td>
          <td><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onclick="valore('gravar');" hspace="1" /></td>
          <td><input type="image" name="apagar" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" onclick="valore('apagar');" /></td>
          <td>&nbsp;</td>
          </tr>
      </table></td>
      <td rowspan="2" class="fontebranca10">&nbsp;</td>
      <td><img src="img/spacer.gif" width="1" height="15" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">&nbsp;</td>
      <td><img src="img/spacer.gif" width="1" height="33" border="0" alt="" /></td>
    </tr>
  </table>
</form>
</body>
</html>
