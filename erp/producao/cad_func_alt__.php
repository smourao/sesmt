<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i ") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "../sessao.php";
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
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
}

if(!empty($_GET["cliente"]) && !empty($_GET["setor"]) and $_POST["btn_enviar"]=="Gravar"){ // IF 1
ppra_progress_update($cliente, $setor);
	$sql = "select cpf from funcionarios";
	$res = pg_query($connect, $sql);
	$buffer = pg_fetch_all($res);
	$cpf_existente = 0;
	$remover = array("/", ".", "-");
		for($x=0;$x<count($buffer);$x++){
			if(str_replace($remover, "", $buffer[$x]['cpf']) == str_replace($remover, "", $cpf)){
				$cpf_existente = 1;
			}
}

	if(!empty($_POST["cliente"]) && !empty($_POST["setor"]) ){ // IF 2
		$sql = "select cpf from funcionarios WHERE cod_cliente = {$_POST['cliente']}";
	$res = pg_query($connect, $sql);
	$buffer = pg_fetch_all($res);
	$cpf_existente = 0;
	$remover = array("/", ".", "-");
		for($x=0;$x<count($buffer);$x++){
			if(str_replace($remover, "", $buffer[$x]['cpf']) == str_replace($remover, "", $cpf)){
				$cpf_existente = 1;
			}
     }
		if(/*$cpf_existente<=0*/1==1){
		
			$query_max = "SELECT max(cod_func) as cod_func FROM funcionarios WHERE cod_cliente = {$_POST['cliente']}";
		
			$result_max = pg_query($query_max) //executa query
				or die ("Erro na busca da tabela funcionarios. ==> " . pg_last_error($connect)); //mostra erro
		
			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
			
			$cod_func = $row_max[cod_func] + 1;

		$seta = $_POST['setarray'];
		$num =  count($seta);
		
		for($x=0;$x<$num;$x++){
		   $sa .= $seta[$x]."|";
		}		

		$query_func = "INSERT INTO funcionarios(cod_cliente, cod_setor, cod_func, nome_func, estado, endereco_func, bairro_func, rg, cep,
					   num_ctps_func, serie_ctps_func, cbo, cidade, cod_status, cod_funcao, cpf, sexo_func, data_nasc_func, data_admissao_func,
					   data_desligamento_func, dinamica_funcao, naturalidade, nacionalidade, civil, cor, setor_adicional, pis, pdh, revezamento,
					   data_ultimo_exame)
					   VALUES
					   ($cliente, $setor, $cod_func, '".addslashes($nome_func)."', '$estado', '$endereco_func', '$bairro_func', '$rg', '$cep', '$num_ctps_func',
					   '$serie_ctps_func', '$cbo', '$cidade', $cod_status, $cod_funcao, '$cpf', '$sexo_func', '$data_nasc_func', '$data_admissao_func',
					   '$data_desligamento_func', '$dinamica_funcao', '$naturalidade', '$nacionalidade', '$civil', '$cor', '$sa', '$pis', '$pdh',
					   '$revezamento', '$data_ultimo_exame')";
		$result_func = pg_query($connect, $query_func) or die
			("Erro na query: $query_func".pg_last_error($connect));
		
		echo '<script> alert("Funcionário Cadastrado com Sucesso!");</script>';

		}else{
	
		$seta = $_POST['setarray'];
		$num =  count($seta);
		
		for($x=0;$x<$num;$x++){
		   $sa .= $seta[$x]."|";
		}		
				
		$query_func = "UPDATE funcionarios
				SET nome_func				= '".addslashes($nome_func)."'
					, estado				= '$estado'
					, endereco_func			= '$endereco_func'
					, bairro_func			= '$bairro_func'
					, rg					= '$rg'
					, cep					= '$cep'
					, num_ctps_func			= '$num_ctps_func'
					, serie_ctps_func		= '$serie_ctps_func'
					, cbo					= '$cbo'
					, cidade				= '$cidade'
					, cod_status			= $cod_status
					, cod_funcao			= $cod_funcao
					, cpf					= '$cpf'
					, sexo_func				= '$sexo_func'
					, data_nasc_func		= '$data_nasc_func'
					, data_admissao_func	= '$data_admissao_func'
					, data_desligamento_func= '$data_desligamento_func'
					, dinamica_funcao		= '$dinamica_funcao'
					, naturalidade			= '$naturalidade'
					, nacionalidade			= '$nacionalidade'
					, civil					= '$civil'
					, cor					= '$cor'
					, setor_adicional		= '$sa'
					, pis					= '$pis'
					, pdh					= '$pdh'
					, revezamento			= '$revezamento'
					, data_ultimo_exame		= '$data_ultimo_exame'
					";
			if(!$buffer[0][cod_setor])
                $query_func .= " , cod_setor = {$_GET[setor]}";
				$query_func .= " WHERE cod_cliente          	= $cliente and cod_func = {$_GET[fid]}";

			$result_func = pg_query($connect, $query_func) or die
				("Erro na query: $query_func".pg_last_error($connect));

			echo "<script> alert('Funcionário Alterado com Sucesso!')
				  location.href='cad_func_alt.php?cliente=$cliente&setor=$setor&fid=$_GET[fid]';
				  </script>";
		}

	}else{
		echo "<script> alert('Setor não cadastrado para o Cliente selecionado!');</script>";
		$cliente = "";
		$setor = ""; 
		}
	}//IF1
