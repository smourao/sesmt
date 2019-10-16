<?php
include "sessao.php";
ini_set("session.gc_maxlifetime", "18000");
//echo ini_get("session.gc_maxlifetime");
switch($erro){
	case 1:
	echo "<script>alert('Ocorreu um erro no Login Verifique o Login ou a senha');</script>";
	break;
	
	case 2:
	echo "<script>alert('Usuário não Autorizado');</script>";
	break;
	
	}
?>
<html>
<head>
<title>Sistema Sesmt</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
td img {display: block;}
#cadastros {
	position:absolute;
	left:51%;
	top:348px;
	width:210px;
	height:117px;
	z-index:1;
	visibility: hidden;
}
#engenharia {
	position:absolute;
	left:75%;
	top:110px;
	width:190px;
	height:68px;
	z-index:1;
	visibility: hidden;
}
#comercial{
	position:absolute;
	left:59%;
	top:251px;
	width:200px;
	height:50px;
	z-index:1;
	visibility:hidden;
}
#medico{
	position:absolute;
	left:5%;
	top:90px;
	width:190px;
	height:68px;
	z-index:1;
	visibility: hidden;
}
#administracao{
	position:absolute;
	left:30%;
	top:130px;
	width:190px;
	height:68px;
	z-index:1;
	visibility: hidden;
}
#recepcao{
	position:absolute;
	left:22%;
	top:270px;
	width:190px;
	height:68px;
	z-index:1;
	visibility: hidden;
}
#relatorio {
	position:absolute;
	left:5%;
	top:348px;
	width:210px;
	height:117px;
	z-index:1;
	visibility: hidden;
}

.style1 {font-size: 12px; font-weight: normal; text-decoration: none; font-family: Arial, Helvetica, sans-serif;}
</style>
<script type="text/javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="position:absolute;float:left;"><img src="2.0/images/trynew.png" border=0 onclick="alert('O novo sistema está em fase de desenvolvimento, alguns módulos podem não estar finalizados!');location.href='2.0/index.php';"></div>
<div id="cadastros" onMouseOver="MM_showHideLayers('cadastros','','show')" onMouseOut="MM_showHideLayers('cadastros','','hide')">
  <table border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" class="linhatopodiresq"><a href="listagem.php" class="fontebranca12">Cadastro Clientes </a></td>
    </tr>
    <tr>
      <td width="193" class="linhatopodiresq"><a href="listagem_pc.php" class="fontebranca12">Cadastro Parceria Comercial</a></td>
    </tr>
    <tr>
      <td height="21" class="linhatopodiresq"><a href="producao/lista_produto.php" class="fontebranca12">Cadastro de Produtos </a></td>
    </tr>
    <tr>
      <td class="linhatopodiresq"><a href="listagem_fornecedores.php" class="fontebranca12">Cadastro de Fornecedores </a></td>
    </tr>
    <tr>
      <td class="linhatopodiresqbase"><a href="medico/lista_clinicas.php" class="fontebranca12">Cadastro de Clínicas </a></td>
    </tr>

  </table>
</div>
<div id="engenharia" onMouseOver="MM_showHideLayers('engenharia','','show')" onMouseOut="MM_showHideLayers('engenharia','','hide')">
  <table width="200" height="67" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
   <!-- <tr>
      <td width="193" height="25" class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="cadastro_setor.php"><font color="#FFFFFF">Cadastro de Edifica&ccedil;&atilde;o </font></a></div></td>
    </tr-->
    <tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="producao/lista_setor.php" class="fontebranca12">Cadastro de Setor</a></div></td>
    </tr>
    <tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="producao/lista_funcao.php" class="fontebranca12">Cadastro Geral da Função</a> </div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="producao/lista_ppra.php" class="fontebranca12">Laboratório Técnico</a> </div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="listagem.php" class="fontebranca12">Lista de Clientes </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="producao/lista_produto.php" class="fontebranca12">Lista de Produtos </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="ata_cipa_index.php" class="fontebranca12">Ata da Cipa</a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="bt/index.php" class="fontebranca12">Biblioteca Técnica</a></div></td>
    </tr>
  	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="site_cli_reg.php" class="fontebranca12">Viabilidade de Atendimento</a></div></td>
    </tr>
    <tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="treinamento/index.php" class="fontebranca12">Cadastro de Treinamento</a></div></td>
    </tr>
  </table>
