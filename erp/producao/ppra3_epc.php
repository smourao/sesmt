<?php
include "../config/connect.php"; //arquivo que cont�m a conex�o com o Banco.
include "../sessao.php";
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

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

if( $_POST["btn_mais"]=="Gravar"){
	if(!empty($_GET[id_ppra]) && !empty($_GET[setor]) ){
		$cliente 		= $_POST["cliente"];
		$setor 			= $_POST["setor"];
		$epc_existente 	= $_POST["epc_existente"];
		$epc_sugerido 	= $_POST["epc_sugerido"];
		$epc_eficaz		= $_POST["epc_eficaz"];
		$ca				= $_POST["ca"];
		$sql = "UPDATE cliente_setor
				SET epc_existente          = '$epc_existente'
					, epc_sugerido         = '$epc_sugerido'
					, epc_eficaz		   = '$epc_eficaz'
					, ca				   = '$ca'
				WHERE id_ppra          = $_GET[id_ppra] AND cod_setor = $_GET[setor]";
		$result = pg_query($sql);
		if ($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!');</script>;";
			//header("location: http://www.sesmt-rio.com/erp/producao/cad_extintor.php?cliente=$cliente&setor=$setor&y=$_GET[y]");
		}
	}
}
/********* ESTE PEDA�O � S� PRA TRAZER O NOME DO CLIENTE PARA ILUSTRAR A TELA ************/
if(!empty($cliente) & !empty($setor)){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}
/******************* FIM PEDA�O PRA TRAZER O NOME DO CLIENTE ***************************/

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="POST">
<table align="center" width="760" border="4" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
<td align="center" colspan="4" bgcolor="#009966" ><b><br>CADASTRO DE EQUIPAMENTOS DE PROTE��O COLETIVA<br>&nbsp;</b></td>
	</tr>
	<?php
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Nome do Cliente: </td> <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[razao_social]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Endere�o: </td>        <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[endereco]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Bairro: </td>          <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[bairro]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Telefone: </td>        <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[telefone]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> E-mail: </td>          <td colspan=3 class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[email]</b> </td> </tr>";
	}

	/********* ESTE PEDA�O � S� PRA TRAZER O NOME DO CLIENTE ************/
	if( !empty($cliente) & !empty($setor) ){
	    /*$cli = "SELECT epc_existente, epc_sugerido, epc_eficaz, ca
    				  FROM cliente_setor cs, cliente c, setor s
    				  where cs.cod_cliente = c.cliente_id
    				  and cs.cod_setor = s.cod_setor
    				  and cs.cod_cliente = $cliente
    				  and cs.cod_setor = $setor
    				  and EXTRACT(year from data_criacao) = {$ano}";
        */
        $cli = "SELECT epc_existente, epc_sugerido, epc_eficaz, ca
        FROM cliente_setor cs, cliente c, setor s
        where cs.cod_cliente = c.cliente_id
        and cs.cod_setor = s.cod_setor
        and cs.id_ppra = $_GET[id_ppra]
        and cs.cod_setor = $_GET[setor]";
        $res_cli = pg_query($cli);
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
	    <option value="N�o" <?php if($row[epc_eficaz]=="N�o")echo "selected";?>>N�o</option>
	    </select></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>EPC Sugerido:&nbsp;</b></td>
		<td><br>&nbsp;<textarea name="epc_sugerido" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?php echo $row["epc_sugerido"]; ?></textarea><br>&nbsp;</td>
		<td align="right" class="fontebranca12"><b>Certificado de Aprova��o:&nbsp;</b></td>
		<td class="fontebranca10">&nbsp;<select name="ca" id="ca">
		<option value="Sim" <?php if($row[ca]=="Sim")echo "selected";?>>Sim</option>
		<option value="N�o" <?php if($row[ca]=="N�o")echo "selected";?>>N�o</option>
		</select></td>
	</tr>
	<!--tr>
		<td align="center" class="fontebranca12" colspan="4"><b>Selecione Apenas EPC(s) Existente(s)</b></td>
	</tr>
	<tr>
		<td class="fontebranca12" colspan="4" align="center">
		  <?php
		  if(!empty($cliente)){
		      $rabica = "SELECT * FROM cliente_setor where cod_cliente = $cliente AND cod_setor = $setor";
    		  $result_rabica = pg_query($rabica);
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
    		  $result_gripal = pg_query($gripal);
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
    		  $result_tanica = pg_query($tanica);
    		  $bu = pg_fetch_all($result_tanica);
    		  if($bu[0]['tanica']){
    			echo "<input name=\"tanica\" type=\"checkbox\" id=\"tanica\" value=\"1\" checked>";
    		  }else{
    			echo "<input name=\"tanica\" type=\"checkbox\" id=\"tanica\" value=\"1\" >";
    		  }
		  }
		  ?>
		  &nbsp;&nbsp;<b>Vacina Antitet�nica</b>
	  </td>
	</tr-->
	<tr>
		<td align="center" colspan="4">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra3_sugestao.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="btn_concluir" value="Avan�ar &gt;&gt;" style="width:100px;" onClick="location.href='cad_extintor.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $ano; ?>&fid=<?PHP echo $_GET[fid];?>';" title="Clique aqui para avan�ar">
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
