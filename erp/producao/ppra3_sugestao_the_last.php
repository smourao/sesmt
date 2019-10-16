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

/***************************************************/
//Gambi provisória (enquanto não houver cod_ppra por GET)
$sql = "SELECT * FROM cliente_setor WHERE cod_cliente = $cliente";
$resc = pg_query($sql);
$pd = pg_fetch_array($resc);
$cod_orc = $pd[cod_orcamento];

//Pega o número de funcionários no setor
$sql = "SELECT * FROM funcionarios WHERE cod_cliente = {$cliente} and cod_setor = {$_GET['setor']}";
$r = pg_query($sql);
$num_func_setor = pg_fetch_all($r);
$num_func_setor = count($num_func_setor);

//Pega dados do funcionário selecionado
$sql = "SELECT * FROM funcionarios WHERE cod_cliente = {$cliente} and cod_func = {$_GET['fid']}";
$r = pg_query($connect, $sql);
$row = pg_fetch_all($r);
$cod_f =  $row[0]['cod_funcao'];

/************ Fim da exclusão *************/
if(!empty($cliente) and !empty($setor) and $_POST){
ppra_progress_update($cliente, $setor);

for($x=0;$x<count($_POST[tmp]);$x++){
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
		$result_verifica = pg_query($sql_verifica);
		
		if(pg_num_rows($result_verifica)==0){
		    $query_medida = "INSERT INTO sugestao (cod_cliente, cod_funcao, cod_setor, med_prev, plano_acao, data)
    											  VALUES
    											  ({$cliente}, {$cod_f}, {$setor}, '{$_POST[tmp][$x]}', '{$_POST[plano_acao][$x]}', {$dataz});";
    		$result_medida = pg_query($query_medida);
        /******************************************************************************************/
            if(!empty($cod_orc)){
                $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = {$cod_orc} AND cod_produto = {$_POST[cprod][$x]}";
                $resp = pg_query($sql);
                if($_POST[plano_acao][$x]==0 && pg_num_rows($resp)<=0){
                    $sql = "SELECT * FROM produto WHERE cod_prod = {$_POST[cprod][$x]}";
                    $rtmp = pg_query($sql);
                    $fprod = pg_fetch_array($rtmp);
                    $prodca = $fprod[cod_atividade];
                    $nis = 0;//numero de items sugeridos
                    switch($prodca){
                        case '1': //equipamentos contra incêndio
                            $nis = 1;
                        break;
                        case '2': //equipamentos de proteção individual
                            $nis = $num_func_setor;
                        break;
                        case '3': //cursos, consultoria e acessoria
                            $nis = 1;
                        break;
                        case '4': //sinalização
                            $nis = 1;
                        break;
                        case '5': //tratamento de água, dedetização e ignifugação
                            $nis = 1;
                        break;
                        case '6': //manutenção de equip. de combate à incêndio
                            $nis = 1;
                        break;
                        default:
                            $nis = 1;
                        break;
                    }
                    $sql = "INSERT INTO site_orc_produto
                            (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado)
                            VALUES
                            ('{$cod_orc}', '{$cliente}', '1', '{$_POST[cprod][$x]}', '{$nis}', 1)";
                    if(!empty($_POST[cprod][$x]))
                        pg_query($sql);
                }elseif($_POST[plano_acao][$x]==1 && pg_num_rows($resp)>0){
                    $sql = "DELETE FROM site_orc_produto WHERE cod_cliente = {$cliente} AND
                            cod_produto = {$_POST[tmp][$x]} AND cod_orcamento = {$cod_orc}";
                    pg_query($sql);
                }
            }
        /******************************************************************************************/
		}else{
			$query_medida = "UPDATE sugestao SET 
							plano_acao = '{$_POST[plano_acao][$x]}',
							data = {$dataz}
							WHERE cod_cliente = $cliente
							and cod_setor = $setor
							--and cod_funcao = $cod_f
							and med_prev = {$_POST[tmp][$x]}";
			$result_medida = pg_query($query_medida);
		}
	} 		
		echo '<script> alert("Os dados foram alterados com sucesso!");</script>';
}
/******************** DADOS DO CLIENTE **********************/
if(!empty($cliente)){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente 
				  where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}

