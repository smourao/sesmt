<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
}

if($cod_extintor != ""){
    $excluir = "DELETE FROM extintor WHERE cod_extintor = $cod_extintor";
    $result = pg_query($excluir);
	if ($result){
		echo "<script>alert('EXTINTOR excluído com sucesso!');
		location.href='cad_extintor.php?cliente=$_GET[cliente]&id_ppra=$_GET[id_ppra]&setor=$setor&y=$_GET[y]';
		</script>";
	}
}

if( $_POST["btn_enviar"]=="Gravar"){
    ppra_progress_update($cliente, $setor);
	if(!empty($_POST["cliente"]) & !empty($_POST["setor"]) ){
		$antes = "SELECT desc_resumida_prod FROM produto WHERE cod_prod = {$_POST[cod_produto]}";
		$r_antes = pg_query($connect, $antes);
		$rr = pg_fetch_array($r_antes);
		if($_POST['extintor'] == "existente"){
		    $sql = "INSERT INTO extintor(extintor, tipo_extintor, cod_produto, qtd_extintor, data_recarga, numero_cilindro, cod_cliente, cod_setor,
				vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, f_inspecao, data, id_ppra)
				VALUES
				('$extintor', '$rr[desc_resumida_prod]', $cod_produto, '$qtd_extintor', '$data_recarga', '$numero_cilindro', $cliente, $setor,
				'$vencimento_abnt', '$proxima_carga', $placa_sinalizacao_id, $demarcacao_solo_id, $tipo_instalacao_id, '$empresa_prestadora', '$f_inspecao', '".$_GET['y']."/".date('m/').date('d')."', $_GET[id_ppra])";
		}else{
		    $sql = "INSERT INTO extintor(extintor, tipo_extintor, cod_produto, qtd_extintor, data_recarga, numero_cilindro, cod_cliente, cod_setor,
				vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, f_inspecao, data, id_ppra)
				VALUES
				('$extintor', '$rr[desc_resumida_prod]', $cod_produto, '$qtd_extintor', '$data_recarga', '$numero_cilindro', $cliente, $setor,
				'$vencimento_abnt', '$proxima_carga', 0, 0, 0, '$empresa_prestadora', '$f_inspecao', '".$_GET['y']."/".date('m/').date('d')."', $_GET[id_ppra])";
		}
		$result = pg_query($sql);
		echo'<script> alert("Informações Cadastradas com Sucesso!");</script>';
	}
}

/****************BUSCANDO DADOS DO CLIENTE********************/
if(!empty($cliente) & !empty($setor) ){
	$query_func = "SELECT c.*, e.*
    FROM cliente_setor c, extintor e
    WHERE e.cod_cliente = c.cod_cliente
    AND e.cod_setor = c.cod_setor
    AND e.id_ppra = c.id_ppra
    and e.id_ppra = $_GET[id_ppra]
    and e.cod_setor = $_GET[setor]";
	$result_func = pg_query($query_func);
	$row_st = pg_fetch_array($result_func);
}

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/
if(!empty($_GET[cliente]) & !empty($_GET[setor]) ){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}

?>
<html>
<head>
<title>Sugestões</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medida_produto" method="POST">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
		<th bgcolor="#009966" colspan=6>
			<br> CADASTRO DE EXTINTORES DE INCÊNDIO <br>&nbsp;		</th>
    </tr>
	<?php 
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan="6">
				<br> <font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Bairro:   		<b><?php echo $row_cli[bairro]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone];     ?></b> <br>
				&nbsp;&nbsp;&nbsp; E-mail:   		<b><?php echo $row_cli[email]; 		  ?></b> <hr>			
				</font> </td>
		</tr>
	<?php 
	}
	?>
</table>
<?php
if($row_st!=""){
echo"<table align=\"center\" width=\"760\" border=\"2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" >
    <tr>
		<td align=\"center\" bgcolor=\"#009966\">Extintores já Cadastrados &nbsp;</td>
    </tr>";
	echo "</table>";
	echo"<table align=\"center\" width=\"760\" border=\"2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" >";
	}

	$query_func = "SELECT * FROM extintor WHERE id_ppra = $_GET[id_ppra] and cod_setor = $_GET[setor]";
	$result_func = pg_query($query_func);
	while($r=pg_fetch_array($result_func)){
		echo"<tr>
			<th class=linksistema><a href=\"cad_extintor.php?cliente=$_GET[cliente]&setor=$_GET[setor]&id_ppra=$_GET[id_ppra]&cod_extintor=$r[cod_extintor]&y=$_GET[y]\" >Excluir</a> </th>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">Tipo de Extintor:<b>$r[tipo_extintor]</b></font></td>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">QTD:<b> $r[qtd_extintor]</b></font></td>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">Dt da Recarga:<b> $r[data_recarga]</b></font></td>
		</tr>";
	}