/****************BUSCANDO O FUNCIONÁRIO********************/
if($_GET['fid']){
    $query_func = "
    SELECT f.*
    FROM funcionarios f
    WHERE f.cod_cliente = $cliente
    and
    ((f.cod_setor = $setor OR f.setor_adicional LIKE '%{$setor}%') OR f.cod_setor is null)
    and f.cod_func <>0
    AND f.cod_func = '$_GET[fid]'
    ";
						
	$result_func = pg_query($connect, $query_func)
		or die ("Erro na query: $query_func ==>".pg_last_error($connect));
		
	$row_func = pg_fetch_array($result_func);
	print_r($row_func);
}
?>
<html>
<head>
	<title>Cadastro de Funcionários</title>
	<link href="../css_js/css.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="../scripts.js"></script>
	<script language="javascript" src="../ajax.js"></script>

<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight: bold; }
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_func" action="cad_func_alt.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&y=<?PHP echo $_GET['y'];?>&fid=<?PHP echo $_GET[fid];?>" method="post">
<center>
<table width="700" border="0" align="center">
	<tr>
		<td class="fontebranca12" align="right">Selecione um Funcionário:</td>
			<?php if(!empty($cliente) && !empty($setor)){
               $con = "SELECT cod_func, nome_func, cod_funcao, cod_setor
               FROM funcionarios f
               WHERE f.cod_cliente = $cliente
               AND (f.cod_setor = $setor OR f.setor_adicional LIKE '%{$setor}%')
               OR f.cod_setor is null AND f.cod_cliente = $cliente
               order by nome_func";
						
				$res = pg_query($connect, $con) or die
					("Erro na Consulta: ==> $con". pg_last_error($connect));
				}
				
				echo "<td><select name=\"cod_func\" id=\"cod_func\" onblur=\"location.href='?cliente={$_GET[cliente]}&setor={$_GET[setor]}&y={$_GET[y]}&fid='+this.options[this.selectedIndex].value+'';\">";

				while ( $row_res = pg_fetch_array($res) ){
					echo"<option "; print $_GET[fid]==$row_res[cod_func]?"selected":""; echo " value=\"$row_res[cod_func]\">";
                    if(!$row_res[cod_setor])
                       echo "*";
                    echo $row_res[nome_func]."</option>";
					if($_GET[fid]==$row_res[cod_func]){
					   $cf = $row_res['cod_funcao'];
					}
				}	
				echo "</select>";			
			?>	
			&nbsp;&nbsp;<input type="button" value="OK">					
		</td>
	</tr>
