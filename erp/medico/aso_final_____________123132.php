<?php 
//include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$funcionario = $_GET["funcionario"];
	$setor = (int)($_GET["setor"]);
	$cliente = $_GET["cliente"];
	$filial = $_GET["filial"];
	$aso = $_GET["aso"];
} else {
	$funcionario = $_POST["funcionario"];
	$setor = $_POST["setor"];
	$cliente = $_POST["cliente"];
	$filial = $_POST["filial"];
	$aso = $_POST["aso"];
}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

/******************** DADOS **********************/
if (!empty($funcionario) and !empty($aso)){
        $query_func = "SELECT f.cod_func, f.nome_func, f.num_ctps_func, f.serie_ctps_func, f.cbo, f.dinamica_funcao -- funcionário
        , a.cod_aso, a.tipo_exame, a.aso_resultado, a.aso_data, a.obs -- aso
        , c.cliente_id, c.razao_social, c.endereco, c.num_end, c.bairro, c.cep, c.cnpj -- cliente
        , ca.cnae_id, ca.cnae, ca.grau_risco -- cnae
        , cl.classificacao_atividade_id, cl.nome_atividade -- classificacao_atividade
        , rc.risco_id, rc.nome -- risco cliente
        , fu.cod_funcao, fu.nome_funcao -- funcao

        FROM

        funcionarios f,
        aso a,
        cliente c,
        cnae ca,
        classificacao_atividade cl,
        risco_cliente rc,
        funcao fu,
        cliente_setor cs

        WHERE
            f.cod_func = $funcionario
        AND a.cod_aso = $aso
        AND a.cod_func = f.cod_func
        AND a.cod_cliente = f.cod_cliente
        AND c.cliente_id = f.cod_cliente
        AND c.cnae_id = ca.cnae_id
        AND cl.classificacao_atividade_id = a.classificacao_atividade_id
        AND rc.risco_id = a.risco_id
        AND fu.cod_funcao = f.cod_funcao
        AND cs.cod_setor = f.cod_setor
        AND cs.cod_cliente = f.cod_cliente";
		$result_func = pg_query($connect, $query_func);
		$row_func = pg_fetch_array($result_func);
		
		
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ASO</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif;color: #006633;}
</style>
</head>
<body text="#000000">&nbsp;
<table border="0" width="760" height="1060" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>
<form action="aso_final.php" name="frm_aso" method="post">
<?PHP if(!$_GET['sem_timbre']){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50%" align="left"><img src="../img/logo_sesmt.png" width="333" height="175" /></td>
		<td width="50%" align="left"><p align="center"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif"><span class="style2">Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho Ltda.<br />
		  CNPJ:04.722.248/0001-17 Insc. Mun.311.213-6</span></font></p>
		  <p align="center"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
	            <span class="style2">Segurança do Trabalho e Higiene Ocupacional</span></font></p>
		  <p align="center" class="style2"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p>
	    <p class="style2">		</td>
	</tr>
</table>
<?PHP
}else{
echo '<table  width="100%" height="175" border="0" cellpadding="0" cellspacing="0">';
echo '	<tr>
		<td width="50%" align="left">&nbsp</td>
		<td width="50%" align="left"><p align="center">
        <font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
        &nbsp;
  	    </font>
          &nbsp;</p>&nbsp;
		<p align="center">
        <font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
		 <p align="center" class="style2"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p>
	    <p class="style2">		</td>
	</tr>
</table>';
} ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
	<td><center><h2 class="style3">ASO - Atestado de Saúde Ocupacional</h2>	
		<h6 class="style3">Conforme NR 7.4.1</h6></center></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="14%" align="left" class="fontepreta12 style2">Nº ASO</td>
		<td width="12%" align="left" class="fontepreta12 style2">Cod.Cli</td>
		<td width="74%" align="left" class="fontepreta12 style2">Razão Social</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="cod_aso" size="5" value="<?php if($row_func[cod_aso]){coloca_zeros($row_func[cod_aso]);} ?>" readonly="true"></td>
		<td class="fontepreta12" align="left"><input type="text" name="cod_cliente" size="5" value="<?php if($row_func[cliente_id]){coloca_zeros($row_func[cliente_id]);} ?>" readonly="true"></td>
		<td class="fontepreta12" align="left"><input type="text" name="razao_social_cliente" size="87" value="<?php echo $row_func[razao_social] ?>" readonly="true"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" align="left" class="fontepreta12 style2">End. &nbsp;<input type="text" name="endereco" size="60" value="<?php echo $row_func[endereco]; echo ", "; echo $row_func[num_end]; echo " - "; echo $row_func[bairro]; ?>" readonly="true" /></td>
		<td width="30%" align="left" class="fontepreta12 style2">CEP &nbsp;<input type="text" name="cep" size="15" value="<?php echo $row_func[cep] ?>" readonly="true" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="25%" align="left" class="fontepreta12 style2">CNPJ</td>
		<td width="20%" align="left" class="fontepreta12 style2">CNAE</td>
		<td width="20%" align="left" class="fontepreta12 style2">Grau de Risco</td>
		<td width="35%" align="left" class="fontepreta12 style2">Tipo de Exame</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="cnpj" size="20" value="<?php echo $row_func[cnpj] ?>" readonly="true" /></td>
		<td class="fontepreta12" align="left"><input type="text" name="cnae" size="10" value="<?php echo $row_func[cnae] ?>" readonly="true" /></td>
		<td class="fontepreta12" align="left"><input type="text" name="grau_de_risco"  size="5" value="<?php echo $row_func[grau_risco] ?>" readonly="true"/></td>
		<td class="fontepreta12" align="left"><input type="text" name="tipo_exame"  size="21" value="<?php echo $row_func[tipo_exame] ?>" readonly="true"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="18%" align="left" class="fontepreta12 style2">Cod.Func</td>
		<td width="82%" align="left" class="fontepreta12 style2">Nome do Funcionário</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="cod_funcionario" size="5" value="<?php if($row_func[cod_func]) {coloca_zeros($row_func[cod_func]);} ?>" readonly="true" /></td>
		<td class="fontepreta12" align="left"><input type="text" name="nome_funcionario" size="95" value="<?php echo $row_func[nome_func] ?>" readonly="true" /></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td width="15%" align="left" class="fontepreta12 style2">CTPS &nbsp;<input type="text" name="carteira_trabalho" size="5" value="<?php echo $row_func[num_ctps_func] ?>"  readonly="true"/></td>
		<td width="15%" align="left" class="fontepreta12 style2">Série &nbsp;<input type="text" name="serie_carteira" size="5" value="<?php echo $row_func[serie_ctps_func] ?>" readonly="true" /></td>
		<td width="15%" align="left" class="fontepreta12 style2">CBO &nbsp;<input type="text" name="cbo" size="5" value="<?php echo $row_func[cbo] ?>" readonly="true" /></td>
		<td width="65%" align="left" class="fontepreta12 style2">Função &nbsp;<input type="text" name="nome_funcao" size="50" value="<?php echo $row_func[nome_funcao] ?>" readonly="true" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Atividade Laborativa&nbsp;<input type="text" name="ativ_laborativa" size="100" value="<?php echo $row_func[dinamica_funcao] ?>" readonly="true" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="50%" align="left" class="fontepreta12 style2">Classificação da Atividade&nbsp;<input type="text" name="classificacao_atividade" size="20" value="<?php echo $row_func[nome_atividade] ?>" readonly="true" /></td>
		<td width="50%" align="left" class="fontepreta12 style2">Nível de Tolerância&nbsp;<input type="text" name="nivel_tolerancia" size="20" value="<?php echo $row_func[nome] ?>" readonly="true" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="15%" align="left" class="fontepreta12 style2">Riscos da Função</td>
		<td width="45%" align="left" class="fontepreta12 style2">Especificar Riscos da Função</td>
		<td width="40%" align="left" class="fontepreta12 style2">Exames Realizados</td>
	</tr>
	<tr>
		<?php
		// SELEÇÃO DOS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			$query_risco="SELECT distinct(nome_tipo_risco)
						  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
						  WHERE ar.cod_agente_risco = rs.cod_agente_risco
						  AND ar.cod_tipo_risco = tr.cod_tipo_risco
						  AND c.cliente_id = rs.cod_cliente
						  AND a.cod_cliente = c.cliente_id
						  AND rs.cod_setor = f.cod_setor
						  AND a.cod_aso = $aso
						  AND f.cod_func = $funcionario 
						  AND f.cod_cliente = $cliente
						  AND f.cod_setor = $setor order by nome_tipo_risco";

			$result_risco=pg_query($query_risco)
			or die("Erro na query: $query_risco".pg_last_error($connect));
			
			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";
			
				while($row_risco=pg_fetch_array($result_risco)){ 
			echo "<input type=\"checkbox\" name\"cod_tipo_risco\" value=\"$row_risco[cod_tipo_risco]\" checked >&nbsp; $row_risco[nome_tipo_risco] <br> ";
				}
			echo "	</td>";
			} //Fim da Seleção
		?>
		
		<?php
		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			$query_agente="SELECT distinct(nome_agente_risco)
						   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
						   WHERE ar.cod_agente_risco = rs.cod_agente_risco
						   AND ar.cod_tipo_risco = tr.cod_tipo_risco
						   AND c.cliente_id = rs.cod_cliente
						   AND a.cod_cliente = c.cliente_id
						   AND rs.cod_setor = f.cod_setor
						   AND a.cod_aso = $aso
						   AND f.cod_func = $funcionario
						   AND f.cod_cliente = $cliente
						   AND f.cod_setor = $setor order by nome_agente_risco";
						  
			$result_agente=pg_query($query_agente) 
			or die("Erro na query: $query_agente".pg_last_error($connect));

			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";

				while($row_agente=pg_fetch_array($result_agente)){ 
			echo "<input type=\"checkbox\" name\"cod_agente_risco\" value=\"$row_agente[cod_agente_risco]\" checked >&nbsp; $row_agente[nome_agente_risco] <br>";
				}
			echo "	</td>";
			} //FIM DA SELEÇÃO
		?>
		<?php
		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
		if( !empty($funcionario) and !empty($aso) ){
			$query_exame="SELECT e.cod_exame, e.especialidade, ae.data
						  FROM exame e, aso a, aso_exame ae, funcionarios f, cliente c
						  WHERE a.cod_aso = ae.cod_aso
						  AND e.cod_exame = ae.cod_exame
						  AND a.cod_func = f.cod_func 
						  AND c.cliente_id = f.cod_cliente
						  AND a.cod_setor = f.cod_setor
						  AND a.cod_aso = $aso
						  AND f.cod_func = $funcionario
						  AND f.cod_cliente = $cliente
						  AND f.cod_setor = $setor order by especialidade";
						  
			$result_exame=pg_query($query_exame) 
			or die("Erro na query: $query_exame".pg_last_error($connect));
			
			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";
			echo "<Table border=0 width=100%>";			
				while($row_exame=pg_fetch_array($result_exame)){ 
					echo "<tr><td align=\"left\" class='fontepreta12 style1'>";
						echo "<input type=\"checkbox\" name\"cod_exame\" value=\"$row_exame[cod_exame]\" checked >&nbsp; $row_exame[especialidade]";
					echo "</td><td align=\"left\" class='fontepreta12 style1'>";
						echo date("d/m/Y", strtotime($row_exame[data]));
					echo "</td></tr>";
				}
				echo "</table>";
			echo "	</td>";
			} //Fim da Seleção
		?>
	</tr>
