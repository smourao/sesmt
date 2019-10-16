<html>
<head>
<title>PPRA - Listagem</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; color:#006633;font-size: 12px;}
.style2 {font-size: 12px}
-->
</style>
</head>
<body alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra5">
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50%" align="left"><img src="../img/logo_sesmt.png" width="333" height="180" /></td>
		<td width="50%" align="left">
			<p align="center">
			<font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
			<span class="style2">Servi�os Especializados de Seguran�a e <br>
		    Monitoramento de Atividades no Trabalho Ltda
			</span>
			</font>
			</p>
		    <p align="center">
			<font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
	        <span class="style2">Seguran�a do Trabalho e Higiene Ocupacional</span>
			</font></p>
		    <p align="center" class="style2">
			<font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
			M�dico Coordenador do PCMSO:<br>
		    Maria de Lourdes Fernandes Magalh�es<br>
	        CRMEJ 52.33.471-0 Reg. MTE 13.320 
			</font>
			</p>
	        <p class="style2">
	    </td>
	</tr>
</table>
<p>
<table align="center" width="800" border="2" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="2">
		<br>
        DADOS DO PPRA
		<br>&nbsp;
    </th>
  </tr>
  <tr>
    <tH colspan=2 class="style1"><BR>&nbsp; CLIENTE <br> 
    &nbsp;</tH>
  </tr>
<?php
include "../config/connect.php"; //arquivo que cont�m a conex�o com o Banco.
include "../sessao.php";

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
}

if( !empty($cliente) & !empty($setor) ){

}
/*************** DADOS DO CLIENTE ****************/
	$query_cli = "SELECT razao_social_cliente, bairro_cliente, telefone_cliente, email, endereco_cliente
				  FROM clientes where cod_cliente = $cliente";
	$result_cli = pg_query($connect, $query_cli)
		or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
		
	if($result_cli){

		$row_cli = pg_fetch_array($result_cli);

			echo "<tr> <td class=\"style1\" align=right> Nome do Cliente: </td> <td> <b>&nbsp;&nbsp;&nbsp; $row_cli[razao_social_cliente]</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Endere�o: </td>        <td> <b>&nbsp;&nbsp;&nbsp; $row_cli[endereco_cliente]</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Bairro: </td>          <td> <b>&nbsp;&nbsp;&nbsp; $row_cli[bairro_cliente]</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Telefone: </td>        <td> <b>&nbsp;&nbsp;&nbsp; $row_cli[telefone_cliente]</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> E-mail: </td>          <td> <b>&nbsp;&nbsp;&nbsp; $row_cli[email]</b> </td> </tr>";

	}

/*************** DADOS DO SETOR ****************/
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
	or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );

	if($result_set){

		$row_set = pg_fetch_array($result_set);
		echo "<tr> <tH colspan=2 class=\"style1\"><BR>&nbsp; SETOR <br> &nbsp;</tH></tr>";
		echo "<tr> <td class=\"style1\" align=right> Nome do Setor: </td>      <td> <b>&nbsp;&nbsp;&nbsp; $row_set[nome_setor]</b> </td> </tr>";
		echo "<tr> <td class=\"style1\" align=right> Descri��o do Setor: </td> <td> <b>&nbsp;&nbsp;&nbsp; $row_set[desc_setor]</b> </td> </tr>";
	}

