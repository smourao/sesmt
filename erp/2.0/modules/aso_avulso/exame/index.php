<?php
include("../../../common/database/conn.php");

if($_GET){
	$funcionario = $_GET["funcionario"];
	$setor = (int)($_GET["setor"]);
	$cod_cliente = $_GET["cliente"];
	$filial = $_GET["filial"];
	$aso = $_GET['aso'];
} else {
	$funcionario = $_POST["funcionario"];
	$setor = $_POST["setor"];
	$cod_cliente = $_POST["cliente"];
	$filial = $_POST["filial"];
	$aso = $_POST["aso"];
}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}
/*>>>>>>>>>R0CH4<<<<<<<<<<<<<<<*/
/******************** DADOS **********************/
/*if (!empty($funcionario) and !empty($aso)){
        $query_func = "SELECT f.cod_func, f.nome_func, f.num_ctps_func, f.serie_ctps_func, f.cbo, f.dinamica_funcao -- funcionário
        , a.cod_aso, a.tipo_exame, a.aso_resultado, a.aso_data, a.obs -- aso
        , c.cliente_id, c.razao_social, c.endereco, c.cep, c.cnpj -- cliente
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
        AND cs.cod_cliente = f.cod_cliente";*/
		
		if (!empty($aso)){
		$query_func = "SELECT * FROM aso_avulso WHERE cod_aso = $aso";
		$result_func = pg_query($query_func);
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
<body text="#000000">
<form action="aso_final.php" name="frm_aso" method="post">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50%" align="left"><img src="../../../images/logo_novo_sesmt.png" width="800" height="135" /></td>
        
	    <p class="style2">		</td>
	</tr>
</table>
<!--
<p align="center" class="style2"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p>
-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
	<td><center><h2 class="style3">ASO - Atestado de Saúde Ocupacional</h2>	
		<h6 class="style3">Conforme NR 7.4.1</h6></center></td>
	</tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="14%" align="left" class="fontepreta12 style2">Nº ASO</td>
		<td width="74%" align="left" class="fontepreta12 style2">Razão Social</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="cod_aso" size="5" value="<?php if($_GET){coloca_zeros($_GET[aso]);} ?>" readonly="true"></td>
		
		<td class="fontepreta12" align="left"><input type="text" name="razao_social_cliente" size="87" value="<?php echo $row_func[razao_social_cliente] ?>" readonly="true"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" align="left" class="fontepreta12 style2">End. &nbsp;<input type="text" name="endereco" size="60" value="<?php echo $row_func[endereco_cliente] ?>" readonly="true" /></td>
		<td width="30%" align="left" class="fontepreta12 style2">CEP &nbsp;<input type="text" name="cep" size="15" value="<?php echo $row_func[cep_cliente] ?>" readonly="true" /></td>
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
		<td class="fontepreta12" align="left"><input type="text" name="cnpj" size="20" value="<?php echo $row_func[cnpj_cliente] ?>" readonly="true" /></td>
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
		<td width="70%" align="left" class="fontepreta12 style2">Nome do Funcionário</td>
        <td width="30%" align="left" class="fontepreta12 style2">RG</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="nome_func" size="80" value="<?php echo $row_func[nome_func] ?>" required="required"></td>
        <td class="fontepreta12" align="left"><input type="text" name="rg" size="20" value="<?php echo $row_func[rg] ?>"></td>
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
		<td width="50%" align="left" class="fontepreta12 style2">Nível de Tolerância&nbsp;<input type="text" name="nivel_tolerancia" size="20" value="<?php echo $row_func[nivel_tolerancia] ?>" readonly="true" /></td>
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
		if(!empty($aso)){
			$query_aso = "select *
						  from aso_avulso 
						  where cod_aso = ".$aso;							
														
			$result_aso = pg_query($query_aso);
				
			$r_aso = pg_fetch_all($result_aso);
			$rr = explode("|", $r_aso[0]['cod_tipo_risco']);
			count($rr);
				
				for($x=0;$x<count($rr)-1;$x++){
					$temp.=$rr[$x]." OR cod_tipo_risco = ";
				}
				$tf = substr($temp, 0, strlen($temp)-21);

				$query_risco = "select * from tipo_risco where cod_tipo_risco = ".$tf." order by cod_tipo_risco ";
				
				$res_risco = pg_query($query_risco);
				$r_risco = pg_fetch_all($res_risco);
				count($r_risco);
			
			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";
			
				for($y=0;$y<count($r_risco);$y++){
						echo $r_risco[$y]['nome_tipo_risco'];
						echo "<br>";
					}
			echo "	</td>";
			} //Fim da Seleção
		?>
		
		<?php
		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
		if( !empty($aso) ){
			$query_aso = "select *
						  	  from aso_avulso 
						      where cod_aso = ".$aso;
							  
				$result_aso = pg_query($query_aso);
				
				$e_aso = pg_fetch_all($result_aso);
				$ee = explode("|", $e_aso[0]['cod_agente_risco']);
				count($ee);
				
				for($x=0;$x<count($ee)-1;$x++){
					$tipo.=$ee[$x]." OR cod_agente_risco = ";
				}
				$ta = substr($tipo, 0, strlen($tipo)-23);

				$query_agente = "select * from agente_risco where cod_agente_risco = ".$ta." order by cod_tipo_risco";
				
				$esp_agente = pg_query($query_agente);
				$e_agente = pg_fetch_all($esp_agente);
				count($e_agente);

			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";

				for($y=0;$y<count($e_agente);$y++){
						echo $e_agente[$y]['nome_agente_risco'];
						echo "<br>";
					}
			echo "	</td>";
			} //FIM DA SELEÇÃO
		?>
		<?php
		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
		if(!empty($aso)){
			$query_aso = "select *
							  from aso_avulso 
							  where cod_aso = ".$aso;
							  
				$result_aso = pg_query($query_aso);
				
				$exa_aso = pg_fetch_all($result_aso);
				$exa = explode("|", $exa_aso[0]['cod_exame']);
				count($exa);
				
				for($x=0;$x<count($exa)-1;$x++){
					if($exa[$x] != '')
					$exame.=$exa[$x]." OR cod_exame = ";
				}
				$te = substr($exame, 0, strlen($exame)-16);

					echo "<td align=\"left\" >";
				
				if($te != ""){					
					$query_exame = "select * from exame where cod_exame = ".$te;
					$res_exame = pg_query($query_exame);
					$r_exame = pg_fetch_all($res_exame);
					count($r_exame);
						for($y=0;$y<count($r_exame);$y++){
							echo $r_exame[$y]['especialidade'];
							echo "<br>";
						}
												
						echo $exa_aso[0]['outro'];
					}else{
					$query_exame = "select * from aso_avulso where cod_aso = ".$aso;
					$res_exame = pg_query($query_exame);
					$r_exame = pg_fetch_all($res_exame);
					count($r_exame);
					$d = explode(',',$r_exame[0]['outro']);
					
			echo "	<td align=\"left\" class=\"fontepreta12 style1\">";
			echo "<Table border=0 width=100%>";			
				for($x=0;$x<count($d);$x++){
								echo $d[$x]."<br>";
								}}
				echo "</table>";
			echo "	</td>";
			} //Fim da Seleção
		?>
	</tr>
</table>
<?php
$sc = "SELECT *
	   FROM aso_avulso
	   WHERE cod_aso = $aso";
$rsc = pg_query($sc);
$ce = pg_fetch_array($rsc);
?> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td align="left" class="fontepreta12">
		Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e 
		despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, 
		encontra-se <strong><?php echo $ce[resultado] ?></strong> mediante ter sido <?php if($ce[resultado] == 'INAPTO' || $ce[resultado] == 'Inapto' || $ce[resultado] == 'inapto'){ echo 'reprovado'; }else{ echo 'aprovado'; } ?> nos
		exames físicos e mental.
        <br />
        <br />
		<?php
		/*if(pg_num_rows($rsc) == 1 and $ce[cod_exame] == 22){
			echo "Dependendo apenas dos exames complementares acima quando solicitados, para diagnosticação do médico coordenador dos programas de PCMSO - NR7, de responsabilidade do empregador realizá-los e remeter ao médico examinador o(s) original(is), em até o 10º dia útil da avaliação física. Este ASO(atestado de saúde ocupacional) só será válido para efeito de fiscalização e ou judicialmente se acompanhado dos exames complementares sempre que for solicitado pelo médico examinador.";
		}else{
		
		}*/
		?>
		</td>
	</tr>
	<?php
	if(!empty($aso) and !empty($ce[texto_r])){
		echo "<tr><td align=left class=fontepreta12>
				<h4>*{$ce[texto_r]}</h4>
			  </td></tr>";
	}
	?>
	<tr>
		<td align="left" class="fontepreta12"><b>Data de Realização:</b>&nbsp;<?php echo $ce[data]; ?></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<br /><br />
	<tr>
		<td width="50%" align="center" valign="bottom">______________________________________</td>
		<td width="50%" align="center">        
		<?PHP
        if(!$_GET['sem_timbre']){
        	echo '<img src="../../../images/assinatura.png" border="0" />';
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<p>
	<tr>
		<td width="65%" align="center" class="fontepreta12">
		
		<br /><br /><br /><br /><br />
		  <p>Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		    Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		    <br />
		    medicotrab@sesmt-rio.com | www.sesmt-rio.com
		    </p>
	    </td>
		<td width="35%" align="right"><img src="../../../images/logo_novo_sesmt2.png" width="195" height="140" /></td>
	</tr>
</table>
</td>
</tr>
</table>


</body>
</html>