?>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
	  <td align="center" class="fontebranca12" bgcolor="#009966" colspan="6"><b>Dados do Extintor</b></td>
	</tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
      <td class="fontebranca10">Extintor</td>
      <td class="fontebranca10">Tipo de Extintor</td>
	  <td class="fontebranca10">Quantidade</td>
    </tr>
    <tr>
      <td class="fontebranca10">  <select name="extintor" id="extintor" onBlur="sugerir(this);">
	  <option value="existente" <?php if($row_st[extintor]=="existente")echo "selected";?> onBlur="existente();">Existente</option>
	  <option value="sugerido" <?php if($row_st[extintor]=="sugerido")echo "selected";?> onBlur="sugerido();">Sugerido</option>
	  </select></td>
      <td class="fontebranca10"><select name="cod_produto" id="cod_produto">
	  <!--option value="Nenhum" <?php if($row_st[tipo_extintor]=="Nenhum")echo "selected";?>>Nenhum</option>
	  <option value="PQSP" <?php if($row_st[tipo_extintor]=="PQSP")echo "selected";?>>PQSP</option>
	  <option value="PQS" <?php if($row_st[tipo_extintor]=="PQS")echo "selected";?>>PQS</option>
	  <option value="AG" <?php if($row_st[tipo_extintor]=="AG")echo "selected";?>>AG</option>
	  <option value="AP" <?php if($row_st[tipo_extintor]=="AP")echo "selected";?>>AP</option>
	  <option value="CO2" <?php if($row_st[tipo_extintor]=="CO2")echo "selected";?>>CO2</option>
	  <option value="Hallon" <?php if($row_st[tipo_extintor]=="Hallon")echo "selected";?>>HALLON</option>
	  <option value="Espuma" <?php if($row_st[tipo_extintor]=="Espuma")echo "selected";?>>Espuma</option-->
	  <?php
	  	$extintor = "select cod_prod, desc_resumida_prod from produto where (cod_atividade = 1 and desc_resumida_prod like '%Extintor%') OR cod_atividade = 6";
		$result_extintor = pg_query($extintor);
		while($row_extintor = pg_fetch_array($result_extintor)) {
			if($row_st[cod_produto]<>$row_extintor[cod_prod]){
				echo "<option value=\"$row_extintor[cod_prod]\">". ucwords(strtolower($row_extintor[desc_resumida_prod]))."</option>";
			}else{
				echo "<option value=\"$row_extintor[cod_prod]\" selected=\"selected\">". ucwords(strtolower($row_extintor[desc_resumida_prod]))."</option>";
			}
		}
	  ?>
	  </select></td>
      <td class="fontebranca10"><input name="qtd_extintor" id="qtd_extintor" type="text" value="<?php echo $row_st[qtd_extintor]?>" size="5"></td>
	  <!--td class="fontebranca10"><select name="capacidade" id="capacidade">
	  <option value="1k" <?php if($row_st[capacidade]=="1k")echo "selected";?>>1 K</option>
	  <option value="2k" <?php if($row_st[capacidade]=="2k")echo "selected";?>>2 K</option>
	  <option value="4k" <?php if($row_st[capacidade]=="4k")echo "selected";?>>4 K</option>
	  <option value="6k" <?php if($row_st[capacidade]=="6k")echo "selected";?>>6 K</option>
	  <option value="6k" <?php if($row_st[capacidade]=="8k")echo "selected";?>>6 K</option>
	  <option value="10k" <?php if($row_st[capacidade]=="10k")echo "selected";?>>10 K</option>
	  <option value="12k" <?php if($row_st[capacidade]=="12k")echo "selected";?>>12 K</option>
	  <option value="25k" <?php if($row_st[capacidade]=="25k")echo "selected";?>>25 K</option>
	  <option value="50k" <?php if($row_st[capacidade]=="50k")echo "selected";?>>50 K</option>
	  <option value="10l" <?php if($row_st[capacidade]=="10l")echo "selected";?>>10 L</option>
	  <option value="75l" <?php if($row_st[capacidade]=="75l")echo "selected";?>>75 L</option>
	  </select></td-->
    </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
      <td class="fontebranca10">Data da Recarga </td>
      <td class="fontebranca10">Nº do Cilindro </td>
      <td class="fontebranca10">Venc ABNT </td>
      <td class="fontebranca10">Prox. Carga </td>
      <td class="fontebranca10">Placa de Sinalização </td>
      <td class="fontebranca10">Demarcação do Solo </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="data_recarga" type="text" id="data_recarga" maxlength="10" onChange="dataRecarga();" OnKeyPress="formatar(this, '##/##/####')" value="<?php echo $row_st[data_recarga]?>" size="10"></td>
      <td class="fontebranca10"><input name="numero_cilindro" type="text" id="numero_cilindro" value="<?php echo $row_st[numero_cilindro]?>" size="8"></td>
      <td class="fontebranca10"><input name="vencimento_abnt" type="text" id="vencimento_abnt" maxlength="7" OnKeyPress="formatar(this, '##/####')" value="<?php echo $row_st[vencimento_abnt]?>" size="8"></td>
      <td class="fontebranca10"><input name="proxima_carga" type="text" id="proxima_carga" value="<?php echo $row_st[proxima_carga]?>" size="10"></td>
      <td class="fontebranca10"><select name="placa_sinalizacao_id" id="placa_sinalizacao_id">
	  <?php
	  	$placa = "SELECT * FROM placa_sinalizacao order by placa_sinalizacao";
		$result_placa = pg_query($placa);
		while($row_placa = pg_fetch_array($result_placa)) {
			if($row_st[placa_sinalizacao_id]<>$row_placa[placa_sinalizacao_id]){
				echo "<option value=\"$row_placa[placa_sinalizacao_id]\">". ucwords(strtolower($row_placa[placa_sinalizacao]))."</option>";
			}else{
				echo "<option value=\"$row_placa[placa_sinalizacao_id]\" selected=\"selected\">". ucwords(strtolower($row_placa[placa_sinalizacao]))."</option>";
			}
		}
	  ?>
        </select></td>
      <td class="fontebranca10"><select name="demarcacao_solo_id" id="demarcacao_solo_id">
	  <?php
	  	$solo = "SELECT * FROM demarcacao_solo order by demarcacao_solo_id";
		$result_solo = pg_query($solo);
		while($row_solo = pg_fetch_array($result_solo)) {
			if($row_st[demarcacao_solo_id]<>$row_solo[demarcacao_solo_id]){
				echo "<option value=\"$row_solo[demarcacao_solo_id]\">". $row_solo[demarcacao_solo]."</option>";
			}else{
				echo "<option value=\"$row_solo[demarcacao_solo_id]\" selected=\"selected\">". $row_solo[demarcacao_solo]."</option>";
			}
		}  
	  ?>
	  </select></td>
    </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
        <td class="fontebranca10">Tipo de Instalação </td>
	  <td class="fontebranca10">Ficha de Inspeção </td>
      <td class="fontebranca10">Empresa Prestadora dos Serviços </td>
    </tr>
    <tr>
	<td class="fontebranca10"><select name="tipo_instalacao_id" id="tipo_instalacao_id">
	  <?php
	  	$instal = "SELECT * FROM tipo_instalacao order by tipo_instalacao_id";
		$result_instal = pg_query($instal);
		while($row_instal = pg_fetch_array($result_instal)) {
			if($row_st[tipo_instalacao_id]<>$row_instal[tipo_instalacao_id]){
				echo "<option value=\"$row_instal[tipo_instalacao_id]\">". $row_instal[tipo_instalacao]."</option>";
			}else{
				echo "<option value=\"$row_instal[tipo_instalacao_id]\" selected>". $row_instal[tipo_instalacao]."</option>";
			}
		}  
	  ?>
        </select></td>
	  <td class="fontebranca10"><select name="f_inspecao" id="f_inspecao">
	  <option value="sim" <?php if($row_st[f_inspecao]=="sim")echo "selected";?>>Sim</option>
	  <option value="nao" <?php if($row_st[f_inspecao]=="nao")echo "selected";?>>Não</option>
	  </select></td>
      <td class="fontebranca10"><input name="empresa_prestadora" type="text" id="empresa_prestadora" value="<?php echo $row_st[empresa_prestadora]?>" size="50"></td>
    </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
		<td align="center" colspan="6">
			<br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra3_epc.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $_GET['y']; ?>&fid=<?PHP echo $_GET[fid];?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_enviar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Continuar >>" onClick="location.href='cad_mangueira.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $ano; ?>&fid=<?PHP echo $_GET[fid];?>';" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">	</td>
	</tr>
</table>
</form>
</body>
</html>
