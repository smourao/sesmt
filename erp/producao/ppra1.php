<?php 	
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$cliente = $_POST["cliente_id"];
$setor   = $_POST["cod_setor"];

if ($cliente!="" and $setor!="" and $_POST[btn_enviar]=="Gravar"){
	$cod = "select max(cod_ppra) as cod_ppra from cliente_setor WHERE EXTRACT(year from data_criacao) = ".date('Y')."";//cria código automático do orçamento
    $res = pg_query($cod);
	$row = pg_fetch_array($res);
	$cod_ppra = $row[cod_ppra] + 1;
	$tsetor = $_POST[tipo_setor];
	
    //GET THE MAX ID FOR ID_PPRA
    $sql = "SELECT MAX(id_ppra) as max FROM cliente_setor";
    $rz =  pg_query($sql);
    $max = pg_fetch_array($rz);
    $id_ppra = $max[max]+1;
    
	for($x=0;$x<$_POST['num_setores'];$x++){
	    $sql = "SELECT c.razao_social, s.nome_setor, cs.data_criacao
			FROM cliente_setor cs, cliente c, setor s
			WHERE cs.cod_cliente = c.cliente_id
			AND cs.cod_setor = s.cod_setor
			AND cs.cod_cliente = $cliente
			AND cs.cod_setor = $setor[$x]
			AND cs.id_ppra = $id_ppra
			AND EXTRACT(year from cs.data_criacao) = ".date('Y')."";
	    $consulta = pg_query($sql);
        if($_POST[dtref]){
            $tmp = explode("/", $_POST[dtref]);
    	    $dtref = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	    }else{
            $dtref = date("Y/m/d");
	    }
	    if(pg_num_rows($consulta)==0){
    		$insert = "INSERT INTO cliente_setor
            (cod_cliente, cod_setor, tipo_setor, cod_ppra, data_criacao, jornada, funcionario_id, id_ppra, elaborador_pcmso)
            values
            ($cliente, $setor[$x], '{$tsetor[$x]}', $cod_ppra,'$dtref', '$jornada', $funcionario_id, $id_ppra, $funcionario)";
    		$result_insert = pg_query($insert);
    		if ($result_insert){
    			header("location: ppra.php?cliente=$cliente&id_ppra=$id_ppra&y=".date("Y", strtotime($dtref))."");
    		}
    	}else{
    		$row = pg_fetch_array($consulta);
    		echo "<script>alert(\"O Setor '$row[nome_setor]' do Cliente '$row[razao_social]' já está cadastrado!\");</script>";
    	}
    }
}else{
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
	if ( !empty($_POST[cliente_pesq]) and $_POST[btn_busca]=="Buscar"){
		echo "  <tr>";
		echo "	<th class=\"style1\" colspan=2> Resultado da busca:</th>";
		echo "</tr>";
		echo "<tr>";
		echo "  <td colspan=2> <br>";
if(is_numeric($cliente_pesq)){
		$sql_busca = "select cliente_id, razao_social, substr(razao_social,1,60) as razao_social
					  from cliente c
					  where cliente_id = $cliente_pesq ";
}else{
		$sql_busca = "select cliente_id, razao_social, substr(razao_social,1,60) as razao_social
					  from cliente c
					  where lower(razao_social) like '%". strtolower(addslashes($cliente_pesq)) ."%'";
}
		$sql_busca = $sql_busca . " order by cliente_id ";
		
		$consulta_busca = pg_query($connect, $sql_busca);
		
		if (pg_num_rows($consulta_busca) == 0){
			echo "<script>alert('A busca pelo Cliente: \"$_POST[cliente_pesq]\" não retornou resultado.');</script>";
		}else /* if (pg_num_rows($consulta_busca)==0) */{
			while($row_busca = pg_fetch_array($consulta_busca)){
              switch($row_busca[cliente_id]){
                  case 147:
                      $row_busca[razao_social] .= " UPV";
                  break;
                  case 148:
                      $row_busca[razao_social] .= " UQMI";
                  break;
                  case 149:
                      $row_busca[razao_social] .= " UQMII";
                  break;
              }
				echo"<input type=\"radio\" name=\"cliente_id\" value=\"$row_busca[cliente_id]\" checked><b>$row_busca[razao_social]</b> - Jornada Trabalhada:&nbsp;<input type=text name=jornada size=5>
					<p>
					Elaborador(a) Responsável do PPRA:&nbsp;<select name=funcionario_id>";
					$f = "SELECT * FROM funcionario WHERE cargo_id = 15";
					$fr = pg_query($f);
					while($ff = pg_fetch_array($fr)){
						echo "<option value=$ff[funcionario_id]> $ff[nome] </option> ";
					}
				echo "</select>
					<p>
					Elaborador(a) Responsável do PCMSO:&nbsp;<select name=funcionario>";
					$p = "SELECT * FROM funcionario WHERE cargo_id = 1001";
					$pr = pg_query($p);
					while($pp = pg_fetch_array($pr)){
						echo "<option value=$pp[funcionario_id]> $pp[nome] </option> ";
					}
				echo "</select>";
				echo "<p>Data de Referência:&nbsp;<input type=text size=10 name=dtref id=dtref maxlength=10 value='".date("d/m/Y")."'  onkeypress=\"formatar(this, '##/##/####');\">";
				echo "<P>";
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
		<select name="cod_setor[]" style="width: 550px;">
<?php
$query_setor = "SELECT cod_setor, desc_setor, nome_setor
			  FROM setor
			  where cod_setor <> 0
			  order by nome_setor";

$result_setor = pg_query($query_setor);
while($row_setor = pg_fetch_array($result_setor)){
	echo "<option value=$row_setor[cod_setor]> $row_setor[nome_setor] </option>";
}
?>
		</select>
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo do Setor:</b>&nbsp;
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
