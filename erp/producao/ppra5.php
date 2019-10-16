<html>
<head>
<title>PPRA - Listagem</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 15px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra5">
<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <th colspan="2" bgcolor="#009966">
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
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
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

			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Nome do Cliente: </td> <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_cli[razao_social_cliente]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Endereço: </td>        <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_cli[endereco_cliente]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Bairro: </td>          <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_cli[bairro_cliente]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Telefone: </td>        <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_cli[telefone_cliente]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> E-mail: </td>          <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_cli[email]</b> </td> </tr>";

	}

/*************** DADOS DO SETOR ****************/
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
	or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );

	if($result_set){

		$row_set = pg_fetch_array($result_set);
		echo "<tr> <tH colspan=2 class=\"style1\"><BR>&nbsp; SETOR <br> &nbsp;</tH></tr>";
		echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Nome do Setor: </td>      <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_set[nome_setor]</b> </td> </tr>";
		echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Descrição do Setor: </td> <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_set[desc_setor]</b> </td> </tr>";
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
				<tH colspan=2 class=\"style1\"><BR>&nbsp; CARACTERÍSTICAS DA EDIFICAÇÃO <br> &nbsp;</tH>
 		      </tr>";

		$row_cli_set = pg_fetch_array($result_cli_set);
		
		echo "
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" width=300  align=right> <font color=black> Observações do Setor: &nbsp; 
				<td width=500> <b> &nbsp; <font color=black> $row_cli_set[observacao_setor]</b></td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Umidade do Setor: &nbsp;
				<td> <b>&nbsp; <font color=black> $row_cli_set[umidade]</b> </td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Temperatura do Setor:&nbsp; 
				<td> <b>&nbsp; <font color=black> $row_cli_set[temperatura]</b> </td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Luz Natural do Setor: &nbsp; 
				<td> <b>&nbsp; <font color=black> $row_cli_set[nome_luz_nat]</b> </td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black>&nbsp; Luz Artificial do Setor: &nbsp; 
				<td> <b>&nbsp; <font color=black> $row_cli_set[nome_luz_art]</b> </td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Tipo de Ventilaçã Artificial do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_vent_art]</b> </td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Tipo de Ventilaçã Natural do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_vent_nat]</b></td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Tipo de Edificação do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_edificacao]</b></td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Piso do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_piso]</b></td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Tipo de Parede do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_parede]</b></td>
			</tr>
			<tr bgcolor=#FFFFFF >
				<td class=\"style1\" align=right> <font color=black> Tipo de Cobertura do Setor: &nbsp; 
				<td><b>&nbsp; <font color=black> $row_cli_set[nome_cobertura]</b></td>
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
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Código: </td>                      <td><font color=black> <b>&nbsp;&nbsp;&nbsp;" . str_pad($row_risco[num_agente_risco], 4, "0", STR_PAD_LEFT) . " &nbsp;</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Agente causador do Risco: </td>    <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_risco[nome_agente_risco] &nbsp;</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Descrição do Risco: </td>          <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_risco[descricao_risco] &nbsp;</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Fonte do Risco: </td>              <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_risco[fonte_geradora] &nbsp;</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Medida Preventiva Existente: </td> <td><font color=black> <b>&nbsp;&nbsp;&nbsp; $row_risco[medida_predentiva_existente] &nbsp;</b> </td> </tr>";
			echo "<tr><th colspan=2 bgcolor=#FFFFFF >&nbsp; &nbsp;</th></tr>";

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
			echo "<tr> <tH colspan=2 class=\"style1\"><BR>&nbsp; DADOS DA MOBÍLIA DO SETOR <br> &nbsp;</tH> </tr>";
	
		while($row_mob = pg_fetch_array($result_mob)){
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Descrição da Mobília: </td>      <td><font color=black> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[descricao_mobilia]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Ruído no local da Mobília: </td> <td><font color=black> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[ruido]</b>  </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"style1\" align=right><font color=black> Imuminação na Mobília: </td>     <td><font color=black> <b>&nbsp;&nbsp;&nbsp; <b>$row_mob[iluminancia]</b>  </td> </tr>";
		}
	}
/************** DADOS DAS SUGESTÕES ****************/

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
			echo "	<th colspan=2 class=\"style1\"><br>&nbsp; SUGESTÕES <p> &nbsp; Serviços / Produtos Sugeridos <br> &nbsp;</th>";
			echo "</tr>";
	
		while($row_sugestao = pg_fetch_array($result_sugestao)){
			echo "<tr>";
			echo "	<td colspan=2 class=\"style1\" bgcolor=#FFFFFF> <font color=black> &nbsp;&nbsp;&nbsp; $row_sugestao[desc_detalhada_prod] </td>";
			echo "</tr>";
		}
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

<table width="800" border="2" align="center" cellpadding="0" cellspacing="0"  bordercolor="#FFFFFF">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966" ><br>
			<div class="style1">Funcionários do Setor <br></div>&nbsp; <br>
		</th>
    </tr>
    <tr>
    	<th colspan="5" class="linhatopodiresq">
			<br>  &nbsp;
			<input type="button" name="btn_concluir" value="Novo Funcionário" style="width:150px;" onClick="MM_goToURL('parent','cad_func.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue">
			<br> &nbsp;
		</th>
    </tr>
  <tr>
    <td width="10%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="style1"><strong>Código</strong></div></td>
    <td width="35%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="style1"><strong>Nome Funcion&aacute;rio </strong></div></td>
    <td width="15%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="style1"><strong>Celular</strong></div></td>
    <td width="25%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="style1"><strong>E-mail</strong></div></td>
    <td width="15%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="style1"><strong>Telefone</strong></div></td>
  </tr>
<?php
  while($row = pg_fetch_array($result_func)){
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[cod_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[nome_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[cel_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[email_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
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
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>

</form>
</body>
</html>
