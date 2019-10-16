<?php

include "sessao.php";
include "../config/connect.php";


if($_GET){
	$cliente = $_GET["cliente"];
	  $setor = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	  $setor = $_POST["setor"];
}

if( $_POST["btn_enviar"]=="Gravar"){ // IF 1

	if(!empty($_POST["cliente"]) & !empty($_POST["setor"]) ){ // IF 2

		$cliente 		= $_POST["cliente"];
		$setor 			= $_POST["setor"];
		$cod_luz_nat 	= $_POST["cod_luz_nat"];
		$cod_luz_art 	= $_POST["cod_luz_art"];
		$cod_vent_nat 	= $_POST["cod_vent_nat"];
		$cod_vent_art 	= $_POST["cod_vent_art"];
		$cod_edificacao = $_POST["cod_edificacao"];
		$cod_piso 		= $_POST["cod_piso"];
		$cod_parede 	= $_POST["cod_parede"];
		$cod_cobertura 	= $_POST["cod_cobertura"];

		$sql = "UPDATE cliente_setor
				SET cod_luz_nat            = $cod_luz_nat
					, cod_luz_art          = $cod_luz_art
					, cod_vent_nat         = $cod_vent_nat
					, cod_vent_art         = $cod_vent_art
					, cod_edificacao       = $cod_edificacao
					, cod_piso             = $cod_piso
					, cod_parede           = $cod_parede
					, cod_cobertura        = $cod_cobertura
				WHERE cod_cliente          = $cliente and cod_setor = $setor";

		$result = pg_query($connect, $sql)
			or die ("Erro na query: $sql ==> " . pg_last_error($connect) );
	
		if ($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!');</script>;";
			
			header("location: http://localhost/erp/producao/cad_func.php?cliente=$cliente&setor=$setor");
		}

	} // IF 2
	else{
		//header("location: http://$dominio/erp/producao/ppra1.php?erro=1");
	} // IF 2
	
}// IF 1

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/

if(!empty($_GET[cliente]) & !empty($_GET[setor]) ){

	$query_cli = "SELECT cliente_id, razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = {$_GET[cliente]}";
	$result_cli = pg_query($connect, $query_cli) 
	or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
}

