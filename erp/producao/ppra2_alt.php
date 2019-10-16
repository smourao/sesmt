<?php
include "../config/connect.php";
include "../sessao.php";
include "ppra_functions.php";

if($_GET["alteracao"]=="ok"){
	echo "<script>alert('Características do Setor alteradas com sucesso!');</script>";
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$cliente = $_GET["cliente"];
$setor = $_GET["setor"];


if($_POST["btn_enviar"]=="Gravar"){
    ppra_progress_update($cliente, $setor);
	if(!empty($_GET["id_ppra"]) & !empty($_GET["setor"]) ){ // IF 2
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
					, func_terc            = $_POST[func_terc]
				WHERE id_ppra              = $_GET[id_ppra]
                AND cod_setor              = $_GET[setor]";
		$result = pg_query($sql);
		
	}
	if($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!') 
			location.href='cad_func_alt.php?cliente=$_GET[cliente]&setor=$_GET[setor]&y=$ano&id_ppra=$_GET[id_ppra]';
			</script>";
	}else{
		echo "<script>alert('Dado do Cliente ou Setor Incorreto!');</script>";
	}
}
/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/
if(!empty($_GET[id_ppra]) && !empty($_GET[setor])){
    $sql = "SELECT razao_social, bairro, telefone, email, endereco, cod_luz_nat, cod_luz_art, cod_vent_nat, cod_vent_art,
    cod_edificacao, cod_piso, cod_parede, cod_cobertura, data_criacao, func_terc
    FROM cliente c, cliente_setor cs
    where cs.cod_cliente = c.cliente_id
    and cs.id_ppra = $_GET[id_ppra]
    and cs.cod_setor = $_GET[setor]";
	$result_cli = pg_query($sql);
}

function convertwords($text){
    $siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "ltda", "av", "rua", "rj", //Siglas normais
    				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "ltda,", "av,", "rua,", //Siglas com vírgula
    				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(ltda)", "(av)", "(rua)", //Siglas entre parênteses
    				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "ltda.", "av.", "rua.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
    $at = explode(" ", $text);
    $temp = "";
    for($x=0;$x<count($at);$x++){
       $at[$x] = strtolower($at[$x]);
       $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

      if(in_array($at[$x], $siglas)){
         $at[$x] = strtoupper($at[$x]);
      }elseif(strlen($at[$x])>3){
            $at[$x] = ucwords($at[$x]);
        }
    	$temp .= $at[$x]." ";
    }
    return $temp;
}

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>
<script>
// CENTRALIZAR O DIV
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
// ADICIONAR AR PORTÁTIL
function add_port(){
	var url = "add_port.php?cliente="+'<?php echo $_GET['cliente'];?>';
	url = url + "&setor="+'<?php echo $_GET['setor'];?>';
	url = url + "&dt_ventilacao="+document.getElementById('dt_ventilacao').value;
	url = url + "&data_limpeza_filtros="+document.getElementById('data_limpeza_filtros').value;
	url = url + "&higiene="+document.getElementById('higiene').value;
	
	http.open("GET", url, true);
	http.onreadystatechange = port_reply;
	http.send(null);
}

function port_reply(){
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
	document.getElementById("port").style.display = "none";
}else{
 if (http.readyState==1){
 
    }
 }
}

// ADICIONAR AR CENTRAL
function add_ar(){
	var url = "add_ar.php?cliente="+'<?PHP echo $_GET['cliente'];?>';
	url = url + "&setor="+'<?PHP echo $_GET['setor'];?>';
	url = url + "&num_aparelhos="+document.getElementById('num_aparelhos').value;
	url = url + "&dt_venti="+document.getElementById('dt_venti').value;
	url = url + "&proxima_limpeza_mecanica="+document.getElementById('proxima_limpeza_mecanica').value;
	url = url + "&marca="+document.getElementById('marca').value;
	url = url + "&ultima_limpeza_duto="+document.getElementById('ultima_limpeza_duto').value;
	url = url + "&proxima_limpeza_duto="+document.getElementById('proxima_limpeza_duto').value;
	url = url + "&modelo="+document.getElementById('modelo').value;
	url = url + "&capacidade="+document.getElementById('capacidade').value;
	url = url + "&empresa_servico="+document.getElementById('empresa_servico').value;

	http.open("GET", url, true);
	http.onreadystatechange = ar_reply;
	http.send(null);
}

