<?php
include "../sessao.php";
include "../config/connect.php";
include "ppra_functions.php";

if($_GET["alteracao"]=="ok"){
	echo "<script>alert('Funcionário alterado com sucesso!');</script>";
}

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

if($_POST["btn_enviar"]=="Gravar"){ // IF 1
ppra_progress_update($cliente, $setor);
	if(!empty($_POST["cliente"]) & !empty($_POST["setor"]) ){ // IF 2
		$cliente 		= $_POST["cliente"];
		$setor 			= $_POST["setor"];
		$ruido	 		= $_POST["ruido"];
		$hora 			= $_POST["hora_avaliacao"];
		$termico		= $_POST["termico"];
		$metragem		= $_POST["metragem"];
		$data_avaliacao = $_POST["data_avaliacao"];
		/***
			Estes tratamentos são para substituir a vírgula por ponto pq este é o separador decimal do banco.
			Ex.: "22,2" passa a ser "22.2"
		***/
		if( empty($_POST["ruido_fundo_setor"]) ){
			$ruido_fundo_setor = 00;
		}else{
			$ruido_fundo_setor = str_replace(",",".",$_POST["ruido_fundo_setor"]);
		}

        if( empty($_POST["ruido_operacao_setor"]) ){
			$ruido_operacao_setor = 0;
		}else{
			$ruido_operacao_setor = str_replace(",",".",$_POST["ruido_operacao_setor"]);
		}
		
		if( empty($_POST["temperatura"]) ){
			$temperatura = 0;
		}else{
			$temperatura = str_replace(",",".",$_POST["temperatura"]);
		}
		
		if( empty($_POST["umidade"]) ){
			$umidade = 0;
		}else{
			$umidade = str_replace(",",".",$_POST["umidade"]);
		}
		
		if( empty($_POST["pavimentos"]) ){
			$pavimentos = 0;
		}else{
			$pavimentos = str_replace(",",".",$_POST["pavimentos"]);
		}
		
		if( empty($_POST["altura"]) ){
			$altura = 0;
		}else{
			$altura = str_replace(",",".",$_POST["altura"]);
		}
		
		if( empty($_POST["frente"]) ){
			$frente = 0;
		}else{
			$frente = str_replace(",",".",$_POST["frente"]);
		}
		
		if( empty($_POST["comprimento"]) ){
			$comprimento = 0;
		}else{
			$comprimento = str_replace(",",".",$_POST["comprimento"]);
		}
		
		$sql = "UPDATE cliente_setor
				SET temperatura            = $temperatura
					, umidade              = $umidade
					, pavimentos           = $pavimentos
					, altura               = $altura
					, termico			   = $termico
					, metragem			   = $metragem
					, frente               = $frente
					, comprimento          = $comprimento
					, ruido			       = $ruido
					, data_avaliacao	   = '$data_avaliacao'
					, hora_avaliacao       = '$hora'
					, ruido_fundo_setor    = $ruido_fundo_setor
					, ruido_operacao_setor = $ruido_operacao_setor
				WHERE id_ppra          = $_GET[id_ppra] and cod_setor = $setor";
		$result = pg_query($sql);
		if ($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!')
				  location.href='iluminacao.php?cliente=$cliente&id_ppra=$_GET[id_ppra]&setor=$setor&fid=$_GET[fid]&y=$ano';
				  </script>;";
		}
	} // IF 2
	else{
		echo "<script> alert('Setor não cadastrado para o Cliente selecionado!');</script>";
	} // IF 2
}// IF 1

/****************BUSCANDO DADOS DO CLIENTE********************/
if(!empty($_GET[id_ppra]) && !empty($setor) ){
    /*
	$query_func = "SELECT temperatura, umidade, pavimentos, altura, termico, metragem, frente, comprimento, ruido, data_avaliacao,
				   hora_avaliacao, ruido_fundo_setor, ruido_operacao_setor, data_criacao
				   FROM cliente c, cliente_setor cs
				   WHERE cs.cod_cliente = c.cliente_id
				   		and c.cliente_id <>0
						and cs.cod_cliente = $cliente
						and cs.cod_setor = $setor
						AND EXTRACT(year FROM data_criacao) = {$ano}";
	*/
    $sql = "SELECT temperatura, umidade, pavimentos, altura, termico, metragem, frente, comprimento, ruido, data_avaliacao,
    hora_avaliacao, ruido_fundo_setor, ruido_operacao_setor, data_criacao
    FROM cliente c, cliente_setor cs
    WHERE cs.cod_cliente = c.cliente_id
    AND cs.id_ppra = $_GET[id_ppra]
    AND cs.cod_setor = $_GET[setor]";
	$result_func = pg_query($sql);
	$row_st = pg_fetch_array($result_func);
}

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/
if(!empty($_GET[cliente])){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}
?>

