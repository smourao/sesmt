<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "../sessao.php";
include "ppra_functions.php";

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
	$fid = $_GET["fid"];
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
	$fid = $_POST["fid"];
}

if( $_POST["btn_mais"]=="Gravar"){ // IF 1

	if(!empty($_POST["cliente"]) & !empty($_POST["setor"]) ){ // IF 2

		$cliente 		= $_POST["cliente"];
		$setor 			= $_POST["setor"];
		$epc_existente 	= $_POST["epc_existente"];
		$epc_sugerido 	= $_POST["epc_sugerido"];
		$epc_eficaz		= $_POST["epc_eficaz"];
		$ca				= $_POST["ca"];

		$sql = "UPDATE cliente_setor
				SET epc_existente          = '$epc_existente'
					, epc_sugerido         = '$epc_sugerido'
					, rabica			   = '$rabica'
					, gripal			   = '$gripal'
					, tanica			   = '$tanica'
					, epc_eficaz		   = '$epc_eficaz'
					, ca				   = '$ca'
				WHERE cod_cliente          = $cliente AND cod_setor = $setor";

		$result = pg_query($connect, $sql)
			or die ("Erro na query: $sql ==> " . pg_last_error($connect) );
	
		if ($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!');</script>;";
			
			header("location: http://www.sesmt-rio.com/erp/producao/cad_extintor.php?cliente=$cliente&setor=$setor");
		}
	} // IF 2
}// IF 1

/********* ESTE PEDAÇO É SÓ PRA TRAZER O NOME DO CLIENTE PARA ILUSTRAR A TELA ************/
if( !empty($cliente) & !empty($setor) ){

	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($connect, $query_cli) 
	or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
}
/******************* FIM PEDAÇO PRA TRAZER O NOME DO CLIENTE ***************************/

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="post" action="ppra3_epc.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>">
<table align="center" width="760" border="4" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
<td align="center" colspan="4" bgcolor="#009966" ><b><br>CADASTRO DE EQUIPAMENTOS DE PROTEÇÃO COLETIVA<br>&nbsp;</b></td>
	</tr>
	<?php
	if($result_cli){

		$row_cli = pg_fetch_array($result_cli);

			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Nome do Cliente: </td> <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[razao_social]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Endereço: </td>        <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[endereco]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Bairro: </td>          <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[bairro]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Telefone: </td>        <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[telefone]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> E-mail: </td>          <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[email]</b> </td> </tr>";

	}

	/********* ESTE PEDAÇO É SÓ PRA TRAZER O NOME DO CLIENTE ************/
	if( !empty($cliente) & !empty($setor) ){

	$cli = "SELECT epc_existente, epc_sugerido, epc_eficaz, ca
				  FROM cliente_setor cs, cliente c, setor s
				  where cs.cod_cliente = c.cliente_id
				  and cs.cod_setor = s.cod_setor
				  and cs.cod_cliente = $cliente
				  and cs.cod_setor = $setor";
	$res_cli = pg_query($connect, $cli) 
		or die ("Erro na query: $cli ==> " . pg_last_error($connect) );
	$row = pg_fetch_array($res_cli);
	}
	?>
	<tr> <td colspan="4">&nbsp;</td> </tr>
	<tr>
		<td width="100" class="fontebranca12" align="right"><b>EPC Existente:&nbsp;</b></td>
		<td width="410"><br>&nbsp;<textarea name="epc_existente" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?php echo $row["epc_existente"]; ?></textarea><br>&nbsp;</td>
		<td width="170" class="fontebranca12" align="right"><b>EPC Eficaz:&nbsp;</b></td>
		<td width="70" class="fontebranca10">&nbsp;<select name="epc_eficaz" id="epc_eficaz">
		<option value="Sim" <?php if($row[epc_eficaz]=="Sim")echo "selected";?>>Sim</option>
	    <option value="Não" <?php if($row[epc_eficaz]=="Não")echo "selected";?>>Não</option>
	    </select></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>EPC Sugerido:&nbsp;</b></td>
		<td><br>&nbsp;<textarea name="epc_sugerido" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?php echo $row["epc_sugerido"]; ?></textarea><br>&nbsp;</td>
		<td align="right" class="fontebranca12"><b>Certificado de Aprovação:&nbsp;</b></td>
		<td class="fontebranca10">&nbsp;<select name="ca" id="ca">
		<option value="Sim" <?php if($row[ca]=="Sim")echo "selected";?>>Sim</option>
		<option value="Não" <?php if($row[ca]=="Não")echo "selected";?>>Não</option>
		</select></td>
	</tr>
	<tr>
		<td align="center" class="fontebranca12" colspan="4"><b>Selecione Apenas EPC(s) Existente(s)</b></td>
	</tr>
	<tr>
		<td class="fontebranca12" colspan="4" align="center">
		  <?php
		  if(!empty($cliente)){
		  $rabica = "SELECT * FROM cliente_setor where cod_cliente = $cliente AND cod_setor = $setor";
		  $result_rabica = pg_query($connect, $rabica) or die
				("Erro na query: $rabica ==>". pg_last_error($connect));
		  $buff = pg_fetch_all($result_rabica);		
		  if($buff[0]['rabica']){
			echo "<input name=\"rabica\" type=\"checkbox\" id=\"rabica\" value=\"1\" checked>";
		  }else{
			echo "<input name=\"rabica\" type=\"checkbox\" id=\"rabica\" value=\"1\" >";
		  }
		  }
		  ?>
		  &nbsp;&nbsp;<b>Vacina Antirabica</b>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php
		  if(!empty($cliente)){
		  $gripal = "SELECT * FROM cliente_setor where cod_cliente = $cliente AND cod_setor = $setor";
		  $result_gripal = pg_query($connect, $gripal) or die
				("Erro na query: $gripal ==>". pg_last_error($connect));
		  $buf = pg_fetch_all($result_gripal);		
		  if($buf[0]['gripal']){
			echo "<input name=\"gripal\" type=\"checkbox\" id=\"gripal\" value=\"1\" checked>";
		  }else{
			echo "<input name=\"gripal\" type=\"checkbox\" id=\"gripal\" value=\"1\" >";
		  }
		  }
		  ?>
		  &nbsp;&nbsp;<b>Vacina Antigripal</b>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php
		  if(!empty($cliente)){
		  $tanica = "SELECT * FROM cliente_setor where cod_cliente = $cliente AND cod_setor = $setor";
		  $result_tanica = pg_query($connect, $tanica) or die
				("Erro na query: $tanica ==>". pg_last_error($connect));
		  $bu = pg_fetch_all($result_tanica);		
		  if($bu[0]['tanica']){
			echo "<input name=\"tanica\" type=\"checkbox\" id=\"tanica\" value=\"1\" checked>";
		  }else{
			echo "<input name=\"tanica\" type=\"checkbox\" id=\"tanica\" value=\"1\" >";
		  }
		  }
		  ?>
		  &nbsp;&nbsp;<b>Vacina Antitetânica</b>
	  </td>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra3_sugestao.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_excluir" value="Excluir" title="Excluir itens selecionados" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Avançar &gt;&gt;" style="width:100px;" onClick="MM_goToURL('parent','cad_extintor.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" title="Clique aqui para avançar">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
			<input type="hidden" name="alterar" value="<?php echo $alterar; ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>