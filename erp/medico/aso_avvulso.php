<?php 
session_start();
include "../config/config.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$act = $_GET['cod_aso'];//variavel de verificação p\ os botões aparecerem somente no INSERT.

if($_GET){
	$aso = $_GET["cod_aso"];
} else {
	$aso = $_POST["cod_aso"];
}

if(empty($cod_aso) || $_POST){
	$query_max = "SELECT max(cod_aso) as cod_aso FROM aso_avulso";

	$result_max = pg_query($query_max) //executa query
		or die ("Erro na busca da tabela aso_avulso. ==> " . pg_last_error($connect)); //mostra erro

	$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
	
	$cod_aso = $row_max[cod_aso] + 1;
}
else if(!empty($cod_aso)){
	$cod_aso = $cod_aso;
} 

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}
//INSERT NA TABELA
if(!empty($aso)  and $_POST[enviar]=="Enviar"){
	// TESTE DE CNPJ
	$tcnpj = str_replace('-', '', $cnpj_cliente);
	$tcnpj = str_replace('/', '', $tcnpj);
	$tcnpj = str_replace('.', '', $tcnpj);
	$sql = "SELECT * FROM cliente
	WHERE replace(replace(replace(cnpj,'-',''), '/',''), '.', '') = '{$tcnpj}'";
	$rt = pg_query($sql);
	$bt = pg_fetch_array($rt);
	$vaiqvai = 0;

//	if (pg_num_rows($rt)>0){
		if($_SESSION['usuario_id']==$bt[contratante] || $_SESSION['grupo']=="funcionario" || $_SESSION['grupo']=="administrador"){
		    $vaiqvai = 1;		
		}else{
		    $vaiqvai = 0;
		}
/*	}else{

	   $vaiqvai = 0;
	}
*/
	//print_r($_SESSION);
if($vaiqvai > 0){	
	$ris = $_POST['risco'];
	$num = count($ris);
	
	for($x=0;$x<$num;$x++){
	$texto .= $ris[$x]."|";
	}

	$especif = $_POST['especifico'];
	$numero = count($especif);
	
	for($y=0;$y<$numero;$y++){
	$texto_especif .= $especif[$y]."|";
	}
	
	$exa = $_POST['exame'];
	$number = count($exa);
	
	for($z=0;$z<$number;$z++){
	$texto_exa .= $exa[$z]."|";
	}
	
	
	$tipo_aso = $_POST['tipo_aso'];
	
	if($tipo_aso == 2){
		$descricao_aso = 'Pagamento aso retroativo do mesmo ano';
		$preco_aso = 50.00;
		$preco_aso2 = 50;
		
		
	}
	else if($tipo_aso == 3){
		$descricao_aso = 'Pagamento aso retroativo de 1 ano';
		$preco_aso = 120.00;
		$preco_aso2 = 120;
		
	}
	else if($tipo_aso == 4){
		$descricao_aso = 'Pagamento aso retroativo de 2 ano';
		$preco_aso = 150.00;
		$preco_aso2 = 150;
		
	}
	else if($tipo_aso == 5){
		$descricao_aso = 'Pagamento aso retroativo de 3 ano';
		$preco_aso = 190.00;
		$preco_aso2 = 190;
		
	}
	else if($tipo_aso == 6){
		$descricao_aso = 'Pagamento aso retroativo de 4 ano';
		$preco_aso = 260.00;
		$preco_aso2 = 260;
		
	}
	else if($tipo_aso == 7){
		$descricao_aso = 'Pagamento aso retroativo de 5 ano';
		$preco_aso = 300.00;
		$preco_aso2 = 300;
		
	}
	else{
		$descricao_aso = 'Pagamento aso avulso';
		$preco_aso = 35.00;
		$preco_aso2 = 35;
		
	}
	
	
	
	//Pegando dia, mes e ano
	
	$datafatura = date('Y-m-d');
	$semana = idate('W');
	$anointeiro = idate('Y');
	
	$dia = date( 'j', strtotime($datafatura) );
	$mes = date( 'n', strtotime($datafatura) );
	$ano = date( 'Y', strtotime($datafatura) );
	
	
	
	$nodoblesql = "SELECT * FROM aso_avulso WHERE cnpj_cliente = '$cnpj_cliente' AND tipo_exame = '$tipo_exame' AND nome_func = '$nome_func' AND data = '$data' ";
	
	$nodoblequery = pg_query($nodoblesql);
	
	$nodoble = pg_num_rows($nodoblequery);
	
	if($nodoble >= 1){
	
	$var = "<script>javascript:history.back(-2)</script>";
	echo $var;
		
	}else{
		
	

	$query_func = "INSERT INTO ASO_AVULSO 
							(cod_aso, razao_social_cliente, endereco_cliente, cep_cliente, cnpj_cliente, cnae,
							grau_risco, tipo_exame, nome_func, num_ctps_func, serie_ctps_func, cbo, nome_funcao,
							dinamica_funcao, nome_atividade, nivel_tolerancia, cod_tipo_risco, cod_agente_risco,
							cod_exame, resultado, outro, texto_r, data, funcionario_id)
						VALUES
							($cod_aso, '$razao_social_cliente', '$endereco_cliente', '$cep_cliente', '$cnpj_cliente', '$cnae',
							'$grau_risco', '$tipo_exame', '$nome_func', '$num_ctps_func', '$serie_ctps_func', '$cbo',
							'$nome_funcao', '$dinamica_funcao', '$nome_atividade', '$nivel_tolerancia', '$texto', '$texto_especif',
							'$texto_exa', '$resultado', '$outro', '$txt', '$data', {$_SESSION['usuario_id']})";
		
	$result_func = pg_query($connect, $query_func) 
			or die ("Erro na query: $query_func ==> ".pg_last_error($connect));
			
			
	//Inserindo na Tabela financeiro_info
			
	$receita1sql = "INSERT INTO financeiro_info (titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ('$razao_social_cliente', $preco_aso, 1, 'Dinheiro', 0, '$datafatura', '$dia', '$mes', '$ano', '$datafatura', '$datafatura', 24, '$descricao_aso', 0, 0)";
	
	$receita1query = pg_query($receita1sql);
	
	
	//Pegando o id da tabela financeiro_info
	
	$cod_faturasql = "SELECT id FROM financeiro_info WHERE titulo = '$razao_social_cliente' ORDER BY id DESC ";
	$cod_faturaquery = pg_query($cod_faturasql);
	$cod_faturaall = pg_fetch_array($cod_faturaquery);
	
	$cod_fatura = $cod_faturaall[id];
	
	
	
	//Inserindo na Tabela financeiro_fatura
	
	$receita2sql = "INSERT INTO financeiro_fatura (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_fatura, '$razao_social_cliente', $preco_aso2, 1, '$datafatura', 0, 1, '$datafatura', '', '')";
	
	$receita2query = pg_query($receita2sql);
		
		
		
	//Inserindo na Tabela financeiro_relatorio
	
	$relatoriosql = "INSERT INTO financeiro_relatorio (cod_fatura, titulo, valor, status, pago, historico, data_lancamento, semana, ano) VALUES ($cod_fatura, '$razao_social_cliente', $preco_aso, 0, 1, '$descricao_aso', '$datafatura', $semana, $anointeiro)";
	
	$fatura_relatorio = pg_query($relatoriosql);
		
		
	
	if($result_func){
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
		$maill = "suporte@sesmt-rio.com;financeiro@sesmt-rio.com";
		$msgg = "Foi feito um ASO avulso, os dados abaixo:<br>";
		$msgg .= "Nome: ".$nome_func."<br>";
		$msgg .= "Empresa: ".$razao_social_cliente."<br>";
		$msgg .= "CNPJ: ".$cnpj_cliente."<br>";
		$msgg .= "Tipo exame: ".$tipo_exame."<br>";
		$msgg .= "Data: ".$data."<br>";
		mail($maill, "Aso Avulso", $msgg, $headers);
		echo '<script> alert("Os dados foram cadastradas com sucesso!");</script>';
	}
		echo "<script>location.href='?cod_aso={$cod_aso}';</script>";
	}}else{
	echo "<script>
				  alert('Este cliente não está cadastrado ou não esta vinculado a seu cadastro.');
				  location.href='lista_aso_avulso.php';
		  </script>";

}

}

