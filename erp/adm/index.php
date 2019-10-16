<?php
include "../sessao.php";
include "../config/connect.php";

if (strtoupper($grupo)!="ADMINISTRADOR"){
	echo '<script>
		alert("Você não tem permissão para acessar aqui!");
		location.href="../tela_principal.php";
		</script>';
	break;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel de Controle</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
	
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<br>
<table width="600" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966"><h2>Painel de Controle do Sistema</h2></th>
  </tr>
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966"><h3>Departamento Pessoal</h3><br>
	<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../tela_principal.php');return document.MM_returnValue" style="width:150; height:30;"></th>
  </tr>
  <tr>
    <td width="20" class="fontebranca12">1</td>
    <td width="210" class="fontebranca12"><a href="usuarios_adm.php" class="fontebranca12">Usuários</a></td>
    <td width="24" class="fontebranca12">8</td>
    <td width="241" class="fontebranca12"><a href="../cipa/cons_risco.php" class="fontebranca12">Pesquisa do SESMT</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="funcionario_sesmt_adm.php" class="fontebranca12">Funcionários SESMT</a></td>
    <td class="fontebranca12">9</td>
    <td class="fontebranca12"><a href="via_localidade.php" class="fontebranca12">Viabilidade de Localidade</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="cargo_adm.php" class="fontebranca12">Cargos</a></td>
    <td class="fontebranca12">10</td>
    <td class="fontebranca12"><a href="cliente_by_location.php" class="fontebranca12">Cliente por Bairro</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">4</td>
    <td valign="top" class="fontebranca12"><a href="associada_adm.php" class="fontebranca12">Franquias SESMT</a> </td>
    <td class="fontebranca12">11</td>
    <td class="fontebranca12"><a href="vendedor_adm.php" class="fontebranca12">Consulta de Acessos</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">5</td>
    <td valign="top" class="fontebranca12"><a href="../producao/lista_atividade.php" class="fontebranca12">Tipo da Atividade</a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td width="24" class="fontebranca12">6</td>
    <td width="241" class="fontebranca12"><a href="cipa_adm.php" class="fontebranca12">Pesquisa da Cipa</a></td>
	<td width="24" class="fontebranca12">&nbsp;</td>
    <td width="241" class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td width="24" class="fontebranca12">7</td>
    <td width="241" class="fontebranca12"><a href="brigada_adm.php" class="fontebranca12">Pesquisa da Brigada de Incêndio</a></td>
	<td width="24" class="fontebranca12">&nbsp;</td>
    <td width="241" class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="3" class="linhatopodiresq" bgcolor="#009966"><h3>Edificação</h3></th>
	<th colspan="1" class="linhatopodiresq" bgcolor="#009966"><h3>Setorial</h3></th>
  </tr>
  <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="tipo_edificacao_adm.php" class="fontebranca12">Tipo edifica&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="riscos_adm.php" class="fontebranca12">Nível Tolerância</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="tipo_ventilacao_natural_adm.php" class="fontebranca12">Tipo Ventila&ccedil;&atilde;o Natural</a> </td>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="cidade_adm.php" class="fontebranca12">Munic&iacute;pios e DDD</a></td>
	<!-- <td class="fontebranca12"><a href="cnae_novo_adm.php" class="fontebranca12">CNAE_NOVO</a></td> -->
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="tipo_ventilacao_artificial_adm.php" class="fontebranca12">Tipo Ventila&ccedil;&atilde;o Artificial</a> </td>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="cnae_adm.php" class="fontebranca12">CNAE</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">4</td>
    <td class="fontebranca12"><a href="tipo_iluminacao_natural_adm.php" class="fontebranca12">Tipo Ilumina&ccedil;&atilde;o Natural </a></td>
    <td class="fontebranca12">4</td>
    <td class="fontebranca12"><a href="classificacao_atividade_adm.php" class="fontebranca12">Classifica&ccedil;&atilde;o da Atividade</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">5</td>
    <td class="fontebranca12"><a href="tipo_iluminacao_artificial_adm.php" class="fontebranca12">Tipo Ilumina&ccedil;&atilde;o Artificial </a></td>
    <td class="fontebranca12">5</td>
    <td class="fontebranca12"><a href="contato_com_agente_adm.php" class="fontebranca12">Contato Com o Agente </a></td>
  </tr>
  <tr>
    <td class="fontebranca12">6</td>
    <td class="fontebranca12"><a href="caracteristica_piso_adm.php" class="fontebranca12">Caracter&iacute;tica do Piso </a></td>
    <td class="fontebranca12">6</td>
    <td class="fontebranca12"><a href="tipo_contato_adm.php" class="fontebranca12">Tipo Contato </a></td>
  </tr>
  <tr>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="caracteristica_parede_adm.php" class="fontebranca12">Caracter&iacute;tica da Parede </a></td>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="../producao/lista_funcao.php" class="fontebranca12">Cadastro Geral da Fun&ccedil;&atilde;o</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12"><a href="caracteristica_cobertura_adm.php" class="fontebranca12">Caracter&iacute;tica Cobertura </a></td>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12">Ordem de Servi&ccedil;o Por Fun&ccedil;&atilde;o</td>
  </tr>
  <tr>
      <td class="fontebranca12">9</td>
      <td class="fontebranca12"><a href="../producao/lista_setor.php" class="fontebranca12">Setor</a></td>
      <td class="fontebranca12">9</td>
      <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
      <td class="fontebranca12">10</td>
      <td class="fontebranca12"><a href="aparelho_adm.php" class="fontebranca12">Aparelhos de Medição</a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
	<tr>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="3" class="linhatopodiresq" bgcolor="#009966"><h3>Medida Preventiva Existente<a name="medidapreventiva"></a></h3></th>
	<th colspan="1" class="linhatopodiresq" bgcolor="#009966"><h3>Medida Preventiva Sugerida: Cursos</h3></th>
  </tr>
  <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="placa_sinalizacao_adm.php" class="fontebranca12">Placa Sinaliza&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="demarcacao_solo_adm.php" class="fontebranca12">Demarca&ccedil;&atilde;o Solo </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="tipo_instalacao_adm.php" class="fontebranca12">Tipo Instala&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">4</td>
    <td class="fontebranca12"><a href="tipo_hidrante_adm.php" class="fontebranca12">Tipo Hidrante</a> </td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">5</td>
    <td class="fontebranca12"><a href="diametro_mangueira_adm.php" class="fontebranca12">Di&acirc;metro Mangueira </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">6</td>
    <td class="fontebranca12"><a href="tipo_para_raio_adm.php" class="fontebranca12">Tipo Para Raio</a> </td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="alarme_incendio_adm.php" class="fontebranca12">Alarme Contra Inc&ecirc;ndio </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12"><a href="sistema_fixo_incendio_adm.php" class="fontebranca12">Tipo Sistema Fixo Contra Incêndio </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966"><h3>Funcion&aacute;rios Cliente<a name="funcionarioscliente"></a></h3></th>
  </tr>
    <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="fun_cliente.php" class="fontebranca12">Relação de Colaboradores</a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966"><h3>Administração do Site<a name="siteadmin"></a></h3></th>
  </tr>
    <tr>
      <td class="fontebranca12">1</td>
      <td class="fontebranca12"><a href="jornal_admin.php" class="fontebranca12">Jornal SESMT</a></td>
      <td class="fontebranca12">4</td>
      <td class="fontebranca12"><a href="../adm_contratos/?action=list" class="fontebranca12">Administração de Contratos</a></td>
    </tr>
    <tr>
      <td class="fontebranca12">2</td>
      <td class="fontebranca12"><a href="clinicas_status.php" class="fontebranca12">Clínicas Cadastradas</a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
    <tr>
      <td class="fontebranca12">3</td>
      <td class="fontebranca12"><a href="access_log.php" class="fontebranca12">Acesso à Abra seu Negócio (Franquia)</a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
	<tr>
      <th colspan="4" class="linhatopodiresq" bgcolor="#009966"><h3>Financeiro</h3><a name="financeiro"></a></th>
    </tr>
    <tr>
      <td class="fontebranca12">1</td>
      <td class="fontebranca12"><a href="lista_desc.php" class="fontebranca12">Lista de Descrição Para as Notas Fiscais</a></td>
      <td class="fontebranca12">5</td>
      <td class="fontebranca12"><a href="https://notacarioca.rio.gov.br/senhaweb/login.aspx" target="_blank" class="fontebranca12">Gerar Nota Fiscal</a></td>
    </tr>
    <tr>
      <td class="fontebranca12">2</td>
      <td class="fontebranca12"><a href="lista_identifica.php" class="fontebranca12">Cadastrar Tipo de Identificação</a></td>
      <td class="fontebranca12">6</td>
      <td class="fontebranca12"><a href="resumo_de_fatura/resumo_de_fatura_index.php" class="fontebranca12" name="resumo">Gerar Resumo de Fatura</a></td>
    </tr>
    <tr>
      <td class="fontebranca12">3</td>
      <td class="fontebranca12"><a href="../financeiro/" class="fontebranca12">Controle Financeiro</a></td>
      <td class="fontebranca12">7</td>
      <td class="fontebranca12"><a href="resumo_de_fatura/planilha_resumo_fatura.php" class="fontebranca12">Planilha de Resumo de Fatura</a></td>
    </tr>
	<tr>
      <td class="fontebranca12">4</td>
      <td class="fontebranca12"><a href="resumo_de_fatura/inadimplente_fatura.php" class="fontebranca12">Controle de Inadimplência</a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
	<tr><td colspan="4" bgcolor="#009966">&nbsp;</td></tr>
</table>
<br>
</body>
</html>
