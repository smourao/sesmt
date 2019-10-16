<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
	$fid  = $_GET["fid"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
	$fid  = $_POST["fid"];
}

$sql = "SELECT * FROM funcionarios WHERE cod_cliente = {$cliente} and cod_func = {$_GET['fid']}";
$r = pg_query($connect, $sql);
$row = pg_fetch_all($r);
$cod_f =  $row[0]['cod_funcao'];

if( !empty($_GET[tmp]) )
{
	$tmp = $_GET[tmp];

	$query_excluir = $query_excluir . "DELETE FROM sugestao WHERE med_prev = '$tmp' and cod_cliente = $cliente;";

	$result_excluir = pg_query($connect, $query_excluir)
		or die ("Erro na query: $query_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir) {
		echo '<script> alert("A Medida Preventiva foi EXCLUIDA com sucesso!");</script>';
	}
} 
/************ Fim da exclusão *************/
if(!empty($cliente) and !empty($setor) and $_POST){
ppra_progress_update($cliente, $setor);

for($x=0;$x<count($_POST[tmp]);$x++){
$_POST[tmp][$x];
$_POST[plano_acao][$x];
$_POST[data][$x];

if($_POST[data][$x] == ""){
	    $dataz = "null";	
	}else{
	    $dt = explode("/", $_POST[data][$x]);
		if(count($dt)>2){
		   $dataz = "'".$dt[2]."-".$dt[1]."-".$dt[0]."'";//se for informado com 3 valores
		}else{
   		   $dataz = "'".$dt[1]."-".$dt[0]."-01'";//se for informado com 2 valores		
		}
	}

		$sql_verifica = "SELECT * FROM sugestao 
						WHERE cod_cliente = {$cliente} 
						and cod_setor 	  = {$setor} 
						and med_prev 	  = {$_POST[tmp][$x]}";
		
		$result_verifica = pg_query($connect, $sql_verifica)
			or die ("Erro na query: $sql_verifica ==> " . pg_last_error($connect) );
		
		if ( pg_num_rows($result_verifica)==0 ){
		// monta o insert no banco
		$query_medida = "INSERT INTO sugestao (cod_cliente, cod_funcao, cod_setor, med_prev, plano_acao, data)
											  VALUES 
											  ({$cliente}, {$cod_f}, {$setor}, '{$_POST[tmp][$x]}', '{$_POST[plano_acao][$x]}', {$dataz});";
					
		$result_medida = pg_query($connect, $query_medida)
			or die ("Erro na query: $query_medida ==> " . pg_last_error($connect) );
			
		 // se os inserts foram corretos
		//echo '<script> alert("Os dados foram cadastradas com sucesso!");<script>';
		}else{
			$query_medida = "UPDATE sugestao SET 
							plano_acao = '{$_POST[plano_acao][$x]}',
							data = {$dataz}
							WHERE cod_cliente = $cliente
							and cod_setor = $setor
							and cod_funcao = $cod_f
							and med_prev = {$_POST[tmp][$x]}";
			$result_medida = pg_query($connect, $query_medida)
				or die ("Erro na query: $sql_up ==> " . pg_last_error($connect) );
			
			// se os updates foram corretos
		}
	} 			echo '<script> alert("Os dados foram alterados com sucesso!");</script>';
}
if(!empty($cliente)){
/******************** DADOS DO CLIENTE **********************/
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente 
				  where cliente_id = $cliente";
	
	$result_cli = pg_query($connect, $query_cli) 
		or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
}
/******************** DADOS DO CLIENTE **********************/