</table>
<fieldset style="width:710;"><legend style="font-size:18px;">&nbsp;&nbsp;&nbsp;Cadastro de Funcionário&nbsp;&nbsp;&nbsp;</legend>
<table width="710" border="0" align="center">
	<tr>
		<th bgcolor="#FFFFFF" style="font-size:18px;"><br><font color="#000000">Dados Pessoais:</font><br> &nbsp;</th>
	</tr>
	<tr>
		<td>
			<table border="0" width="700" align="center">
				<tr>
					<td class="style2" align="right"><br>Nome:<br>&nbsp;</td>
				    <td>&nbsp;<input type="text" name="nome_func" size="30" value="<?php echo $row_func[nome_func] ?>"></td>
					<td class="style2" align="right">Sexo:&nbsp;</td>
					<td>&nbsp;<select name="sexo_func" style="width:180px;">
							  <option value="Masculino" <?php if($row_func[sexo_func]=="Masculino") echo "selected"; ?>>Masculino</option>
							  <option value="Feminino" <?php if($row_func[sexo_func]=="Feminino") echo "selected"; ?>>Feminino</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>RG:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="rg" size="30" value="<?php echo $row_func[rg] ?>"></td>
					<td class="style2" align="right">CPF:&nbsp;</td>
					<td>&nbsp;<input type="text" name="cpf" size="13" class="input" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)" value="<?php echo $row_func[cpf] ?>"></td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>PIS:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="pis" size="30" class="input" maxlength="14" onKeyPress="formatar('###.#####.##.#', this)" value="<?php echo $row_func[pis] ?>"></td>
					<td class="style2" align="right">BR/PDH:&nbsp;</td>
					<td>&nbsp;<select name="pdh">
							  <option value="N/A" <?php if($row_func[pdh]=="N/A") echo "selected"; ?>>Não Aplicável</option>
							  <option value="BR" <?php if($row_func[pdh]=="BR") echo "selected"; ?>>Beneficiário Reabilitado</option>
							  <option value="PDH" <?php if($row_func[pdh]=="PDH") echo "selected"; ?>>Portador de Deficiência Habilitado</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>CEP:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="cep" id="cep" size="15" onChange="showDataFunc();" value="<?php echo $row_func[cep] ?>"></td>
					<td class="style2" align="right">Endereço:&nbsp;</td>
					<td>&nbsp;<input type="text" name="endereco_func" id="endereco_func" size="35" value="<?php echo $row_func[endereco_func] ?>"></td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>Bairro:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="bairro_func" id="bairro_func" size="30" value="<?php echo $row_func[bairro_func] ?>"></td>
					<td class="style2" align="right">Cidade:&nbsp;</td>
					<td>&nbsp;<input name="cidade" id="cidade" type"text" size="35" value="<?php echo $row_func[cidade] ?>"></td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>Estado:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="estado" id="estado" size="30" value="<?php echo $row_func[estado] ?>"></td>
					<td class="style2" align="right">Natural:&nbsp;</td>
					<td>&nbsp;<input type="text" name="naturalidade" size="15" value="<?php echo $row_func[naturalidade] ?>"></td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>Nacionalidade:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="nacionalidade" size="30" value="<?php echo $row_func[nacionalidade] ?>"></td>
					<td class="style2" align="right">Estado Civil:&nbsp;</td>
					<td>&nbsp;<input type="text" name="civil" size="15" value="<?php echo $row_func[civil] ?>"></td>
				</tr>
				<tr>
					<td class="style2" align="right"><br>Dt. Nasc:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="data_nasc_func" size="30" class="input" maxlength="10" OnKeyPress="formatar('##/##/####', this)" title="DD/MM/YYYY" value="<?php echo $row_func[data_nasc_func] ?>"></td>
					<td class="style2" align="right">Cor:&nbsp;</td>
					<td>&nbsp;<input type="text" name="cor" size="15" value="<?php echo $row_func[cor] ?>"></td>
				</tr>
				<tr>
					<th bgcolor="#FFFFFF" colspan="6" style="font-size:18px;"><font color="#000000">Dados Profissionais:</font></th>
				</tr>
				<tr>
					<td class="style2" colspan="3"><br>Função:&nbsp;
					<?php 
					$sql_funcao = "SELECT *
								   FROM funcao								  
								   order by nome_funcao";
					
					$result_funcao = pg_query($connect, $sql_funcao) 
						or die ("Erro na query: $sql_funcao ==> " . pg_last_error($connect) );
					
					$rr = pg_fetch_all($result_funcao);
					for($x=0;$x<count($rr);$x++){
					    $txt .= urlencode($rr[$x][dsc_funcao])."|";
						
					}

					echo "<select name=\"cod_funcao\" id=\"cod_funcao\" onChange=\"func_cod('{$txt}');\">";

					while ( $row_funcao = pg_fetch_array($result_funcao) ){
					$tmp.= $row_funcao[cod_funcao]." - ";
						echo"<option "; print $cf==$row_funcao[cod_funcao] ? " selected " : " " ;echo " value=\"$row_funcao[cod_funcao]\">  " . ucwords( strtolower( $row_funcao[nome_funcao] ) ) . "</option>";
					}
					echo "</select>";
					
					?>
					  
						<br>
						&nbsp;
					</p></td>
			  		<td class="style2" colspan="3">Dinâmica da Função: &nbsp;
					<textarea id="dinamica_funcao" name="dinamica_funcao" rows="2" cols="50" class="fonte"><?PHP echo $row_func[dinamica_funcao];?></textarea><br>&nbsp;
					</td>
			  </tr>
				<tr>
					<td class="style2" colspan="4"><br>
						Data de Adimissão:&nbsp;
						<input type="text" name="data_admissao_func" size="8" class="input" maxlength="10" OnKeyPress="formatar('##/##/####', this)" title="DD/MM/YYYY" value="<?php echo $row_func[data_admissao_func]; ?>">
					    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						CBO: &nbsp;
					    <input type="text" name="cbo" size="10" class="input" title="Cadastro Brasileiro de Ocupação" value="<?php echo $row_func[cbo] ?>">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						CTPS: &nbsp;
						<input type="text" name="num_ctps_func" size="10" class="input" maxlength="10" value="<?php echo $row_func[num_ctps_func] ?>">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Série: &nbsp;
					    <input type="text" name="serie_ctps_func" size="10" class="input" maxlength="15" value="<?php echo $row_func[serie_ctps_func] ?>"> <br>&nbsp;
					</td>
				</tr>
				<tr>
					<td class="style2" colspan="4"><br>
					Regime de Revezamento:&nbsp;
					<input type="text" name="revezamento" size="10" class="input" value="<?php echo $row_func[revezamento] ?>">
					&nbsp;&nbsp;
					Status:&nbsp;
					<select name="cod_status">
					<?php
					$sql_status = "SELECT cod_status, dsc_status
								   FROM status
								   where cod_status <> 0
								   order by dsc_status";
					
					$result_status = pg_query($connect, $sql_status) 
						or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
					
					while ( $row_status = pg_fetch_array($result_status) ){
						if($row_func[cod_status]<>$row_status[cod_status]){
							echo"<option value=\"$row_status[cod_status]\"> &nbsp;&nbsp;&nbsp; " . $row_status[dsc_status] . "</option>";
						}else{
							echo"<option value=\"$row_status[cod_status]\" selected=selected> &nbsp;&nbsp;&nbsp; " . $row_status[dsc_status] . "</option>";
						}
					}
					
					?>
						</select>
					&nbsp;&nbsp;
					Último Exame:&nbsp;
					<input type="text" name="data_ultimo_exame" size="10" class="input" maxlength="10" OnKeyPress="formatar('##/##/####', this)" title="DD/MM/YYYY" value="<?php echo $row_func[data_ultimo_exame]; ?>">
					
					&nbsp;&nbsp;
					Demissão:&nbsp;
					<input type="text" name="data_desligamento_func" size="10" class="input" maxlength="10" OnKeyPress="formatar('##/##/####', this)" title="DD/MM/YYYY" value="<?php echo $row_func[data_desligamento_func]; ?>"><br>&nbsp;
					</td>
				</tr>
				</table>
				<table border="0" width="700" align="center">
				<tr>
    				 <td class="style2" align="right">Setores:</td>
                     <td colspan="4">
                     <?PHP					 
                         $sql = "SELECT cs.cod_setor, s.*
                         FROM cliente_setor cs, setor s
                         WHERE cs.cod_setor = s.cod_setor
                         AND cs.cod_cliente = {$_GET['cliente']}
						 order by s.nome_setor";
                         $result = pg_query($sql);
                         $sets = pg_fetch_all($result);
						 
						 if($_GET[fid]){
						 $q_func = "SELECT * FROM funcionarios WHERE cod_func = {$_GET[fid]} AND cod_cliente = {$_GET[cliente]}";
						 $result_func = pg_query($connect, $q_func);
						 $r_func = pg_fetch_all($result_func);
						 $rf = explode("|", $r_func[0]['setor_adicional']);
						 }

                        for($o=0;$o<pg_num_rows($result);$o++){
						 	if($_GET[fid]){
							    if(in_array($sets[$o][cod_setor], $rf) || $sets[$o][cod_setor] == $r_func[0][cod_setor]){
                                    echo "<input name=setarray[] type=checkbox value='{$sets[$o][cod_setor]}' checked> {$sets[$o][nome_setor]}<br>";
    							}else{
    							    echo "<input name=setarray[] type=checkbox value='{$sets[$o][cod_setor]}'> {$sets[$o][nome_setor]}<br>";
    							}
							}else{
							    echo "<input name=setarray[] type=checkbox value='{$sets[$o][cod_setor]}'> {$sets[$o][nome_setor]}<br>";
							}
						}
                     ?>
                     </td>
				</tr>
			</table>		
		</td>
	</tr>
	<tr>
		<th><hr></th>
	</tr>
	<tr>
		<th><br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra2_alt.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&y=<?PHP echo $_GET['y'];?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="cancelar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Gravar" style="width:100px;" name="btn_enviar" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Continuar >>" style="width:100px;" onClick="MM_goToURL('parent','ppra2_equip_alt.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&y=<?PHP echo $ano;?>&alt=sim&fid=<?PHP echo $_GET[fid];?>');return document.MM_returnValue">
			<br>&nbsp;
		</th>
	</tr>
</table>
</fieldset>
</center>
<input type="hidden" name="cliente" value="<?php echo $cliente; ?>" >
<input type="hidden" name="setor" value="<?php echo $setor; ?>" >
<input type="hidden" name="cod_func" value="<?php echo $row_max[cod_func]+1; ?>">
</form>
</body>
</html>