/*************** DADOS DO SETOR DO CLIENTE ****************/
if(!empty($setor)){
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($query_set);
}
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
<form name="frm_medida_produto" action="ppra3_sugestao.php?cliente=<?PHP echo $_GET[cliente];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>" method="post">
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
	if (!empty($setor) and !empty($cliente)){
        //LISTA POR FUNÇÃO
		$sql_epi = "SELECT * FROM funcao_epi  
					WHERE cod_epi={$cod_f}";
		$result_epi = pg_query($sql_epi);

        $sql_medi = "SELECT * FROM funcao_medi
					WHERE cod_medi={$cod_f}";
		$result_medi = pg_query($sql_medi);
		
		$sql_curso = "SELECT * FROM funcao_curso  
					WHERE cod_curso={$cod_f}";
		$result_curso = pg_query($sql_curso);
			
		$sql_ambiental = "SELECT * FROM funcao_ambiental  
					WHERE cod_funcao={$cod_f}";
		$result_ambiental = pg_query($sql_ambiental);

		$sql_prog = "SELECT * FROM funcao_programas  
					WHERE cod_funcao={$cod_f}";
		$result_prog = pg_query($sql_prog);

		//LISTA POR SETORES
		$sql = "SELECT * FROM setor_epi
					WHERE cod_setor = $setor";
		$r_setor_epi = pg_query($sql);
		
        $sql = "SELECT * FROM setor_medi
					WHERE cod_setor = $setor";
		$r_setor_medi = pg_query($sql);
		
		$sql = "SELECT * FROM setor_curso
					WHERE cod_setor = $setor";
		$r_setor_curso = pg_query($sql);
		
		$sql = "SELECT * FROM setor_ambiental
					WHERE cod_setor = $setor";
		$r_setor_ambiental = pg_query($sql);
		
		$sql = "SELECT * FROM setor_programas
					WHERE cod_setor = $setor";
		$r_setor_programas = pg_query($sql);


		echo "<table width=\"760\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td colspan=3 bgcolor=\"#009966\"><center><h2 class=\"style3\" >Medidas Preventivas</h2></center></td>
	 		  </tr><br>
				<tr>
				<td align=\"left\" class=\"fontebranca12\">";
			
			    $aepi = array();
			    $amedi = array();
			    $acurso = array();
			    $aambiental = array();
			    $aprogramas = array();
			    //EPI FUNÇÃO
				while($row_epi=pg_fetch_array($result_epi)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_epi[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aepi[] = trim($row_epi[descricao]);
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
					<input type=hidden name=tmp[] value=$row_epi[id]>
                    <input type=hidden name=cprod[] value=$row_epi[cod_produto]>
                    </tr>";
				}
                //EPI SETOR
				while($setor_epi=pg_fetch_array($r_setor_epi)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_epi[id]}";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_epi[descricao]), $aepi)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_epi[descricao]<br></td>
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
    					<input type=hidden name=tmp[] value=$setor_epi[id]>
                        <input type=hidden name=cprod[] value=$setor_epi[cod_produto]>
                        </tr>";
					}
				}

                //MEDICAMENTOS SERÃO EXIBIDOS NO PCMSO!!!
			    /*
				//MEDI FUNÇÃO
				while($row_medi=pg_fetch_array($result_medi)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_medi[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$amedi[] = trim($row_medi[descricao]);
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
                //MEDI SETOR
				while($setor_medi=pg_fetch_array($r_setor_medi)){
					$sql = "SELECT * FROM sugestao WHERE cod_setor = $setor and med_prev = {$setor_medi[id]}";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_medi[descricao]), $amedi)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_medi[descricao]<br></td>
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
    					<input type=hidden name=tmp[] value=$setor_medi[id]></tr>";
					}
				}
				*/
				
                //FUNÇÃO CURSO
				while($row_curso=pg_fetch_array($result_curso)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_curso[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$acurso[] = trim($row_curso[descricao]);
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
					<input type=hidden name=tmp[] value=$row_curso[id]>
                    <input type=hidden name=cprod[] value=$row_curso[cod_produto]>
                    </tr>";
				}
				//SETOR CURSO
				while($setor_curso=pg_fetch_array($r_setor_curso)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_curso[id]}";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_curso[descricao]), $acurso)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_curso[descricao]<br></td>
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
    					<input type=hidden name=tmp[] value=$setor_curso[id]>
                        <input type=hidden name=cprod[] value=$setor_curso[cod_produto]>
                        </tr>";
					}
				}
				//FUNÇÃO AMBIENTAL
				while($row_ambiental=pg_fetch_array($result_ambiental)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_ambiental[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aambiental[] = trim($row_ambiental[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_ambiental[descricao]<br></td>
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
					<input type=hidden name=tmp[] value=$row_ambiental[id]>
                    <input type=hidden name=cprod[] value=$row_ambiental[cod_produto]>
                    </tr>";
				}
                //SETOR AMBIENTAL
				while($setor_ambiental=pg_fetch_array($r_setor_ambiental)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_ambiental[id]}";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_ambiental[descricao]), $aambiental)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_ambiental[descricao]<br></td>
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
    					<input type=hidden name=tmp[] value=$setor_ambiental[id]>
                        <input type=hidden name=cprod[] value=$setor_ambiental[cod_produto]>
                        </tr>";
					}
				}
				//FUNÇÃO PROGRAMAS
				while($row_prog=pg_fetch_array($result_prog)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_prog[id]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aprogramas[] = trim($row_prog[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_prog[descricao]<br></td>
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
					<input type=hidden name=tmp[] value=$row_prog[id]>
                    <input type=hidden name=cprod[] value=$row_prog[cod_produto]>
                    </tr>";
				}
				//SETOR PROGRAMAS
				while($setor_programas=pg_fetch_array($r_setor_programas)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_programas[id]}";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_programas[descricao]), $aprogramas)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_programas[descricao]<br></td>
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
    					<input type=hidden name=tmp[] value=$setor_programas[id]>
                        <input type=hidden name=cprod[] value=$setor_programas[cod_produto]>
                        </tr>";
					}
				}
			echo "	 </td>";
			echo "  </tr> </table>";
	}
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
