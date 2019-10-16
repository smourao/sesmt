<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
/*
$query_clientes="select * from clientes";

switch($grupo){

	case "administrador":
	break;

	default:
	header("location: index.php");
	break;
}

*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::SESMT:: Painel de Controle</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>      <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Geral</font></div></td>
  </tr>
  <tr>
    <td width="20" class="fontebranca12">1</td>
    <td width="210" class="fontebranca12"><a href="usuarios-_adm.php" class="fontebranca12">Usu&aacute;rios
      
    </a></td>
    <td width="24" class="fontebranca12">6</td>
    <td width="241" class="fontebranca12"><a href="associada-_adm.php" class="fontebranca12">Associada</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="riscos-_adm.php" class="fontebranca12">Risco</a></td>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="cargo-_adm.php" class="fontebranca12">Cargo</a><a href="associada-_adm.php" class="fontebranca12"></a></td>
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="cnae-_adm.php" class="fontebranca12">CNAE</a></td>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12"><a href="cipa-_adm.php" class="fontebranca12">Cipa</a><a href="cargo-_adm.php" class="fontebranca12"></a></td>
  </tr>
   <tr>
    <td height="21" valign="top" class="fontebranca12">4</td>
    <td valign="top" class="fontebranca12"><a href="cidade-_adm.php" class="fontebranca12">Munic&iacute;pios &amp; DDD</a> </td>
    <td class="fontebranca12">9</td>
    <td class="fontebranca12"><a href="brigada-_adm.php" class="fontebranca12">Brigada de Inc&ecirc;ndio </a></td>
  </tr>
     <tr>
    <td height="21" valign="top" class="fontebranca12">5</td>
    <td valign="top" class="fontebranca12"><a href="cidade-_adm.php" class="fontebranca12"></a> <a href="funcionario_sesmt_adm.php" class="fontebranca12">Funcion&aacute;rio SESMT </a><a href="tipo_contato_adm.php" class="fontebranca12"></a></td>
    <td class="fontebranca12"></font>10</td>
    <td class="fontebranca12"><a href="cnae_novo_adm.php" class="fontebranca12">CNAE_NOVO</a></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000"><b>Edifica&ccedil;&atilde;o</b></font></div></td>
  </tr>
  <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="tipo-_edificacao_adm.php" class="fontebranca12">Tipo edifica&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">9</td>
    <td class="fontebranca12"><a href="../producao/lista-_atividade.php" class="fontebranca12">Atividades </a></td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="tipo_ventilacao-_natural_adm.php" class="fontebranca12">Tipo Ventila&ccedil;&atilde;o Natural</a> </td>
    <td class="fontebranca12">10</td>
    <td class="fontebranca12"><a href="../producao/lista-_epi.php" class="fontebranca12">EPI </a></td>
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="tipo_ventilacao-_artificial_adm.php" class="fontebranca12">Tipo Ventila&ccedil;&atilde;o Artificial</a> </td>
    <td class="fontebranca12">11</td>
    <td class="fontebranca12"><a href="../producao/lista-_medicamento.php" class="fontebranca12">Medicamentos</a></td>
  </tr>
  <tr>
    <td class="fontebranca12">4</td>
    <td class="fontebranca12"><a href="tipo_iluminacao-_natural_adm.php" class="fontebranca12">Tipo Ilumina&ccedil;&atilde;o Natural </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">5</td>
    <td class="fontebranca12"><a href="tipo_iluminacao-_artificial_adm.php" class="fontebranca12">Tipo Ilumina&ccedil;&atilde;o Artificial </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">6</td>
    <td class="fontebranca12"><a href="caracteristica-_piso_adm.php" class="fontebranca12">Caracter&iacute;tica do Piso </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="caracteristica-_parede_adm.php" class="fontebranca12">Caracter&iacute;tica da Parede </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12"><a href="caracteristica_-cobertura_adm.php" class="fontebranca12">Caracter&iacute;tica Cobertura </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold">Equipamento de Inc&ecirc;ndio </div></td>
  </tr>
  <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="placa_sinalizacao-_adm.php" class="fontebranca12">Placa Sinaliza&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">8</td>
    <td class="fontebranca12"><a href="sistema_fixo-_incendio_adm.php" class="fontebranca12">Tipo Sistema Fixo Contra Inc&ecirc;ndio </a></td>
  </tr>
  <tr>
    <td class="fontebranca12">2</td>
    <td class="fontebranca12"><a href="demarcacao-_solo_adm.php" class="fontebranca12">Demarca&ccedil;&atilde;o Solo </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">3</td>
    <td class="fontebranca12"><a href="tipo_instalacao-_adm.php" class="fontebranca12">Tipo Instala&ccedil;&atilde;o </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">4</td>
    <td class="fontebranca12"><a href="tipo_hidrante-_adm.php" class="fontebranca12">Tipo Hidrante</a> </td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">5</td>
    <td class="fontebranca12"><a href="diametro-_mangueira_adm.php" class="fontebranca12">Di&acirc;metro Mangueira </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
  <tr>
    <td class="fontebranca12">6</td>
    <td class="fontebranca12"><a href="tipo_para-_raio_adm.php" class="fontebranca12">Tipo Para Raio</a> </td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
    <td class="fontebranca12">7</td>
    <td class="fontebranca12"><a href="alarme-_incendio_adm.php" class="fontebranca12">Alarme Contra Inc&ecirc;ndio </a></td>
    <td class="fontebranca12">&nbsp;</td>
    <td class="fontebranca12">&nbsp;</td>
  </tr>
    <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold">Funcion&aacute;rios Cliente </div></td>
  </tr>
    <tr>
    <td class="fontebranca12">1</td>
    <td class="fontebranca12"><a href="funcao-_func_cliente_adm.php" class="fontebranca12">Fun&ccedil;&atilde;o</a></td>
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
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold">Riscos</div></td>
  </tr>
    <tr>
      <td class="fontebranca12">1</td>
      <td class="fontebranca12"><a href="classificacao-_atividade_adm.php" class="fontebranca12">Classifica&ccedil;&atilde;o da Atividade</a> </td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
    <tr>
      <td class="fontebranca12">2</td>
      <td class="fontebranca12"><a href="contato_com-_agente_adm.php" class="fontebranca12">Contato Com o Agente </a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
    <tr>
      <td class="fontebranca12">3</td>
      <td class="fontebranca12"><a href="tipo_contato-_adm.php" class="fontebranca12">Tipo Contato </a><a href="cnae_adm.php" class="fontebranca12"></a></td>
      <td class="fontebranca12">&nbsp;</td>
      <td class="fontebranca12">&nbsp;</td>
    </tr>
</table>
</body>
</html>
