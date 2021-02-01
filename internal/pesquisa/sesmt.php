<?PHP
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

   if($func >= 50 && $func <=100){
      $table = 1;
   }elseif($func >= 101 && $func <=250){
      $table = 2;
   }elseif($func >= 251 && $func <=500){
      $table = 3;
   }elseif($func >= 501 && $func <=1000){
      $table = 4;
   }elseif($func >= 1001 && $func <=2000){
      $table = 5;
   }elseif($func >= 2001 && $func <=3500){
      $table = 6;
   }elseif($func >= 3501 && $func <=5000){
      $table = 7;
   }elseif($func > 5000){
      $table = 8;
   }else{
   
   }

?>
Todos os campos são de preenchimento obrigatório.
<form method="post" onsubmit="return dim(this);">
<table align="center" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="50%" align=right>Nº de Colaboradores:</td>
		<td width="50%"><input type="text" name="f" size="5" class="required" onkeydown="return only_number(event);" value="<?php echo $row[numero_funcionarios]; ?>" ></td>
	</tr>
	<tr>
		<td width="50%" align=right>Grau de Risco:</td>
		<td width="50%"><input type="text" name="risco" size="5" class="required" maxlength="1" onkeydown="return only_number(event);" value="<?php echo $row[grau_de_risco]; ?>" ></td>
	</tr>
	<tr>
		<th colspan="2"><input type="submit" value="Buscar" name="btn_enviar" class="button" ></th>
	</tr>
</table>
</form>

<?php
if($risco != ""){
    if($risco >=5 || $risco <=0){
        echo "<script>alert('Grau de risco inválido! \\nInforme um valor entre 1 e 4.');</script>";
        exit;
    }
	$sql = "SELECT * FROM cons_dim WHERE risco=".$risco;
	$result = pg_query($conn, $sql);
	$row = pg_fetch_all($result);
echo "<br><table align=center width=100% border=0 cellpadding=2 cellspacing=2>
	<tr>
		<td align=center colspan=2 class=bgTitle>Registro do SESMT</td>
	</tr>";
	for($x=0;$x<pg_num_rows($result);$x++){
	    if($x % 2)
		    $bg = 'bgContent1';			
		else
		    $bg = 'bgContent2';
		
	   $t = "fun".$table;
		echo "<tr>
			<td width=\"50%\" class=$bg>";
	   if($row[$x][$t]!=""){
		  echo $row[$x]['tecnicas']."</td>
		  	<td width=50% class=$bg>".$row[$x][$t]."</td>";
	   }else{
		  echo $row[$x]['tecnicas']."</td>
		  	<td width=50% class=$bg> Não necessário.</td>";
	   }
echo "</td></tr>";
	}
echo "</table>";

if($risco =! ""){
	$sql = "SELECT * FROM cons_dim WHERE risco=".$_POST['risco'];
	$result = pg_query($conn, $sql);
	$row = pg_fetch_all($result);
	$t = "fun".$table;

echo"<form name=form1 id=form1 action=\"internal/pesquisa/print_sesmt.php\" method=post target=\"_blank\">";

if($row[0][$t] || $row[1][$t] ||$row[2][$t]|| $row[3][$t] || $row[4][$t]){
echo "<br><table align=center width=100% border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td align=center colspan=2>Entre com os Dados do Profissional</td>
	</tr>
	</table>";
}
$rr = array();
	for($x=0;$x<5;$x++){
	  for($z=0;$z<$row[$x][$t];$z++){
	  $rr[] = $row[$x]['tecnicas'];
		echo "<table align=center width=100% border=0 cellpadding=5 cellspacing=2>
			  	<tr>
					<td align=center colspan=2 width=50%><b>{$row[$x]['tecnicas']}</b></td>
				</tr>
			  	<tr>
					<td width=50%>Nome do Profissional:</td>
			  		<td><input type=text class=required name=tecnico[] id=tecnico size=40><br></td>
				</tr>
			  	<tr>
					<td width=50%>Habilitação do Profissional:</td>
			  		<td><input type=text class=required name=habilitacao[] id=habilitacao size=40><br></td>
				</tr>
			  	<tr>
					<td width=50%>Regime de Horário do Profissional:</td>
			  		<td><input type=text class=required name=horario[] id=horario maxlength=5 onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##:##');\" size=40><br></td>
				</tr>
			  </table><br>";
	  }
	}
echo "<input type=hidden name=tec value=".urlencode(serialize($rr)).">";
}

	if($row[0][$t] || $row[1][$t] ||$row[2][$t]|| $row[3][$t] || $row[4][$t]){
		echo"<table align=center width=90% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center colspan=2>
					<input type=submit class=button name=write id=write value='Enviar' OnClick=\"return Write();\">
				</td>
			</tr>
		</table><br>&nbsp;";
		
		echo"<table align=center width=90% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td >(*) Tempo parcial (mínimo de três horas).<br>&nbsp;</td>
			</tr>
			<tr>
				<td >(**) O dimensionamento total deverá ser feito levando-se em consideração o dimensionamento de faixas de 3501 a 5000 mais o dimensionamento do(s) grupo(s) de 4000 ou fração acima de 2000.<br>&nbsp;</td>
			</tr>
			<tr>
				<td >OBS: Hospitais, Ambulatórios, Maternidade, Casas de Saúde e Repouso, Clínicas e estabelecimentos similares com mais de 500 (quinhentos) empregados deverão contratar um Enfermeiro em tempo integral.</td>
			</tr>
		</table><br>";
	}
}
echo "</form>";
?>