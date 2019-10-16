<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "../sessao.php";

if($_GET["alteracao"]=="ok"){
	echo "<script>alert('Risco do PPRA alterado com sucesso!');</script>";
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
	$agente_risco = $_GET["agente_risco"]; 
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
	$agente_risco = $_POST["agente_risco"];
}

/* IDENTIFICA SE O USUÁRIO QUE CONTINUAR INSERINDO DADOS OU PARAR */
$alterar = $_POST["btn_alterar"]; // ALTERAR
$concluir = $_POST["btn_concluir"]; // PÁRA

/*************** ESTE PEDAÇO É SÓ PRA TRAZER O NOME DO CLIENTE **********************/
if( !empty($cliente) & !empty($setor) ){

	$query_cli = "SELECT c.razao_social_cliente
					, c.bairro_cliente
					, c.telefone_cliente
					, c.email
					, c.endereco_cliente
					, s.nome_setor
					, s.desc_setor
				  FROM clientes c, setor s, cliente_setor cs
				  where cs.cod_cliente = c.cod_cliente
					  and cs.cod_setor = s.cod_setor
					  and cs.cod_cliente = $cliente
					  and cs.cod_setor = $setor";
	$result_cli = pg_query($connect, $query_cli)
		or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
}
/******************* FIM PEDAÇO PRA TRAZER O NOME DO CLIENTE ***************************/

/*********************** Exclusão **********************/
if ($_POST["btn_excluir"] == "Excluir"){

	if(isset($_POST["risco_agente"])) // verifica se tem produtos selecionados
	{
		foreach($_POST["risco_agente"] as $risco_agente) // recebe a lista de produtos
		{
			// monta o insert no banco
			$excluir = $excluir . "delete from risco_setor 
								   where cod_cliente = $cliente 
								   and cod_setor = $setor 
								   and cod_agente_risco = $risco_agente;";
		}

		$result_excluir = pg_query($connect, $excluir)
			or die ("Erro na query: $excluir ==> " . pg_last_error($connect) );

		if ($result_excluir) { // se os inserts foram corretos
			echo '<script> alert("Agentes de Risco excluirdos com sucesso!");</script>';
//			header("location: http://www.sesmt-rio.com/erp/producao/ppra4.php?cliente=$cliente&setor=$setor");

		}
	}
}
/*********************** FIM Exclusão **********************/

if($alterar == "Alterar"){ //ALTERAR

//     $descricao_risco = $_POST["descricao_risco"];
	  $fonte_geradora = $_POST["fonte_geradora"];
//	        $sugestao = $_POST["sugestao"];
//	$medida_predentiva_existente = $_POST["medida_predentiva_existente"];

	$sql = "UPDATE risco_setor
			   SET fonte_geradora = '$fonte_geradora'
			 WHERE cod_cliente = $cliente
			 and cod_setor = $setor
			 and cod_agente_risco = $agente_risco;";
		
	$result = pg_query($connect, $sql) 
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );
	
	if($result){
		echo "<script>alert('Risco do Setor alterado com sucesso!');</script>";
		header("location: http://$dominio/erp/producao/ppra3_alt.php?cliente=$cliente&setor=$setor&alteracao=ok");
	}
}

if($continuar == "Mais"){ //CONTINUA

	$cod_agente_risco = $_POST["cod_agente_risco"];
     $descricao_risco = $_POST["descricao_risco"];
	  $fonte_geradora = $_POST["fonte_geradora"];
	        $sugestao = $_POST["sugestao"];
	$medida_predentiva_existente = $_POST["medida_predentiva_existente"];

	$sql = "INSERT INTO risco_setor(
            cod_cliente
			, cod_setor
			, cod_agente_risco
			, fonte_geradora)
    VALUES ($cliente
			, $setor
			, $cod_agente_risco
			, '$fonte_geradora')";
		
	$result = pg_query($connect, $sql) 
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );
	
	if($result){
		echo "<script>alert('Risco do Setor cadastrado com sucesso!');</script>";
		$sql = "";
		$cod_agente_risco = "";
		$descricao_risco = "";
		$fonte_geradora = "";
		$medida_predentiva_existente = "";
		$sugestao = "";
	}
}

?>
<html>
<head>
<title>PPRA - parte III</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="post" action="ppra3_alt.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
<th colspan="2" bgcolor="#009966" ><p align="left">
	<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIA&Ccedil;&Otilde;ES AMBIENTAIS<br>
	<br>
	&nbsp;&nbsp; COLETA DE DADOS DA EXPOSI&Ccedil;&Atilde;O DO TRABALHADOR AOS AGENTES:<br>
	<br> <center>IDENTIFICA&Ccedil;&Atilde;O QUALITATIVA AGENTE NOCIVO <br>&nbsp;</center></th>
