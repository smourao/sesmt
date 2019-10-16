<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$cliente = $_POST["cod_cliente"];
$setor   = $_POST["cod_setor"];
//$filial  = $_POST["cod_filial"];

if( !empty($cliente) and !empty($setor) and $_POST[btn_enviar]=="Enviar" ){
		header("location: http://www.sesmt-rio.com/erp/medico/lista_func_aso.php?cliente=$cliente&setor=$setor");
		//header("location: http://localhost/erp/medico/lista_func_aso.php?cliente=$cliente&setor=$setor&filial=$filial");
}
//echo "<script>alert('CLIENTE: $cliente');<script>"
?>
<html>
<head>
<title>Pesquisa de Clientes</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="form1" method="post" action="pesq_cli.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <th colspan="2" bgcolor="#009966" ><br>
        <h2>Pesquisa de Clientes</h2>
        <p>
		Escolha o <U>Cliente</U> e selecione o <U>Setor</U> :<br>
		&nbsp;
    </th>
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
  	<td width="210"><br><b>&nbsp;Cód/Nome do Cliente:<br>&nbsp;</td>
	<td width="490"> 
		<br>
		&nbsp;&nbsp;&nbsp;<input type="text" name="cliente_pesq" size="25"> 
		&nbsp;&nbsp;&nbsp;<input type="submit" name="btn_busca" value="Buscar" style="width:100;"> <br>&nbsp;
	</td>
  </tr>
<?php
// trecho que realiza a busca dos clientes pelo que foi digitado
	if ( (!empty($_POST[cliente_pesq]) and $_POST[btn_busca]=="Buscar") or ( !empty($cliente) and $_POST[btn_enviar]=="Enviar" ) )
	{
		echo "  <tr>";
		echo "	<th class=\"style1\" colspan=2> Resultado da busca:</th>";
		echo "</tr>";
		echo "<tr>";
		echo "  <td colspan=2> <br>";

if ( !empty($_POST[cliente_pesq]) ){
	$cliente_busca = $_POST[cliente_pesq];
}else if ( !empty($cliente) ){
	$cliente_busca = $cliente;
}
	if(is_numeric($cliente_busca)){
		$sql_busca = "select cliente_id, razao_social
					  from cliente c
					  where cliente_id = $cliente_busca
					  order by cliente_id";
	}else{
		$sql_busca = "select cliente_id, razao_social
					  from cliente c
					  where lower(c.razao_social) LIKE '%".strtolower(addslashes($cliente_busca))."%'
					  --and c.cliente_id = cs.cod_cliente
					  order by cliente_id";
	}
		$consulta_busca = pg_query($connect, $sql_busca);
		
		if ($consulta_busca){
			while($row_busca = pg_fetch_array($consulta_busca)){
			/*$sql_busca = "select razao_social from cliente where cliente_id = $row_busca[cliente_id]";
			$busca = pg_query($sql_busca);
			$res = pg_fetch_array($busca);*/
				echo "&nbsp;<input type=\"radio\" name=\"cod_cliente\" value=\"$row_busca[cliente_id]\" checked > $row_busca[razao_social] <br>";
				$cliente = $row_busca[cliente_id];
			}
		}
		else if (pg_num_rows($consulta_busca)==0) {
			echo "<script>alert('A busca por \"$_POST[cliente_pesq]\" não retornou resultado.');</script>";
		}
		echo "<br> &nbsp;	</td>";
		echo " </tr>";

	}
	//if(empty($cliente))
	    //$cliente = $_POST[cliente_pesq];//$row_busca[cliente_id];
if (!empty($cliente)){
?>	
  
  <tr>
  	<td><b>&nbsp;&nbsp;Selecione a Filial:</td>
	<td><br>&nbsp;
		<select name="cod_filial">
		<?php

		$query_filial = "SELECT cliente_id, filial_id
						  FROM cliente
						  where cliente_id <> 0
						  and cliente_id = $cliente
						  order by filial_id";

		$result_filial = pg_query($connect, $query_filial) 
		or die ("Erro na query: $query_filial ==> " . pg_last_error($connect) );
		
		while($row_filial = pg_fetch_array($result_filial)){

			echo "<option value=$row_filial[filial_id]>" . $row_filial[filial_id] . "</option>";

		}
		?>
		</select><br>&nbsp;
	</td>
  </tr>
  
    <tr>
		<td><b>&nbsp;&nbsp;Selecione o Setor:</td>
		<td><br>&nbsp;
			<select name="cod_setor">
			<?php
			$cons = "select max(extract(year from cs.data_criacao)) as d
					FROM cliente c, cliente_setor cs, setor s
					where c.cliente_id <> 0
					and cs.cod_cliente = c.cliente_id
					and s.cod_setor = cs.cod_setor
					and c.cliente_id = $cliente";
			$rc = pg_query($connect, $cons);
			$rcon = pg_fetch_array($rc);
	
			$query_setor = "SELECT distinct(s.nome_setor), c.cliente_id, c.filial_id, cs.cod_setor
							  FROM cliente c, cliente_setor cs, setor s
							  where c.cliente_id <> 0
							  and cs.cod_cliente = c.cliente_id
							  and s.cod_setor = cs.cod_setor
							  and c.cliente_id = $cliente
							  and extract(year from data_criacao) = {$rcon[d]}
							  order by cod_setor";
	
			$result_setor = pg_query($connect, $query_setor) 
			or die ("Erro na query: $query_setor ==> " . pg_last_error($connect) );
			
			while($row_setor = pg_fetch_array($result_setor)){
	
				echo "<option value=$row_setor[cod_setor]>" . $row_setor[nome_setor] . "</option>";
	
			}
			?>
			</select><br>&nbsp;
		</td>
  </tr>
<?php
}
?>
  <tr>
    <th colspan="2" bgcolor="#009966"> <br>
       <input type="submit" value="Enviar" name="btn_enviar" style="width:100;">
      &nbsp;&nbsp;&nbsp;
      <input name="reset" type="reset" style="width:100;"  value="Limpar">
      &nbsp;&nbsp;&nbsp;
      <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../medico/lista_aso.php');return document.MM_returnValue" style="width:100;">
      <br>&nbsp;
	  <?php /* encerrar conexão */ pg_close($connect);?>	  
	</th>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>