</div>
<div id="comercial" onMouseOver="MM_showHideLayers('comercial','','show')" onMouseOut="MM_showHideLayers('comercial','','hide')">
	<table width="120" height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" height="21" class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="simulador_listagem.php" class="fontebranca12">Simulador </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="producao/lista_produto.php" class="fontebranca12">Lista de Produtos </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="listagem.php" class="fontebranca12">Lista de Clientes </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="lista_orcamento.php" class="fontebranca12">Lista de Orçamentos </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="cria_orcamento_index.php" class="fontebranca12">Gerar Orçamento </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="lista_contadores.php" class="fontebranca12">Lista de Contadores </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="carta_vendedor.php" class="fontebranca12">Carta de Vendedores </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="sim_avaliacao_ambiental.php" class="fontebranca12">Simulador de Avaliação Ambiental </a></div></td>
    </tr>

	</table>
</div>
<div id="administracao" onMouseOver="MM_showHideLayers('administracao','','show')" onMouseOut="MM_showHideLayers('administracao','','hide')">
	<table width="120" height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" height="21" class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="adm/index.php" class="fontebranca12">Painel de Administração </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="listagem_fornecedores.php" class="fontebranca12">Lista de Fornecedores </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="listagem.php" class="fontebranca12">Lista de Clientes </a></div></td>
    </tr>
	</table>
</div>
<div id="medico" onMouseOver="MM_showHideLayers('medico','','show')" onMouseOut="MM_showHideLayers('medico','','hide')">
	<table width="200" height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" height="21" class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="listagem.php" class="fontebranca12">Lista de Clientes </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="medico/lista_aso.php" class="fontebranca12">ASO de Contrato</a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="medico/lista_aso_avulso.php" class="fontebranca12">ASO Avulso</a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="medico/lista_aso_complementar.php" class="fontebranca12">ASO sem Complementar</a></div></td>
    </tr>
    <tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="orcamento_medi/cria_orcamento_index.php" class="fontebranca12">Orç. de Exame Complementar</a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="2.0/index.php?dir=autorizacao_atend&p=index" class="fontebranca12">Autorização de Atendimento </a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="medico/lista_prontuario.php" class="fontebranca12">Lista de Prontuários </a></div></td>
    </tr>
    </table>
</div>
<div id="recepcao" onMouseOver="MM_showHideLayers('recepcao','','show')" onMouseOut="MM_showHideLayers('recepcao','','hide')">
	<table width="120" height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" height="21" class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="listagem_fornecedores.php" class="fontebranca12">Lista de Fornecedores</a></div></td>
    </tr>
	<tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12"><a href="news_cliente/" class="fontebranca12">Newsletter </a></div></td>
    </tr>

	<tr>
      <td class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="listagem.php" class="fontebranca12">Lista de Clientes </a></div></td>
    </tr>
	</table>
</div>
<div id="relatorio" onMouseOver="MM_showHideLayers('relatorio','','show')" onMouseOut="MM_showHideLayers('relatorio','','hide')">
	<table width="120" height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#097A44">
    <tr>
      <td width="193" height="21" class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="medico/lista_aso.php" class="fontebranca12">ASO Contrato</a></div></td>
    </tr>
    <tr>
      <td width="193" height="21" class="linhatopodiresqbase"><div align="left" class="fontebranca12"><a href="os/index.php" class="fontebranca12">Ordem de Serviços</a></div></td>
    </tr>
	</table>
</div>

