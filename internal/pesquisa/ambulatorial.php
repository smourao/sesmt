<?php
$func = $_POST['f'];
$risco = $_POST['risco'];

if($_SESSION[cod_cliente]){
	$ses = "SELECT * FROM cliente WHERE cliente_id = {$_SESSION[cod_cliente]}";
	$ss = pg_query($ses);
	$row = pg_fetch_array($ss);
}
if($_POST){
	$row[numero_funcionarios] = $func;	
	$row[grau_de_risco] = $risco;
}
?>
<center><img src='images/dim_amb.jpg' border=0></center>
Todos os campos são de preenchimento obrigatório.<p>
<form method="post" onsubmit="return dim(this);">
<table width="100%" align="center" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="50%" align="right" >Nº de Colaboradores:</td>
		<td width="50%" ><input class="required" type="text" name="f" id="f" size="5" onkeydown="return only_number(event);" value="<?php echo $row[numero_funcionarios]; ?>" ></td>
	</tr>
	<tr>
		<td width="50%" align="right" >Grau de Risco:</td>
		<td width="50%" ><input class="required" type="text" name="risco" id="risco" size="5" maxlength="1" onkeydown="return only_number(event);" value="<?php echo $row[grau_de_risco]; ?>" ></td>
	</tr>
	<tr>
		<th colspan="2"><br /><input type="submit" value="Buscar" name="btn_enviar" onclick="return pesq();"></th>
	</tr>
</table>
<?php
if($_POST){
	if($risco >=5){
        echo "<script>alert('Grau de risco inválido! \\nInforme um valor entre 1 e 4.');</script>";
        exit;
    }
	if(($risco <= 2 and $func >= 1001) || ($risco == 3 and $func >= 501) || ($risco == 4 and $func >= 101)){
		echo "<br><table align=center width=90% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td>Baseado no dimensionamento do SESMT (NR4), esta empresa deverá ter um ambulatório próprio de atendimento em saúde ocupacional.</td>
			</tr>
		</table>";	
	}else{
		echo "<br><table align=center width=90% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td>Baseado no dimensionamento do SESMT (NR4), esta empresa <font color=#ff0000>NÃO</font> é obrigado a ter um ambulatório próprio de atendimento em saúde ocupacional.</td>
			</tr>
		</table>";	
	}
}
?>
</form>