/******************** DADOS **********************/
if (!empty($aso)) {	
	
	$query_busca = "SELECT cod_aso, razao_social_cliente, endereco_cliente, cep_cliente, cnpj_cliente, cnae,
						   grau_risco, tipo_exame, nome_func, num_ctps_func, serie_ctps_func, cbo, nome_funcao,
						   dinamica_funcao, nome_atividade, nivel_tolerancia, cod_tipo_risco, resultado, texto_r, data
						   FROM aso_avulso
						   WHERE cod_aso = $aso";
						   
	$result_busca = pg_query($connect, $query_busca) 
			or die ("Erro na query: $query_busca ==> ".pg_last_error($connect));

	$row = pg_fetch_array($result_busca);
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
td{font-size:12px;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif;}
</style>
<script language="javascript" src="../scripts.js"></script>

</head>
<body text="#000000">&nbsp;
<center>
<table border=0 width=760 height="900">
<tr>
<td>
<form action="aso_avulso.php?cod_aso=<?php echo $cod_aso; ?>" name="frm_aso" method="post">
<div align="center">
<?PHP if(!$_GET['sem*timbre']){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50%" align="left"><img src="../img/logo_novo_sesmt.png" width="800" height="135" /></td>
		
	</tr>
</table><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p>
<?PHP
}else{
echo '<table  width="100%" height="180" border="0" cellpadding="0" cellspacing="0">';
echo '	<tr>
		<td width="50%" align="left">
        <p align="center">
        <font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
        &nbsp;
  	    </font>
          &nbsp;</p>&nbsp;
		<p align="center">&nbsp;
        <font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">
        </font>&nbsp;</p>&nbsp;
		 <p align="center" class="style2"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p>
	    		</td>
	</tr>
</table>';
} ?>
</div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
	<td><center><h2 class="style3">ASO - Atestado de Saúde Ocupacional</h2>	
		<h6 class="style3">Conforme NR 7.4.1</h6></center></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="14%" align="left" class="fontepreta12 style5">Nº ASO</td>
		<td width="86%" align="left" class="fontepreta12 style2">Razão Social</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="codaso" size="5" value="<?php if(empty($cod_aso)){coloca_zeros($row_max[cod_aso]);} else {echo coloca_zeros($cod_aso);}?>" readonly="true" ></td>
		<td class="fontepreta12" align="left"><input type="text" name="razao_social_cliente" size="90" value="<?php echo $row[razao_social_cliente]; ?>" ></td>		
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" align="left" class="fontepreta12 style2">End. &nbsp;<input type="text" name="endereco_cliente" size="60" value="<?php echo $row[endereco_cliente] ?>"  /></td>
		<td width="30%" align="left" class="fontepreta12 style2">CEP &nbsp;<input type="text" name="cep_cliente" size="15" value="<?php echo $row[cep_cliente] ?>"  /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="25%" align="left" class="fontepreta12 style2">CNPJ</td>
		<td width="20%" align="left" class="fontepreta12 style2">CNAE</td>
		<td width="20%" align="left" class="fontepreta12 style2">Grau de Risco</td>
		<td width="35%" align="left" class="fontepreta12 style2">Tipo de Exame</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="cnpj_cliente" size="20" value="<?php echo $row[cnpj_cliente] ?>"  /></td>
		<td class="fontepreta12" align="left"><input type="text" name="cnae" size="10" value="<?php echo $row[cnae] ?>"  /></td>
		<td class="fontepreta12" align="left"><input type="text" name="grau_risco"  size="5" value="<?php echo $row[grau_risco] ?>" /></td>
		<td class="fontepreta12" align="left"><input type="text" name="tipo_exame"  size="21" value="<?php echo $row[tipo_exame] ?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Nome do Funcionário</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="nome_func" size="100" value="<?php echo $row[nome_func] ?>"  /></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td width="15%" align="left" class="fontepreta12 style2">CTPS &nbsp;<input type="text" name="num_ctps_func" size="5" value="<?php echo $row[num_ctps_func] ?>"  /></td>
		<td width="15%" align="left" class="fontepreta12 style2">Série &nbsp;<input type="text" name="serie_ctps_func" size="5" value="<?php echo $row[serie_ctps_func] ?>"  /></td>
		<td width="15%" align="left" class="fontepreta12 style2">CBO &nbsp;<input type="text" name="cbo" size="5" value="<?php echo $row[cbo] ?>"  /></td>
		<td width="65%" align="left" class="fontepreta12 style2">Função &nbsp;<input type="text" name="nome_funcao" size="50" value="<?php echo $row[nome_funcao] ?>"  /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Atividade Laborativa&nbsp;<input type="text" name="dinamica_funcao" size="95" value="<?php echo $row[dinamica_funcao] ?>"  /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="50%" align="left" class="fontepreta12 style2">Classificação da Atividade&nbsp;<input type="text" name="nome_atividade" size="20" value="<?php echo $row[nome_atividade] ?>"  /></td>
		<td width="50%" align="left" class="fontepreta12 style2">Nível de Tolerância&nbsp;<input type="text" name="nivel_tolerancia" size="20" value="<?php echo $row[nivel_tolerancia] ?>"  /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="1" cellspacing="1" bordercolor="#000000">
	<tr>
		<td width="14%" align="left" class="fontepreta12 style2" bgcolor="#999999">Riscos da Função</td>
		<td width="46%" align="left" class="fontepreta12 style2" bgcolor="#999999">Especificar Riscos da Função</td>
		<td width="40%" align="left" class="fontepreta12 style2" bgcolor="#999999">Exames Realizados</td>
	</tr>
	<tr>
		<?php
		if($act == ""){
		// pra buscar os dados do Tipo de Risco 
		$query_risco = "select cod_tipo_risco, nome_tipo_risco from tipo_risco order by cod_tipo_risco";
		$result_risco = pg_query($connect, $query_risco) 
			or die ("Erro na query: $query_risco ==> ".pg_last_error($connect));
		?>
		 <td align="left" ><select name = "risco[]" multiple="multiple" style="width:100px" size="5">
           <?php
			while($row_risco = pg_fetch_array($result_risco))
  			{
			echo "<option value=$row_risco[cod_tipo_risco]>$row_risco[nome_tipo_risco]</option>";
  			}
		?>
         </select></td>
		
		<?php
		// pra buscar os dados do Tipo de Riscos Especificos
		$query_espec = "select cod_agente_risco, nome_agente_risco from agente_risco order by cod_tipo_risco";
		$result_espec = pg_query($connect, $query_espec) 
			or die ("Erro na query: $query_espec ==> ".pg_last_error($connect));
		?>
		 <td align="left">
		<select name = "especifico[]" multiple="multiple" style="width:345px" size="5">
		<?php
			while($row_espec = pg_fetch_array($result_espec))
  			{
			echo "<option value=$row_espec[cod_agente_risco]>$row_espec[nome_agente_risco]</option>";
  			}
		?>
		</select>		</td>
		
		<?php
		// pra buscar os dados dos Exames Realizados
		$query_exame = "select cod_exame, especialidade from exame order by cod_exame";
		$result_exame = pg_query($connect, $query_exame) 
			or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));
		
		?>
		 <td align="left">
		<select name = "exame[]" id="exame[]" multiple="multiple" style="width:210px" size="5" onclick="tExame();">
		<?php
			while($row_exame = pg_fetch_array($result_exame))
  			{
			echo "<option value=$row_exame[cod_exame]>$row_exame[especialidade]</option>";
  			}
  			echo "<option value=''>OUTROS</option>";
		?>
		</select>
		<div id="auxi"></div>
		<?php
			}else{
/*****************************RISCOS****************************/
			$query_aso = "select *
						  from aso_avulso 
						  where cod_aso = ".$act;							
														
			$result_aso = pg_query($connect, $query_aso) 
				or die ("Erro na query: $query_aso ==> ".pg_last_error($connect));
				
			$r_aso = pg_fetch_all($result_aso);
			$rr = explode("|", $r_aso[0]['cod_tipo_risco']);
			count($rr);
				
				for($x=0;$x<count($rr)-1;$x++){
					$temp.=$rr[$x]." OR cod_tipo_risco = ";
				}
				$tf = substr($temp, 0, strlen($temp)-21);

				$query_risco = "select * from tipo_risco where cod_tipo_risco = ".$tf." order by cod_tipo_risco ";
				
				$res_risco = pg_query($connect, $query_risco);
				$r_risco = pg_fetch_all($res_risco);
				count($r_risco);
				echo "<td align=\"left\" bgcolor=\"#CCCCCC\">";
					for($y=0;$y<count($r_risco);$y++){
						echo $r_risco[$y]['nome_tipo_risco'];
						echo "<br>";
					}
					echo "</td>";
/******************ESPECIFICO***********************/
				$query_aso = "select *
						  	  from aso_avulso 
						      where cod_aso = ".$act;
							  
				$result_aso = pg_query($connect, $query_aso) 
					or die ("Erro na query: $query_aso ==> ".pg_last_error($connect));
				
				$e_aso = pg_fetch_all($result_aso);
				$ee = explode("|", $e_aso[0]['cod_agente_risco']);
				count($ee);
				
				for($x=0;$x<count($ee)-1;$x++){
					$tipo.=$ee[$x]." OR cod_agente_risco = ";
				}
				$ta = substr($tipo, 0, strlen($tipo)-23);

				$query_agente = "select * from agente_risco where cod_agente_risco = ".$ta." order by cod_tipo_risco";
				
				$esp_agente = pg_query($connect, $query_agente);
				$e_agente = pg_fetch_all($esp_agente);
				count($e_agente);
				echo "<td align=\"left\" bgcolor=\"#CCCCCC\">";
					for($y=0;$y<count($e_agente);$y++){
						echo $e_agente[$y]['nome_agente_risco'];
						echo "<br>";
					}	
					echo "</td>";
/***************************EXAMES****************************/												
				$query_aso = "select *
							  from aso_avulso 
							  where cod_aso = ".$act;
							  
				$result_aso = pg_query($connect, $query_aso) 
					or die ("Erro na query: $query_aso ==> ".pg_last_error($connect));
				
				$exa_aso = pg_fetch_all($result_aso);
				$exa = explode("|", $exa_aso[0]['cod_exame']);
				count($exa);
				
				for($x=0;$x<count($exa)-1;$x++){
					if($exa[$x] != '')
					$exame.=$exa[$x]." OR cod_exame = ";
				}
				$te = substr($exame, 0, strlen($exame)-16);

					echo "<td align=\"left\" bgcolor=\"#CCCCCC\">";
				
				if($te != ""){					
					$query_exame = "select * from exame where cod_exame = ".$te;
					$res_exame = pg_query($connect, $query_exame);
					$r_exame = pg_fetch_all($res_exame);
					count($r_exame);
						for($y=0;$y<count($r_exame);$y++){
							echo $r_exame[$y]['especialidade'];
							echo "<br>";
						}
												
						echo $exa_aso[0]['outro'];
					}else{
					$query_exame = "select * from aso_avulso where cod_aso = ".$act;
					$res_exame = pg_query($connect, $query_exame);
					$r_exame = pg_fetch_all($res_exame);
					count($r_exame);
					
							$d = explode(',',$r_exame[0]['outro']);
							for($x=0;$x<count($d);$x++){
								echo $d[$x]."<br>";
								}
						echo "";
				}	
						echo "</td>";
			}
		?>		</td>
	</tr>
	<tr>
		<th colspan="3">
		<?PHP
		if($act == ""){
			echo '<input type="submit" name="enviar" value="Enviar" style="width:100;" onClick="return Check();">&nbsp;&nbsp;&nbsp;';
			echo "<input name=\"btn1\" type=\"submit\" onClick=\"MM_goToURL('parent','../medico/lista_aso_avulso.php'); return document.MM_returnValue\" value=\"Sair\" style=\"width:100;\">";
		}else{
			
		}	
		?>		</th>
	</tr>
