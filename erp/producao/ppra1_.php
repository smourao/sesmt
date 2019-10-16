<?php 	/*echo "<script>alert('Aquiiiiiiii');</script>".$filial;*/

include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$cliente = $_POST["cliente_id"];
$setor   = $_POST["cod_setor"];

if ($cliente!="" and $setor!="" and $_POST[btn_enviar]=="Gravar"){
/* Verifica se o cliente e o setor já estão cadastrados */
	$cod = "select max(cod_ppra) as cod_ppra from cliente_setor";//cria código automático do orçamento
    $res = pg_query($cod) or die ("erro na consulta". pg_last_error($connect));
	$row = pg_fetch_array($res);
	$cod_ppra = $row[cod_ppra] + 1;
	$tsetor = $_POST[tipo_setor];
	for($x=0;$x<$_POST['num_setores'];$x++){

	$sql = "select c.razao_social, s.nome_setor
			from cliente_setor cs, cliente c, setor s
			where cs.cod_cliente = c.cliente_id 
			and cs.cod_setor = s.cod_setor
			and cs.cod_cliente = $cliente
			and cs.cod_setor = $setor[$x]";
			
	$consulta = pg_query($connect, $sql);	

	if(pg_num_rows($consulta)==0){ // se quantidade de linhas retornadas na consulta for diferente de zero...
	
		$insert = "insert into cliente_setor(cod_cliente, cod_setor, tipo_setor, cod_ppra, data_criacao, jornada)
				   values ($cliente, $setor[$x], '{$tsetor[$x]}', $cod_ppra,'".date('Y/m/d')."', '$jornada')";
		$result_insert = pg_query($connect, $insert)
			or die ("Erro na query: $insert ==> " . pg_last_error($connect) );
		if ($result_insert){
			header("location: lista_ppra.php?cliente=$cliente");
		}
	}
	else{ // se a quantidade de registros for igual a zero...
		$row = pg_fetch_array($consulta);
		echo "<script>alert(\"O Setor '$row[nome_setor]' no Cliente '$row[razao_social]' já está cadastrado!\");</script>";
	}
}
} else {
	$cod_ppra = $cod_ppra;
}
?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra1" method="post" action="ppra1.php">
<table align="center" width="770" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <th colspan="2" bgcolor="#009966" ><br>
        <h2>Gerar Relatório</h2>
        <p>
		Escolha o <U>Cliente</U> e selecione o <U>Setor</U> :<br>
&nbsp;    </th>
  </tr>
  </tr>
    <td colspan="2">&nbsp;</td>
  </tr>
<?php
  /*****************
  	Parte destinada a erros!
   *****************/
  	if($_GET["erro"]==1){
		echo "<tr>
				<th colspan=2 bgcolor=#FFFFFF>
					<font color=#FF0000><b><br>Preencha todos os campos corretamente!</b><br>&nbsp;</font>
				</th>
			  </tr>
		      <tr>
				 <td colspan=2>&nbsp;</td>
			  </tr>";
	}
?>
  <tr>
  	<th colspan="2">
		<br>
		Cliente: &nbsp; <input type="text" name="cliente_pesq" size="8" value="<?php echo $_POST[cliente_pesq];?>"> 
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Nº de Setores:&nbsp; <input type="text" name="num_setores" size="8" value="<?php echo $_POST[num_setores];?>">
		<br>&nbsp;
	</th>
  </tr>
  <tr>
  	<th>
		 <br>
		<input type="submit" name="btn_busca" value="Buscar" style="width:100;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
		<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;"><br>&nbsp;	</th>
  </tr>
<?php
// trecho que realiza a busca dos clientes pelo que foi digitado
	if ( !empty($_POST[cliente_pesq]) and $_POST[btn_busca]=="Buscar")
	{
		echo "  <tr>";
		echo "	<th class=\"style1\" colspan=2> Resultado da busca:</th>";
		echo "</tr>";
		echo "<tr>";
		echo "  <td colspan=2> <br>";
if(is_numeric($cliente_pesq)){
		$sql_busca = "select cliente_id, razao_social
						, substr(razao_social,1,60) as razao_social
					  from cliente c
					  where cliente_id = $cliente_pesq ";


}else{
		$sql_busca = "select cliente_id, razao_social
						, substr(razao_social,1,60) as razao_social
					  from cliente c
					  where lower(razao_social) like '%". strtolower(addslashes($cliente_pesq)) ."%'";
}

		$sql_busca = $sql_busca . " order by cliente_id ";
		
		$consulta_busca = pg_query($connect, $sql_busca);
		
		if ( pg_num_rows($consulta_busca) == 0 )
		{
			echo "<script>alert('A busca pelo Cliente: \"$_POST[cliente_pesq]\" não retornou resultado.');</script>";
		}
		else /* if (pg_num_rows($consulta_busca)==0) */ {
			while($row_busca = pg_fetch_array($consulta_busca)){
				echo"<input type=\"radio\" name=\"cliente_id\" value=\"$row_busca[cliente_id]\" checked>$row_busca[razao_social] 
					- Jornada Trabalhada:&nbsp;<input type=text name=jornada size=5>";
			}
		}
		echo "<br> &nbsp;	</td>";
		echo " </tr>";
	}

if ( ($consulta_busca) and pg_num_rows($consulta_busca) > 0 ){
for($x=0;$x<$_POST['num_setores'];$x++){
?>
  <tr>
  	<td><br><b>&nbsp;&nbsp;Selecione o Setor:</b>&nbsp;
		<select name="cod_setor[]">
<?php
$query_setor = "SELECT cod_setor
				, desc_setor
				, nome_setor
			  FROM setor
			  where cod_setor <> 0
			  order by nome_setor";

$result_setor = pg_query($connect, $query_setor) 
or die ("Erro na query: $query_setor ==> " . pg_last_error($connect) );

while($row_setor = pg_fetch_array($result_setor)){

	echo "<option value=$row_setor[cod_setor]> $row_setor[nome_setor] </option>";

}
?>
		</select>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo do Setor:</b>&nbsp;
		<select name="tipo_setor[]">
			<option value="Administrativo">Administrativo</option>
			<option value="Operacional">Operacional</option>
		</select>
		<br>&nbsp;	</td>
  </tr>
<?PHP
}
?>
  <tr>
    <th colspan="2" bgcolor="#009966"> <br>
        <input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
      &nbsp;&nbsp;&nbsp;
      <input name="reset" type="reset" style="width:100;"  value="Limpar">
      &nbsp;&nbsp;&nbsp;
      <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
      <br>
      &nbsp; </th>
  </tr>
<?php
}
// encerrar conexão
pg_close($connect);
?>
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>