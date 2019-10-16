<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "../sessao.php";

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
}
else{
	$cliente = $_POST["cod_cliente"];
	$setor = $_POST["cod_setor"];
}

if ( $_POST[btn_enviar] == "Gravar" and !empty($cliente) ){ // realizar o cadastro

	$sql_testa = "SELECT * FROM cliente_setor where cod_cliente = $cliente and cod_setor = $setor";
	$result_testa = pg_query($connect, $sql_testa)
		or die ("Erro na query: $sql_testa ==> " . pg_last_error($connect) );
	$row_ = pg_fetch_array($result_testa);

	if( pg_num_rows($result_testa) > 0 ){
	
		$sql_func = "select max(cod_func)+1 as cod_func from funcionarios";
		$result_func = pg_query($connect, $sql_func)
			or die ("Erro na query: $sql_func ==> " . pg_last_error($connect) );
		$row_func = pg_fetch_array($result_func);
		$cod_func = $row_func[cod_func];
	
		if ( empty($cod_func) ){ $cod_func = 1;}
	
		$sql = "INSERT INTO funcionarios(
					  cod_func
					, nome_func
					, tel_func
					, endereco_func
					, bairro_func
					, cel_func
					, email_func
					, num_ctps_func
					, serie_ctps_func
					, cbo
					, cidade
					, cod_status
					, cod_funcao
					, cod_setor
					, cod_cliente
					, cpf_func
					, sexo_func
					, data_nasc_func
					, data_admissao_func
					, data_desligamento_func
					, dinamica_funcao)
				VALUES ( 
						 $cod_func
						, '$_POST[nome_func]'
						, '$_POST[tel_func]'
						, '$_POST[endereco_func]'
						, '$_POST[bairro_func]'
						, '$_POST[cel_func]'
						, '$_POST[email_func]'
						, '$_POST[num_ctps_func]'
						, '$_POST[serie_ctps_func]'
						, '$_POST[cbo]'
						, '$_POST[cidade]'
						, $_POST[cod_status]
						, $_POST[cod_funcao]
						, $setor
						, $cliente
						, '$_POST[cpf_func]'
						, '$_POST[sexo_func]'
						, '$_POST[data_nasc_func]'
						, '$_POST[data_admissao_func]'
						, '$_POST[data_desligamento_func]'
						, '$_POST[dinamica_funcao]')";
	
		$result = pg_query($connect, $sql)
			or die ("Erro na query $sql ==>" . pg_last_error($connect) );
	
		if ($result){
			echo "<script> alert('Funcionário Cadastrado com Sucesso!');</script>)";
		}

	} else{
		echo "<script> alert('Setor não cadastrado para o Cliente selecionado!');</script>";
		$cliente = "";
		$setor = "";
	}
}
?>
<html>
<head>
	<title>Cadastro de Funcionários</title>
	<link href="../css_js/css.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="../scripts.js"></script>