function ar_reply(){
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
	document.getElementById("ar").style.display = "none";
}else{
 if (http.readyState==1){
 
    }
 }
}
</script>

<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<div id="port" style="position: absolute; display: none;">
	<table width="400" height="200" align="center" border="1" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
		<tr>
			<td align="center" colspan="2" class="fontepreta12bold">Dados Complementares do Ar Portátil</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">Data da Última Higienização Mecânica:&nbsp;</td>
			<td align="left" class="fontepreta12">&nbsp;<input type="text" name="dt_ventilacao" id="dt_ventilacao" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/####');"></td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">Data da Última Limpeza de Filtros:&nbsp;</td>
			<td align="left" class="fontepreta12">&nbsp;<input type="text" name="data_limpeza_filtros" id="data_limpeza_filtros" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/####');"></td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">O Aparelho Encontra-se em Área de Circulação?&nbsp;</td>
			<td align="left" class="fontepreta12">&nbsp;<select name="higiene" id="higiene">
													<option value="sim">Sim</option>
													<option value="nao">Não</option> 
			</select></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="button" name="ok" value="OK" onClick="add_port();">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="cance" value="Cancelar" onClick="document.getElementById('port').style.display='none';"></td>
		</tr>
	</table>
</div>
<div id="ar" style="position: absolute; display: none;">
	<table width="500" height="300" align="center" border="1" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
		<tr>
			<td align="center" colspan="3" class="fontepreta12bold">Complemento Para a Qualidade do Ar</td>
		</tr>
		<tr>
			<td align="center" width="100" class="fontepreta12">Nº de Aparelhos</td>
			<td align="center" width="200" class="fontepreta12">Última Limpeza dos Filtros</td>
			<td align="center" width="200" class="fontepreta12">Próxima Limpeza Mecânica</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12"><input type="text" name="num_aparelhos" id="num_aparelhos" size="5"></td>
			<td align="center" class="fontepreta12"><input type="text" name="dt_venti" id="dt_venti" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/###');"></td>
			<td align="center" class="fontepreta12"><input type="text" name="proxima_limpeza_mecanica" id="proxima_limpeza_mecanica" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/####');"></td>			
		</tr>
		<tr>
			<td align="center" class="fontepreta12">Marca</td>
			<td align="center" class="fontepreta12">Última Limpeza dos Dutos</td>
			<td align="center" class="fontepreta12">Próxima Limpeza dos Dutos</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12"><input type="text" name="marca" id="marca" size="15"></td>
			<td align="center" class="fontepreta12"><input type="text" name="ultima_limpeza_duto" id="ultima_limpeza_duto" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/####');"></td>
			<td align="center" class="fontepreta12"><input type="text" name="proxima_limpeza_duto" id="proxima_limpeza_duto" size="10" maxlength="10" onKeyPress="formatar(this, '##/##/####');"></td>			
		</tr>
		<tr>
			<td align="center" class="fontepreta12">Modelo</td>
			<td align="center" class="fontepreta12">Capacidade</td>
			<td align="center" class="fontepreta12">Empresa Prestadora dos Serviços</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12"><input type="text" name="modelo" id="modelo" size="15"></td>
			<td align="center" class="fontepreta12"><input type="text" name="capacidade" id="capacidade" size="15"></td>
			<td align="center" class="fontepreta12"><input type="text" name="empresa_servico" id="empresa_servico" size="30"></td>			
		</tr>
		<tr>
			<td align="center" colspan="3"><input type="button" name="ok" value="OK" onClick="add_ar();">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="cancelar" value="Cancelar" onClick="document.getElementById('ar').style.display='none';"></td>
		</tr>
	</table>
</div>