?>
<html>
<head>
<title> PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra2" method="post" action="ppra2.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
		<th colspan="2" bgcolor="#009966" align="left">
			<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS
            <br> 
            <br>
			&nbsp;&nbsp;&nbsp; COLETA DE DADOS DAS 
			 CARACTERÍSTICAS FÍSICAS DO SETOR <br>
			 &nbsp;
		</th>
    </tr>
	<?php
	if($result_cli){

		$row_cli = pg_fetch_array($result_cli);
		echo "<tr>
				<td colspan=2 bgcolor=#FFFFFF>
					<br><font color=black>
					&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social]</b> <br>
					&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco]</b> <br>
					&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro]</b> <br>
					&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone]</b> <br>
					&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> <br>&nbsp;
				</td>
			</tr>";

	}
	?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="300"><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Ventilação Natural:</span></b><br>
		&nbsp;
      </td>
		<td width="500"> &nbsp;&nbsp;&nbsp;
			<select name="cod_vent_nat">
			<?php
			
			$query_nat = "SELECT cod_vent_nat, nome_vent_nat, substr(decricao_vent_nat, 1, 60) as decricao_vent_nat
						  FROM ventilacao_natural order by nome_vent_nat";
			
			$result_nat = pg_query($connect, $query_nat) 
			or die ("Erro na query: $query_nat ==> " . pg_last_error($connect) );
			
			while($row_nat = pg_fetch_array($result_nat)){
	
				echo "<option value=\"$row_nat[cod_vent_nat]\">" . ucwords(strtolower($row_nat[decricao_vent_nat])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;<span class="style2">&nbsp;Ventilação Artificial:</span></b><span class="style2"><br>
		  &nbsp;</span></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_vent_art">
			<?php
			
			$query_art = "SELECT cod_vent_art, nome_vent_art, substr(decricao_vent_art, 1, 60) as decricao_vent_art 
						  FROM ventilacao_artificial";
			
			$result_art = pg_query($connect, $query_art) 
			or die ("Erro na query: $query_art ==> " . pg_last_error($connect) );
			
			while($row_art = pg_fetch_array($result_art)){
	
				echo "<option value=\"$row_art[cod_vent_art]\">" . ucwords(strtolower($row_art[decricao_vent_art])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Iluminação Natural:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_luz_nat">
			<?php
			
			$query_luz_nat = "SELECT cod_luz_nat, nome_luz_nat, substr(descricao_luz_nat, 1, 60) as descricao_luz_nat 
							  FROM luz_natural order by nome_luz_nat";
			
			$result_luz_nat = pg_query($connect, $query_luz_nat) 
			or die ("Erro na query: $query_luz_nat ==> " . pg_last_error($connect) );
			
			while($row_luz_nat = pg_fetch_array($result_luz_nat)){
	
				echo "<option value=\"$row_luz_nat[cod_luz_nat]\">" . ucwords(strtolower( $row_luz_nat[descricao_luz_nat])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Iluminação Artficial:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_luz_art">
			<?php
			
			$query_luz_art = "SELECT cod_luz_art, nome_luz_art,  substr(decricao_luz_art, 1, 60) as decricao_luz_art
							  FROM luz_artificial order by nome_luz_art";
			
			$result_luz_art = pg_query($connect, $query_luz_art) 
			or die ("Erro na query: $query_luz_art ==> " . pg_last_error($connect) );
			
			while($row_luz_art = pg_fetch_array($result_luz_art)){
	
				echo "<option value=\"$row_luz_art[cod_luz_art]\">" . ucwords(strtolower($row_luz_art[decricao_luz_art])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Tipo de Edificação:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_edificacao">
			<?php
			
			$query_edi = "SELECT cod_edificacao, nome_edificacao, substr(descicao_edificacao, 1, 60) as  descicao_edificacao
							  FROM edificacao order by descicao_edificacao";
			
			$result_edi = pg_query($connect, $query_edi) 
			or die ("Erro na query: $query_edi ==> " . pg_last_error($connect) );
			
			while($row_edi = pg_fetch_array($result_edi)){
	
				echo "<option value=\"$row_edi[cod_edificacao]\">" . ucwords(strtolower($row_edi[descicao_edificacao])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Tipo de Piso:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_piso">
			<?php
			
			$query_piso = "SELECT cod_piso,  nome_piso, substr(descricao_piso, 1, 60) as descricao_piso
						  FROM piso order by nome_piso";
			
			$result_piso = pg_query($connect, $query_piso) 
			or die ("Erro na query: $query_piso ==> " . pg_last_error($connect) );
			
			while($row_piso = pg_fetch_array($result_piso)){
	
				echo "<option value=\"$row_piso[cod_piso]\">" . ucwords(strtolower($row_piso[descricao_piso])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Tipo de Parede:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_parede">
			<?php
			
			$query_parede = "SELECT cod_parede, nome_parede, substr(decicao_parede, 1, 60) as decicao_parede
						  FROM parede order by nome_parede";
			
			$result_parede = pg_query($connect, $query_parede) 
			or die ("Erro na query: $query_parede ==> " . pg_last_error($connect) );
			
			while($row_parede = pg_fetch_array($result_parede)){
	
				echo "<option value=\"$row_parede[cod_parede]\">" . ucwords(strtolower($row_parede[decicao_parede])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style2">Tipo de Cobertura:</span></b><br>
	  &nbsp;</td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_cobertura">
			<?php
			
			$query_cob = "SELECT cod_cobertura, nome_cobertura, substr(decicao_cobertura, 1, 60) as decicao_cobertura
						  FROM cobertura order by nome_cobertura";
			
			$result_cob = pg_query($connect, $query_cob) 
			or die ("Erro na query: $query_cob ==> " . pg_last_error($connect) );
			
			while($row_cob = pg_fetch_array($result_cob)){
	
				echo "<option value=\"$row_cob[cod_cobertura]\">" . ucwords(strtolower($row_cob[decicao_cobertura])) . "</option>";
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
			<input type="submit" name="btn_enviar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente ?>">
			<input type="hidden" name="setor" value="<?php echo $setor ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>