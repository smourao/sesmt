<?php
include "../sessao.php";
include "../config/connect.php";
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
	$fid = $_GET["fid"];
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
	$fid = $_POST["fid"];
}

if($id != ""){
    $excluir = "DELETE FROM iluminacao_ppra WHERE id = $id";
    $result = pg_query($excluir);
	if ($result){
		echo "<script>
        alert('Cadastro excluído com sucesso!');
        location.href='iluminacao.php?cliente=$_GET[cliente]&id_ppra=$_GET[id_ppra]&setor=$_GET[setor]&fid=$_GET[fid]&y=$_GET[y]';
        </script>";
	}
}

if($_POST['btn_enviar']=="Gravar"){
ppra_progress_update($cliente, $setor);
	$sql = "SELECT * FROM iluminacao_ppra WHERE id_ppra = $_GET[id_ppra] and cod_setor = $setor and cod_func = $cod_func";
	$res = pg_query($sql);
	$buffer = pg_fetch_all($res);
	if(!empty($_GET["cliente"]) && !empty($_GET["setor"])){ // IF 2
		if(pg_num_rows($res)<=0){
		    $luz = "INSERT INTO iluminacao_ppra(cod_cliente, cod_setor, cod_func, lux_atual, lux_recomendado, exposicao, movel, numero, lux, data, id_ppra)
    				VALUES($cliente, $setor, $cod_func, '$lux_atual', '$recomendado', '$exposicao', '$movel', '$numero', $lux, '".$_GET['y']."/".date('m/').date('d')."', $_GET[id_ppra])";
    		$result_luz = pg_query($luz);
    		echo'<script> alert("Informações Cadastradas com Sucesso!");</script>';
		}else{
		    $luz = "UPDATE iluminacao_ppra
					SET lux_atual 		= '$lux_atual',
						lux_recomendado = '$recomendado',
						exposicao 		= '$exposicao',
						movel 			= '$movel',
						numero			= '$numero',
						lux 			= $lux
					WHERE id_ppra 	= $_GET[id_ppra] AND cod_setor = $setor AND cod_func = $cod_func";
			$result_luz = pg_query($luz);
			echo'<script> alert("Informações Alteradas com Sucesso!");</script>';
		}
	}
}
/****************BUSCANDO DADOS DO CLIENTE********************/
if(!empty($cliente) & !empty($setor) ){
	$sql = "SELECT i.*, c.data_criacao
    FROM cliente_setor c, iluminacao_ppra i
    WHERE
    i.cod_cliente = c.cod_cliente
    AND i.cod_setor = c.cod_setor
    AND i.id_ppra = c.id_ppra
    AND i.id_ppra = $_GET[id_ppra]
    AND i.cod_setor = $_GET[setor]";
	$result_func = pg_query($sql);
	$row_st = pg_fetch_array($result_func);
}

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/
if(!empty($_GET[cliente]) & !empty($_GET[setor]) ){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_iluminacao" method="POST">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
		<th bgcolor="#009966" align="left" colspan="6">
			<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS
            <br> 
            <br>
			&nbsp;&nbsp;&nbsp;COLETA DE DADOS DA ILUMINÂNCIA DO SETOR <br>
			 &nbsp;
		</th>
    </tr>
	<?php

	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan="6">
			<br><font color="black">
			&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
			&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; ?></b> <br>
			&nbsp;&nbsp;&nbsp; Bairro: 			<b><?php echo $row_cli[bairro]; ?></b> <br>
			&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone]; ?></b> <br>
			&nbsp;&nbsp;&nbsp; E-mail: 			<b><?php echo $row_cli[email]; ?></b> <br>&nbsp;
			</font></td>
		</tr>
	<?php
		}
	?>