<form name="frm_ppra2" method="POST">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
		<th colspan="2" bgcolor="#009966" align="left">
			<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS
            <br>
            <br>
			&nbsp;&nbsp;&nbsp; COLETA DE DADOS DAS CARACTERÍSTICAS FÍSICAS DO SETOR <br>&nbsp;
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
		<td width="300"><div align="right"><b><br>
		  &nbsp;&nbsp;<span class="style1">&nbsp;Tipo de Edificação: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td width="500"> &nbsp;&nbsp;&nbsp;
			<select name="cod_edificacao">
			<?php
			$query_edi = "SELECT * FROM tipo_edificacao order by descricao";
			$result_edi = pg_query($query_edi);
			while($row_edi = pg_fetch_array($result_edi)){
				if($row_cli[cod_edificacao]<>$row_edi[tipo_edificacao_id]){
					echo "<option value=\"$row_edi[tipo_edificacao_id]\">" . convertwords($row_edi[descricao]) . "</option>";
				}else{
					echo "<option value=\"$row_edi[tipo_edificacao_id]\" selected=\"selected\">" . convertwords($row_edi[descricao]) . "</option>";
				}
			}
			?>
			</select>
            </td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;<span class="style1">Ventilação Natural: &nbsp;</span></b><br>
	  &nbsp;	    </div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_vent_nat">
			<?php
			$query_nat = "SELECT cod_vent_nat, nome_vent_nat, substr(decricao_vent_nat,1 ,60) as decricao_vent_nat
						  FROM ventilacao_natural order by nome_vent_nat";
			$result_nat = pg_query($query_nat);
			while($row_nat = pg_fetch_array($result_nat)){
				if($row_cli[cod_vent_nat]<>$row_nat[cod_vent_nat]){
					echo "<option value=\"$row_nat[cod_vent_nat]\">" . convertwords($row_nat[decricao_vent_nat]) . "</option>";
				}else{
					echo "<option value=\"$row_nat[cod_vent_nat]\" selected=\"selected\">" . convertwords($row_nat[decricao_vent_nat]) . "</option>";
				}
			}
			?>
			</select>		
		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Ventilação Artificial: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_vent_art" id="cod_vent_art" 
			onChange="if(this.options[this.selectedIndex].value == 5 || this.options[this.selectedIndex].value == 6){
				document.getElementById('ar').style.display='block';
				document.getElementById('ar').style.left = (getWidth() / 2)-250;
				getElementById('ar').style.top = (getHeight() / 2)-150;
				}else if(this.options[this.selectedIndex].value == 4 ){
				document.getElementById('port').style.display='block';
				document.getElementById('port').style.left = (getWidth() / 2)-200;
				getElementById('port').style.top = (getHeight() / 2)-100;}">

			<?php
			$query_art = "SELECT cod_vent_art, nome_vent_art, substr(decricao_vent_art,1,60) as decricao_vent_art
						  FROM ventilacao_artificial";
			$result_art = pg_query($query_art);
			while($row_art = pg_fetch_array($result_art)){
				if($row_cli[cod_vent_art]<>$row_art[cod_vent_art]){
					echo "<option value=\"$row_art[cod_vent_art]\">" . convertwords($row_art[decricao_vent_art]) . "</option>";
				}else{
					echo "<option value=\"$row_art[cod_vent_art]\" selected=\"selected\">" . convertwords($row_art[decricao_vent_art]) . "</option>";
				}
			}
			?>
			</select>		
		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Tipo de Piso: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_piso">
			<?php
			$query_piso = "SELECT cod_piso, nome_piso, substr(descricao_piso,1,60) as descricao_piso
						  FROM piso order by nome_piso";
			$result_piso = pg_query($query_piso);
			while($row_piso = pg_fetch_array($result_piso)){
				if($row_cli[cod_piso]<>$row_piso[cod_piso]){
					echo "<option value=\"$row_piso[cod_piso]\">" . convertwords($row_piso[descricao_piso]) . "</option>";
				}else {
					echo "<option value=\"$row_piso[cod_piso]\" selected=\"selected\">" . convertwords($row_piso[descricao_piso]) . "</option>";
				}
			}
			?>
			</select>		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Iluminação Natural: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_luz_nat">
			<?php
			$query_luz_nat = "SELECT cod_luz_nat, nome_luz_nat, substr(descricao_luz_nat,1,60) as descricao_luz_nat
							  FROM luz_natural order by nome_luz_nat";
			$result_luz_nat = pg_query($query_luz_nat);
			while($row_luz_nat = pg_fetch_array($result_luz_nat)){
				if($row_cli[cod_luz_nat]<>$row_luz_nat[cod_luz_nat]){
					echo "<option value=\"$row_luz_nat[cod_luz_nat]\">" . convertwords($row_luz_nat[descricao_luz_nat]) . "</option>";
				}else{
					echo "<option value=\"$row_luz_nat[cod_luz_nat]\" selected=\"selected\">" . convertwords($row_luz_nat[descricao_luz_nat]) . "</option>";
				}
			}
			?>
			</select>		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Iluminação Artficial: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_luz_art">
			<?php
			$query_luz_art = "SELECT cod_luz_art, nome_luz_art, substr(decricao_luz_art,1,60) as decricao_luz_art
							  FROM luz_artificial order by nome_luz_art";
			$result_luz_art = pg_query($query_luz_art);
			while($row_luz_art = pg_fetch_array($result_luz_art)){
				if($row_cli[cod_luz_art]<>$row_luz_art[cod_luz_art]){
					echo "<option value=\"$row_luz_art[cod_luz_art]\">" . convertwords($row_luz_art[decricao_luz_art]) . "</option>";
				}else{
					echo "<option value=\"$row_luz_art[cod_luz_art]\" selected=\"selected\">" . convertwords($row_luz_art[decricao_luz_art]) . "</option>";
				}
			}
			?>
			</select>		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;<span class="style1">&nbsp;Tipo de Parede: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_parede">
			<?php
			$query_parede = "SELECT cod_parede, nome_parede, substr(decicao_parede,1,60) as decicao_parede
						  FROM parede order by nome_parede";

			$result_parede = pg_query($query_parede);
			while($row_parede = pg_fetch_array($result_parede)){
				if($row_cli[cod_parede]<>$row_parede[cod_parede]){
					echo "<option value=\"$row_parede[cod_parede]\">" . convertwords($row_parede[decicao_parede]) . "</option>";
				}else{
					echo "<option value=\"$row_parede[cod_parede]\" selected=\"selected\">" . convertwords($row_parede[decicao_parede]) . "</option>";
				}
			}
			?>
			</select>		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Tipo de Cobertura: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="cod_cobertura">
			<?php
			$query_cob = "SELECT cod_cobertura, nome_cobertura, substr(decicao_cobertura,1,60) as decicao_cobertura
						  FROM cobertura order by nome_cobertura";

			$result_cob = pg_query($query_cob);

			while($row_cob = pg_fetch_array($result_cob)){
				if($row_cli[cod_cobertura]<>$row_cob[cod_cobertura]){
					echo "<option value=\"$row_cob[cod_cobertura]\">" . convertwords($row_cob[decicao_cobertura]) . "</option>";
				}else{
					echo "<option value=\"$row_cob[cod_cobertura]\" selected=\"selected\">" . convertwords($row_cob[decicao_cobertura]) . "</option>";
				}
			}
			?>
			</select>		</td>
	</tr>

	
	<tr>
		<td><div align="right"><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Funcionários Terceirizados: &nbsp;</span></b><br>&nbsp;</div></td>
		<td> &nbsp;&nbsp;&nbsp;
			<select name="func_terc">
                 <option value=0 <?PHP print $row_cli[func_terc] ? "":" selected ";?> >Não</option>
                 <option value=1 <?PHP print $row_cli[func_terc] ? " selected ":"";?>>Sim</option>
			</select>
        </td>
	</tr>

	
	<tr>
		<td align="center" colspan="2">
			<br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&y=<?php echo $_GET['y'];?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_enviar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Continuar >>" onClick="location.href='cad_func_alt.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $ano; ?>&alt=sim';" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">	</td>
	</tr>
</table>
</form>
</body>
</html>
