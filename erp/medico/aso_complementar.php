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

if(empty($_GET[cod_aso]) || $_POST){
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
	
	if($result_func){
		echo '<script> alert("Os dados foram cadastradas com sucesso!");</script>';
	}
		echo "<script>location.href='?cod_aso={$cod_aso}';</script>";
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
<form action="aso_complementar.php?cod_aso=<?php echo $cod_aso; ?>" name="frm_aso" method="post">
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
<div align="left">CNPJ:04.722.248/0001-17</div>
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
		<td class="fontepreta12" align="left"><input type="text" name="codaso" size="5" value="<?php if(empty($cod_aso)){coloca_zeros($cod_aso);} else {echo coloca_zeros($cod_aso);}?>" ></td>
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
		$query_espec = "select cod_agente_risco, nome_agente_risco from agente_risco order by cod_agente_risco";
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

				$query_risco = "select * from tipo_risco where cod_tipo_risco = ".$tf;
				
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

				$query_agente = "select * from agente_risco where cod_agente_risco = ".$ta;
				
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
			echo "<input name=\"btn1\" type=\"submit\" onClick=\"MM_goToURL('parent','../medico/lista_aso_complementar.php'); return document.MM_returnValue\" value=\"Sair\" style=\"width:100;\">";
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
		<td align="justify" class="fontepreta14 style2">
		Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e 
		despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, 
		encontra-se
		<?PHP
		if($act == ""){
		echo "<select name=\"resultado\" id=\"resultado\" onchange=\"fdp();\">
		<option value=\"____________\" <?php if($row[resultado]==\"nenhum\"){echo \"selected\";} ?>____________</option>
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
		?> mediante ter sido aprovado nos exames físicos e psicológicos. Dependendo apenas dos exames 
		complementares acima quando solicitados, para diagnosticação do médico coordenador dos programas 
		de PCMSO - NR7, de responsabilidade do empregador realizá-los e remeter ao médico examinador o(s) 
		original(is), em até o 10º dia útil da avaliação física. Este ASO(atestado de saúde ocupacional) 
		só será válido para efeito de fiscalização e ou judicialmente se acompanhado dos exames 
		complementares sempre que for solicitado pelo médico examinador.
		
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
</table>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<br /><br />
	<tr>
		<td align="center" width="380"><br /><br /><br />___________________________________</td>
		<td align="center" width="380"><br /><br /><br />___________________________________</td>
		<!--td align="center" width="380"><img src="../img/assinatura.png" border="0" /></td-->
	</tr>
	<tr>
		<th class="fontepreta12 style2" width="380">Assinatura do Examinado</th>
		<th class="fontepreta12 style2" width="380">Assinatura do Examinador</th>
	</tr>
</table></div>
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
</form>
</td>
</tr>
</table>
</body>
</html>