/*************** DADOS DO SETOR DO CLIENTE ****************/
	$query_cli_set = "SELECT  cs.observacao_setor
						, cs.temperatura
						, cs.umidade
						, ln.nome_luz_nat
						, la.nome_luz_art
						, va.nome_vent_art
						, vn.nome_vent_nat
						, e.nome_edificacao
						, p.nome_piso
						, pa.nome_parede
						, co.nome_cobertura
						
					  FROM cliente_setor cs, luz_natural ln, luz_artificial la, ventilacao_natural vn,
					  		ventilacao_artificial va, edificacao e, piso p, parede pa, cobertura co
					  
					  WHERE cs.cod_cliente = $cliente
						and cs.cod_setor = $setor
						and cs.cod_luz_nat = ln.cod_luz_nat
						and cs.cod_luz_art = la.cod_luz_art
						and cs.cod_vent_nat = vn.cod_vent_nat
						and cs.cod_vent_art = va.cod_vent_art
						and cs.cod_edificacao = e.cod_edificacao
						and cs.cod_piso = p.cod_piso
						and cs.cod_parede = pa.cod_parede
						and cs.cod_cobertura = co.cod_cobertura";

	$result_cli_set = pg_query($connect, $query_cli_set) 
	or die ("Erro na query: $query_cli_set ==> " . pg_last_error($connect) );

	if( pg_num_rows($result_cli_set)>0 ){

		echo "<tr>
				<tH colspan=2 class=\"style1\"><BR>&nbsp; CARACTER�STICAS DA EDIFICA��O <br> &nbsp;</tH>
 		      </tr>";

		$row_cli_set = pg_fetch_array($result_cli_set);
		
		echo "
			<tr>
				<td class=\"style1\" width=300  align=right>  Observa��es do Setor: &nbsp; 
				<td width=500> <b> &nbsp;  $row_cli_set[observacao_setor]</b></td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Umidade do Setor: &nbsp;
				<td> <b>&nbsp;  $row_cli_set[umidade]</b> </td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Temperatura do Setor:&nbsp; 
				<td> <b>&nbsp;  $row_cli_set[temperatura]</b> </td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Luz Natural do Setor: &nbsp; 
				<td> <b>&nbsp;  $row_cli_set[nome_luz_nat]</b> </td>
			</tr>
			<tr>
				<td class=\"style1\" align=right> &nbsp; Luz Artificial do Setor: &nbsp; 
				<td> <b>&nbsp;  $row_cli_set[nome_luz_art]</b> </td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Tipo de Ventila�� Artificial do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_vent_art]</b> </td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Tipo de Ventila�� Natural do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_vent_nat]</b></td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Tipo de Edifica��o do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_edificacao]</b></td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Piso do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_piso]</b></td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Tipo de Parede do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_parede]</b></td>
			</tr>
			<tr>
				<td class=\"style1\" align=right>  Tipo de Cobertura do Setor: &nbsp; 
				<td><b>&nbsp;  $row_cli_set[nome_cobertura]</b></td>
			</tr>";

	}

	$query_risco = "SELECT ar.nome_agente_risco
					, ar.num_agente_risco
					, rs.descricao_risco
					, rs.fonte_geradora
					, rs.medida_predentiva_existente
				  FROM risco_setor rs, agente_risco ar
				  where rs.cod_setor = $setor
				  and rs.cod_cliente = $cliente
				  and ar.cod_agente_risco = rs.cod_agente_risco";

	$result_risco = pg_query($connect, $query_risco) 
		or die ("Erro na query: $query_risco ==> " . pg_last_error($connect) );

	if ( pg_num_rows($result_risco)>0 ){
			echo "<tr>
					<th colspan=2 class=\"style1\"><br> &nbsp; RISCOS E AGENTES <br> &nbsp;</th>
				</tr>";

		while($row_risco = pg_fetch_array($result_risco)){
			echo "<tr> <td class=\"style1\" align=right> C�digo: </td>                      <td> <b>&nbsp;&nbsp;&nbsp;" . str_pad($row_risco[num_agente_risco], 4, "0", STR_PAD_LEFT) . " &nbsp;</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Agente causador do Risco: </td>    <td> <b>&nbsp;&nbsp;&nbsp; $row_risco[nome_agente_risco] &nbsp;</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Descri��o do Risco: </td>          <td> <b>&nbsp;&nbsp;&nbsp; $row_risco[descricao_risco] &nbsp;</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Fonte do Risco: </td>              <td> <b>&nbsp;&nbsp;&nbsp; $row_risco[fonte_geradora] &nbsp;</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Medida Preventiva Existente: </td> <td> <b>&nbsp;&nbsp;&nbsp; $row_risco[medida_predentiva_existente] &nbsp;</b> </td> </tr>";
			echo "<tr><th colspan=2>&nbsp; &nbsp;</th></tr>";

		}
	}
