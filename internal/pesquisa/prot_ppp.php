<?PHP
if($_SESSION[cod_cliente]){
	$ses = "SELECT c.*, cn.* FROM cliente c, cnae cn WHERE c.cliente_id = {$_SESSION[cod_cliente]} AND c.cnae_id = cn.cnae_id";
	$ss = pg_query($ses);
	$row = pg_fetch_array($ss);
}

$meses = array("", "janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
?>
<form name="frm" id="frm" action="internal/pesquisa/print_prot_ppp.php" target="_blank" method="post" onsubmit="return prot(this);">
<table align="center" border="0">
<tr>
<td align="center" class="fontebranca22bold"><p><br>PROTOCOLO DE ENTREGA DO PPP</td>
</tr>
</table><br />
Todos os campos são obrigatórios.
<table align="center" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="18%" >Razão Social:</td>
		<td><input type="text" name="razao_social" id="razao_social" size="60" class="required" value="<?php echo $row[razao_social]; ?>" ></td>
	</tr>
	<tr>
		<td >CNPJ:</td>
		<td><input type="text" name="cnpj" id="cnpj" size="15" maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');" onkeydown="return only_number(event);" class="required" value="<?php echo $row[cnpj]; ?>" ></td>
	</tr>
	<tr>
		<td >CNAE:</td>
		<td><input type="text" name="cnae" id="cnae" size="15" maxlength="7" OnKeyPress="formatar(this, '##.##-#');" onkeydown="return only_number(event);" class="required" value="<?php echo $row[cnae]; ?>" ></td>
	</tr>
	<tr>
		<td >CEP:</td>
		<td><input type="text" id="cep" name="cep" size="15" maxlength="9" OnKeyPress="formatar(this, '#####-###');" class="required" onblur="check_cep(this);" value="<?php echo $row[cep]; ?>" >        </td>
	</tr>
	<tr>
		<td >Endereço:</td>
		<td><input type="text" id="endereco" name="endereco" size="30" class="required" value="<?php echo $row[endereco]; ?>" > Nº: <input type="text" id="numero" name="numero" size="5" class="required" value="<?php echo $row[num_end]; ?>" ></td>
	</tr>
	<tr>
		<td >Bairro:</td>
		<td><input type="text" id="bairro" name="bairro" size="15" class="required" value="<?php echo $row[bairro]; ?>" >
		<input type="hidden" name="cidade" id="cidade" />
		<input type="hidden" name="estado" id="estado" />
		</td>
	</tr>
	<tr>
		<td >Funcionário:</td>
		<td><select name="funcionario" id="funcionario" class="required" onchange="check_func(this);">
			<option></option>
			<?php
			$funci = "SELECT * FROM funcionarios WHERE cod_cliente = {$_SESSION[cod_cliente]}";
			$fun = pg_query($funci);
			while($r_fun = pg_fetch_array($fun)){
				echo "<option value='$r_fun[nome_func]'> {$r_fun[nome_func]} </option>";
			}
			?>
		</select>
		<span id="load"></span>
		</td>
	</tr>
	<tr>
		<td >CBO:</td>
		<td><input type="text" name="cbo" id="cbo" size="10" class="required" value=""> CTPS: <input type="text" name="ctps" id="ctps" size="10" class="required" value="" > Série: <input type="text" name="serie" id="serie" size="10" class="required" value="" ></td>
	</tr>
	<tr>
		<th colspan="2">
        <br><input type="submit" value="Avançar" name="btn_enviar" class="button" ></th>
	</tr>
</table>
</form>