<?php
include "../sessao.php";
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
		$ruido	 		= $_POST["ruido"];
		$hora 			= $_POST["hora_avaliacao"];
		$termico		= $_POST["termico"];
		$lux			= $_POST["lux"];
		$metragem		= $_POST["metragem"];
		$lux_atual		= $_POST["lux_atual"];
		$lux_recomendado= $_POST["lux_recomendado"];

		/***

			Estes tratamentos são para substituir a vírgula por ponto pq este é o separador decimal do banco.

			Ex.: "22,2" passa a ser "22.2"

		***/

		if( empty($_POST["ruido_fundo_setor"]) ){

			$ruido_fundo_setor = 0;

		}

		else{

			$ruido_fundo_setor = str_replace(",",".",$_POST["ruido_fundo_setor"]);

		}

		if( empty($_POST["ruido_operacao_setor"]) ){

			$ruido_operacao_setor = 0;

		}

		else{

			$ruido_operacao_setor = str_replace(",",".",$_POST["ruido_operacao_setor"]);

		}

		if( empty($_POST["data_avaliacao"]) ){

			$data = "null";

		}

		else{

			$data = "'$_POST[data_avaliacao]'";// substr($_POST[data_avaliacao],8,2) . "/" . substr($_POST[data_avaliacao],5,2) . "/" . substr($_POST[data_avaliacao],0,4) ;

		}

		if( empty($_POST["temperatura"]) ){

			$temperatura = 0;

		}

		else{

			$temperatura = str_replace(",",".",$_POST["temperatura"]);

		}

		if( empty($_POST["umidade"]) ){

			$umidade = 0;

		}

		else{

			$umidade = str_replace(",",".",$_POST["umidade"]);

		}

		if( empty($_POST["pavimentos"]) ){

			$pavimentos = 0;

		}

		else{

			$pavimentos = str_replace(",",".",$_POST["pavimentos"]);

		}

		if( empty($_POST["altura"]) ){

			$altura = 0;

		}

		else{

			$altura = str_replace(",",".",$_POST["altura"]);

		}

		if( empty($_POST["frente"]) ){

			$frente = 0;

		}

		else{

			$frente = str_replace(",",".",$_POST["frente"]);

		}

		if( empty($_POST["comprimento"]) ){

			$comprimento = 0;

		}

		else{

			$comprimento = str_replace(",",".",$_POST["comprimento"]);

		}

		$sql = "UPDATE cliente_setor

				SET temperatura          = $temperatura

					, umidade              = $umidade
					, pavimentos           = $pavimentos
					, altura               = $altura
					, termico			   = $termico
					, metragem			   = $metragem
					, lux				   = $lux
					, lux_atual			   = $lux_atual
					, lux_recomendado	   = $lux_recomendado
					, frente               = $frente
					, comprimento          = $comprimento
					, ruido			       = '$ruido'
					, data_avaliacao	   = $data
					, hora_avaliacao       = '$hora'
					, ruido_fundo_setor    = $ruido_fundo_setor
					, ruido_operacao_setor = $ruido_operacao_setor

				WHERE cod_cliente          = $cliente and cod_setor = $setor";

		$result = pg_query($connect, $sql)
			or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

		if ($result){

			echo "<script>alert('Dados do Setor cadastrado com sucesso!');</script>;";

			header("location: http://$dominio/erp/producao/ppra3.php?cliente=$cliente&setor=$setor");

		}
	} // IF 2

	else{

		//header("location: http://$dominio/erp/producao/ppra1.php?erro=1");

	} // IF 2
}// IF 1

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/