</table>
<?php
$sc = "SELECT *
	   FROM aso_exame
	   WHERE cod_aso = $aso";
$rsc = pg_query($connect, $sc);
$ce = pg_fetch_array($rsc);
?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td align="left" class="fontepreta12">
		Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e 
		despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, 
		encontra-se <strong><?php echo $row_func[aso_resultado] ?></strong> mediante ter sido aprovado nos
		exames físicos e psicológicos.
		</td>
	</tr>
	<?php
	if($row_func[aso_resultado] == "Inapto" || $row_func[aso_resultado] == "Apto com Restrição"){
		echo "<tr><td align=left class=fontepreta12>
				{$row_func[obs]}
			  </td></tr>";
	}
	?>
	<tr>
		<td align="left" class="fontepreta12"><b>Data de Realização:</b>&nbsp;<?php echo date("d/m/Y", strtotime($row_func[aso_data])); ?></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<br /><br />
	<tr>
		<td width="50%" align="center">_________________________________</td>
		<td width="50%" align="center">        
		<?PHP
        if(!$_GET['sem_timbre']){
        	echo '<img src="../img/assinatura.png" border="0" />';
        }
        ?>
		</td>
	</tr>
	<tr>
		<th class="fontepreta12 style2">Assinatura do Examinado</th>
		<th class="fontepreta12 style2">Assinatura do Examinador</th>
	</tr>
</table>
</form>
<?PHP if(!$_GET['sem_timbre']){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<p>
	<tr>
		<td width="65%" align="center" class="fontepreta12 style2">
		<br /><br /><br /><br /><br /><br />
		  Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		  <p>
		  faleprimeirocomagente@sesmt-rio.com - medicotrab@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />
	    </td>
		<td width="35%" align="right"><img src="../img/logo_sesmt2.png" width="280" height="200" /></td>
	</tr>
</table>
<?PHP
}else{
echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<p>
	<tr>
		<td valign="bottom" width="65%" align="center" class="fontepreta12 style2">
		<br /><br /><br /><br /><br /><br />
		  Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		  <p>
		  faleprimeirocomagente@sesmt-rio.com - medicotrab@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com
	    </td>
		<td width="35%" align="right">&nbsp;</td>
	</tr>
</table>';
}?>
</td>
</tr>
</table>
</body>
</html>