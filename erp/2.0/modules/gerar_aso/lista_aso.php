<?php
echo '
<script language="Javascript">
function showDiv(div)
{
document.getElementById("Apto com Restricao").className = "invisivel";

document.getElementById(div).className = "visivel";
}
</script>
<style>
.invisivel { display: none; }
.visivel { visibility: visible; }
</style>';

//riscos
if($_POST['tipo_risco']){
	$dl = "DELETE FROM avulso_tipo_risco WHERE cod_aso = '$_POST[aso1]'";
	$dll = pg_query($dl);
}
$ris = $_POST['tipo_risco'];
$num = count($ris);

for($x=0;$x<$num;$x++){
	//$texto .= $ris[$x]."|";
	if($ris[$x] != 0){
		$sql = "INSERT INTO avulso_tipo_risco (cod_aso, cod_tipo_risco) VALUES ('$_POST[aso1]', '$ris[$x]')";
		$query = pg_query($sql);
	}
}

if($_POST['agente_risco']){
	$dl = "DELETE FROM avulso_agente_risco WHERE cod_aso = '$_POST[aso1]'";
	$dll = pg_query($dl);
}

$especif = $_POST['agente_risco'];
$numero = count($especif);

for($y=0;$y<$numero;$y++){
	if($especif[$y] != 0){
	//$texto_especif .= $especif[$y]."|";
		$sql = "INSERT INTO avulso_agente_risco (cod_aso, cod_agente_risco) VALUES ('$_POST[aso1]', '$especif[$y]')";
		$query = pg_query($sql);
	}
}