</table>
</div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td align="left" class="fontepreta14 style2">
		Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e 
		despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, 
		encontra-se
		<?PHP
		if($act == ""){
		echo "<select name=\"resultado\" id=\"resultado\" onchange=\"fdp();\">
		<option value=\"__________\" <?php if($row[resultado]==\"nenhum\"){echo \"selected\";} ?>__________</option>
		<option value=\"APTO\" <?php if($row[resultado]==\"apto\"){echo \"selected\";} ?>Apto</option>
		<option value=\"APTO à Manipular Alimentos\" <?php if($row[resultado]==\"alimento\"){echo \"selected\";} ?>Apto à Manipular Alimentos</option>
		<option value=\"INAPTO\" <?php if($row[resultado]==\"inapto\"){echo \"selected\";} ?>Inapto</option>
		<option value=\"Apto para trabalhar em altura\" <?php if($row[resultado]==\"altura\"){echo \"selected\";} ?>Apto para Trabalhar em Altura</option>
		<option value=\"Apto para operar empilhadeira\" <?php if($row[resultado]==\"empilhadeira\"){echo \"selected\";} ?>Apto para Operar Empilhadeira</option>
		<option value=\"Apto para trabalhar em espaço confinado\" <?php if($row[resultado]==\"confinado\"){echo \"selected\";} ?>Apto para Trabalhar em Espaço Confinado</option>
		<option value=\"* APTO COM RESTRIÇÃO\" <?php if($row[resultado]==\"restrincao\"){echo \"selected\";} ?>* Apto com Restrição</option>
		</select>";
		}else{
			echo "<strong>".$row[resultado]."</strong>"; 
		}	
		echo "<input type=hidden value='' name=txt id=txt>";
		?> mediante ter sido aprovado nos
		exames físicos e psicológicos.
		
		</td>
	</tr>