<form action="auth.php" method="post" enctype="multipart/form-data" name="Login" target="_self" id="Login">
  <table width="680" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#036735">
    
    <tr>
      <td><img src="img/spacer.gif" width="14" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="37" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="16" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="24" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="55" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="7" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="31" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="48" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="56" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="99" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="22" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="55" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="48" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="32" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="43" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="21" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="17" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="55" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="6"><img name="tel_inicial_r1_c1" src="img/tel_inicial_r1_c1.jpg" width="153" height="48" border="0" id="tel_inicial_r1_c1" alt="" /></td>
      <td colspan="8"><img name="tel_inicial_r1_c7" src="img/tel_inicial_r1_c7.jpg" width="391" height="48" border="0" id="tel_inicial_r1_c7" alt="" /></td>
      <td colspan="4"><img name="tel_inicial_r1_c15" src="img/tel_inicial_r1_c15.jpg" width="136" height="48" border="0" id="tel_inicial_r1_c15" alt="" /></td>
      <td><img src="img/spacer.gif" width="1" height="48" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="18" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="9" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="9" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="2" rowspan="2" bgcolor="#036735"><img name="tel_inicial_r3_c10" src="img/tel_inicial_r3_c10.jpg" width="121" height="121" border="0" id="tel_inicial_r3_c10" alt="" onMouseOver="MM_showHideLayers('administracao','','show')" onMouseOut="MM_showHideLayers('administracao','','hide')"/></td>
      <td colspan="7" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="7" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="6" rowspan="2" bgcolor="#036735"><img name="tel_inicial_r4_c3" src="img/tel_inicial_r4_c3.jpg" width="181" height="139" border="0" id="tel_inicial_r4_c3" alt="" onMouseOver="MM_showHideLayers('medico','','show')" onMouseOut="MM_showHideLayers('medico','','hide')" /></td>
      <td rowspan="10" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td rowspan="10" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="3" rowspan="3" bgcolor="#036735"><img src="img/tel_inicial_r4_c13.jpg" alt="" name="tel_inicial_r4_c13" width="123" height="150" border="0" id="tel_inicial_r4_c13" onMouseOver="MM_showHideLayers('engenharia','','show')" onMouseOut="MM_showHideLayers('engenharia','','hide')" /></td>
      <td rowspan="4" colspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="120" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="4" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="19" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="6" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="11" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" rowspan="2" bgcolor="#036735"><img name="tel_inicial_r7_c3" src="img/tel_inicial_r7_c3.jpg" width="95" height="126" border="0" id="tel_inicial_r7_c3" alt="" onMouseOver="MM_showHideLayers('recepcao','','show')" onMouseOut="MM_showHideLayers('recepcao','','hide')"/></td>
      <td rowspan="2" colspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="2" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="2" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td rowspan="2" colspan="2" bgcolor="#036735"><img src="img/tel_inicial_r8_c14.jpg" name="tel_inicial_r8_c14" width="99" height="124" border="0" id="tel_inicial_r8_c14" alt="" onMouseOver="MM_showHideLayers('comercial','','show')" onMouseOut="MM_showHideLayers('comercial','','hide')" /></td>
      <td rowspan="2" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="124" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="2" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="3" rowspan="4" bgcolor="#036735"><img name="tel_inicial_r9_c5" src="img/tel_inicial_r9_c5.jpg" width="93" height="123" border="0" id="tel_inicial_r9_c5" alt="" onMouseOver="MM_showHideLayers('relatorio','','show')" onMouseOut="MM_showHideLayers('relatorio','','hide')" /></td>
      <td rowspan="5" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td rowspan="5" colspan="2" bgcolor="#036735"><img src="img/tel_inicial_r9_c10.jpg" alt="" name="tel_inicial_r9_c10" width="110" height="124" border="0" id="tel_inicial_r9_c10" onMouseOver="MM_showHideLayers('cadastros','','show')" onMouseOut="MM_showHideLayers('cadastros','','hide')" /></td>
      <td rowspan="5" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="2" border="0" alt="" /></td>
    </tr>
   
    <tr>
      <td rowspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td colspan="2" bgcolor="#036735"><a href="javascript:parent.location.href='index.php?logout=1';"><img name="tel_inicial_r11_c2" src="img/tel_inicial_r11_c2.jpg" width="53" height="74" border="0" id="tel_inicial_r11_c2" alt="Sair" /></a></td>
      <td rowspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="74" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="2" colspan="2" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="4" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" bgcolor="#036735"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
  </table>
</form>
</body>
</html>