if($_GET[m] == 1){
	showMessage('Notificação enviada com sucesso!');
}
if($_GET[pq]){
	$_POST[search] = $_GET[pq];
}
if($_GET[pq] == 1){	
}
/*echo "<pre>";
print_r($_POST);
exit();
echo "</pre>";*/
$dat = date("Y-m-d");
//${dtaso[$key]}
if($_POST[aso1]){
	$chkbox = $_POST[confirma];	
	$dtaso = $_POST[aso_data];
	$_POST[search] = $_POST[aso1];
	if(is_array($chkbox)){
		foreach($chkbox as $key => $schkbox){
		$t = "SELECT * FROM aso WHERE cod_aso = $_POST[aso1]";
		$tt = pg_query($t);
		$ttt = pg_fetch_array($tt);
		$sqll = "SELECT c.*, a.*, ce.*, ae.* FROM clinicas c, aso a, clinica_exame ce, aso_exame ae WHERE a.cod_clinica = c.cod_clinica AND a.cod_aso = $_POST[aso1] AND ae.cod_exame = '$schkbox' AND ce.cod_exame = '$schkbox' AND ce.cod_clinica = a.cod_clinica";
	    $res = pg_query($sqll);
	    $buffer = pg_fetch_array($res);
	   
		    if($buffer['cod_clinica'] == 0){
		    	$sqlup = "UPDATE aso SET cod_clinica = $_POST[clinic] WHERE cod_aso = $_POST[aso1]";
		    	$queryup = pg_query($sqlup);

				$sql = "UPDATE aso_exame SET confirma= 1, data_repasse = '$dat', data = '${dtaso[$key]}' WHERE cod_exame = '$schkbox' AND cod_aso = $_POST[aso1] ";
				$query = pg_query($sql); 
				$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
				
				$sqlexame = "SELECT * FROM exame WHERE cod_exame = $schkbox";
				$queryexame = pg_query($sqlexame);
				$arrayexame = pg_fetch_array($queryexame);
				
				$sqlfunc = "SELECT * FROM funcionarios WHERE cod_func = $ttt[cod_func] AND cod_cliente = $ttt[cod_cliente]";
				$queryfunc = pg_query($sqlfunc);
				$arrayfunc = pg_fetch_array($queryfunc);
				
				$sqlrpj = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente = $ttt[cod_cliente]";
				$queryrpj = pg_query($sqlrpj);
				$arrayrpj = pg_fetch_array($queryrpj);
				
				
				$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente, confirma_data, nome_exame, nome_func, nome_cliente) VALUES ('$schkbox', '$_POST[aso1]', '$_POST[clinic]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]', '$dat', '$arrayexame[especialidade]', '$arrayfunc[nome_func]', '$arrayrpj[razao_social]')";
				$query3 = @pg_query($sql3);
			}else{
				$sql = "UPDATE aso_exame SET confirma= 1, data_repasse = '$dat', data = '${dtaso[$key]}' WHERE cod_exame = '$schkbox' AND cod_aso = $_POST[aso1] ";
				$query = pg_query($sql); 
				$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
				
				$sqlexame = "SELECT * FROM exame WHERE cod_exame = $schkbox";
				$queryexame = pg_query($sqlexame);
				$arrayexame = pg_fetch_array($queryexame);
				
				$sqlfunc = "SELECT * FROM funcionarios WHERE cod_func = $ttt[cod_func] AND cod_cliente = $ttt[cod_cliente]";
				$queryfunc = pg_query($sqlfunc);
				$arrayfunc = pg_fetch_array($queryfunc);
				
				$sqlrpj = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente = $ttt[cod_cliente]";
				$queryrpj = pg_query($sqlrpj);
				$arrayrpj = pg_fetch_array($queryrpj);
				
				
				$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente, confirma_data, nome_exame, nome_func, nome_cliente) VALUES ('$schkbox', '$_POST[aso1]', '$buffer[cod_clinica]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]', '$dat', '$arrayexame[especialidade]', '$arrayfunc[nome_func]', '$arrayrpj[razao_social]')";
				$query3 = @pg_query($sql3);
			}
		}
		
		//Pegar o Status do Cliente, ve se é Parceira
		$statussql = "SELECT status FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
		$statusquery = pg_query($statussql);
		$status = pg_fetch_array($statusquery);
		
		$contratosql = "SELECT tipo_contrato, ultima_alteracao FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente]";
		$contratoquery = pg_query($contratosql);
		$tipo_contratos = pg_fetch_array($contratoquery);
		if($tipo_contratos['tipo_contrato'] == ''){
			$tipo_contrato = 'Fechado';
		}else{
			$tipo_contrato = ucfirst($tipo_contratos['tipo_contrato']);
			if($tipo_contrato == "A"){
				$tipo_contrato = "Aberto";
			}else if($tipo_contrato == "E"){
				$tipo_contrato = "Específico";
			}
		}
		
		$pegarparceriasql = "SELECT status, cliente_id FROM cliente WHERE status = 'parceria' AND cliente_id = $ttt[cod_cliente]";
		$pegarparceriaquery = pg_query($pegarparceriasql);
		$pegarparceria = pg_num_rows($pegarparceriaquery);
		
		if(($pegarparceria < 1) && ($tipo_contratos['tipo_contrato'] != "aberto")){
			//Pegar a data da emissao da Fatura
			
			$diaaa = date("d");
			$messs = date("m");
			$anooo = date("Y");
			
			$dia = $diaaa;
			$mes = $messs;
			$ano = $anooo;

			if($dia >= 22){
				$mes = $mes + 1;
			}

			if($mes == 13){
				$ano = $ano+1;
			}

			if($mes == 13){
				$mes = 01;
			}
		
			$dataconfirm = $ano."-".$mes."-21";
			
			//Pegar a data de vencimento da Fatura
			//Pegar data de vencimento do contrato
			$contratovencisql = "SELECT vencimento FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente]";
			$contratovenciquery = pg_query($contratovencisql);
			$contratovenci = pg_fetch_array($contratovenciquery);
			$contravencinum = pg_num_rows($contratovenciquery);
			
			if($contravencinum >= 1){
			
				$diacontravenci = date('d', strtotime($contratovenci['vencimento']));
			}else{
				$diacontravenci = '20';
			}
		
			$dia2 = date("d");
			$mes2 = date("m");
			$mes2 = $mes2+1;
			$ano2 = date("Y");

			if($dia2 >= 22){
				$mes2 = $mes2 + 1;
			}

			if($mes2 == 13){
				$ano2 = $ano2+1;
			}

			if($mes2 == 13){
				$mes2 = 01;
			}

			$dataconfirm2 = $ano2."-".$mes2."-".$diacontravenci;
			
			//Esse pega o numero da Fatura
			$numfaturasql = "SELECT * FROM site_fatura_info WHERE data_emissao = '$dataconfirm' AND cod_cliente = $ttt[cod_cliente]";
			$numfaturaquery = pg_query($numfaturasql);
			$numfatura = pg_fetch_array($numfaturaquery);
			$numfaturanum = pg_num_rows($numfaturaquery);
			
			//Pegar Filial			
			$filialsql = "SELECT filial_id FROM cliente WHERE cliente_id = $ttt[cod_cliente] ";
			$filialquery = pg_query($filialsql);
			$numfilial = pg_fetch_array($filialquery);
		
			if($numfaturanum == 0){
				//Esse pega o numero do ultimo cod_fatura e aumenta mais um
				$sqlmax = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
		  		$rmax = pg_query($sqlmax);
		  		$max = pg_fetch_array($rmax);
				$maxnumfatura = $max[cod_fatura] + 1;
			
				//Puxar Tipo de Contrato pela Site Gerar Contrato.
				$sql = "INSERT INTO site_fatura_info(cod_fatura, cod_cliente, cod_filial, data_criacao, data_emissao, data_vencimento, tipo_contrato, planilha_checked, email_enviado, migrado, parcela, tipo_pagamento, tagged, pc, tipo_fatura)
				VALUES('".$maxnumfatura."','".$ttt[cod_cliente]."','".$numfilial[filial_id]."','".date("Y-m-d", mktime(0,0,0,$messs,$diaaa,$anooo))."','$dataconfirm','$dataconfirm2','".$tipo_contratos[tipo_contrato]."',0,0,0,'1/1','Boleto',0,0,0)";
				
		        $result = pg_query($sql);
				
				$numfaturasql = "SELECT * FROM site_fatura_info WHERE data_emissao = '$dataconfirm' AND cod_cliente = $ttt[cod_cliente]";
				$numfaturaquery = pg_query($numfaturasql);
				$numfatura = pg_fetch_array($numfaturaquery);
			}
			
			//INÍCIO DO NÃO PERIÓDICO
			if($ttt['tipo_exame'] != "Periódico"){
			
				//Pegar numero de funcionários ativos do CGRT
				$numcgrtsql = "SELECT cod_cgrt FROM cgrt_info WHERE cod_cliente = $ttt[cod_cliente] ORDER BY ano DESC, data_criacao ASC";
				$numcgrtquery = pg_query($numcgrtsql);
				$numcgrt = pg_fetch_array($numcgrtquery);
				
				if(pg_num_rows($numcgrtquery) >=1){
					$cod_cgrt = $numcgrt[cod_cgrt];
			
					$sqlcgrtfunc = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
					WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
					AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
					$rflcgrtfunc = pg_query($sqlcgrtfunc);
					$cgrtfunc = pg_num_rows($rflcgrtfunc);
					
					$numfunc = $cgrtfunc;
				}else{
					$numfuncsql = "SELECT * FROM funcionarios WHERE cod_cliente = $ttt[cod_cliente] AND cod_status = 1";
					$numfuncquery = pg_query($numfuncsql);
					$numfunc = pg_num_rows($numfuncquery);
				}
		
				//Colocar em grupo e Puxar preço dos produtos Aso e PPP, se ele for contrato novo, preço fixo
				$pegaranocontratosql = "SELECT tipo_contrato, ultima_alteracao FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente] AND ultima_alteracao >= '2015-01-01'";
				$pegaranocontratoquery = pg_query($pegaranocontratosql);
				$pegaranocontrato = pg_num_rows($pegaranocontratoquery);
		
				if($pegaranocontrato >= 1){
					$numaso = 70481;
					$numppp = 70521;
				}else{
					$grau_riscosql = "SELECT grau_de_risco FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
					$grau_riscoquery = pg_query($grau_riscosql);
					$grau_riscoarray = pg_fetch_array($grau_riscoquery);
					
					$grau_risco = $grau_riscoarray['grau_de_risco'];
			
					if($grau_risco == 1){
						if($numfunc<=10){
							$numaso = 43;
							$numppp = 67;
						}elseif($numfunc<=20){
							$numaso = 44;
							$numppp = 68;
						}elseif($numfunc<=50){
							$numaso = 45;
							$numppp = 69;
						}elseif($numfunc<=100){
							$numaso = 46;
							$numppp = 70;
						}elseif($numfunc<=150){
							$numaso = 47;
							$numppp = 71;
						}elseif($numfunc<=250){
							$numaso = 48;
							$numppp = 72;
						}elseif($numfunc<=350){
							$numaso = 49;
							$numppp = 73;
						}elseif($numfunc>=351){
							$numaso = 50;
							$numppp = 74;
						}
					}elseif($grau_risco == 2){
						if($numfunc<=10){
							$numaso = 205;
							$numppp = 229;
						}elseif($numfunc<=20){
							$numaso = 206;
							$numppp = 230;
						}elseif($numfunc<=50){
							$numaso = 207;
							$numppp = 231;
						}elseif($numfunc<=100){
							$numaso = 208;
							$numppp = 232;
						}elseif($numfunc<=150){
							$numaso = 209;
							$numppp = 233;
						}elseif($numfunc<=250){
							$numaso = 210;
							$numppp = 234;
						}elseif($numfunc<=350){
							$numaso = 211;
							$numppp = 235;
						}elseif($numfunc>=351){
							$numaso = 212;
							$numppp = 236;
						}
					}elseif($grau_risco == 3){
						if($numfunc<=10){
							$numaso = 367;
							$numppp = 391;
						}elseif($numfunc<=20){
							$numaso = 368;
							$numppp = 392;
						}elseif($numfunc<=50){
							$numaso = 369;
							$numppp = 393;
						}elseif($numfunc<=100){
							$numaso = 370;
							$numppp = 394;
						}elseif($numfunc<=150){
							$numaso = 371;
							$numppp = 395;
						}elseif($numfunc<=250){
							$numaso = 372;
							$numppp = 396;
						}elseif($numfunc<=350){
							$numaso = 373;
							$numppp = 397;
						}elseif($numfunc>=351){
							$numaso = 374;
							$numppp = 398;
						}
					}elseif($grau_risco == 4){
						if($numfunc<=10){
							$numaso = 555;
							$numppp = 579;
						}elseif($numfunc<=20){
							$numaso = 556;
							$numppp = 580;
						}elseif($numfunc<=50){
							$numaso = 557;
							$numppp = 581;
						}elseif($numfunc<=100){
							$numaso = 558;
							$numppp = 582;
						}elseif($numfunc<=150){
							$numaso = 559;
							$numppp = 583;
						}elseif($numfunc<=250){
							$numaso = 560;
							$numppp = 584;
						}elseif($numfunc<=350){
							$numaso = 561;
							$numppp = 585;
						}elseif($numfunc>=351){
							$numaso = 562;
							$numppp = 586;
						}
					}
				}
		
				if($pegaranocontrato >= 1){
					$precoasosql = "SELECT * FROM produto WHERE cod_prod = $numaso";
					$precoasoquery = pg_query($precoasosql);
					$precoaso = pg_fetch_array($precoasoquery);
					
					$precopppsql = "SELECT * FROM produto WHERE cod_prod = $numppp";
					$precopppquery = pg_query($precopppsql);
					$precoppp = pg_fetch_array($precopppquery);
				}else{
					$precoasosql = "SELECT * FROM produto_alt WHERE cod_prod = $numaso";
					$precoasoquery = pg_query($precoasosql);
					$precoaso = pg_fetch_array($precoasoquery);
					
					$precopppsql = "SELECT * FROM produto_alt WHERE cod_prod = $numppp";
					$precopppquery = pg_query($precopppsql);
					$precoppp = pg_fetch_array($precopppquery);
				}
				
				$valoraso = $precoaso[preco_prod];
				$valorppp = $precoppp[preco_prod];
		
				// Pegar nome do Funcionário
				$nomefuncsql = "SELECT nome_func FROM funcionarios WHERE cod_cliente = $ttt[cod_cliente] AND cod_func = $ttt[cod_func]";
				$nomefuncquery = pg_query($nomefuncsql);
				$nomefunc = pg_fetch_array($nomefuncquery);
				
				$nome_func = ucwords(strtolower($nomefunc[nome_func]));
				
				// inverter a Data do aso
				$data = $ttt['aso_data'];
				$dataaso = date('d/m/Y', strtotime($data)) ;
		
				// Pegar numero contrato
				$anocontratosql = "SELECT ano_contrato FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
		        $anocontratoquery = pg_query($anocontratosql);
		        $anocontrato = pg_fetch_array($anocontratoquery);
				
				$num_contrato = $anocontrato['ano_contrato'].".".STR_PAD($ttt[cod_cliente],3, "0", STR_PAD_LEFT);
		
				//Pegar Descrição
				/*if($ttt['tipo_exame'] == "Periódico"){
					$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Periódico, $nomefunc[nome_func] em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
				}*/
				
				if($ttt['tipo_exame'] == "Admissional"){
					$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Admissional. Do(s) colaborador(es): ".$nome_func." em $dataaso . Conforme esta vigente no contrato de número: $num_contrato";
					
					$descricaoppp = "Prestação de serviço em segurança e medicina ocupacional,em emissão de PPP, de acordo com ASO Admissional do(s) colaborador(es): ".$nome_func." emitido em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
				}
				
				if($ttt['tipo_exame'] == "Demissional"){
					$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Demissional. Do(s) colaborador(es): ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
				}
				
				if($ttt['tipo_exame'] == "Mudança de função"){
					$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Mudança de Função, ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
				}
				
				if($ttt['tipo_exame'] == "Retorno ao Trabalho"){
					$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Retorno ao Trabalho, ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
				}
		
				//Inserir na Tabela
				$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
				VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoaso',1,'1/01',$valoraso)";
				$faturaquery = pg_query($faturasql);
				
				if($ttt['tipo_exame'] == "Admissional"){
					$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
					VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoppp',1,'1/01',$valorppp)";
					$faturaquery = pg_query($faturasql);
				}
			}//final do não periótico
				
			//Ve se na fatura tem Pro-Rata
			$proratasql = "SELECT * FROM site_fatura_produto WHERE descricao like '%Pro-rata%' AND cod_fatura = $numfatura[cod_fatura]";
			$prorataquery = pg_query($proratasql);
			$proratanum = pg_num_rows($prorataquery);
			
			//Inserir Pro-Rata
			if($proratanum >=1){
				
			}else{
				$descricaoprorata = "Taxa correspondente a atualização de programa por movimentação de pessoal Pro-rata, Conforme cláusula 2.1 (s) e 3.1(k) e do contrato de número: $num_contrato";
				
				$valorprorata = 35.28;
				
				$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
				VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoprorata',1,'1/01',$valorprorata)";
				
				$faturaquery = pg_query($faturasql);
			}
			
			//Ve se na fatura tem Cobrança Bancária
			$cobrabancosql = "SELECT * FROM site_fatura_produto WHERE descricao like '%bancário%' AND cod_fatura = $numfatura[cod_fatura]";
			$cobrabancoquery = pg_query($cobrabancosql);
			$cobrabanconum = pg_num_rows($cobrabancoquery);
		
			//Inserir Cobrança Bancária
			if($cobrabanconum >=1){
				
			}else{
				$descricaocobrabanco = "Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: $num_contrato";
				$valorcobrabanco = 8.12;
					
				$faturabancosql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
				VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaocobrabanco',1,'1/01',$valorcobrabanco)";
				
				$faturabancoquery = pg_query($faturabancosql);
			}
		}//final do parceria
		if($query){

		}
	}else{
		$t = "SELECT * FROM aso WHERE cod_aso = $_POST[aso1]";
		$tt = pg_query($t);
		$ttt = pg_fetch_array($tt);
		$sqll = "SELECT c.*, a.*, ce.*, ae.* FROM clinicas c, aso a, clinica_exame ce, aso_exame ae WHERE a.cod_clinica = c.cod_clinica AND a.cod_aso = $_POST[aso1] AND ae.cod_exame = '$chkbox' AND ce.cod_exame = '$chkbox' AND ce.cod_clinica = a.cod_clinica";
	    $res = @pg_query($sqll);
	    $buffer = @pg_fetch_array($res);
	    if($buffer['cod_clinica'] == 0){
	    	$sqlup = "UPDATE aso SET cod_clinica = $_POST[clinic] WHERE cod_aso = $_POST[aso1]";
	    	$queryup = pg_query($sqlup);

			$sql="UPDATE aso_exame SET confirma= 1, data = '$dtaso'  WHERE cod_exame = '$chkbox' AND cod_aso = $_POST[aso1] ";
			$query = @pg_query($sql); 
			$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
			$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente) VALUES ('$chkbox', '$_POST[aso1]', '$_POST[clinic]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]')";
			$query3 = @pg_query($sql3);
		}else{
			$sql="UPDATE aso_exame SET confirma= 1, data = '$dtaso'  WHERE cod_exame = '$chkbox' AND cod_aso = $_POST[aso1] ";
			$query = @pg_query($sql); 
			$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
			$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente) VALUES ('$chkbox', '$_POST[aso1]', '$buffer[cod_clinica]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]')";
			$query3 = @pg_query($sql3);
		}
		
		//Pegar o Status do Cliente, ve se é Parceira
		$statussql = "SELECT status FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
		$statusquery = pg_query($statussql);
		$status = pg_fetch_array($statusquery);
		
		$contratosql = "SELECT tipo_contrato, ultima_alteracao FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente]";
		$contratoquery = pg_query($contratosql);
		$tipo_contratos = pg_fetch_array($contratoquery);
		if($tipo_contratos['tipo_contrato'] == ''){
			$tipo_contrato = 'Fechado';
		}else{
			$tipo_contrato = ucfirst($tipo_contratos['tipo_contrato']);
				if($tipo_contrato == "A"){
					$tipo_contrato = "Aberto";
				}else if($tipo_contrato == "E"){
					$tipo_contrato = "Específico";
				}
		}
		
		$pegarparceriasql = "SELECT status, cliente_id FROM cliente WHERE status = 'parceria' AND cliente_id = $ttt[cod_cliente]";
		$pegarparceriaquery = pg_query($pegarparceriasql);
		$pegarparceria = pg_num_rows($pegarparceriaquery);
		
		if(($pegarparceria < 1) && ($tipo_contratos['tipo_contrato'] != "aberto")){
			//Pegar a data da emissao da Fatura
			
			$diaaa = date("d");
			$messs = date("m");
			$anooo = date("Y");
			
			$dia = $diaaa;
			$mes = $messs;
			$ano = $anooo;

			if($dia >= 22){
				$mes = $mes + 1;
			}

			if($mes == 13){
				$ano = $ano+1;
			}

			if($mes == 13){
				$mes = 01;
			}
			
			$dataconfirm = $ano."-".$mes."-21";
		
			//Pegar a data de vencimento da Fatura
			//Pegar data de vencimento do contrato
			$contratovencisql = "SELECT vencimento FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente]";
			$contratovenciquery = pg_query($contratovencisql);
			$contratovenci = pg_fetch_array($contratovenciquery);
			$contravencinum = pg_num_rows($contratovenciquery);
			
			if($contravencinum >= 1){
				$diacontravenci = date('d', strtotime($contratovenci['vencimento']));
			}else{
				$diacontravenci = '20';
			}
		
			$dia2 = date("d");
			$mes2 = date("m");
			$mes2 = $mes2+1;
			$ano2 = date("Y");

			if($dia2 >= 22){
				$mes2 = $mes2 + 1;
			}

			if($mes2 == 13){
				$ano2 = $ano2+1;
			}

			if($mes2 == 13){
				$mes2 = 01;
			}

			$dataconfirm2 = $ano2."-".$mes2."-".$diacontravenci;
			
			//Esse pega o numero da Fatura
			$numfaturasql = "SELECT * FROM site_fatura_info WHERE data_emissao = '$dataconfirm' AND cod_cliente = $ttt[cod_cliente]";
			$numfaturaquery = pg_query($numfaturasql);
			$numfatura = pg_fetch_array($numfaturaquery);
			$numfaturanum = pg_num_rows($numfaturaquery);
			
			//Pegar Filial
			$filialsql = "SELECT filial_id FROM cliente WHERE cliente_id = $ttt[cod_cliente] ";
			$filialquery = pg_query($filialsql);
			$numfilial = pg_fetch_array($filialquery);
		
			if($numfaturanum == 0){
				//Esse pega o numero do ultimo cod_fatura e aumenta mais um
				$sqlmax = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
		  		$rmax = pg_query($sqlmax);
		  		$max = pg_fetch_array($rmax);
				$maxnumfatura = $max[cod_fatura] + 1;
				
				//Puxar Tipo de Contrato pela Site Gerar Contrato.
				$sql = "INSERT INTO site_fatura_info(cod_fatura, cod_cliente, cod_filial, data_criacao, data_emissao, data_vencimento, tipo_contrato, planilha_checked, email_enviado, migrado, parcela, tipo_pagamento, tagged, pc, tipo_fatura)
				VALUES('".$maxnumfatura."','".$ttt[cod_cliente]."','".$numfilial[filial_id]."','".date("Y-m-d", mktime(0,0,0,$messs,$diaaa,$anooo))."','$dataconfirm','$dataconfirm2','".$tipo_contratos[tipo_contrato]."',0,0,0,'1/1','Boleto',0,0,0)";
		        $result = pg_query($sql);
				
				$numfaturasql = "SELECT * FROM site_fatura_info WHERE data_emissao = '$dataconfirm' AND cod_cliente = $ttt[cod_cliente]";
				$numfaturaquery = pg_query($numfaturasql);
				$numfatura = pg_fetch_array($numfaturaquery);
			}
		
			if($ttt['tipo_exame'] != "Periódico"){
				//Pegar numero de funcionários ativos do CGRT
				$numcgrtsql = "SELECT cod_cgrt FROM cgrt_info WHERE cod_cliente = $ttt[cod_cliente] ORDER BY ano DESC, data_criacao ASC";
				$numcgrtquery = pg_query($numcgrtsql);
				$numcgrt = pg_fetch_array($numcgrtquery);
				
				if(pg_num_rows($numcgrtquery) >=1){
					$cod_cgrt = $numcgrt[cod_cgrt];
			
					$sqlcgrtfunc = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
					WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
					AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
					$rflcgrtfunc = pg_query($sqlcgrtfunc);
					$cgrtfunc = pg_num_rows($rflcgrtfunc);
					
					$numfunc = $cgrtfunc;
				}else{
					$numfuncsql = "SELECT * FROM funcionarios WHERE cod_cliente = $ttt[cod_cliente] AND cod_status = 1";
					$numfuncquery = pg_query($numfuncsql);
					$numfunc = pg_num_rows($numfuncquery);
				}
		
				//Colocar em grupo e Puxar preço dos produtos Aso e PPP, se ele for contrato novo, preço fixo
				$pegaranocontratosql = "SELECT tipo_contrato, ultima_alteracao FROM site_gerar_contrato WHERE cod_cliente = $ttt[cod_cliente] AND ultima_alteracao >= '2015-01-01'";
				$pegaranocontratoquery = pg_query($pegaranocontratosql);
				$pegaranocontrato = pg_num_rows($pegaranocontratoquery);
				
				if($pegaranocontrato >= 1){
					$numaso = 70481;
					$numppp = 70521;
				}else{
					$grau_riscosql = "SELECT grau_de_risco FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
					$grau_riscoquery = pg_query($grau_riscosql);
					$grau_riscoarray = pg_fetch_array($grau_riscoquery);
					
					$grau_risco = $grau_riscoarray['grau_de_risco'];
			
				if($grau_risco == 1){
					if($numfunc<=10){
						$numaso = 43;
						$numppp = 67;
					}elseif($numfunc<=20){
						$numaso = 44;
						$numppp = 68;
					}elseif($numfunc<=50){
						$numaso = 45;
						$numppp = 69;
					}elseif($numfunc<=100){
						$numaso = 46;
						$numppp = 70;
					}elseif($numfunc<=150){
						$numaso = 47;
						$numppp = 71;
					}elseif($numfunc<=250){
						$numaso = 48;
						$numppp = 72;
					}elseif($numfunc<=350){
						$numaso = 49;
						$numppp = 73;
					}elseif($numfunc>=351){
						$numaso = 50;
						$numppp = 74;
					}
				}elseif($grau_risco == 2){
					if($numfunc<=10){
						$numaso = 205;
						$numppp = 229;
					}elseif($numfunc<=20){
						$numaso = 206;
						$numppp = 230;
					}elseif($numfunc<=50){
						$numaso = 207;
						$numppp = 231;
					}elseif($numfunc<=100){
						$numaso = 208;
						$numppp = 232;
					}elseif($numfunc<=150){
						$numaso = 209;
						$numppp = 233;
					}elseif($numfunc<=250){
						$numaso = 210;
						$numppp = 234;
					}elseif($numfunc<=350){
						$numaso = 211;
						$numppp = 235;
					}elseif($numfunc>=351){
						$numaso = 212;
						$numppp = 236;
					}
				}elseif($grau_risco == 3){
					if($numfunc<=10){
						$numaso = 367;
						$numppp = 391;
					}elseif($numfunc<=20){
						$numaso = 368;
						$numppp = 392;
					}elseif($numfunc<=50){
						$numaso = 369;
						$numppp = 393;
					}elseif($numfunc<=100){
						$numaso = 370;
						$numppp = 394;
					}elseif($numfunc<=150){
						$numaso = 371;
						$numppp = 395;
					}elseif($numfunc<=250){
						$numaso = 372;
						$numppp = 396;
					}elseif($numfunc<=350){
						$numaso = 373;
						$numppp = 397;
					}elseif($numfunc>=351){
						$numaso = 374;
						$numppp = 398;
					}
				}elseif($grau_risco == 4){
					if($numfunc<=10){
						$numaso = 555;
						$numppp = 579;
					}elseif($numfunc<=20){
						$numaso = 556;
						$numppp = 580;
					}elseif($numfunc<=50){
						$numaso = 557;
						$numppp = 581;
					}elseif($numfunc<=100){
						$numaso = 558;
						$numppp = 582;
					}elseif($numfunc<=150){
						$numaso = 559;
						$numppp = 583;
					}elseif($numfunc<=250){
						$numaso = 560;
						$numppp = 584;
					}elseif($numfunc<=350){
						$numaso = 561;
						$numppp = 585;
					}elseif($numfunc>=351){
						$numaso = 562;
						$numppp = 586;
					}
				}
			}
		
			if($pegaranocontrato >= 1){
				$precoasosql = "SELECT * FROM produto WHERE cod_prod = $numaso";
				$precoasoquery = pg_query($precoasosql);
				$precoaso = pg_fetch_array($precoasoquery);
				
				$precopppsql = "SELECT * FROM produto WHERE cod_prod = $numppp";
				$precopppquery = pg_query($precopppsql);
				$precoppp = pg_fetch_array($precopppquery);
			}else{
				$precoasosql = "SELECT * FROM produto_alt WHERE cod_prod = $numaso";
				$precoasoquery = pg_query($precoasosql);
				$precoaso = pg_fetch_array($precoasoquery);
				
				$precopppsql = "SELECT * FROM produto_alt WHERE cod_prod = $numppp";
				$precopppquery = pg_query($precopppsql);
				$precoppp = pg_fetch_array($precopppquery);
			}
			
			$valoraso = $precoaso[preco_prod];
			$valorppp = $precoppp[preco_prod];
		
			// Pegar nome do Funcionário
			$nomefuncsql = "SELECT nome_func FROM funcionarios WHERE cod_cliente = $ttt[cod_cliente] AND cod_func = $ttt[cod_func]";
			$nomefuncquery = pg_query($nomefuncsql);
			$nomefunc = pg_fetch_array($nomefuncquery);
			
			$nome_func = ucwords(strtolower($nomefunc[nome_func]));
			
			// inverter a Data do aso
			$data = $ttt['aso_data'];
			$dataaso = date('d/m/Y', strtotime($data));
		
			// Pegar numero contrato
			$anocontratosql = "SELECT ano_contrato FROM cliente WHERE cliente_id = $ttt[cod_cliente]";
	        $anocontratoquery = pg_query($anocontratosql);
	        $anocontrato = pg_fetch_array($anocontratoquery);
			
			$num_contrato = $anocontrato['ano_contrato'].".".STR_PAD($ttt[cod_cliente],3, "0", STR_PAD_LEFT);
			
			//Pegar Descrição
			/*if($ttt['tipo_exame'] == "Periódico"){
				$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Periódico, $nomefunc[nome_func] em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
			}*/
			
			if($ttt['tipo_exame'] == "Admissional"){
				$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Admissional. Do(s) colaborador(es): ".$nome_func." em $dataaso . Conforme esta vigente no contrato de número: $num_contrato";
				
				$descricaoppp = "Prestação de serviço em segurança e medicina ocupacional,em emissão de PPP, de acordo com ASO Admissional do(s) colaborador(es): ".$nome_func." emitido em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
			}
			
			if($ttt['tipo_exame'] == "Demissional"){
				$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Demissional. Do(s) colaborador(es): ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
			}
			
			if($ttt['tipo_exame'] == "Mudança de função"){
				$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Mudança de Função, ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
			}
			
			if($ttt['tipo_exame'] == "Retorno ao Trabalho"){
				$descricaoaso = "Prestação de serviço em segurança e medicina ocupacional,em emissão de ASO Retorno ao Trabalho, ".$nome_func." em $dataaso , conforme esta vigente no contrato de número: $num_contrato";
			}
		
			//Inserir na Tabela
			$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
			VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoaso',1,'1/01',$valoraso)";
			$faturaquery = pg_query($faturasql);
			
			if($ttt['tipo_exame'] == "Admissional"){
				$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
				VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoppp',1,'1/01',$valorppp)";
				$faturaquery = pg_query($faturasql);
			}
		}//final do não periótico
		
		//Ve se na fatura tem Pro-Rata
		$proratasql = "SELECT * FROM site_fatura_produto WHERE descricao like '%Pro-rata%' AND cod_fatura = $numfatura[cod_fatura]";
		$prorataquery = pg_query($proratasql);
		$proratanum = pg_num_rows($prorataquery);
		
		//Inserir Pro-Rata
		if($proratanum >=1){
			
		}else{
			$descricaoprorata = "Taxa correspondente a atualização de programa por movimentação de pessoal Pro-rata, Conforme cláusula 2.1 (s) e 3.1(k) e do contrato de número: $num_contrato";
			
			$valorprorata = 35.28;
			
			$faturasql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
			VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaoprorata',1,'1/01',$valorprorata)";
			
			$faturaquery = pg_query($faturasql);
		}
		
		//Ve se na fatura tem Cobrança Bancária
		$cobrabancosql = "SELECT * FROM site_fatura_produto WHERE descricao like '%bancário%' AND cod_fatura = $numfatura[cod_fatura]";
		$cobrabancoquery = pg_query($cobrabancosql);
		$cobrabanconum = pg_num_rows($cobrabancoquery);
		
		//Inserir Cobrança Bancária
		if($cobrabanconum >=1){
			
		}else{
			$descricaocobrabanco = "Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: $num_contrato";
			$valorcobrabanco = 8.12;
				
			$faturabancosql = "INSERT INTO site_fatura_produto (cod_fatura,cod_cliente,cod_filial,descricao,quantidade,parcelas,valor)
			VALUES ($numfatura[cod_fatura],$ttt[cod_cliente],1,'$descricaocobrabanco',1,'1/01',$valorcobrabanco)";
			
			$faturabancoquery = pg_query($faturabancosql);
		}
	}//final do não parceria		
}// final da programação do financeiro
}
$sql_r = "SELECT a.cod_aso, a.cod_cliente, c.cliente_id, c.grau_de_risco FROM aso a, cliente c WHERE a.cod_aso = $_POST[aso1] AND a.cod_cliente = c.cliente_id";
$query_r = @pg_query($sql_r);
$array_r = @pg_fetch_array($query_r);
$aso_ = $_POST[aso2];
if($_POST[aso2]){
	$sql3="UPDATE aso SET aso_resultado = '$aso_', risco_id = {$array_r[0][grau_de_risco]} WHERE cod_aso = $_POST[aso1]";
	$query3 = @pg_query($sql3); 
}
if($_POST[clas]){
	$sql4="UPDATE aso SET classificacao_atividade_id = $_POST[clas] WHERE cod_aso = $_POST[aso1]";
	$query4 = @pg_query($sql4); 
}