<style >
	.fonte {
		font-family: verdana, arial, helvetica, sans-serif;
		font-weight: normal;
		color:#000000;
		text-decoration: none;
	}
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_func" action="cad_func.php" method="post">
<center>
<fieldset style="width:710;"><legend>&nbsp;&nbsp;&nbsp;Cadastro de Funcionário&nbsp;&nbsp;&nbsp;</legend>
<table width="700" border="0" align="center">
	<tr>
		<th bgcolor="#FFFFFF"><br><font color="#000000">Dados Pessoais:</font><br> &nbsp;</th>
	</tr>
	<tr>
		<td>
			<table border="0" width="700" align="center">
				<tr>
					<td align="right"><br>Nome:<br>&nbsp;</td>
				    <td>&nbsp;<input type="text" name="nome_func" size="35" value="<?php echo $row_func[nome_func] ?>"></td>
					<td align="right">Sexo:&nbsp;</td>
					<td> 
						&nbsp;<select name="sexo_func" style="width:180px;">
							<option value="Homem">Masculino</option>
							<option value="Mulher">Feminino</option>
						</select>				    </td>
				</tr>
				<tr>
					<td align="right"><br>Endereço:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="endereco_func" size="35"></td>
					<td align="right">Cidade:&nbsp;</td>
					<td>&nbsp;<input name="cidade" type"text" size="35"></td>
				</tr>
				<tr>
					<td align="right"><br>Bairro:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="bairro_func" size="35"></td>
					<td align="right">Telefone:&nbsp;</td>
					<td>&nbsp;<input type="text" name="tel_func" size="35"></td>
				</tr>
				<tr>
					<td align="right"><br>E-mail:<br>&nbsp;</td>
					<td>&nbsp;<input type="text" name="email_func" size="35"></td>
					<td align="right">Celular:&nbsp;</td>
					<td>&nbsp;<input type="text" name="cel_func" size="15"></td>
				</tr>
				<tr>
					<td colspan="4">
						&nbsp;&nbsp; Data de Nascimento:&nbsp;<input type="text" name="data_nasc_func" size="8" class="input" maxlength="10" title="DD/MM/YYYY">
						&nbsp;Data de Adimissão:&nbsp;<input type="text" name="data_admissao_func" size="8" class="input" maxlength="10" title="DD/MM/YYYY">
						&nbsp;CPF:&nbsp;<input type="text" name="cpf_func" size="13" class="input" maxlength="14" onKeyPress="cpf(this)"> <br>&nbsp;					</td>
				</tr>
				<tr>
					<th bgcolor="#FFFFFF" colspan="4"><font color="#000000">Dados Profissionais:</font></th>
				</tr>
				<tr>
					<td colspan="2"><br>Função:&nbsp;
						<select name="cod_funcao">
					      <?php 
					$sql_funcao = "SELECT cod_funcao, substr(dsc_funcao,1,80) as dsc_funcao, nome_funcao
								  FROM funcao_cliente
								   where cod_funcao <> 0
								   order by nome_funcao";
					
					$result_funcao = pg_query($connect, $sql_funcao) 
						or die ("Erro na query: $sql_funcao ==> " . pg_last_error($connect) );
					
					while ( $row_funcao = pg_fetch_array($result_funcao) ){
						echo"<option value=\"$row_funcao[cod_funcao]\">  " . ucwords( strtolower( $row_funcao[nome_funcao] ) ) . "</option>";
					}
					
					?>
					  </select>
						<br>
						&nbsp;
					</p></td>
			  		<td colspan="2">Dinâmica da Função: &nbsp;
					<textarea name="dinamica_funcao" rows="3" cols="30" class="fonte"></textarea><br>&nbsp;</td>
			  </tr>
				<tr>
					<td colspan="4"><br>
					    CBO: &nbsp;
					  <input type="text" name="cbo" size="10" class="input" title="Cadastro Brasileiro de Ocupação">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CTPS: &nbsp;
						<input type="text" name="num_ctps_func" size="10" class="input" maxlength="10">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;Série: &nbsp;
					    <input type="text" name="serie_ctps_func" size="10" class="input" maxlength="15" > <br>&nbsp;					</td>
				</tr>
				<tr>
					<td>Status:&nbsp;</td>
					<td>
						<select name="cod_status" style="width:180px;">
					<?php
					$sql_status = "SELECT cod_status, dsc_status
								   FROM status
								   where cod_status <> 0
								   order by dsc_status";
					
					$result_status = pg_query($connect, $sql_status) 
						or die ("Erro na query: $sql_status ==> " . pg_last_error($connect) );
					
					while ( $row_status = pg_fetch_array($result_status) ){
						echo"<option value=\"$row_status[cod_status]\"> &nbsp;&nbsp;&nbsp; " . $row_status[dsc_status] . "</option>";
					}
					
					?>
						</select><br></td>

					<td>* Em caso de demissão: &nbsp;</td>
					<td><input type="text" name="data_desligamento_func" size="10" class="input" maxlength="10" title="DD/MM/YYYY"></td>
				</tr>
			</table>		
		</td>
	</tr>
	<tr>
		<th><hr></th>
	</tr>
	<tr>
		<th><br>
			<input type="submit" value="Gravar" style="width:150px;" name="btn_enviar" onClick="MM_goToURL('parent','cad_func.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Limpar" style="width:150px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Avançar" style="width:100px;" onClick="MM_goToURL('parent','ppra2_equip.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue">
			<br>
&nbsp;		</th>
	</tr>
</table>
</fieldset>
</center>
<input type="hidden" name="cod_cliente" value="<?php echo $cliente?>" >
<input type="hidden" name="cod_setor" value="<?php echo $setor?>" >
</form>
</body>
</html>