</table>
<?php
if($row_st!=""){
echo"<table align=\"center\" width=\"760\" border=\"2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" >
    <tr>
		<td align=\"center\" bgcolor=\"#009966\">Iluminação Cadastrada &nbsp;</td>
    </tr>";
	echo "</table>";
	echo"<table align=\"center\" width=\"760\" border=\"2\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" >";
	}

    $sql = "SELECT i.*, nome_func, f.setor_adicional
    FROM cgrt_func_list l, iluminacao_ppra i, funcionarios f
    WHERE i.cod_cliente = l.cod_cliente
    AND f.cod_cliente = l.cod_cliente
    AND i.cod_cliente = f.cod_cliente
    AND i.id_ppra = l.cod_cgrt
    AND (l.cod_setor = $_GET[setor] OR f.setor_adicional LIKE '%$_GET[setor]%')
    AND i.cod_func = f.cod_func
    and i.cod_func = l.cod_func
    and f.cod_func = l.cod_func
    AND l.cod_cgrt = $_GET[id_ppra]
    AND i.cod_setor = $_GET[setor]
    and l.cod_cliente = $_GET[cliente]";
	$result_func = pg_query($sql);
	while($r=pg_fetch_array($result_func)){
		echo"<tr>
			<th class=linksistema><a href=\"iluminacao.php?cliente=$_GET[cliente]&id_ppra=$_GET[id_ppra]&setor=$_GET[setor]&fid=$_GET[fid]&id=$r[id]&y=$_GET[y]\">Excluir</a></th>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">Funcionário:<b>$r[nome_func]</b></font></td>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">Movel:<b> $r[movel] $r[numero]</b></font></td>
			<td class=\"fontepreta12\" bgcolor=#FFFFFF><font color=\"black\">Luz Atual:<b> $r[lux_atual]</b></font></td>
			</tr>";
	}
?>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td width="150" class="fontebranca12" align="left"><b>&nbsp;Luz Atual:</b></td>
		<td width="150">&nbsp;<input type="text" name="lux_atual" size="5" maxlength="6" value="<?php echo $row_st[lux_atual] ?>"></td>
		<td width="150" class="fontebranca12" align="left"><b>&nbsp;Recomendado:</b></td>
		<td width="300">&nbsp;<input type="text" name="recomendado" size="5" maxlength="6" value="<?php echo $row_st[lux_recomendado] ?>"></td>
	</tr>
	<tr>
		<td class="fontebranca12" align="left"><b>&nbsp;Tmp. Exposição:</b></td>
		<td>&nbsp;<input type="text" name="exposicao" size="5" maxlength="6" value="<?php echo $row_st[exposicao] ?>"></td>
		<td align="left" class="fontebranca12" ><strong>&nbsp;Móvel:</strong></td>
		<td >&nbsp;<select name="movel">
			<option value="Mesa">Mesa</option>
			<option value="Bancada">Bancada</option>
			</select>
			&nbsp;<input type="text" name="numero" size="2" value="<?php echo $row_st[numero] ?>">
		</td>
	</tr>
	<tr>
	    <td align="left" class="fontebranca12" ><b>&nbsp;Aparelho:</b></td>
	    <td>&nbsp;<select name="lux">
		<?php
			$sql_status = "SELECT cod_aparelho, nome_aparelho
							   FROM aparelhos
							   where cod_aparelho <> 0
							   AND tipo_aparelho = 4
							   order by nome_aparelho";
			$result_status = pg_query($sql_status);
			while ( $row_status = pg_fetch_array($result_status) ){
				echo"<option value=\"$row_status[cod_aparelho]\"> " . $row_status[nome_aparelho] . "</option>";
			}
		?>
		</select> 
		</td>
		<td align="left" class="fontebranca12"><b>&nbsp;Funcionário:</b></td>
		<td>&nbsp;<select name="cod_func">
		<?php
            $sql_func = "SELECT f.cod_func, nome_func
						FROM funcionarios f, cgrt_func_list l
						WHERE l.cod_cgrt = $_GET[id_ppra]
						AND l.cod_cliente = f.cod_cliente
						AND l.cod_cliente = $_GET[cliente]
						AND	f.cod_func = l.cod_func
						AND	(l.cod_setor = $_GET[setor]
						OR f.setor_adicional LIKE '%$_GET[setor]%')
						ORDER BY nome_func";
            $result_func = pg_query($sql_func);
			while ( $row_func = pg_fetch_array($result_func) ){
				echo"<option value=\"$row_func[cod_func]\"> " . $row_func[nome_func] . "</option>";
			}
		?>
		</select> 
		</td>
	</tr>
	<tr>
	<th colspan="6" bgcolor="#009966"><br>
	    <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra2_equip_alt.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra]; ?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button"  name="cancelar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Gravar" style="width:100px;" name="btn_enviar" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="btn_concluir" value="Continuar >>" style="width:100px;" onClick="location.href='ppra3.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra]; ?>&setor=<?php echo $setor; ?>&alt=sim&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $ano; ?>';">
		<br>&nbsp;
	  </th>
	</tr>
<?php
pg_close($connect);
?>
</table>
</form>
</body>
</html>