/************** DADOS DAS MOBILIAS CADASTRADAS ****************/

	$query_mob = "SELECT descricao_mobilia
					, ruido
					, iluminancia
				  FROM mobilia m
				  where m.cod_setor = $setor
				  and m.cod_cliente = $cliente";

	$result_mob = pg_query($connect, $query_mob) 
		or die ("Erro na query: $query_mob ==> " . pg_last_error($connect) );

	if( pg_num_rows($result_mob)>0 ){
			echo "<tr> <tH colspan=2 class=\"style1\"><BR>&nbsp; DADOS DA MOB�LIA DO SETOR <br> &nbsp;</tH> </tr>";
	
		while($row_mob = pg_fetch_array($result_mob)){
			echo "<tr> <td class=\"style1\" align=right> Descri��o da Mob�lia: </td>      <td> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[descricao_mobilia]</b> </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Ru�do no local da Mob�lia: </td> <td> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[ruido]</b>  </td> </tr>";
			echo "<tr> <td class=\"style1\" align=right> Imumina��o na Mob�lia: </td>     <td> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[iluminancia]</b>  </td> </tr>";
		}
	}
/************** DADOS DAS SUGEST�ES ****************/

	$query_sugestao = "SELECT  cod_prod,
						desc_detalhada_prod,
						desc_resumida_prod,
						cod_atividade
					  FROM produto p, sugestao_setor ss
					  where ss.cod_cliente = $cliente
					  and ss.cod_setor = $setor
					  and ss.cod_produto = p.cod_prod;";

	$result_sugestao = pg_query($connect, $query_sugestao) 
		or die ("Erro na query: $query_sugestao ==> " . pg_last_error($connect) );

	if( pg_num_rows($result_sugestao)>0 ){
			echo "<tr>";
			echo "	<th colspan=2 class=\"style1\"><br>&nbsp; SUGEST�ES <p> Servi�os / Produtos Sugeridos <br> &nbsp; </th>";
			echo "</tr>";

			echo "<tr>";
			echo "	<td colspan=2 class=\"style1\"> ";

		while($row_sugestao = pg_fetch_array($result_sugestao)){
			echo "&nbsp;&nbsp;&nbsp; $row_sugestao[desc_detalhada_prod]<br>";
		}
			echo "	</td>";
			echo "</tr>";
	}
	?>
  <tr>
    <th colspan="2"><br>
		<input type="button"  name="concluir" value="Concluir" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button"  name="alterar" value="Alterar" onClick="MM_goToURL('parent','ppra2_alt.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" style="width:100;">&nbsp;
		<br>&nbsp;
	</th>
  </tr>
</table>
<p>

<?php

	$query_func = "SELECT cod_func, nome_func, tel_func, endereco_func, bairro_func, cel_func, 
					   email_func, num_ctps_func, serie_ctps_func, cbo, cod_cidade, 
					   cod_status, cod_funcao, cod_setor, cod_cliente, cpf_func, sexo_func, 
					   data_nasc_func, data_admissao_func, data_desligamento_func
			  	   FROM funcionarios
					where cod_cliente = $cliente 
					and cod_setor = $setor";

$result_func = pg_query($connect, $query_func) 
	or die ("Erro na query: $query_func ==> ".pg_last_error($connect));

?>

<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5"><br>
			<div class="style1">FUNCION�RIO<br></div>&nbsp; <br>
		</th>
    </tr>
    <tr>
    	<th colspan="5">
			<br>  &nbsp;
			<input type="button" name="btn_concluir" value="Novo Funcion�rio" style="width:150px;" onClick="MM_goToURL('parent','cad_func.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue">
			<br> &nbsp;
		</th>
    </tr>
  <tr>
    <td width="10%"><div align="center" class="style1"><strong>C�digo</strong></div></td>
    <td width="35%"><div align="center" class="style1"><strong>Nome Funcion&aacute;rio </strong></div></td>
    <td width="15%"><div align="center" class="style1"><strong>Celular</strong></div></td>
    <td width="25%"><div align="center" class="style1"><strong>E-mail</strong></div></td>
    <td width="15%"><div align="center" class="style1"><strong>Telefone</strong></div></td>
  </tr>
<?php
  while($row = pg_fetch_array($result_func)){
?>
  <tr>
    <td>
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[cod_func];?></a>
	  </div>
	</td>
    <td>
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[nome_func];?></a>
	  </div>
	</td>
    <td>
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[cel_func];?></a>
	  </div>
	</td>
    <td>
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[email_func];?></a>
	  </div>
	</td>
    <td>
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[tel_func];?></a>
	  </div>
	</td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td ><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td ><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>

</form>
</body>
</html>
