<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Riscos::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" tracingsrc="img/Sistema sesmt riscos.png" tracingopacity="0">
<form id="form1" name="form1" method="post" action="">
  <table width="698" border="0" align="center" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td height="32" colspan="12" valign="top" class="fontebranca10"><div align="center"></div></td>
    </tr>
    <tr>
      <td height="25" colspan="12" valign="top" class="fontebranca10"><div align="center" class="fontebranca22bold">CADASTRO DOS RISCOS </div></td>
    </tr>
    <tr>
      <td height="17" colspan="3" valign="top" class="fontebranca10">COD CLIENTE </td>
      <td valign="top" class="fontebranca10">COD FILIAL </td>
      <td colspan="5" valign="top" class="fontebranca10">NOME DO COLABORADOR </td>
      <td colspan="2" valign="top" class="fontebranca10">DATA DO &Uacute;LTIMO EXAME </td>
      <td width="169" valign="top" class="fontebranca10">HORA DA ENTRADA </td>
    </tr>
    <tr>
      <td height="30" colspan="3" valign="top" class="fontebranca10"><input name="cliente_id" type="text" id="cliente_id" size="10" /></td>
      <td valign="top" class="fontebranca10"><input name="filial_id" type="text" id="filial_id" size="10" /></td>
      <td colspan="5" valign="top" class="fontebranca10"><input name="funcionario" type="text" id="funcionario" size="25" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><input name="data_ultimo_exame" type="text" id="data_ultimo_exame" size="10" /></td>
      <td valign="top" class="fontebranca10"><input name="hora_da_entrada" type="text" id="hora_da_entrada" size="10" /></td>
    </tr>
    <tr>
      <td height="18" colspan="3" valign="top" class="fontebranca10">CTPS</td>
      <td valign="top" class="fontebranca10">SERIE</td>
      <td colspan="3" valign="top" class="fontebranca10">IDENTIDADE</td>
      <td colspan="2" valign="top" class="fontebranca10">ORGAO EXPED.</td>
      <td width="89" valign="top" class="fontebranca10">CPF</td>
      <td valign="top" class="fontebranca10">PIS</td>
      <td valign="top" class="fontebranca10">DATA ADMISS&Atilde;O </td>
    </tr>
    <tr>
      <td height="25" colspan="3" valign="top" class="fontebranca10"><input name="ctps" type="text" id="ctps" size="10" /></td>
      <td valign="top" class="fontebranca10"><input name="serie" type="text" id="serie" size="10" /></td>
      <td colspan="3" valign="top" class="fontebranca10"><input name="identidade" type="text" id="identidade" size="8" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><input name="orgao_expedidor" type="text" id="orgao_expedidor" size="5" /></td>
      <td valign="top" class="fontebranca10"><input name="cpf" type="text" id="cpf" size="10" /></td>
      <td valign="top" class="fontebranca10"><input name="pis" type="text" id="pis" size="8" /></td>
      <td valign="top" class="fontebranca10"><input name="data_admissao" type="text" id="data_admissao" size="10" /></td>
    </tr>
    <tr>
      <td height="19" colspan="3" valign="top" class="fontebranca10">HORA SA&Iacute;DA </td>
      <td colspan="2" valign="top" class="fontebranca10">TEMPO DO LANCHE </td>
      <td colspan="3" valign="top" class="fontebranca10">HORA DO ALMO&Ccedil;O </td>
      <td colspan="2" valign="top" class="fontebranca10">RETORNO DO ALMO&Ccedil;O </td>
      <td valign="top" class="fontebranca10">FUN&Ccedil;&Atilde;O </td>
      <td valign="top" class="fontebranca10">CLASSIFICA&Ccedil;&Atilde;O DA ATIVIDADE </td>
    </tr>
    <tr>
      <td height="27" colspan="3" valign="top" class="fontebranca10"><input name="hora_saida" type="text" id="hora_saida" size="10" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><input name="tempo_lanche" type="text" id="tempo_lanche" size="10" /></td>
      <td colspan="3" valign="top" class="fontebranca10"><input name="hora_almoco" type="text" id="hora_almoco" size="10" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><input name="retorno_almoco" type="text" id="retorno_almoco" size="10" /></td>
      <td valign="top" class="fontebranca10"><input name="funcao" type="text" id="funcao" size="8" /></td>
      <td valign="top" class="fontebranca10">&nbsp;
        <select name="select" class="camposform" id="select">
          <option selected="selected">Exemplo</option>
        </select>
      </td>
    </tr>
    <tr>
      <td height="15" colspan="10" valign="top" class="fontebranca10">DIN&Atilde;MICA DA FUN&Ccedil;&Atilde;O </td>
      <td colspan="2" valign="top" class="fontebranca10">RISCO DA FUN&Ccedil;&Atilde;O </td>
    </tr>
    <tr>
      <td height="29" colspan="10" valign="top" class="fontebranca10"><input name="dinamica_funcao" type="text" id="dinamica_funcao" size="50" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><input name="risco_funcao" type="text" id="risco_funcao" size="20" /></td>
    </tr>
    <tr>
      <td height="19" colspan="2" valign="top" class="fontebranca10">COD RISCO </td>
      <td colspan="4" valign="top" class="fontebranca10">CONTATO COM AGENTE </td>
      <td colspan="4" valign="top" class="fontebranca10">MEDIDAS PREVENTIVAS EPI'S </td>
      <td colspan="2" valign="top" class="fontebranca10"><!--DWLayoutEmptyCell-->&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="25" class="fontebranca10">&nbsp;</td>
      <td width="89" class="fontebranca10"><input name="cod_risco" type="text" id="cod_risco" size="5" /></td>
      <td colspan="4" valign="top" class="fontebranca10"><select name="contato_agente" class="camposform" id="contato_agente"><option selected="selected">Exemplo</option>
      </select></td>
      <td colspan="4" valign="top" class="fontebranca10"><input name="hora_saida4" type="text" id="hora_saida4" size="30" /></td>
      <td colspan="2" valign="top" class="fontebranca10"><!--DWLayoutEmptyCell-->&nbsp;</td>
    </tr>
    <tr>
      <td height="19" class="fontebranca10">&nbsp;</td>
      <td class="fontebranca10">&nbsp;</td>
      <td width="1" class="fontebranca10"></td>
      <td width="103" class="fontebranca10"></td>
      <td width="1" class="fontebranca10"></td>
      <td width="29" class="fontebranca10"></td>
      <td width="43" class="fontebranca10">&nbsp;</td>
      <td width="34" class="fontebranca10">&nbsp;</td>
      <td width="61" class="fontebranca10">&nbsp;</td>
      <td class="fontebranca10">&nbsp;</td>
      <td width="75" class="fontebranca10"></td>
      <td class="fontebranca10"></td>
    </tr>
    <tr>
      <td height="19" class="fontebranca10">&nbsp;</td>
      <td colspan="8" valign="top" class="fontebranca10">POSS&Iacute;VEIS DANOS &Agrave; SA&Uacute;DE DO COLABORADOR </td>
      <td class="fontebranca10">&nbsp;</td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
    </tr>
    
    
    
    
    <tr>
      <td height="18" class="fontebranca10"></td>
      <td valign="top" class="fontebranca10">COD</td>
      <td colspan="7" valign="top" class="fontebranca10">DESCRI&Ccedil;&Atilde;O M&Eacute;DICA </td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10"></td>
      <td valign="top" class="fontebranca10"><input name="cod_dano_saude" type="text" id="cod_dano_saude" size="8" /></td>
      <td colspan="7" valign="top" class="fontebranca10"><input name="descricao_medica" type="text" id="descricao_medica" size="20" /></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
    </tr>
    <tr>
      <td height="9" class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
      <td class="fontebranca10"></td>
    </tr>
    <tr>
      <td height="58" class="fontebranca10"></td>
      <td colspan="11" valign="middle" class="fontebranca10"><table width="519" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" height="12">&nbsp;</td>
          <td width="25">&nbsp;</td>
          <td width="26">&nbsp;</td>
          <td width="24">&nbsp;</td>
          <td width="25">&nbsp;</td>
          <td width="25" rowspan="2"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" alt="" /></td>
          <td width="25">&nbsp;</td>
          <td width="25">&nbsp;</td>
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
    </tr>
  </table>
</form>
</body>
</html>