</tr>
	<?php
	if($result_cli){

		$row_cli = pg_fetch_array($result_cli);

		echo "<tr>
				<td colspan=2 bgcolor=#FFFFFF>
					<br><font color=black> 
					&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone_cliente]</b> <br>
					&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> <p>
					 
					&nbsp;&nbsp;&nbsp; Nome do Setor: <b>$row_cli[nome_setor]</b> <br>
					&nbsp;&nbsp;&nbsp; Descrição do Setor: <b>$row_cli[desc_setor]</b> <br>&nbsp;
				</td>
			</tr>";
	}
	?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>

	<?php
	  if( !empty($cliente) and !empty($setor) ){
	  
			$sql_dados = "select s.nome_setor
								, a.nome_agente_risco
								, r.fonte_geradora
								, r.cod_agente_risco
							from setor s, risco_setor r, cliente_setor c, agente_risco a
							where r.cod_cliente = c.cod_cliente
								and r.cod_setor = c.cod_setor
								and r.cod_setor = s.cod_setor
								and r.cod_agente_risco = a.cod_agente_risco
								and r.cod_cliente = $cliente
								and r.cod_setor = $setor";
			$result_dados = pg_query($connect, $sql_dados) 
			or die ("Erro na query: $sql_dados <p> " . pg_last_error($connect) );
			
			while($row_dados = pg_fetch_array($result_dados)){
			
				echo "<tr>
						<td colspan=2 class=linksistema><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name=\"risco_agente[]\" type=\"checkbox\" value=\"$row_dados[cod_agente_risco]\"> <u>Excluir</u> <br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"ppra3_alt.php?cliente=$cliente&setor=$setor&agente_risco=$row_dados[cod_agente_risco]\" title=\"Clique aqui para alterar\"> Agente do Risco: <u> $row_dados[nome_agente_risco] </u> </a><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"ppra3_alt.php?cliente=$cliente&setor=$setor&agente_risco=$row_dados[cod_agente_risco]\" title=\"Clique aqui para alterar\"> Fonte do Risco: <u> $row_dados[fonte_geradora] </u> </a> <br>&nbsp;
						</td>
					  </tr>";
			}
			
			if(pg_num_rows($result_dados)>0){
				echo "	<tr>";
				echo "		<th colspan=2><br><input type=\"submit\" name=\"btn_excluir\" value=\"Excluir\" title=\"Excluir itens selecionados\" style=\"width:100px;\"> <br>&nbsp;</th>";
				echo "	</tr>";
			}

		}

	if( !empty($cliente) and !empty($setor) and !empty($agente_risco) ){
	
		$sql_risco_setor = "SELECT cod_cliente, cod_setor, cod_agente_risco
								fonte_geradora
							FROM risco_setor
							where cod_cliente = $cliente
								and cod_setor = $setor
								and cod_agente_risco = $agente_risco;";

		$result_risco_setor = pg_query($connect, $sql_risco_setor) 
					or die ("Erro na query: $sql_risco_setor ==> " . pg_last_error($connect) );

		$row_risco_setor = pg_fetch_array($result_risco_setor);

?>
	<tr>
		<td width="300"><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Riscos do Setor:</span></b><br>
	  &nbsp;	    </td>
		<td width="500"> <br>&nbsp;&nbsp;&nbsp;
			<select name="cod_agente_risco">
			<?php
					$query_risco = "SELECT cod_agente_risco
										, nome_agente_risco
										, t.cod_tipo_risco
										, nome_tipo_risco
									FROM agente_risco a, tipo_risco t
									where a.cod_tipo_risco = t.cod_tipo_risco 
										and cod_agente_risco <> 0
									order by t.nome_tipo_risco, a.nome_agente_risco";

				$result_risco = pg_query($connect, $query_risco) 
					or die ("Erro na query: $query_risco ==> " . pg_last_error($connect) );
				
				while($row_risco = pg_fetch_array($result_risco)){
					if ($row_risco_setor[cod_agente_risco] <> $row_risco[cod_agente_risco]){
						echo "<option value=\"$row_risco[cod_agente_risco]\"> $row_risco[nome_tipo_risco] - $row_risco[nome_agente_risco] </option>";
					}
					else{
						echo "<option value=\"$row_risco[cod_agente_risco]\" selected> $row_risco[nome_tipo_risco] - $row_risco[nome_agente_risco] </option>";
					}
				}

			?>
			</select><br>&nbsp;		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Agente do Risco:</span></b><br>
	  &nbsp;</td>
		<td><br>&nbsp;&nbsp;&nbsp;<textarea name="nome_agente_risco" cols=50 rows=5><?php echo $row_risco_setor[nome_agente_risco]; ?></textarea><br>&nbsp;</td>
	</tr>

	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Fonte Geradora:</span></b><br>
	  &nbsp;</td>
		<td><br>&nbsp;&nbsp;&nbsp;<textarea name="fonte_geradora" cols=50 rows=5><?php echo $row_risco_setor[fonte_geradora]; ?></textarea><br>&nbsp;</td>
	</tr>
<!--
	<tr>
		<td><b><br>&nbsp;&nbsp;<span class="style3">&nbsp;Medida Predentiva Existente:</span></b><br>
	  &nbsp;</td>
		<td><br>&nbsp;&nbsp;&nbsp;<textarea name="medida_predentiva_existente" cols=50 rows=5><?php //echo $row_risco_setor[medida_predentiva_existente]; ?></textarea><br>&nbsp;</td>
	</tr>
-->
	<tr>
		<th colspan="2">
			<br>
			<input type="submit" name="btn_alterar" value="Alterar" style="width:100px;" title="Clique aqui para cadastrar mais">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			<br>
			&nbsp;		</th>
	</tr>
<?php
}
?>
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
	        <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra2_alt.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="continuar2" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="mais" value="Novo" onClick="MM_goToURL('parent','ppra3.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&alterar=mais');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Continuar >>" onClick="MM_goToURL('parent','ppra3_sugestao.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&update=sim');return document.MM_returnValue" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="p_cliente" value="<?php echo $g_cliente; /*RECEBE AS VARIÁVEIS NA PRIMEIRA VEZ*/?>">
			<input type="hidden" name="p_setor" value="<?php echo $g_setor; /*RECEBE AS VARIÁVEIS NA PRIMEIRA VEZ*/?>">
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
			<input type="hidden" name="agente_risco" value="<?php echo $agente_risco; ?>">		</td>
	</tr>
</table>
</form>
</body>
</html>