<html>
<head>
<title> PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script>
function getWidth() {
   return window.innerWidth && window.innerWidth > 0 ? window.innerWidth : /* Non IE */
   document.documentElement.clientWidth && document.documentElement.clientWidth > 0 ? document.documentElement.clientWidth : /* IE 6+ */
   document.body.clientWidth && document.body.clientWidth > 0 ? document.body.clientWidth : -1; /* IE 4 */
}
function getHeight() {
   return window.innerHeight && window.innerHeight > 0 ? window.innerHeight : /* Non IE */
   document.documentElement.clientHeight && document.documentElement.clientHeight > 0 ? document.documentElement.clientHeight : /* IE 6+ */
   document.body.clientHeight && document.body.clientHeight > 0 ? document.body.clientHeight : -1; /* IE 4 */
}
</script>
<script>
//ADICIONAR PAVIMENTOS 
function add_pav(){
		var url = "add_pav.php?cliente="+'<?PHP echo $_GET['cliente'];?>';
		url = url + "&setor="+'<?PHP echo $_GET['setor'];?>';
		url = url + "&degraus="+document.getElementById('degraus').value;
		url = url + "&largura="+document.getElementById('largura').value;
		url = url + "&fita="+document.getElementById('fita').value;
		http.open("GET", url, true);
		http.onreadystatechange = pav_reply;
		http.send(null);
}

function pav_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	//alert(msg);
    if(msg != 0){
       //alert(msg);
	}else{
       //
	}
	alert('Dados Incluídos com Sucesso!!!');
	document.getElementById("pav").style.display = "none";
}else{
 if (http.readyState==1){
 
    }
 }
}
</script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<div id="pav" style="position: absolute; display: none;">
	<table width="400" height="300" align="center" border="1" bordercolor="#000000" bgcolor="#CCCCCC">
		<tr>
			<td align="center" colspan="2" class="fontepreta12bold">Complemento do Pavimento</td>
		</tr>
		<tr>
			<td width="150" align="left" class="fontepreta12"><b>QTD. de Degraus:</b></td>
			<td width="250" class="fontepreta12"><input type="text" name="degraus" id="degraus" size="10"></td>			
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Largura:</b></td>
			<td class="fontepreta12"><input type="text" name="largura" id="largura" size="10"></td>			
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Fita Antiderrapante:</b></td>
			<td class="fontepreta12"><select name="fita" id="fita">
									 <option value="Sim">Sim</option>
									 <option value="nao">Não</option>
									 </select></td>			
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="button" name="ok" value="OK" onClick="add_pav();"></td>
		</tr>
	</table>