if(!empty($_GET[cliente]) & !empty($_GET[setor]) ){

	$query_cli = "SELECT razao_social_cliente, bairro_cliente, telefone_cliente, email, endereco_cliente
				  FROM clientes where cod_cliente = $cliente";

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
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;}
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra2" method="post" action="ppra2_equip.php">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">

    <tr>

		<th bgcolor="#009966" align="left">

			<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS
            <br> 
            <br>
			&nbsp;&nbsp;&nbsp;COLETA DE DADOS DAS CARACTERÍSTICAS FÍSICAS DO SETOR <br>
			 &nbsp;
		</th>
    </tr>

	<?php

	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);

		echo "<tr>

				<td bgcolor=#FFFFFF>
					<br><font color=black>
					&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> <br>&nbsp;
				</td>
			</tr>";
		}
	?>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="150" class="style2" align="right"><b><br>Temperatura (ºC):&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="temperatura" size="5" maxlength="6"></td>
			<td width="150" class="style2" align="right"><b><br>Umidade:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="umidade" size="5" maxlength="6"></td>
			<td width="100" align="right" class="style1"><br><strong>Aparelho: &nbsp;<br>&nbsp;</strong></td>
			<td width="140">&nbsp;<select name="termico">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 1
								   order by nome_aparelho";
					
				$result_status = pg_query($connect, $sql_status) 
					or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
				while ( $row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> &nbsp;&nbsp;&nbsp; " . $row_status[nome_aparelho] . "</option>";
				}
			?>
			</select> 
		  	</td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="100" class="style2" align="right"><b><br>Pé Direito:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="altura" size="5" maxlength="6"></td>
			<td width="100" class="style2" align="right"><b><br>Nº Pav.:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="pavimentos" size="5" maxlength="6"></td>
			<td width="30" class="style2" align="right"><b><br>Frente:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="frente" size="5" maxlength="6"></td>
			<td width="30" class="style2" align="right"><b><br>Comp.:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="comprimento" size="5" maxlength="6"></td>
			<td width="30" align="right" class="style1"><br><strong>Aparelho:&nbsp;<br>&nbsp;</strong></td>
			<td width="140">&nbsp;<select name="metragem">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 2
								   order by nome_aparelho";
					
				$result_status = pg_query($connect, $sql_status) 
					or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
				
				while ( $row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> &nbsp;&nbsp;&nbsp; " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
		  </td>

		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="150" class="style2" align="right"><b><br>Luz Atual:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="lux_atual" size="5" maxlength="6"></td>
			<td width="150" class="style2" align="right"><b><br>Recomendado:&nbsp;</b><br>&nbsp;</td>
			<td width="70">&nbsp;<input type="text" name="lux_recomendado" size="5" maxlength="6"></td>
			<td width="80" align="right" class="style1"><br><strong>Aparelho:&nbsp;<br>&nbsp;</strong></td>
			<td width="140">&nbsp;<select name="lux">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 4
								   order by nome_aparelho";
					
				$result_status = pg_query($connect, $sql_status) 
					or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
				
				while ( $row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> &nbsp;&nbsp;&nbsp; " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
			</td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="150" class="style2" align="right"><br><b>Ruído de Fundo: &nbsp;<br>&nbsp;</b></td>
			<td width="70">&nbsp;<input type="text" name="ruido_fundo_setor" size="5" maxlength="6" ></td>
			<td width="150" class="style2" align="right"><br><strong>Ruído de Operação: &nbsp;<br>&nbsp;</strong></td>
			<td width="70">&nbsp;<input type="text" name="ruido_operacao_setor" size="5" maxlength="6" ></td>
			<td width="100" align="right" class="style1"><br><strong>Aparelho: &nbsp;<br>&nbsp;</strong></td>
			<td width="140">&nbsp;<select name="ruido">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 3
								   order by nome_aparelho";
					
				$result_status = pg_query($connect, $sql_status) 
					or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
				
				while ( $row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> &nbsp;&nbsp;&nbsp; " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
		  </td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="150" class="style2" align="right"><br><strong>Data da Avaliação: &nbsp;<br>&nbsp;</strong></td>
			<td width="250">&nbsp; <input type="text" name="data_avaliacao" size="10" title="ano-mês-dia" > &nbsp;DD-MM-AAAA</td>
			<td width="150" class="style2" align="right"><br><strong>Hora da Avaliação: &nbsp;<br>&nbsp;</strong></td>
			<td width="150">&nbsp; <input type="text" name="hora_avaliacao" size="10" title="hh:mm:ss"  > </td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="center" colspan="2">

			<br>&nbsp;
			<input type="submit" name="btn_enviar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','cad_func.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente ?>">
			<input type="hidden" name="setor" value="<?php echo $setor ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>