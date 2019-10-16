<html>
<head>
	<title>Alteração de Funcionário</title>
	<link href="../css_js/css.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="../scripts.js"></script>
	<style >
		.fonte {
			font-family: "Times New Roman", Times, serif
			font-size: 10px;
			font-weight: normal;
			color:#000000;
			text-decoration: none;
		}
	</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_func" action="alt_func.php" method="post">
<?php

include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
	$func    = $_GET["id"];
}
else{
	$cliente = $_POST["cod_cliente"];
	$setor   = $_POST["cod_setor"];
	$func    = $_POST["cod_func"];
}

if ( $_POST[btn_enviar] == "Alterar" ){

/********************************* TRATAMETO PARA DATA **********************************/
	if( $_POST[data_nasc_func] == "" ) {$data_nasc_func = "null";} else { $data_nasc_func = "'$_POST[data_nasc_func]'"; }
	if( $_POST[data_admissao_func] == "" ) {$data_admissao_func = "null";} else { $data_admissao_func = "'$_POST[data_admissao_func]'"; }
	if( $_POST[data_desligamento_func] == "" ) {$data_desligamento_func = "null";} else { $data_desligamento_func = "'$_POST[data_desligamento_func]'"; }
/*******************************************************************/

	$sql_insert = "UPDATE funcionarios
				   SET nome_func='$_POST[nome_func]', tel_func='$_POST[tel_func]', endereco_func='$_POST[endereco_func]', bairro_func='$_POST[bairro_func]', 
					   cel_func='$_POST[cel_func]', email_func='$_POST[email_func]', num_ctps_func='$_POST[num_ctps_func]', serie_ctps_func='$_POST[serie_ctps_func]', 
					   cbo='$_POST[cbo]', cod_cidade=$_POST[cod_cidade], cod_status=$_POST[cod_status], cod_setor=$setor, 
					   cod_cliente=$cliente, cpf_func='$_POST[cpf_func]', sexo_func='$_POST[sexo_func]', data_nasc_func=$data_admissao_func, data_admissao_func=$data_admissao_func, 
					   data_desligamento_func=$data_desligamento_func, dinamica_funcao = '$_POST[dinamica_funcao]'
				 WHERE cod_cliente = $cliente and cod_setor = $setor and cod_func = $func";
//	echo $sql_insert . "<p>";
	$result_insert = pg_query($connect, $sql_insert)
		or die ("Erro na query: $sql_insert ==> " . pg_last_error($connect) );
	
	if($result_insert){
		echo "<script>alert('Dados atualizados com sucesso!');</script>";
	}
		
}