</div>
<form name="frm_ppra2" method="POST">
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
					&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social]</b> <br>
					&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco]</b> <br>
					&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro]</b> <br>
					&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone]</b> <br>
					&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> <br>&nbsp;
				</td>
			</tr>";
		}
	?>
	</table>
	<table align="center" width="760" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr bgcolor="#999999">
			<td colspan="2" width="189" class="fontebranca12" align="center"><b>Condição da Edificação</b></td>
			<td colspan="2" class="fontebranca12" align="center"><b>(db) Ruídos</b></td>
			<td colspan="2" class="fontebranca12" align="center"><b>Temperatura</b></td>
		</tr>
		<tr>
			<td class="fontebranca12" align="right"><b><br>Pé Direito:&nbsp;</b><br>&nbsp;</td>
			<td>&nbsp;<input type="text" name="altura" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo $row_st[altura] ?>"></td>
			<td bgcolor="#009966" class="fontebranca12" align="right"><br><b>Ruído de Fundo: &nbsp;<br>&nbsp;</b></td>
			<td bgcolor="#009966">&nbsp;<input type="text" name="ruido_fundo_setor" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo number_format($row_st[ruido_fundo_setor], 1, '.',''); ?>"></td>
			<td class="fontebranca12" align="right"><b><br>Calor (ºC):&nbsp;</b><br>&nbsp;</td>
			<td >&nbsp;<input type="text" name="temperatura" size="5" maxlength="6" value="<?php echo number_format($row_st[temperatura], 1, '.',''); ?>"></td>
		</tr>
		<tr>
			<td class="fontebranca12" align="right"><b><br>Nº Pav.:&nbsp;</b><br>&nbsp;</td>
			<td >&nbsp;<input type="text" name="pavimentos" id="pavimentos" size="5" maxlength="6" value="<?php echo $row_st[pavimentos] ?>" 
				onBlur="if(this.value > 1){document.getElementById('pav').style.display='block';
				document.getElementById('pav').style.left = (getWidth() / 2)-200;
				getElementById('pav').style.top = (getHeight() / 2)-150;}"></td>
			<td bgcolor="#009966" class="fontebranca12" align="right"><br><strong>R. de Operação: &nbsp;<br>&nbsp;</strong></td>
			<td bgcolor="#009966">&nbsp;<input type="text" name="ruido_operacao_setor" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo number_format($row_st[ruido_operacao_setor], 1, '.',''); ?>"></td>
			<td class="fontebranca12" align="right"><b><br>Umidade:&nbsp;</b><br>&nbsp;</td>
			<td >&nbsp;<input type="text" name="umidade" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo number_format($row_st[umidade], 1, '.',''); ?>">%</td>
		</tr>
		<tr>
			<td class="fontebranca12" align="right"><b><br>Frente:&nbsp;</b><br>&nbsp;</td>
			<td >&nbsp;<input type="text" name="frente" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo $row_st[frente]; ?>"></td>
			<td bgcolor="#009966" align="right" class="fontebranca12" ><br><strong>Aparelho: &nbsp;<br>&nbsp;</strong></td>
			<td bgcolor="#009966">&nbsp;<select name="ruido">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 3
								   order by nome_aparelho";
					
				$result_status = pg_query($sql_status);
				while ( $row_status = pg_fetch_array($result_status)){
					echo"<option value=\"$row_status[cod_aparelho]\"> " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
		    </td>
			<td align="right" class="fontebranca12" ><br><strong>Aparelho: &nbsp;<br>&nbsp;</strong></td>
			<td >&nbsp;<select name="termico">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 1
								   order by nome_aparelho";
				$result_status = pg_query($sql_status);
				while ( $row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
		  	</td>
		</tr>
		<tr>
			<td class="fontebranca12" align="right"><b><br>Comp.:&nbsp;</b><br>&nbsp;</td>
			<td >&nbsp;<input type="text" name="comprimento" size="5" maxlength="6" onKeyPress="return FormataReais(this, '', '.', event);" value="<?php echo $row_st[comprimento] ?>"></td>
			<td bgcolor="#009966">&nbsp;</td>
			<td bgcolor="#009966">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="right" class="fontebranca12" ><br><strong>Aparelho:&nbsp;<br>&nbsp;</strong></td>
			<td >&nbsp;<select name="metragem">
			<?php
				$sql_status = "SELECT cod_aparelho, nome_aparelho
								   FROM aparelhos
								   where cod_aparelho <> 0
								   AND tipo_aparelho = 2
								   order by nome_aparelho";
				$result_status = pg_query($sql_status);
				while($row_status = pg_fetch_array($result_status) ){
					echo"<option value=\"$row_status[cod_aparelho]\"> " . $row_status[nome_aparelho] . "</option>";
				}
			?>
				</select> 
		    </td>
		    <td bgcolor="#009966">&nbsp;</td>
		    <td bgcolor="#009966">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td width="350" class="fontebranca12" align="center"><br><strong>Data da Avaliação: &nbsp;&nbsp;</strong>
			<input type="text" name="data_avaliacao" size="10" maxlength="10" OnKeyPress="formatar('##/##/####', this)" value="<?php echo $row_st[data_avaliacao] ?>"><br>&nbsp;</td>
			<td width="350" class="fontebranca12" align="center"><br><strong>Hora da Avaliação: &nbsp;&nbsp;</strong>
			<input type="text" name="hora_avaliacao" size="10" title="hh:mm:ss" maxlength="8" OnKeyPress="formatar('##:##:##', this)" value="<?php echo $row_st[hora_avaliacao] ?>"><br>&nbsp;</td>
		</tr>
	</table>
	<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='cad_func_alt.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra]; ?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="cancelar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Gravar" style="width:100px;" name="btn_enviar" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button" name="btn_concluir" value="Continuar >>" style="width:100px;" onClick="location.href='iluminacao.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra]; ?>&setor=<?php echo $setor; ?>&alt=sim&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $ano; ?>';">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>