if(!empty($setor)){
/*************** DADOS DO SETOR ****************/
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
		or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );
}
/*************** DADOS DO SETOR DO CLIENTE ****************/
?>
<html>
<head>
<title>Sugestões</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medida_produto" action="ppra3_sugestao_.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>" method="post">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
		<th bgcolor="#009966" colspan=2>
			<br> CADASTRO DE MEDIDAS PREVENTIVAS <br>&nbsp;		</th>
    </tr>
	<?php 
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<br> <font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Bairro:   		<b><?php echo $row_cli[bairro]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone];     ?></b> <br>
				&nbsp;&nbsp;&nbsp; E-mail:   		<b><?php echo $row_cli[email]; 		  ?></b> <hr>			
				</font> </td>
		</tr>
	<?php 
	}
	
	if($result_set){
		$row_set = pg_fetch_array($result_set);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Setor:	   <b> <?php echo $row_set[nome_setor]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Descrição do Setor: <b> <?php echo $row_set[desc_setor]; ?></b> <hr>
				</font>			</td>
		</tr>
	<?php 
	}
	/************BUSCANDO O EPI PARA SER EXIBIDO**********************
	$sql_epi = "SELECT distinct(e.id), e.cod_epi, e.descricao 
				FROM funcao_epi e, sugestao s 
				WHERE e.cod_epi={$cod_f} 
				AND e.id in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f})";
	
	$result_epi = pg_query($connect, $sql_epi) 
		or die ("Erro na query: $sql_epi ==> ".pg_last_error($connect));*/

	/************BUSCANDO O MEDICAMENTOS PARA SER EXIBIDO**********************
	$sql_medi = "SELECT distinct(m.id), m.cod_medi, m.descricao 
				FROM funcao_medi m, sugestao s 
				WHERE m.cod_medi={$cod_f} 
				AND m.id in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f})";
	
	$result_medi = pg_query($connect, $sql_medi) 
		or die ("Erro na query: $sql_medi ==> ".pg_last_error($connect));*/

	/************BUSCANDO O EXAMES PARA SER EXIBIDO**********************
	$sql_exame = "SELECT distinct(f.id), f.cod_exame, f.descricao 
				FROM funcao_exame f, sugestao s 
				WHERE f.cod_exame={$cod_f} 
				AND f.id in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f})";
	
	$result_exame = pg_query($connect, $sql_exame) 
		or die ("Erro na query: $sql_exame ==> ".pg_last_error($connect));*/

	/************BUSCANDO O CURSO PARA SER EXIBIDO**********************
	$sql_curso = "SELECT distinct(c.id), c.cod_curso, c.descricao 
				FROM funcao_curso c, sugestao s 
				WHERE c.cod_curso={$cod_f} 
				AND c.id in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f})";
	
	$result_curso = pg_query($connect, $sql_curso) 
		or die ("Erro na query: $sql_curso ==> ".pg_last_error($connect));

	if ( pg_num_rows($result_epi)>0 || pg_num_rows($result_curso)>0 || pg_num_rows($result_medi)>0 || pg_num_rows($result_exame)>0 ){
		echo "		<table width=\"760\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">";
		echo "			<tr>";
		echo "		<th colspan=2 bgcolor=#009966> Medidas Preventivas Existentes </th>";
		echo "</tr>";
		$total = 0;
		
		while( $row_epi = pg_fetch_array($result_epi) )
		{
			echo "<tr>";
			echo "	<td class=linksistema align=center>";
			echo "		&nbsp; <a href=\"ppra3_sugestao.php?cliente=$cliente&setor=$setor&fid={$_GET['fid']}&tmp=$row_epi[id]\"> Excluir </a>";
			echo "	</td>";
			echo "	<td class=fontebranca12>&nbsp;$row_epi[descricao]<br> 	</td>";
			echo "</tr>";
		}

		while( $row_medi = pg_fetch_array($result_medi) )
		{
			echo "<tr>";
			echo "	<td class=linksistema align=center>";
			echo "		&nbsp; <a href=\"ppra3_sugestao.php?cliente=$cliente&setor=$setor&fid={$_GET['fid']}&tmp=$row_medi[id]\"> Excluir </a>";
			echo "	</td>";
			echo "	<td class=fontebranca12>&nbsp;$row_medi[descricao]<br> 	</td>";
			echo "</tr>";
		}

		while( $row_exame = pg_fetch_array($result_exame) )
		{
			echo "<tr>";
			echo "	<td class=linksistema align=center>";
			echo "		&nbsp; <a href=\"ppra3_sugestao.php?cliente=$cliente&setor=$setor&fid={$_GET['fid']}&tmp=$row_exame[id]\"> Excluir </a>";
			echo "	</td>";
			echo "	<td class=fontebranca12>&nbsp;$row_exame[descricao]<br> 	</td>";
			echo "</tr>";
		}
		
		while( $row_curso = pg_fetch_array($result_curso) )
		{
			echo "<tr>";
			echo "	<td class=linksistema align=center>";
			echo "		&nbsp; <a href=\"ppra3_sugestao.php?cliente=$cliente&setor=$setor&fid={$_GET['fid']}&tmp=$row_curso[id]\"> Excluir </a>";
			echo "	</td>";
			echo "	<td class=fontebranca12>&nbsp;$row_curso[descricao]<br> 	</td>";
			echo "</tr>";
		}

			echo "</table>";
		
	}*/
	
	if (!empty($setor) and !empty($cliente) ) {

		$sql_epi = "SELECT * FROM funcao_epi  
					WHERE cod_epi={$cod_f} ";		
		$result_epi = pg_query($connect, $sql_epi)
			or die ("Erro na query: $sql_epi ==> " . pg_last_error($connect) );

		$sql_medi = "SELECT * FROM funcao_medi  
					WHERE cod_medi={$cod_f} ";		
		$result_medi = pg_query($connect, $sql_medi)
			or die ("Erro na query: $sql_medi ==> " . pg_last_error($connect) );

		$sql_exame = "SELECT * FROM funcao_exame  
					WHERE cod_exame={$cod_f} ";		
		$result_exame = pg_query($connect, $sql_exame)
			or die ("Erro na query: $sql_exame ==> " . pg_last_error($connect) );

		$sql_curso = "SELECT * FROM funcao_curso  
					WHERE cod_curso={$cod_f} ";		
		$result_curso = pg_query($connect, $sql_curso)
			or die ("Erro na query: $sql_curso ==> " . pg_last_error($connect) );

		/*$sql_medi = "SELECT distinct(m.id), m.cod_medi, m.descricao, s.cod_setor, s.cod_cliente, s.cod_filial FROM funcao_medi m, sugestao s 
					WHERE m.cod_medi={$cod_f} AND m.id not in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f}) ";		
		$result_medi = pg_query($connect, $sql_medi)
			or die ("Erro na query: $sql_medi ==> " . pg_last_error($connect) );

		$sql_exame = "SELECT distinct(f.id), f.cod_exame, f.descricao, s.cod_setor, s.cod_cliente, s.cod_filial FROM funcao_exame f, sugestao s 
					WHERE f.cod_exame={$cod_f} AND f.id not in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f}) ";		
		$result_exame = pg_query($connect, $sql_exame)
			or die ("Erro na query: $sql_exame ==> " . pg_last_error($connect) );

		$sql_curso = "SELECT distinct(c.id), c.cod_curso, c.descricao, s.cod_setor, s.cod_cliente, s.cod_filial FROM funcao_curso c, sugestao s 
					WHERE c.cod_curso={$cod_f} AND c.id not in (SELECT med_prev FROM sugestao WHERE cod_funcao = {$cod_f}) ";		
		$result_curso = pg_query($connect, $sql_curso)
			or die ("Erro na query: $sql_curso ==> " . pg_last_error($connect) );*/

		echo "<table width=\"760\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td colspan=3 bgcolor=\"#009966\"><center><h2 class=\"style3\" >Medidas Preventivas</h2></center></td>
	 		  </tr><br>
				<tr>
				<td align=\"left\" class=\"fontebranca12\">";
			
				while($row_epi=pg_fetch_array($result_epi)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_epi[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_epi[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data]){
					echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_epi[id]></tr>";
				}

				while($row_medi=pg_fetch_array($result_medi)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_medi[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_medi[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data]){
					echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_medi[id]></tr>";
				}

				while($row_exame=pg_fetch_array($result_exame)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_exame[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_exame[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data]){
					echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_exame[id]></tr>";
				}

				while($row_curso=pg_fetch_array($result_curso)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_curso[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_curso[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data]){
					echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_curso[id]></tr>";
				}
				
				/*while($row_medi=pg_fetch_array($result_medi)){ 
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">
					<input type=\"checkbox\" name=\"tmp[]\" value=\"$row_medi[id]\">&nbsp;$row_medi[descricao]<br>
					</td></tr>";
				}

				while($row_exame=pg_fetch_array($result_exame)){ 
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">
					<input type=\"checkbox\" name=\"tmp[]\" value=\"$row_exame[id]\">&nbsp;$row_exame[descricao]<br>
					</td></tr>";
				}

				while($row_curso=pg_fetch_array($result_curso)){ 
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">
					<input type=\"checkbox\" name=\"tmp[]\" value=\"$row_curso[id]\">&nbsp;$row_curso[descricao]<br>
					</td></tr>";
				}*/
				
			echo "	 </td>";
			echo "  </tr> </table>";
	}

		/*while( $row_sugestao = pg_fetch_array($result_sugestao) )
		{
			$id = substr($row_sugestao[med_prev], 3, (strlen($row_sugestao[med_prev])-3));
			$table = substr($row_sugestao[med_prev], 0, 3);

			if($table == "EPI"){
			    $table = "funcao_epi";
				$epis[] = $id;
			}
			
			$sql = "SELECT * FROM $table WHERE id={$id}";
			$res = pg_query($sql);
			$buff = pg_fetch_array($res);
			
			echo "<tr>";
			echo "	<td class=linksistema align=center>";
			echo "		<a href=\"ppra3_sugestao.php?cliente=$cliente&setor=$setor&fid={$_GET['fid']}&tmp=$row_sugestao[med_prev]\"> Excluir </a>";
			echo "	</td>";
			echo "	<td class=fontebranca12>&nbsp;{$buff[descricao]}";
			echo "	</td>";
			echo "</tr>";
		}
			echo "</table>";
	}
	
	if (!empty($setor) and !empty($cliente) ) {
		
		for($x=0;$x<count($epis);$x++){
		   $tt .= " AND id <> $epis[$x]";
		}
		
		$sql_epi = "SELECT * FROM funcao_epi WHERE cod_epi={$cod_f} $tt";		
		$result_epi = pg_query($connect, $sql_epi)
			or die ("Erro na query: $sql_epi ==> " . pg_last_error($connect) );
	
		echo "<table width=\"760\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td bgcolor=\"#009966\"><center><h2 class=\"style3\" >Medidas Preventivas Sugeridas </h2></center></td>
	 		  </tr><br>
				<tr>
				<td align=\"left\" class=\"fontebranca10 style1\">";

				while($row_epi=pg_fetch_array($result_epi)){ 
				echo "<input type=\"checkbox\" name=\"tmp[]\" value=\"EPI$row_epi[id]\">&nbsp;$row_epi[descricao]<br>";
				}
				
			echo "	 </td>";
			echo "  </tr> </table>";
	}*/
?>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
		<td align="center">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra3.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Avançar &gt;&gt;" style="width:100px;" onClick="MM_goToURL('parent','ppra3_epc.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>');return document.MM_returnValue" title="Clique aqui para avançar">
			<br>&nbsp;
		</td>
	</tr>
<input type="hidden" name="cliente" value="<?php echo $cliente; ?>" />
<input type="hidden" name="setor"   value="<?php echo $setor;   ?>" />

</table>
</form>
</body>
</html>