</table></div>
<?php
echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	  	<td align=\"center\" id=\"zxc\"></td>
	  </table>";
	  
	  if(!empty($aso) and !empty($row[texto_r])){
	  	$qry_bus = "SELECT texto_r FROM aso_avulso WHERE cod_aso = $aso";
		$resul = pg_query($connect, $qry_bus) or die
			("Erro na busca! ==>".pg_last_error($connect));
		$row_r = pg_fetch_array($resul);
	  
	  echo "<br>";
	  echo "* Restrição: ".$row_r[texto_r]."<p>";
	  }else{
	  	echo "";
	}
	
	 echo "<input type=hidden name=abc id=abc value='".$row_r[texto_r]."'>";
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
<td width="100%" align="left" class="fontepreta12 style2">Data&nbsp;<input type="text" name="data" size="10" value="<?php echo $row[data] ?>"  /></td>
</tr>
<?php
if($act == ""){
?>

<tr>
<td width="100%" align="left" class="fontepreta12 style2">Tipo de ASO&nbsp;
<select name="tipo_aso">
<option value="1">Comercial</option>
<option value="2">Retroativo mesmo ano</option>
<option value="3">Retroativo 1 ano</option>
<option value="4">Retroativo 2 ano</option>
<option value="5">Retroativo 3 ano</option>
<option value="6">Retroativo 4 ano</option>
<option value="7">Retroativo 5 ano</option>
</select>
</td>
</tr>


<?php
}
?>
</table>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<br />
	<tr>
		<td align="center" width="380"><br /><br />___________________________________</td>
		<td align="center" width="380">
        <?PHP
        if(!$_GET['sem_timbre']){
        echo '<img src="../img/assinatura.png" border="0" />';
        }else{
		echo "<br /><br />___________________________________";
		}
        
        ?>
        </td>
	</tr>
	<tr>
		<th class="fontepreta12 style2" width="380">Assinatura do Examinado</th>
		<!--<th class="fontepreta12 style2" width="380">Assinatura do Examinador<br>Maria de Lourdes F. Magalhães<br>CRMEJ 52.33.471-0<br>Reg. MTE 13.320</th>-->
	</tr>
</table></div>
<div align="center">
<?PHP if(!$_GET['sem*timbre']){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="65%" align="center" class="fontepreta12 style2">
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
		  <p>Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		    Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		    <br />
		    medicotrab@sesmt-rio.com | www.sesmt-rio.com
		    </p></td>
		<td width="35%" align="right"><img src="../img/logo_novo_sesmt2.png" width="195" height="140" /></td>
	</tr>
</table>
<?PHP
}else{
echo '<br /><br /><br /><br /><br /><br /><br /><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="65%" align="center" class="fontepreta12 style2">
		  Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		  <br />
          medicotrab@sesmt-rio.com | www.sesmt-rio.com
	    </td>
		<td width="35%" align="right" width=280 height=1>&nbsp;</td>
	</tr>
</table>';

}?>
</div>
</form>
</td>
</tr>
</table>
</body>
</html>
