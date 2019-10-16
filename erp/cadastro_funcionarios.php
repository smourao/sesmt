<?php
include "sessao.php";
include ('./config/connect.php');
include ('./config/config.php');
include ('./config/funcoes.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Funcion&aacute;rios::</title>
<style type="text/css">



td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
</style>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="form1" name="form1" method="post" action="">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <!-- fwtable fwsrc="Sistema cadastro funcionario.png" fwbase="sistema_cadastro_funcionario.png" fwstyle="Dreamweaver" fwdocid = "1033621754" fwnested="0" -->
    <tr>
      <td><img src="img/spacer.gif" width="21" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="182" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="148" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="79" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="68" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="9" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="83" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="98" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="11" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="17">&nbsp;</td>
      <td colspan="7" class="fontebranca10"><div align="center" class="fontebranca22bold">Cadastro de Funcion&aacute;rios </div></td>
      <td rowspan="4" class="fontebranca10"><img name="sistema_cadastro_funcionario_r1_c9" src="img/sistema_cadastro_funcionario_r1_c9.jpg" width="98" height="100" border="0" id="sistema_cadastro_funcionario_r1_c9" alt="" /></td>
      <td rowspan="15" class="fontebranca10">&nbsp;</td>
      <td><img src="img/spacer.gif" width="1" height="42" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="6" class="fontebranca10"><img name="sistema_cadastro_funcionario_r2_c2" src="img/sistema_cadastro_funcionario_r2_c2.jpg" width="569" height="10" border="0" id="sistema_cadastro_funcionario_r2_c2" alt="" /></td>
      <td rowspan="3" valign="top" class="fontebranca10"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="10" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="4" class="fontebranca10"><img name="sistema_cadastro_funcionario_r3_c2" src="img/sistema_cadastro_funcionario_r3_c2.jpg" width="477" height="30" border="0" id="sistema_cadastro_funcionario_r3_c2" alt="" /></td>
      <td colspan="2" rowspan="2" class="fontebranca10"><table width="84" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="84"><div align="center">N&ordm; Registro </div></td>
          </tr>
          <tr>
            <td><div align="center">
              <input name="textfield2" type="text" size="8" />
            </div></td>
          </tr>
      </table></td>
      <td><img src="img/spacer.gif" width="1" height="30" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="3" class="fontebranca10">Colaborador</td>
      <td><img src="img/spacer.gif" width="1" height="18" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2" class="fontebranca10"><img src="img/spacer.gif" /></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td><img src="img/spacer.gif" width="1" height="8" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="8" class="fontebranca10"><input name="textfield" type="text" size="60" /></td>
      <td><img src="img/spacer.gif" width="1" height="27" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">CTPS</td>
      <td class="fontebranca10">S&eacute;rie</td>
      <td colspan="3" class="fontebranca10">CBO</td>
      <td colspan="3" class="fontebranca10">Estado Civil </td>
      <td><img src="img/spacer.gif" width="1" height="28" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="textfield22" type="text" size="10" /></td>
      <td class="fontebranca10"><input name="textfield23" type="text" size="8" /></td>
      <td colspan="3" class="fontebranca10"><input name="textfield24" type="text" size="10" /></td>
      <td colspan="3" class="fontebranca10"><input name="textfield25" type="text" size="15" /></td>
      <td><img src="img/spacer.gif" width="1" height="32" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">CPF</td>
      <td class="fontebranca10">Data &Uacute;ltimo Exame </td>
      <td colspan="3" class="fontebranca10">Data Adm </td>
      <td colspan="3" class="fontebranca10">PIS</td>
      <td><img src="img/spacer.gif" width="1" height="23" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="textfield26" type="text" size="15" /></td>
      <td class="fontebranca10"><input name="textfield27" type="text" size="15" /></td>
      <td colspan="3" class="fontebranca10"><input name="textfield28" type="text" size="15" /></td>
      <td colspan="3" class="fontebranca10"><input name="textfield29" type="text" size="15" /></td>
      <td><img src="img/spacer.gif" width="1" height="32" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">Fun&ccedil;&atilde;o</td>
      <td colspan="7" class="fontebranca10">Endere&ccedil;o</td>
      <td><img src="img/spacer.gif" width="1" height="23" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10"><?php
	  $tipo="funcao_func_cliente";
	  ?>
        <select name="select" class="camposform" id="select">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  ?>
        </select>
      </td>
      <td colspan="7" class="fontebranca10"><input name="textfield211" type="text" size="20" /></td>
      <td><img src="img/spacer.gif" width="1" height="32" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">Bairro</td>
      <td colspan="2" class="fontebranca10">Cep</td>
      <td colspan="5" class="fontebranca10">Telefone</td>
      <td><img src="img/spacer.gif" width="1" height="21" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="textfield212" type="text" size="8" /></td>
      <td colspan="2" class="fontebranca10"><input name="textfield213" type="text" size="8" /></td>
      <td colspan="5" class="fontebranca10"><input name="textfield214" type="text" size="8" /></td>
      <td><img src="img/spacer.gif" width="1" height="33" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="5" rowspan="2" class="fontebranca10"><table width="457" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" height="12">&nbsp;</td>
          <td width="86">&nbsp;</td>
          <td width="84">&nbsp;</td>
          <td width="86">&nbsp;</td>
          <td width="40">&nbsp;</td>
          <td width="66" rowspan="2"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" alt="" /></td>
          <td width="20">&nbsp;</td>
          <td width="35">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><img name="cadastro_cliente_verde_r22_c3" src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0" id="cadastro_cliente_verde_r22_c3" alt="" /></td>
          <td><img name="cadastro_cliente_verde_r22_c5" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" border="0" id="cadastro_cliente_verde_r22_c5" alt="" /></td>
          <td><img name="cadastro_cliente_verde_r22_c9" src="img/cadastro_cliente_verde_r22_c9.gif" width="53" height="38" border="0" id="cadastro_cliente_verde_r22_c9" alt="" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td colspan="4" class="fontebranca10">Ass. do Resp </td>
      <td><img src="img/spacer.gif" width="1" height="23" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="4" class="fontebranca10"><input name="textfield2112" type="text" size="20" /></td>
      <td><img src="img/spacer.gif" width="1" height="37" border="0" alt="" /></td>
    </tr>
  </table>
</form>
</body>
</html>