if($_POST['obs']){
	$obs = $_POST['obs'];
	$sql5="UPDATE aso SET obs = '$obs' WHERE cod_aso = $_POST[aso1]";
	$query5 = @pg_query($sql5); 
}

if($_POST['aso_d']){
	$dma = explode('/', $_POST['aso_d']);
	$aso_d = $dma[2]."-".$dma[1]."-".$dma[0];
	$sql6="UPDATE aso SET aso_data = '$aso_d' WHERE cod_aso = $_POST[aso1]";
	$query6 = @pg_query($sql6); 
}

if($_POST['aso_d'] && $aso_ != ''){
	$sel = "SELECT cod_aso, cod_func FROM aso WHERE cod_aso = $_POST[aso1] ORDER BY aso_data DESC";
	$que = pg_query($sel);
	$buf = pg_fetch_all($que);
	$sql6="UPDATE funcionarios SET data_ultimo_exame = '$_POST[aso_d]' WHERE cod_func = '{$buf[0][cod_func]}'";
	$query6 = @pg_query($sql6); 
}

if($_POST['tolerancia']){
	$tolerancia = $_POST['tolerancia'];
	$sql7="UPDATE aso SET tolerancia = '$tolerancia' WHERE cod_aso = $_POST[aso1]";
	$query7 = @pg_query($sql7); 
}