if ( !empty($cliente) and !empty($setor) and !empty($func) ){ // verifica se os dados estão preenchidos

	$sql_busca = "SELECT cod_func, nome_func, tel_func, endereco_func, bairro_func, cel_func, 
					   email_func, num_ctps_func, serie_ctps_func, cbo, cod_cidade, 
					   cod_status, cod_funcao, cod_setor, cod_cliente, cpf_func, sexo_func, 
					   data_nasc_func, data_admissao_func, data_desligamento_func, dinamica_funcao
				  FROM funcionarios
				  WHERE cod_cliente = $cliente and cod_setor = $setor and cod_func = $func";

	$result_busca = pg_query($connect, $sql_busca)
		or die ("Erro na query: $sql_busca ==> " . pg_last_error($connect) );

	$row = pg_fetch_array($result_busca);

?>
<center>
<fieldset style="width:850;"><legend>&nbsp;&nbsp;&nbsp;Cadastro de Funcionário&nbsp;&nbsp;&nbsp;</legend>
<table width="800" border="0" align="center">
	<tr>
		<th bgcolor="#FFFFFF"><br><font color="#000000">Dados Pessoais:</font><br> &nbsp;</th>
	</tr>
	<tr>
		<td>
			<table border="0" width="800" align="center">
				<tr>
					<td><br>&nbsp;&nbsp;&nbsp; Nome:<br>&nbsp;</td>
				    <td class="input"><input type="text" name="nome_func" size="50" value="<?php echo $row[nome_func];?>" ></td>
					<td>&nbsp;&nbsp;&nbsp; Sexo:</td>
					<td><br>
						<select name="sexo_func" style="width:180px;">
							<option value="Homem">Masculino</option>
							<option value="Mulher">Feminino</option>
						</select><br>&nbsp;				    </td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp; Endereço:<br>
				  &nbsp;</td>
					<td><textarea name="endereco_func" rows="3" cols="52" class="fonte"><?php echo $row[endereco_func];?></textarea><br>&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp; Estado - Cidade:<br>&nbsp;</td>
					<td>
						<select name="cod_cidade" style="width:180px;">
<?php
$sql_cidade = "SELECT c.cod_cidade, c.nome_cidade , e.sigla_estado
			   FROM cidades c, estado e
			   where c.cod_estado = e.cod_estado
			   and c.cod_cidade <> 0
			   order by e.sigla_estado";

$result_cidade = pg_query($connect, $sql_cidade) 
	or die ("Erro na query: $sql_cidade ==> " . pg_last_error($connect) );

while ( $row_cidade = pg_fetch_array($result_cidade) ){
	if( $row[cod_cidade] == $row_cidade[cod_cidade] ){
		echo"<option value=\"$row_cidade[cod_cidade]\" selected> $row_cidade[sigla_estado] - " . $row_cidade[nome_cidade] . "</option>";
	}
	else{
		echo"<option value=\"$row_cidade[cod_cidade]\"> $row_cidade[sigla_estado] - " . $row_cidade[nome_cidade] . "</option>";
	}
}
?>
						</select><br>&nbsp;					</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp; Bairro:<br>&nbsp;</td>
					<td><input type="text" name="bairro_func" size="50" class="input" value="<?php echo $row[bairro_func];?>"><br>&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp; Telefone:<br>&nbsp;</td>
					<td><input type="text" name="tel_func" size="30" class="input" value="<?php echo $row[tel_func];?>"><br>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp; E-mail:<br>&nbsp;</td>
					<td><input type="text" name="email_func" size="50" class="input" value="<?php echo $row[email_func];?>"><br>&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp; Celular:<br>&nbsp;</td>
					<td><input type="text" name="cel_func" size="30" class="input" value="<?php echo $row[cel_func];?>"><br>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4">
						&nbsp;&nbsp;&nbsp; Data de Nascimento: &nbsp; <input type="text" name="data_nasc_func" value="<?php echo $row[data_nasc_func];?>" size="10" class="input" maxlength="10" title="DD/MM/YYYY">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp;  Data de Adimissão: &nbsp;
						<input type="text" name="data_admissao_func" size="10" class="input" maxlength="10" title="DD/MM/YYYY" value="<?php echo $row[data_admissao_func];?>">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; CPF: &nbsp;
                        <input type="text" name="cpf_func" size="15" class="input" maxlength="15" title="999.999.999-99" value="<?php echo $row[cpf_func];?>" > <br>&nbsp;					</td>
				</tr>
				<tr>
					<th bgcolor="#FFFFFF" colspan="4"><font color="#000000">Dados Profissionais:</font></th>
				</tr>
				<tr>
					<td colspan="4"><br>Função: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="cod_funcao">
					      <?php
					$sql_funcao = "SELECT cod_funcao, substr(dsc_funcao,1,80) as dsc_funcao, nome_funcao
								  FROM funcao f
								   where cod_funcao <> 0
								   order by nome_funcao";
					
					$result_funcao = pg_query($connect, $sql_funcao) 
						or die ("Erro na query: $sql_funcao ==> " . pg_last_error($connect) );
					
					while ( $row_funcao = pg_fetch_array($result_funcao) ){

						if ($row_funcao[cod_funcao] <> $row[cod_funcao] ){
							echo"<option value=\"$row_funcao[cod_funcao]\" >  $row_funcao[dsc_funcao] </option>";
						}
						else{
							echo"<option value=\"$row_funcao[cod_funcao]\" selected>  $row_funcao[dsc_funcao] </option>";
						}
					}
					
					?>
					  </select>
						<br>
						&nbsp;
					</p></td>
			  	</tr>

				<tr>
					<td colspan="4"><br>
					    &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;&nbsp;&nbsp; Código CBO: &nbsp;
					  <input type="text" name="cbo" size="10" class="input" title="Cadastro Brasileiro de Ocupação" value="<?php echo $row[cbo];?>">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Núm. Carteira de Trabalho: &nbsp;<input type="text" name="num_ctps_func" value="<?php echo $row[num_ctps_func];?>" size="10" class="input" maxlength="10">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;Série: &nbsp;
					    <input type="text" name="serie_ctps_func" size="15" class="input" maxlength="15" value="<?php echo $row[serie_ctps_func];?>" > <br>&nbsp;					</td>
				</tr>
					<td>&nbsp;&nbsp;&nbsp; Status:<br>&nbsp;</td>
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
	if( $row[cod_status] == $row_status[cod_status] ){
		echo"<option value=\"$row_status[cod_status]\">" . $row_status[dsc_status] . "</option>";
	}
	else{
		echo"<option value=\"$row_status[cod_status]\" selected>" . $row_status[dsc_status] . "</option>";
	}
}

?>
						</select><br>&nbsp;
					</td>

				<tr>
					<td> Dinâmica da Função: &nbsp; </td>
					<td><textarea name="dinamica_funcao" rows="3" cols="52" class="fonte"><?php echo $row[dinamica_funcao];?></textarea><br>&nbsp;</td>
					<td>* Em caso de demissão: &nbsp;</td>
					<td> <input type="text" name="data_desligamento_func" size="10" class="input" maxlength="10" title="DD/MM/YYYY" value="<?php echo $row[data_desligamento_func];?>">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th><hr></th>
	</tr>
	<tr>
		<th><br>
			<input type="submit" value="Alterar" style="width:150px;" name="btn_enviar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Limpar" style="width:150px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="<< Voltar" style="width:100px;" onClick="MM_goToURL('parent','ppra5.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue">
			<br>&nbsp;
			<input type="hidden" name="cod_func" value="<?php echo $row[cod_func];?>" >
		</th>
	</tr>
</table>
</fieldset>
</center>
<input type="hidden" name="cod_cliente" value="<?php echo $cliente?>" >
<input type="hidden" name="cod_setor" value="<?php echo $setor?>" >
</form>
</body>
</html>
<?php
}// verifica se os dados estão preenchidos
else {
	header("location: lista_func.php?erro=1");
}
?>