$count = 0;
$datas = array();
while(count($datas)<40){
	if(date("w", mktime(0,0,0,date("m"),date("d")-$count,date("Y"))) != 0 &&
	date("w", mktime(0,0,0,date("m"),date("d")-$count,date("Y"))) != 6){
		$datas[] =  date("Y-m-d", mktime(0,0,0,date("m"),date("d")-$count,date("Y")));
	}
	$count++;
}

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);

if(!empty($_GET[cliente]) && !empty($_GET[funcionario]) && !empty($_GET[aso]) && !empty($_GET[email])){
    $sql = "SELECT f.cod_cliente, f.cod_filial, f.cod_funcao,f.nome_func, f.num_ctps_func, f.serie_ctps_func, fe.exame_id, 								fe.descricao, fun.nome_funcao, fun.dsc_funcao FROM
        funcionarios f, funcao_exame fe, funcao fun WHERE
        f.cod_cliente = '".$_GET['cliente']."' AND
        f.cod_func = {$_GET['funcionario']} AND
        f.cod_funcao = fe.cod_exame AND
        fun.cod_funcao = fe.cod_exame";
    $rss = pg_query($sql);
    $funcionario = pg_fetch_all($rss);
}

if($_POST[aso1]){
	$aso = $_POST[aso1];
}else{
	$aso = $_POST[search];
}

$p = "SELECT * FROM aso WHERE cod_aso = '$aso'";
$pp = pg_query($p);
$ppp = pg_fetch_array($pp);

/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
    echo "<td width=250 class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            echo "<b>Pesquisa</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
        echo "<form method=POST name='form1' action='?dir=gerar_aso&p=lista_aso'>";
            echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o numero do encaminhamento no campo e clique em Busca para pesquisar um ASO.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                echo "&nbsp;";
                echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
            echo "</td>";
        echo "</form>";
		echo "</tr>";
		echo "</table>";
		echo "<P>";
		
        // --> TIPBOX
        echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
            echo "<td class=text height=30 valign=top align=justify>";
                echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
	echo "<td class='text roundborder' valign=top>";
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td align=center class='text roundborderselected'><b>Resultado da Pesquisa</b></td>";
			echo "</tr>";
		echo "</table>";
	
		echo "<form method=POST name='form2' action='?dir=gerar_aso&p=lista_aso'>";
		if($_POST[search]){
			$sql = "SELECT * FROM aso WHERE $_POST[search] = cod_aso ORDER BY cod_aso";
			$result_aso = pg_query($sql);
			$row = pg_fetch_all($result_aso);

			for($x=0;$x<pg_num_rows($result_aso);$x++){
				$sql = "SELECT f.*, c.*, s.* FROM funcionarios f, cliente c, funcao s
				WHERE
				f.cod_cliente = c.cliente_id AND
				f.cod_funcao = s.cod_funcao AND
				c.cliente_id = {$row[$x][cod_cliente]} AND
				f.cod_func = {$row[$x][cod_func]}";
				$result = pg_query($sql);
				$buffer = pg_fetch_array($result);
				echo "<table width=100% border=0>";	
					echo "<tr><td width=60%>";
						echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
							echo "<tr>";	
								echo "<td bgcolor='$color'><b>Empresa:</b></td>";
							echo "</tr>";
							echo "<tr>";	
								echo "<td>" . $buffer[razao_social] . "</td>";
							echo "</tr>";
						echo "</table>";
					echo "<table  width=100% border=0 cellspacing=2 cellpadding=2 >";
						echo "<tr>";
							echo "<td class='text' width=100%><b>Exames feitos:</b></td>";
						echo "</tr>";
					echo "</table>";
				$nome_f = $buffer[nome_func];
				$setor_f = $buffer[nome_funcao];
			}
		}
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";

	$sql = "SELECT ae.*, e.* FROM aso_exame ae, exame e WHERE $_POST[search] = ae.cod_aso AND ae.cod_exame = e.cod_exame";
	$result_ex=@pg_query($sql);
	
		for($x=0;$x<@pg_num_rows($result_ex);$x++){
		$row_ex[$x] = @pg_fetch_array($result_ex);
		echo "<td align=left class='text' width=100%>";
		echo "<input name=confirma[] type=checkbox value={$row_ex[$x][cod_exame]}";
		if ($row_ex[$x][confirma] == 0){
		echo ">";
				
		}else{
		echo " checked disabled >";
		}
		echo " <b>Exame:</b> ";
		echo $row_ex[$x][especialidade];
		
         echo "<td width=70%>";
            echo "<select name=aso_data[] id=aso_data";
			
			if ($row_ex[$x][confirma] == 0){
			echo ">";
				
			}else{
			echo " disabled=disabled>";
			}
			if ($row_ex[$x][confirma] == 1){
                echo "<option value='".date("Y-m-d", strtotime($row_ex[$x][data]))."'>".date("d-m-Y", strtotime($row_ex[$x][data]))."</option>";
			}
            for($d=0;$d<count($datas);$d++){
                echo "<option value='".date("Y-m-d", strtotime($datas[$d]))."'>".date("d-m-Y", strtotime($datas[$d]))."</option>";
            }
            echo "</select>";
         echo "</td>";
         
		$as = $row_ex[$x][cod_aso];
		echo "<input name=aso1 type=hidden value={$row_ex[$x][cod_aso]}>";
	echo "</td>";
    echo "</tr>";
	}
	
	$result = "SELECT * FROM aso WHERE cod_aso = $as";
	$raso = @pg_query($result);
	$buffer = @pg_fetch_array($raso);
	
	$t = "SELECT * FROM clinicas";
	$tt = pg_query($t);
	$ttt = pg_fetch_all($tt);
		
	$sq = "SELECT f.*, c.* FROM funcionarios f, cliente c
	WHERE
	f.cod_cliente = c.cliente_id AND
	c.cliente_id = $buffer[cod_cliente] AND
	f.cod_func = $buffer[cod_func]";
	$resul = @pg_query($sq);
	$buff = @pg_fetch_array($resul);

if($resul){

	if($buffer[cod_clinica] == 0){
	echo "<tr>";
    echo "<tr><td><b>Clínica:</b></td></tr>";
	echo "<tr><td>";
	echo "<select name='clinic' id='clinic' style=\"width: 230px;\">";
	echo "<option value='' selected=selected></option>";
	for($x=0;$x<=pg_num_rows($tt);$x++){
		echo "<option value='{$ttt[$x][cod_clinica]}'>{$ttt[$x][razao_social_clinica]}	</option>";
	}
	echo "</select></td></tr>";
	}
	
		echo "<tr>";
    echo "<tr><td><b>Classificação da Atividade:</b></td><td><b>ASO data:</b></td></tr>";
    echo "<tr><td><select name='clas' id='clas' style=\"width: 230px;\">";
		
		echo "<option value='0'"; 
		if($buffer[classificacao_atividade_id]==""){
			echo "selected";
		} 
		echo "></option>";
		//0
		echo "<option value='1'"; 
		if($buffer[classificacao_atividade_id]==1){
			echo "selected";
		} 
		echo ">Penosa</option>";
		//1
		echo "<option value='2'"; 
		if($buffer[classificacao_atividade_id]==2){
			echo " selected";
		} 
		echo ">Insalubre</option>";
		//2
		echo "<option value='3'"; 
		if($buffer[classificacao_atividade_id]==3){
			echo " selected";
		} 
		echo ">Periculosa</option>";
		//3
		echo "<option value='4'"; 
		if($buffer[classificacao_atividade_id]==4){
			echo " selected";
		} 
		echo ">Nenhuma das Situações</option>";
		
	echo "</select></td>";
    echo "<td align=left class='text'><input type='text' class='inputText' size=10 name=aso_d id=aso_d";
		$dma = explode('-', $buffer[aso_data]);
		echo " value='".$dma[2]."/".$dma[1]."/".$dma[0]."'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "</tr>";
	echo "<tr>";
    echo "<tr><td><b>Resultado:</b></td>";
	//Caso seja ASO avulso mostra opções adicionais
	if($buffer[tipo] == 1){
		echo "<td><b>Tolerância:</b></td>";
	}
    echo "</tr><tr><td><select name='aso2' id='aso2' onchange=\"showDiv(this.value);\" style=\"width: 230px;\">";
		
		echo "<option value=''"; 
		if($buffer[aso_resultado]==""){
			echo " selected";
		} 
		echo "></option>";
		//0
		echo "<option value='Apto'"; 
		if($buffer[aso_resultado]=="Apto"){
			echo " selected";
		} 
		echo ">Apto</option>";
		//1
		echo "<option value='Apto a manipular alimentos'"; 
		if($buffer[aso_resultado]=="Apto a manipular alimentos"){
			echo " selected";
		} 
		echo ">Apto à manipular alimentos</option>";
		//2
		echo "<option value='Apto para trabalhar em altura'"; 
		if($buffer[aso_resultado]=="Apto para trabalhar em altura"){
			echo " selected";
		} 
		echo ">Apto para trabalhar em altura</option>";
		//3
		echo "<option value='Apto para operar empilhadeira'"; 
		if($buffer[aso_resultado]=="Apto para operar empilhadeira"){
			echo " selected";
		} 
		echo ">Apto para operar empilhadeira</option>";
		//4
		echo "<option value='Apto para trabalhar em espaco confinado'"; 
		if($buffer[aso_resultado]=="Apto para trabalhar em espaco confinado"){
			echo " selected";
		} 
		echo ">Apto para trabalhar em espaço confinado</option>";
		//5
		echo "<option value='Inapto'";
		if($buffer[aso_resultado]=="Inapto"){
			echo " selected";
		} 
		echo ">Inapto</option>";
		//6
		echo "<option value='Apto com Restricao'"; 
		if($buffer[aso_resultado]=="Apto com Restricao"){
			echo " selected";
		} echo ">Apto com Restrição</option>";
		//7
		echo "<option value='Apto para trabalhar em altura e espaço confinado'"; 
		if($buffer[aso_resultado]=="Apto para trabalhar em altura e espaço confinado"){
			echo " selected";
		} 
		echo ">Apto para trabalhar em altura e espaço confinado</option>";
	echo "</select></td>";
	//Caso seja ASO avulso mostra opções adicionais
	if($buffer[tipo] == 1){
    echo "<td><select name='tolerancia' id='tolerancia' onchange=\"showDiv(this.value);\" style=\"width: 100px;\">";
		
		echo "<option value=''"; 
		if($ppp[tolerancia]==""){
			echo "selected";
		} 
		echo "></option>";
		echo "<option value='Pequeno'"; 
		if($ppp[tolerancia]=="Pequeno"){
			echo "selected";
		} 
		echo ">Pequeno</option>";
		echo "<option value='Médio'"; 
		if($ppp[tolerancia]=="Médio"){
			echo " selected";
		} 
		echo ">Médio</option>";
		echo "<option value='Grande'"; 
		if($ppp[tolerancia]=="Grande"){
			echo " selected";
		} 
		echo ">Grande</option>";
	echo "</select></td>";
	}
    echo "</tr>";
	
	$slist1 = "SELECT * FROM tipo_risco ORDER BY nome_tipo_risco ";
	$qlist1 = pg_query($slist1);
	$alist1 = pg_fetch_all($qlist1);
	
	$slist2 = "SELECT * FROM agente_risco ORDER BY nome_agente_risco";
	$qlist2 = pg_query($slist2);
	$alist2 = pg_fetch_all($qlist2);
			
	if($buffer[tipo] == 1){

	echo "<tr>";
    echo "<tr><td><b>Agente risco:</b></td><td><b>Tipo risco:</b></td></tr>";
    echo "<tr><td><select name='agente_risco[]' multiple='multiple' id='agente_risco_risco' style=\"width: 230px;\"  size='5'>";
			
		for($a=0;$a<pg_num_rows($qlist2);$a++){
			echo "<option value='".$alist2[$a][cod_agente_risco]."'";
			$slist22 = "SELECT * FROM avulso_agente_risco WHERE cod_aso = ".$aso." AND cod_agente_risco = ".$alist2[$a][cod_agente_risco]." ";
			if(pg_num_rows(pg_query($slist22))>=1){
				echo "selected";
			}
			echo ">".$alist2[$a][nome_agente_risco]."</option>";
		}
		
	echo "</select></td>";
    echo "<td><select name='tipo_risco[]' id='tipo_risco' multiple='multiple' style=\"width: 100px;\" size='5'>";
		
		for($b=0;$b<pg_num_rows($qlist1);$b++){
			echo "<option value='".$alist1[$b][cod_tipo_risco]."'";
			$slist11 = "SELECT * FROM avulso_tipo_risco WHERE cod_aso = ".$aso." AND cod_tipo_risco = ".$alist1[$b][cod_tipo_risco]." ";
			if(pg_num_rows(pg_query($slist11))>=1){
				echo "selected";
			}
			echo ">".$alist1[$b][nome_tipo_risco]."</option>";
		}
		
	echo "</select></td>";
    echo "</tr>";
	}
	echo '<tr><td>
		<div id="Apto com Restricao" ';
			if($buffer[aso_resultado]=="Apto com Restricao"){
				echo ' class="visivel">';
			}else{
				echo ' class="invisivel">';
			}
			echo'<b>Observações da restrição:<b><br>
			<textarea name="obs" id="obs" cols="26" rows="3">'.$buffer[obs].'</textarea>
		</div>
		</td></tr>';
	echo "</table>";
    echo "</td>";
    echo "<td width=40% valign=top>";
	
	echo "<table width=100%>";	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<b>Funcionário:</b>";					
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo $nome_f;			
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<b>Função: </b>";
	echo $setor_f;						
	echo "</td>";
	echo "</tr>";	
	echo "</table>";
	
    echo "</td>";
	echo "</table>";
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table width=100%>";	
	echo "<tr>";
	echo "<td align=center class='text roundborderselected'>";
	
	$confirmbtsql = "SELECT ae.confirma FROM aso_exame ae, exame e WHERE $_POST[search] = ae.cod_aso AND ae.cod_exame = e.cod_exame AND confirma = 1";
	$confirmbtquery = pg_query($confirmbtsql);
	$confirmbt = pg_num_rows($confirmbtquery);
	
	$diaina = date("d");
	$mesina = date("m");
	$anoina = date('Y');
	
	$sqlinatiaso = "SELECT c.cliente_id FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    ( EXTRACT(year FROM fi.data_vencimento) < $anoina )OR( EXTRACT(day FROM fi.data_vencimento) < $diaina
    AND
    EXTRACT(month FROM fi.data_vencimento) = $mesina
    AND
    EXTRACT(year FROM fi.data_vencimento) = $anoina )OR( EXTRACT(month FROM fi.data_vencimento) < $mesina
    AND
    EXTRACT(year FROM fi.data_vencimento) = $anoina
    )
    )
    AND
    fi.migrado = 0
    AND
    c.status != 'Inativo'
	AND
	c.cliente_id = $buff[cod_cliente]
    GROUP BY c.cliente_id
	ORDER BY cliente_id";
	
	$queryinatiaso = pg_query($sqlinatiaso);
	
	$inatiaso = pg_num_rows($queryinatiaso);
	
	if($inatiaso >= 1){
		if($_SESSION[grupo] == 'administrador'){
			if ($confirmbt == 0){
				echo "<input name=confirmar type=submit value='Confirmar ASO' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar exames e resultado do ASO.');\" onmouseout=\"hidetip('tipbox');\">";
			}else{
				echo "<input name=confirmar type=button value='Ja Confirmado' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Este ASO ja foi confirmado.');\" onmouseout=\"hidetip('tipbox');\">";
			}
		}else{
			echo "<input name=confirmar type=button value='Inadimplente' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Este Cliente esta em Inadimplência com a SESMT.');\" onmouseout=\"hidetip('tipbox');\">";
		}
	}else{
		if ($confirmbt == 0){
			echo "<input name=confirmar type=submit value='Confirmar ASO' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar exames e resultado do ASO.');\" onmouseout=\"hidetip('tipbox');\">";
		}else{
			echo "<input name=confirmar type=button value='Ja Confirmado' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Este ASO ja foi confirmado.');\" onmouseout=\"hidetip('tipbox');\">";
		}
	}
	
	echo "<input name=geraraso type=button value='Ver/Gerar ASO' class='btn' onmouseover=\"showtip('tipbox', '- Gerar e Visualizar PDF do ASO.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".$buff[cod_cliente]."&setor=".$buff[cod_setor]."&funcionario=".$buff[cod_func]."&aso=".$as."');\">
		<input name=enviaemail type=button value='Notificar' class='btn' onmouseover=\"showtip('tipbox', '- Enviar notificação para que o cliente saiba que o ASO encontra-se disponível no site.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"var mmm = prompt('Enviar este ASO para:','$buff[email]');
			if(mmm){location.href='?dir=gerar_aso&p=aso_mail&funcionario=$buff[cod_func]&aso=$as&cod_cliente=$buff[cod_cliente]&setor=$buff[cod_setor]&email='+mmm+'';
			}\">";
	echo "</td></tr>";
}else{
	showMessage('ASO não encontrado! Verifique o código e tente novamente!');	
}
	echo "</form>";
	echo "</table>";
    echo "</td>";
echo "</tr>";
echo "</table>";
?>