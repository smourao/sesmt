<?php
session_start();
// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i ") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
include "sessao.php";
include "./config/connect.php";
include "functions.php";
switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"
	case "administrador":
		$leitura = "";
	break;
}
$data = date("Y/m/d");
$qtd = 0;
$qtd2 = 1;
/*************************************************************************************/
//    DELEÇÃO DE CADASTRO
/*************************************************************************************/
if($_GET['act']=="del" && !empty($_GET['cod_cliente'])){
$sql = "SELECT * FROM orcamento WHERE cod_cliente = {$_GET['cod_cliente']}";
$result = pg_query($sql);
$orc = pg_fetch_all($result);
//echo $orc[0]['cod_orcamento'];
$sql = "DELETE FROM orcamento_produto WHERE cod_orcamento={$orc[0]['cod_orcamento']}";
pg_query($sql);
$sql = "DELETE FROM orcamento WHERE cod_orcamento = {$orc[0]['cod_orcamento']}";
pg_query($sql);
$sql = "DELETE FROM cliente_comercial WHERE cliente_id = {$_GET['cod_cliente']}";
pg_query($sql);
echo "<script>location.href='simulador_listagem.php';</script>";
}
/*************************************************************************************/
//    DUPLICAR CADASTRO
/*************************************************************************************/
if($_GET['act']=="duplicar"){
$sql = "SELECT * FROM cliente_comercial WHERE cliente_id={$_GET['cliente_id']} AND filial_id={$_GET['filial_id']}";
$result = pg_query($connect, $sql);
$dados = pg_fetch_all($result);

$sql = "SELECT MAX(filial_id) as max_filial FROM cliente_comercial WHERE cliente_id={$_GET['cliente_id']}";
$result = pg_query($connect, $sql);
$max = pg_fetch_all($result);

$new_filial = $max[0]['max_filial']+1;
$query_double="insert into cliente_comercial
		(cliente_id, filial_id, razao_social, nome_fantasia, endereco, num_end, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir, cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir, nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador, skype_contador, nome_contador, email_contador, status, classe, funcionario_id, data, cnpj_contratante ) values
        ({$dados[0]['cliente_id']},{$new_filial},'{$dados[0]['razao_social']}','{$dados[0]['nome_fantasia']}','{$dados[0]['endereco']}','{$dados[0]['num_end']}','{$dados[0]['bairro']}','{$dados[0]['cep']}','{$dados[0]['municipio']}','{$dados[0]['estado']}','{$dados[0]['telefone']}','{$dados[0]['fax']}','{$dados[0]['celular']}','{$dados[0]['email']}','{$dados[0]['cnpj']}','{$dados[0]['insc_estadual']}','{$dados[0]['insc_municipal']}','{$dados[0]['cnae_id']}','{$dados[0]['descricao_atividade']}','{$dados[0]['numero_funcionarios']}','{$dados[0]['grau_de_risco']}','{$dados[0]['nome_contato_dir']}','{$dados[0]['cargo_contato_dir']}','{$dados[0]['tel_contato_dir']}','{$dados[0]['email_contato_dir']}','{$dados[0]['skype_contato_dir']}','{$dados[0]['msn_contato_dir']}','{$dados[0]['nextel_contato_dir']}','{$dados[0]['nextel_id_contato_dir']}','{$dados[0]['nome_cont_ind']}','{$dados[0]['cargo_cont_ind']}','{$dados[0]['email_cont_ind']}','{$dados[0]['skype_cont_ind']}','{$dados[0]['tel_cont_ind']}','{$dados[0]['escritorio_contador']}','{$dados[0]['tel_contador']}','{$dados[0]['msn_contador']}','{$dados[0]['skype_contador']}','
        {$dados[0]['nome_contador']}','{$dados[0]['email_contador']}','{$dados[0]['status']}','{$dados[0]['classe']}','{$dados[0]['funcionario_id']}','{$dados[0]['data']}', '{$dados[0]['cnpj_contratante']}')";

$result_insert = pg_query($connect, $query_double);

 if($result_insert){
	header("location: simulador_cadastro_cliente.php?cliente_id={$dados[0]['cliente_id']}&filial_id=$new_filial&funcionario_id={$dados[0]['funcionario_id']}");
 }else{
	echo "<script> alert('ERRO NA DUPLICAÇÃO!!!'); </script>";
 }
}
if($cnae_digitado!=""){
	$query_cnae="select cnae_id, descricao from cnae where cnae='$cnae_digitado'";
	$result_cnae=pg_query($query_cnae)
		or die("Erro na pesquisa de CNAE $query_cnae".pg_last_error($connect));

	$qtd_cnae=pg_num_rows($result_cnae);

	if($qtd_cnae==1){
		$row_cnae=pg_fetch_array($result_cnae);
		$cnae_id=$row_cnae[cnae_id];
	}
	else{
		$valor="";
		echo'<script>alert("CNAE não cadastrado ou inválido");</script>';
	}
}
/*************************************************************************************/
//    MIGRAR CADASTRO
/*************************************************************************************/
if ($_GET[migrar]=="Migrar"){

// TESTE DE CNPJ
$tcnpj = str_replace('-', '', $cnpj);
$tcnpj = str_replace('/', '', $tcnpj);
$tcnpj = str_replace('.', '', $tcnpj);
$sql = "SELECT * FROM cliente
WHERE replace(replace(replace(cnpj,'-',''), '/',''), '.', '') = '{$tcnpj}'";
$rt = pg_query($sql);
$bt = pg_fetch_array($rt);

//print_r($bt);

if(pg_num_rows($rt)>0){
		$query_insert = "UPDATE cliente SET
        razao_social = '$razao_social',
        nome_fantasia = '$nome_fantasia',
        endereco = '$endereco',
        bairro = '$bairro',
        cep = '$cep',
        municipio = '$municipio',
        estado = '$estado',
        telefone = '$telefone',
        fax = '$fax',
        celular = '$celular',
        email = '$email',
        insc_estadual = '$insc_estadual',
        insc_municipal = '$insc_municipal',
        cnae_id = $cnae_id,
        descricao_atividade = '$desc_atividade',
        numero_funcionarios = '$numero_funcionarios',
        grau_de_risco = '$grau_de_risco',
        nome_contato_dir = '$nome_contato_dir',
        cargo_contato_dir = '$cargo_contato_dir',
        tel_contato_dir = '$tel_contato_dir',
        email_contato_dir = '$email_contato_dir',
        skype_contato_dir = '$skype_contato_dir',
        msn_contato_dir = '$msn_contato_dir',
        nextel_contato_dir = '$nextel_contato_dir',
        nextel_id_contato_dir = '$nextel_id_contato_dir',
        nome_cont_ind  = '$nome_cont_ind',
        cargo_cont_ind = '$cargo_cont_ind',
        email_cont_ind = '$email_cont_ind',
        skype_cont_ind = '$skype_cont_ind',
        tel_cont_ind = '$tel_cont_ind',
        escritorio_contador = '$escritorio_contador',
        tel_contador = '$tel_contador',
        msn_contador = '$msn_contador',
        skype_contador = '$skype_contador',
        nome_contador = '$nome_contador',
        email_contador = '$email_contador',
        cnpj_contratante = '$cnpj_contratante',
        status = '$status',
        classe = '$classe',
        vendedor_id = $funcionario_id,
        num_end = '$num_end',
        num_rep = '$num_rep',
        membros_brigada = '$membros_brigada'
        WHERE
        cliente_id = {$bt[cliente_id]}
        AND
        filial_id = {$bt[filial_id]}
        ";
        
        if(pg_query($query_insert)){
           echo "<script>alert('Dados migrados com atualização de cadastro.');</script>";
        }else{
           echo "<script>alert('Erro ao atualizar dados na migração!');</script>";
        }
     $row_cod[cliente_id] = $bt[cliente_id];
     
   	$query_migrar = "SELECT * FROM cliente_comercial where cliente_id={$_GET['cod_cliente']}";
	$result_migrar = pg_query($query_migrar) or die ("Erro na migração!!! $query_migrar" .pg_last_error($connect));
	$row_migrar = pg_fetch_array($result_migrar);

	$query_cod = "select max(cliente_id)+1 as cliente_id, max(substr(ano_contrato, 6)) as max from cliente";//cria código automático do orçamento
    $result_cod = pg_query($query_cod) or die ("erro na consulta". pg_last_error($connect));
	$row_cod = pg_fetch_array($result_cod);


}else{
	$query_migrar = "SELECT * FROM cliente_comercial where cliente_id={$_GET['cod_cliente']}";
	$result_migrar = pg_query($query_migrar) or die ("Erro na migração!!! $query_migrar" .pg_last_error($connect));
	$row_migrar = pg_fetch_array($result_migrar);

	$query_cod = "select max(cliente_id)+1 as cliente_id, max(substr(ano_contrato, 6)) as max from cliente";//cria código automático do orçamento
    $result_cod = pg_query($query_cod) or die ("erro na consulta". pg_last_error($connect));
	$row_cod = pg_fetch_array($result_cod);

		$query_insert = "INSERT INTO cliente
		( cliente_id, filial_id, razao_social, nome_fantasia, endereco, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, cnpj_contratante, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir, cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir, nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador, skype_contador, nome_contador, email_contador, status, classe, vendedor_id, num_end, num_rep, membros_brigada, ano_contrato) values
		( $row_cod[cliente_id], 001, '$razao_social', '$nome_fantasia', '$endereco', '$bairro', '$cep', '$municipio', '$estado', '$telefone', '$fax', '$celular', '$email', '$cnpj', '$cnpj_contratante','$insc_estadual', '$insc_municipal', $cnae_id, '$desc_atividade', '$numero_funcionarios', '$grau_de_risco', '$nome_contato_dir', '$cargo_contato_dir', '$tel_contato_dir', '$email_contato_dir', '$skype_contato_dir', '$msn_contato_dir', '$nextel_contato_dir', '$nextel_id_contato_dir', '$nome_cont_ind', '$cargo_cont_ind', '$email_cont_ind', '$skype_cont_ind', '$tel_cont_ind', '$escritorio_contador', '$tel_contador', '$msn_contador', '$skype_contador', '$nome_contador', '$email_contador', '$status', '$classe', $funcionario_id, '$num_end', '$num_rep', '$membros_brigada', '".date("Y")."/".($row_cod[max]+1)."')";

        $result_insert = pg_query($query_insert) or die ("Erro ao inserir dados! $query_insert" .pg_last_error($connect));
}

/*****************************************************************************************************/
// MIGRAR ORÇAMENTO PARA TABELA DO SITE (SER APROVADO E GERADO CONTRATO PELO CLIENTE)
/*****************************************************************************************************/
        //SELECT DO ORÇAMENTO
        $sql = "SELECT * FROM orcamento WHERE cod_cliente = '{$_GET[cod_cliente]}'";
        $result = pg_query($sql);
        $orc_sim = pg_fetch_array($result);
        echo "<script>alert('".$_GET[cod_cliente]."');</script>";
        //SELECT DOS PRODUTOS DO ORCAMENTO
        $sql = "SELECT * FROM orcamento_produto WHERE cod_orcamento = '{$orc_sim['cod_orcamento']}'";
        $r = pg_query($sql);
        $sim_prod = pg_fetch_all($r);
        
        echo "<script>alert('".$sim_prod[$x]['cod_produto']."');</script>";

        //INSERE O ORCAMENTO NA TABELA DO SITE
        $sql = "INSERT INTO site_orc_info
        (cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado,
        orc_request_time, orc_request_time_sended, vendedor_id)
        VALUES
        ('{$orc_sim['cod_orcamento']}', '{$row_cod[cliente_id]}', '1','".pg_num_rows($r)."',
        '{$orc_sim['data']}', '".date("Y/m/d")."','1', '".date("h:i:s")."', '1',
        '{$row_migrar['funcionario_id']}')";
        $result_in = pg_query($sql);

        //SE FOI INSERIDO NO INFO, LOOP PARA INSERIR PRODUTOS
        if($result_in){
           for($x=0;$x<pg_num_rows($r);$x++){
              //INSERE OS PRODUTOS DO ORÇAMENTO NA TABELA DO SITE
              if($sim_prod[$x]['preco_unitario']){
                  $sql = "INSERT INTO site_orc_produto
                  (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
                  VALUES
                  ('{$orc_sim['cod_orcamento']}','{$row_cod[cliente_id]}', '1',
                  '{$sim_prod[$x]['cod_produto']}', '{$sim_prod[$x]['quantidade']}',
                  '1','', '{$sim_prod[$x]['preco_unitario']}')";
              }else{
                  $sql = "INSERT INTO site_orc_produto
                  (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda)
                  VALUES
                  ('{$orc_sim['cod_orcamento']}','{$row_cod[cliente_id]}', '1',
                  '{$sim_prod[$x]['cod_produto']}', '{$sim_prod[$x]['quantidade']}',
                  '1','')";
              }
              pg_query($sql);
           }
           header("location: cadastro_cliente.php?cliente_id=$row_cod[cliente_id]&filial_id=1");
        }else{
           echo "<script>alert('Erro ao migrar orçamento do cliente!')</script>";
           die("Erro ao migrar orçamento do cliente!");
        }
    if($result_insert){

    }else{
	    echo "<script> alert('ERRO NA MIGRAÇÃO!!!'); </script>";
    }


header("location: cadastro_cliente.php?cliente_id=$row_cod[cliente_id]&filial_id=1");

}//END MIGRAR
//}

function coloca_zeros($numero){
	echo str_pad($numero, 03, "0", STR_PAD_LEFT);
}

/*************************************************************************************/
//    NOVO CADASTRO
/*************************************************************************************/
if($valor == "gravar"){
	$query_cliente_cod = "select * from cliente_comercial where cliente_id=".$cod_cliente." and filial_id = ".$filial_id."";
	$result_cliente_cod = pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod = pg_fetch_array($result_cliente_cod);
	if ( pg_num_rows($result_cliente_cod) < 1) {
         $sql = "SELECT * FROM cliente_comercial WHERE cnpj='$cnpj'";
         $re = pg_query($sql);
        if(pg_num_rows($re) < 1){
        if($email == ""){$email = "comercial@sesmt-rio.com";}
		$query_cliente="insert into cliente_comercial
		(cliente_id, filial_id, razao_social, nome_fantasia, endereco, num_end, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, cnpj_contratante, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir, cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir, nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador, skype_contador, nome_contador, email_contador, status, classe, funcionario_id, data, num_rep, membros_brigada, relatorio_de_atendimento ) values
		($cod_cliente, $filial_id, '".addslashes(convertwords($razao_social))."', '".addslashes(convertwords($nome_fantasia))."', '".addslashes(convertwords($endereco))."', '$num_end', '".convertwords($bairro)."', '$cep', '".convertwords($municipio)."', '".convertwords($estado)."', '$telefone', '$fax', '$celular', '$email', '$cnpj', '$cnpj_contratante', '$insc_estadual', '$insc_municipal', '".$cnae_id."', '$desc_atividade', '$numero_funcionarios', '$grau_de_risco', '$nome_contato_dir', '$cargo_contato_dir', '$tel_contato_dir', '$email_contato_dir', '$skype_contato_dir', '$msn_contato_dir', '$nextel_contato_dir', '$nextel_id_contato_dir', '$nome_cont_ind', '$cargo_cont_ind', '$email_cont_ind', '$skype_cont_ind', '$tel_cont_ind', '$escritorio_contador', '$tel_contador', '$msn_contador', '$skype_contador', '$nome_contador', '$email_contador', '$status', '$classe', '$funcionario_id', '$dat', '$num_rep', '$membros_brigada', '".addslashes($relatorio)."')";

		$result_cliente = pg_query($query_cliente)
			or die("Erro na query: $query_cliente".pg_last_error($connect));

		$sql = "SELECT MAX(cod_orcamento)as cod_orcamento FROM site_orc_info";
		$r = pg_query($connect, $sql);
		$max = pg_fetch_array($r);

		$sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM orcamento";
		$r2 = pg_query($connect, $sql);
		$max2 = pg_fetch_array($r2);
		$row_cod[cod_orcamento] = 0;
		if($max[cod_orcamento] > $max2[cod_orcamento]){
		   $row_cod[cod_orcamento] = $max[cod_orcamento];
		}else{
		   $row_cod[cod_orcamento] = $max2[cod_orcamento];
		}
		
		$sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM site_orc_medi_info";
		$r3 = pg_query($sql);
		$max3 = pg_fetch_array($r3);

        if($row_cod[cod_orcamento] < $max3[cod_orcamento]){
            $row_cod[cod_orcamento] = $max3[cod_orcamento];
		}

		$row_cod[cod_orcamento]++;

		$query_incluir = "insert into orcamento (cod_cliente, cod_orcamento, data, tipo_cliente)
						  values
						  ($cod_cliente, $row_cod[cod_orcamento], '$data', 'Cliente Comercial')";//insere na tabela orçamento

		$result_incluir = pg_query($query_incluir)
			or die ("Erro na query:$query_incluir".pg_last_error($connect));

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = $numero_funcionarios;
				$sql_prod = 891;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = $numero_funcionarios;
				$sql_prod = 893;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = $numero_funcionarios;
				$sql_prod = 895;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = $numero_funcionarios;
				$sql_prod = 928;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = $numero_funcionarios;
				$sql_prod = 929;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = $numero_funcionarios;
				$sql_prod = 930;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = $numero_funcionarios;
				$sql_prod = 931;
			}elseif( $numero_funcionarios > 350){
				$qtd = $numero_funcionarios;
				$sql_prod = 932;
			}

				//seleciona ASO da tebela produto.
				$query_orcamento = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_prod;

				$result_orcamento = pg_query($query_orcamento) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento = pg_fetch_array($result_orcamento)) {
				$query_orc = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento[cod_prod], $qtd, $row_orcamento[preco_prod], ( $qtd * $row_orcamento[preco_prod]) )";

				$result_orc = pg_query($connect, $query_orc)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$sql_ppra = 423;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$sql_ppra = 966;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$sql_ppra = 967;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$sql_ppra = 968;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$sql_ppra = 969;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$sql_ppra = 970;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$sql_ppra = 971;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$sql_ppra = 990;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$sql_ppra = 991;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$sql_ppra = 992;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$sql_ppra = 993;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$sql_ppra = 994;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$sql_ppra = 995;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$sql_ppra = 996;
			}
				//seleciona PPRA da tebela produto.
				$query_orcamento2 = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_ppra;

				$result_orcamento2 = pg_query($query_orcamento2) or die ("Erro na Consulta orcamento2!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento2 = pg_fetch_array($result_orcamento2)) {
				$query_orc2 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento2[cod_prod], $qtd, $row_orcamento2[preco_prod], ( $qtd * $row_orcamento2[preco_prod]) )";


				$result_orc2 = pg_query($connect, $query_orc2)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = $numero_funcionarios;
				$qtd_prod = 933;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = $numero_funcionarios;
				$qtd_prod = 934;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = $numero_funcionarios;
				$qtd_prod = 935;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = $numero_funcionarios;
				$qtd_prod = 936;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = $numero_funcionarios;
				$qtd_prod = 937;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = $numero_funcionarios;
				$qtd_prod = 938;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 939;
			}elseif( $numero_funcionarios > 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 940;
			}

				//seleciona PPP da tebela produto.
				$query_orcamento3 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_prod;

				$result_orcamento3 = pg_query($query_orcamento3) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento3 = pg_fetch_array($result_orcamento3)) {
				$query_orc3 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento3[cod_prod], $qtd, $row_orcamento3[preco_prod], ( $qtd * $row_orcamento3[preco_prod]) )";

				$result_orc3 = pg_query($connect, $query_orc3)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_pcmso = 424;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_pcmso = 952;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_pcmso = 953;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_pcmso = 954;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_pcmso = 955;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_pcmso = 956;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_pcmso = 957;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_pcmso = 958;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_pcmso = 997;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_pcmso = 998;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_pcmso = 999;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_pcmso = 1000;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_pcmso = 1001;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_pcmso = 1002;
			}

				//seleciona PCMSO da tebela produto.
				$query_orcamento4 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_pcmso;

				$result_orcamento4 = pg_query($query_orcamento4) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento4 = pg_fetch_array($result_orcamento4)) {
				$query_orc4 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento4[cod_prod], $qtd, $row_orcamento4[preco_prod], ( $qtd * $row_orcamento4[preco_prod]) )";

				$result_orc4 = pg_query($connect, $query_orc4)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_apgre = 972;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_apgre = 973;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_apgre = 974;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_apgre = 975;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_apgre = 976;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_apgre = 977;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_apgre = 978;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_apgre = 979;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_apgre = 1003;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_apgre = 1004;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_apgre = 1005;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_apgre = 1006;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_apgre = 1007;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_apgre = 1008;
			}

				//seleciona APGRE da tebela produto.
				$query_orcamento5 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_apgre;

				$result_orcamento5 = pg_query($query_orcamento5) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento5 = pg_fetch_array($result_orcamento5)) {
				$query_orc5 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento5[cod_prod], $qtd, $row_orcamento5[preco_prod], ( $qtd * $row_orcamento5[preco_prod]) )";

				$result_orc5 = pg_query($connect, $query_orc5)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Condição para inserir curso de EPI
			if($numero_funcionarios != ""){
			$query_orcamento6 = "select cod_prod, preco_prod from produto where cod_prod = 431 ";

			$result_orcamento6 = pg_query($query_orcamento6) or die ("Erro na Consulta!". pg_last_error($connect));
			}
				while($row_orcamento6 = pg_fetch_array($result_orcamento6)){
				$query_orc6 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento6[cod_prod], $qtd, $row_orcamento6[preco_prod], ( $qtd * $row_orcamento6[preco_prod] ) )";

					$result_orc6 = pg_query($connect, $query_orc6)
						or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));

				}

			//AQUI FAZ O UPDATE NO GRAU DE RISCO
			if($grau_de_risco == 3){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 440;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 441;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 442;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 443;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 444;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 445;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 446;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 447;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1009;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1010;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1011;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1012;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1013;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1014;
				}
			}elseif($grau_de_risco == 4){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 448;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 804;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 805;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 890;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 892;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 894;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 896;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 942;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1015;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1016;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1017;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1018;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1019;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1020;
				}
			}

				if($grau_de_risco > 2){
				//seleciona LTCAT da tebela produto.
				$query_orcamento7 = "select cod_prod, preco_prod from produto where cod_prod = " .$ltcat;

				$result_orcamento7 = pg_query($query_orcamento7) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento7 = pg_fetch_array($result_orcamento7)) {
				$query_orc7 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento7[cod_prod], $qtd_ltcat, $row_orcamento7[preco_prod], ( $qtd_ltcat * $row_orcamento7[preco_prod]) )";

				$result_orc7 = pg_query($connect, $query_orc7)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
				}
			//CONDIÇÃO PARA INSERIR MAPA DE RISCO A3 E A4
			if($grau_de_risco <= 2){
			$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
							 	 FROM produto
								 WHERE cod_prod in (963, 965) ";
			$result_orcamento8 = pg_query($connect, $query_orcamento8)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

				while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
				if($row_orcamento8[cod_prod] == 965){
				   $qtd = 2;
				}else{
				   $qtd = 1;
				}

				$query_orc8 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento8[cod_prod], $qtd, $row_orcamento8[preco_prod], ( $qtd * $row_orcamento8[preco_prod] ) )";

					$result_orc8 = pg_query($connect, $query_orc8)
						or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}
			//CONDIÇÃO PARA INSERIR MAPA DE RISCO A0 E A3
			elseif($grau_de_risco >= 3){
				$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
									FROM produto
									WHERE cod_prod in (422, 964) ";
				$result_orcamento8 = pg_query($connect, $query_orcamento8)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

			while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
			if($row_orcamento8[cod_prod] == 964){
				   $qtd = 2;
				}else{
				   $qtd = 1;
				}

				$query_orc8 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento8[cod_prod], $qtd, $row_orcamento8[preco_prod], ( $qtd * $row_orcamento8[preco_prod] ) )";

					$result_orc8 = pg_query($connect, $query_orc8)
						or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}

			if($num_rep != ""){
				$num = explode("|", $num_rep);
				$t = $num[0] + $num[1];

				if($t == 1){
				$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod
							  		FROM produto
							  		WHERE cod_prod = 897 ";

				$result_orcamento9 = pg_query($connect, $query_orcamento9)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

					while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
						$query_orc9 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
									  values
									  ($row_cod[cod_orcamento], $row_orcamento9[cod_prod], ".$t.", $row_orcamento9[preco_prod], ".( $t * $row_orcamento9[preco_prod] )." )";

						$result_orc9 = pg_query($connect, $query_orc9)
							or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
					}
				}elseif($t > 1){
				$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod
									FROM produto
									WHERE cod_prod = 840 ";

				$result_orcamento9 = pg_query($connect, $query_orcamento9)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

					while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
						$query_orc9 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
									  values
									  ($row_cod[cod_orcamento], $row_orcamento9[cod_prod], ".$t.", $row_orcamento9[preco_prod], ".( $t * $row_orcamento9[preco_prod] )." )";

						$result_orc9 = pg_query($connect, $query_orc9)
							or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
					}
				}
			}

			if($membros_brigada != "" && $membros_brigada != '0'){
			$query_orcamento10 = "SELECT cod_prod, desc_resumida_prod, preco_prod
								  FROM produto
								  WHERE cod_prod = 982 ";
			$result_orcamento10 = pg_query($connect, $query_orcamento10)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

				while($row_orcamento10 = pg_fetch_array($result_orcamento10)){
				$query_orc10 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
								values
								($row_cod[cod_orcamento], $row_orcamento10[cod_prod], '$membros_brigada', $row_orcamento10[preco_prod], ( $membros_brigada * $row_orcamento10[preco_prod] ) )";

				$result_orc10 = pg_query($connect, $query_orc10)
					or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}

			if($t > 1){
			$query_orcamento11 = "SELECT desc_resumida_prod, preco_prod, cod_prod
								 FROM produto
								 WHERE cod_prod in (980, 981) ";

			$result_orcamento11 = pg_query($connect, $query_orcamento11)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

			while($row_orcamento11 = pg_fetch_array($result_orcamento11)){
				if($row_orcamento11[cod_prod] == 980){
				   $qtd = 1;
				}else{
				   if($row_orcamento11[cod_prod] == 981){
				      $qtd = 12;
					}
				}

				$query_orc11 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ($row_cod[cod_orcamento], $row_orcamento11[cod_prod], $qtd, $row_orcamento11[preco_prod], ( $qtd * $row_orcamento11[preco_prod] ) )";

				$result_orc11 = pg_query($connect, $query_orc11)
					or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}
			
			//CONDIÇÃO PARA INSERIR O PCMAT.
			$query_orcamento12 = "select * from cnae where cnae='{$cnae_digitado}' AND lower(descricao) like '%construção%' AND grau_risco > 2";
			$result_orcamento12 = pg_query($query_orcamento12);
			
			if(pg_num_rows($result_orcamento12) > 0){
				$query_orc12 = "select * from produto where desc_resumida_prod like '%Pcmat%'
								and $numero_funcionarios between g_min and g_max";
				$result_orc12 = pg_query($connect, $query_orc12);
				$ro2 = pg_fetch_array($result_orc12);


					$q_orc12 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
								values
								($row_cod[cod_orcamento], $ro2[cod_prod], 1, $ro2[preco_prod], $ro2[preco_prod])";
								
					$res_orc12 = pg_query($connect, $q_orc12);
			}
			
			if ($result_orc and $result_orc2 and $result_orc3 and $result_orc4 and $result_orc5 and $result_orc6 and $result_orc7 and $result_orc8 and $result_orc9 and $result_orc10 and $result_orc11){
				echo '<script>
				alert("Cliente Cadastrado com Sucesso!");
				location.href="simulador_cadastro_cliente.php?cliente_id='.$cod_cliente.'&filial_id='.$filial_id.'&funcionario_id=23";
				</script>';
			}
       }else{
       	echo '<script>
                 alert("CNPJ já cadastrado!");
             </script>';
       }
	} //SEQUENCIA DE ALTERAÇÕES DO SIMULADOR E DO ORÇAMENTO
	else{
	
	$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = {$cod_cliente}";
	$rsz = pg_query($sql);
	$cd = pg_fetch_array($rsz);
	
	$query_usuario = "select funcionario_id, nome from funcionario where funcionario_id={$cd['funcionario_id']} ";
	$result_usuario = pg_query($query_usuario);
	$func = pg_fetch_array($result_usuario);
	
    if($_SESSION['usuario_id'] == $cd['funcionario_id']){
       $quem = $func["nome"];
    }else{
       $quem = $func["nome"];
       $query_usuario = "select funcionario_id, nome from funcionario where funcionario_id={$_SESSION['usuario_id']} ";
	   $result_usuario = pg_query($query_usuario);
	   $func = pg_fetch_array($result_usuario);
	   $quem .=  " (Atualizado por: {$func[nome]})";
    }
	
	/*****************************************************************************/
	// RELATORIO DIFERENTE ENVIAR POR EMAIL
	/*****************************************************************************/
	if($cd[relatorio_de_atendimento] != $relatorio){
	   $headers = "MIME-Version: 1.0\n";
       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
       $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";

       $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
      <TITLE>Informativo</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
<style type=\"text/css\">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style13 {font-size: 14px}
.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style16 {font-size: 9px}
.style17 {font-family: Arial, Helvetica, sans-serif}
.style18 {font-size: 12px}
</style>
   </HEAD>
   <BODY>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho ltda.</span>
		  </font><br><br>
		  <p class=\"style18\">
		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
</td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"left\" class=\"fontepreta12\"><br />
		  <div class=\"style2 fontepreta12\" style=\"font-size:14px;\">
<center><u><strong>Atualização de Relatório de Atendimento</strong></u></center>
<p>
<br>
<table border=0 width=100%>
<tr>
<td width=100><b>Cód. Cliente:</b> </td><td>".$cd[cliente_id]."</td>
</tr>
<tr>
<td><b>Razão Social:</b> </td><td>".$cd[razao_social]."</td>
</tr>
<tr>
<td><b>Vendedor:</b> </td><td>".$quem."</td>
</tr>

<tr>
<td><b>Atualizado:</b> </td><td>".date("d/m/Y H:i:s")."</td>
</tr>
</table>
<p>

<table border=0 width=100%>
<tr><td><b>Informações do atendimento:</b></td></tr>
<tr>
<td bgcolor='#d5d5d5'>".addslashes(nl2br($relatorio))."</td>
</tr>
</table>
          </div>
           </td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<p>
		<tr>
		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
          <p class=\"style17\">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width=\"35%\" align=\"right\">
        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
	</tr>
</table></div>
   </BODY>
</HTML>  ";
  mail("comercial@sesmt-rio.com", "SESMT - Relatório de atendimento - {$cd[razao_social]}", $msg, $headers);
	}
	
	
		$query_cliente = "update cliente_comercial SET cliente_id=".$cod_cliente.", filial_id=".$filial_id.", razao_social='".addslashes($razao_social)."', nome_fantasia='".addslashes($nome_fantasia)."', endereco='".addslashes($endereco)."', num_end='$num_end', bairro='$bairro', cep='$cep', municipio='$municipio', estado='$estado', telefone='$telefone', fax='$fax', celular='$celular', email='$email', cnpj='$cnpj', insc_estadual='$insc_estadual', insc_municipal='$insc_municipal', cnae_id='$cnae_id', descricao_atividade='$desc_atividade', numero_funcionarios='$numero_funcionarios', grau_de_risco='$grau_de_risco', nome_contato_dir='$nome_contato_dir', cargo_contato_dir='$cargo_contato_dir', tel_contato_dir='$tel_contato_dir', email_contato_dir='$email_contato_dir', skype_contato_dir='$skype_contato_dir', msn_contato_dir='$msn_contato_dir', nextel_contato_dir='$nextel_contato_dir', nextel_id_contato_dir='$nextel_id_contato_dir', nome_cont_ind='$nome_cont_ind', cargo_cont_ind='$cargo_cont_ind', email_cont_ind='$email_cont_ind',
			skype_cont_ind='$skype_cont_ind', relatorio_de_atendimento = '".addslashes($relatorio)."', tel_cont_ind='$tel_cont_ind', escritorio_contador='$escritorio_contador', tel_contador='$tel_contador', msn_contador='$msn_contador', skype_contador='$skype_contador', nome_contador='$nome_contador', email_contador='$email_contador', status='$status', classe='$classe', funcionario_id='$funcionario_id', data='$dat', num_rep='$num_rep', membros_brigada='$membros_brigada', cnpj_contratante='$cnpj_contratante' where cliente_id=".$row_cliente_cod[cliente_id]."  and filial_id=".$filial_id."";
		$result_cliente=pg_query($query_cliente)
			or die("Erro na query: $query_cliente".pg_last_error($connect));

		if($cod_cliente != ""){
		$search = "select o.cod_orcamento from orcamento_produto op, cliente_comercial cc, orcamento o
				  where o.cod_cliente = cc.cliente_id
				  and cc.cliente_id = $cod_cliente";

		$resu = pg_query($connect, $search);
		$buff = pg_fetch_all($resu);

		//DELETAR PRODUTOS DO ORÇAMENTO
		$del = "delete from orcamento_produto where cod_orcamento = {$buff[0][cod_orcamento]}";
		$rr = pg_query($connect, $del);

		//Aqui faz o update da quantidade de funcionários.
		if( $numero_funcionarios <= 10 ){
			$qtd = $numero_funcionarios;
			$sql_prod = 891;
		}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
			$qtd = $numero_funcionarios;
			$sql_prod = 893;
		}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
			$qtd = $numero_funcionarios;
			$sql_prod = 895;
		}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
			$qtd = $numero_funcionarios;
			$sql_prod = 928;
		}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
			$qtd = $numero_funcionarios;
			$sql_prod = 929;
		}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
			$qtd = $numero_funcionarios;
			$sql_prod = 930;
		}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
			$qtd = $numero_funcionarios;
			$sql_prod = 931;
		}elseif( $numero_funcionarios > 350){
			$qtd = $numero_funcionarios;
			$sql_prod = 932;
		}

			//seleciona ASO da tebela produto.
			$query_orcamento = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_prod;

			$result_orcamento = pg_query($query_orcamento) or die ("Erro na Consulta!". pg_last_error($connect));

			//insere na tabela orcamento_produto.
			while($row_orcamento = pg_fetch_array($result_orcamento)) {
			$query_orc = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
						  values
						  ({$buff[0][cod_orcamento]}, {$row_orcamento[cod_prod]}, $qtd, {$row_orcamento[preco_prod]}, ".( $qtd * $row_orcamento[preco_prod])." )";

			$result_orc = pg_query($connect, $query_orc)
						  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
			}

		//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$sql_ppra = 423;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$sql_ppra = 966;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$sql_ppra = 967;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$sql_ppra = 968;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$sql_ppra = 969;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$sql_ppra = 970;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$sql_ppra = 971;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$sql_ppra = 990;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$sql_ppra = 991;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$sql_ppra = 992;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$sql_ppra = 993;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$sql_ppra = 994;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$sql_ppra = 995;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$sql_ppra = 996;
			}
				//seleciona PPRA da tebela produto.
				$query_orcamento2 = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_ppra;

				$result_orcamento2 = pg_query($query_orcamento2) or die ("Erro na Consulta orcamento2!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento2 = pg_fetch_array($result_orcamento2)) {
				$query_orc2 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento2[cod_prod]}, $qtd, {$row_orcamento2[preco_prod]}, ".( $qtd * $row_orcamento2[preco_prod])." )";

				$result_orc2 = pg_query($connect, $query_orc2)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = $numero_funcionarios;
				$qtd_prod = 933;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = $numero_funcionarios;
				$qtd_prod = 934;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = $numero_funcionarios;
				$qtd_prod = 935;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = $numero_funcionarios;
				$qtd_prod = 936;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = $numero_funcionarios;
				$qtd_prod = 937;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = $numero_funcionarios;
				$qtd_prod = 938;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 939;
			}elseif( $numero_funcionarios > 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 940;
			}

				//seleciona PPP da tebela produto.
				$query_orcamento3 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_prod;

				$result_orcamento3 = pg_query($query_orcamento3) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento3 = pg_fetch_array($result_orcamento3)) {
				$query_orc3 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento3[cod_prod]}, $qtd, {$row_orcamento3[preco_prod]}, ".( $qtd * $row_orcamento3[preco_prod])." )";

				$result_orc3 = pg_query($connect, $query_orc3)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_pcmso = 424;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_pcmso = 952;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_pcmso = 953;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_pcmso = 954;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_pcmso = 955;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_pcmso = 956;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_pcmso = 957;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_pcmso = 958;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_pcmso = 997;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_pcmso = 998;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_pcmso = 999;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_pcmso = 1000;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_pcmso = 1001;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_pcmso = 1002;
			}

				//seleciona PCMSO da tebela produto.
				$query_orcamento4 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_pcmso;

				$result_orcamento4 = pg_query($query_orcamento4) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento4 = pg_fetch_array($result_orcamento4)) {
				$query_orc4 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento4[cod_prod]}, $qtd, {$row_orcamento4[preco_prod]}, ".( $qtd * $row_orcamento4[preco_prod])." )";

				$result_orc4 = pg_query($connect, $query_orc4)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Aqui faz o update da quantidade de funcionários.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_apgre = 972;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_apgre = 973;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_apgre = 974;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_apgre = 975;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_apgre = 976;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_apgre = 977;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_apgre = 978;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_apgre = 979;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_apgre = 1003;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_apgre = 1004;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_apgre = 1005;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_apgre = 1006;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_apgre = 1007;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_apgre = 1008;
			}

				//seleciona APGRE da tebela produto.
				$query_orcamento5 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_apgre;

				$result_orcamento5 = pg_query($query_orcamento5) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento5 = pg_fetch_array($result_orcamento5)) {
				$query_orc5 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento5[cod_prod]}, $qtd, {$row_orcamento5[preco_prod]}, ".( $qtd * $row_orcamento5[preco_prod])." )";

				$result_orc5 = pg_query($connect, $query_orc5)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}

			//Condição para inserir curso de EPI
			if($numero_funcionarios != ""){
			$query_orcamento6 = "select cod_prod, preco_prod from produto where cod_prod = 431 ";

			$result_orcamento6 = pg_query($query_orcamento6) or die ("Erro na Consulta!". pg_last_error($connect));
			}
				while($row_orcamento6 = pg_fetch_array($result_orcamento6)){
				$query_orc6 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento6[cod_prod]}, $qtd, {$row_orcamento6[preco_prod]}, ".( $qtd * $row_orcamento6[preco_prod] )." )";

					$result_orc6 = pg_query($connect, $query_orc6)
						or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));

				}

			//AQUI FAZ O UPDATE NO GRAU DE RISCO
			if($grau_de_risco == 3){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 440;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 441;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 442;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 443;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 444;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 445;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 446;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 447;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1009;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1010;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1011;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1012;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1013;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1014;
				}
			}elseif($grau_de_risco == 4){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 448;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 804;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 805;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 890;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 892;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 894;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 896;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 942;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1015;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1016;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1017;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1018;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1019;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1020;
				}
			}

				if($grau_de_risco > 2){
				//seleciona LTCAT da tebela produto.
				$query_orcamento7 = "select cod_prod, preco_prod from produto where cod_prod = " .$ltcat;

				$result_orcamento7 = pg_query($query_orcamento7) or die ("Erro na Consulta!". pg_last_error($connect));

				//insere na tabela orcamento_produto.
				while($row_orcamento7 = pg_fetch_array($result_orcamento7)) {
				$query_orc7 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento7[cod_prod]}, $qtd_ltcat, {$row_orcamento7[preco_prod]}, ".( $qtd_ltcat * $row_orcamento7[preco_prod])." )";

				$result_orc7 = pg_query($connect, $query_orc7)
							  or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
				}
			//CONDIÇÃO PARA INSERIR MAPA DE RISCO A3 E A4
			if($grau_de_risco <= 2){
			$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
							 	 FROM produto
								 WHERE cod_prod in (963, 965) ";
			$result_orcamento8 = pg_query($connect, $query_orcamento8)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

				while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
				if($row_orcamento8[cod_prod] == 965){
				   $qtd = 2;
				}else{
				   $qtd = 1;
				}

				$query_orc8 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento8[cod_prod]}, $qtd, {$row_orcamento8[preco_prod]}, ".( $qtd * $row_orcamento8[preco_prod] )." )";

					$result_orc8 = pg_query($connect, $query_orc8)
						or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}
			//CONDIÇÃO PARA INSERIR MAPA DE RISCO A0 E A3
			elseif($grau_de_risco >= 3){
				$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
									FROM produto
									WHERE cod_prod in (422, 964) ";
				$result_orcamento8 = pg_query($connect, $query_orcamento8)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

				while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
				if($row_orcamento8[cod_prod] == 964){
					   $qtd = 2;
					}else{
					   $qtd = 1;
					}

					$query_orc8 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
								  values
								  ({$buff[0][cod_orcamento]}, {$row_orcamento8[cod_prod]}, $qtd, {$row_orcamento8[preco_prod]}, ".( $qtd * $row_orcamento8[preco_prod] )." )";

						$result_orc8 = pg_query($connect, $query_orc8)
							or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
					}
				}

			if($num_rep != ""){
				$num = explode("|", $num_rep);
				$t = $num[0] + $num[1];

				if($t == 1){
				$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod
									FROM produto
									WHERE cod_prod = 897 ";

				$result_orcamento9 = pg_query($connect, $query_orcamento9)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

					while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
						$query_orc9 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
									  values
									  ({$buff[0][cod_orcamento]}, {$row_orcamento9[cod_prod]}, ".$t.", {$row_orcamento9[preco_prod]}, ".( $t * $row_orcamento9[preco_prod] )." )";

						$result_orc9 = pg_query($connect, $query_orc9)
							or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
					}
				}elseif($t > 1){
				$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod
									FROM produto
									WHERE cod_prod = 840 ";

				$result_orcamento9 = pg_query($connect, $query_orcamento9)
					or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

					while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
						$query_orc9 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
									  values
									  ({$buff[0][cod_orcamento]}, {$row_orcamento9[cod_prod]}, ".$t.", {$row_orcamento9[preco_prod]}, ".( $t * $row_orcamento9[preco_prod] )." )";

						$result_orc9 = pg_query($connect, $query_orc9)
							or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
					}
				}
			}

			if($membros_brigada != "" && $membros_brigada != 0){
			$query_orcamento10 = "SELECT cod_prod, desc_resumida_prod, preco_prod
								  FROM produto
								  WHERE cod_prod = 982 ";
			$result_orcamento10 = pg_query($connect, $query_orcamento10)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

				while($row_orcamento10 = pg_fetch_array($result_orcamento10)){
				$query_orc10 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
								values
								({$buff[0][cod_orcamento]}, {$row_orcamento10[cod_prod]}, '$membros_brigada', {$row_orcamento10[preco_prod]}, ".( $membros_brigada * $row_orcamento10[preco_prod] )." )";

				$result_orc10 = pg_query($connect, $query_orc10)
					or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}

			if($t > 1){
			$query_orcamento11 = "SELECT desc_resumida_prod, preco_prod, cod_prod
								 FROM produto
								 WHERE cod_prod in (980, 981) ";

			$result_orcamento11 = pg_query($connect, $query_orcamento11)
				or die ("Erro na busca! ==> $query_busca".pg_last_error($connect));

			while($row_orcamento11 = pg_fetch_array($result_orcamento11)){
				if($row_orcamento11[cod_prod] == 980){
				   $qtd = 1;
				}else{
				   if($row_orcamento11[cod_prod] == 981){
				      $qtd = 12;
					}
				}

				$query_orc11 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
							  values
							  ({$buff[0][cod_orcamento]}, {$row_orcamento11[cod_prod]}, $qtd, {$row_orcamento11[preco_prod]}, ".( $qtd * $row_orcamento11[preco_prod] )." )";

				$result_orc11 = pg_query($connect, $query_orc11)
					or die ("Erro na tabela orcamento_produto! ". pg_last_error($connect));
				}
			}
		
					//CONDIÇÃO PARA INSERIR O PCMAT.
			$query_orcamento12 = "select * from cnae where cnae='{$cnae_digitado}' AND lower(descricao) like '%construção civil%' AND grau_risco > 2";
			
			$result_orcamento12 = pg_query($connect, $query_orcamento12);
			
			if(pg_num_rows($result_orcamento12) > 0){
				$query_orc12 = "select * from produto where desc_resumida_prod like '%Pcmat%'
								and $numero_funcionarios between g_min and g_max";
								
				$result_orc12 = pg_query($connect, $query_orc12);
				$ro2 = pg_fetch_array($result_orc12);
				
					$q_orc12 = "insert into orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
								values
								({$buff[0][cod_orcamento]}, $ro2[cod_prod], 1, $ro2[preco_prod], $ro2[preco_prod])";
								
					$res_orc12 = pg_query($connect, $q_orc12);
			}
		}

		echo '
        <script>
        alert("Cliente Alterado com Sucesso!");
        location.href="simulador_cadastro_cliente.php?cliente_id='.$cod_cliente.'&filial_id='.$filial_id.'&funcionario_id=23";
        </script>';
	}
}

if($valor=="novo" || $novo=="new"){

	$query_cliente_cod="select cliente_id from cliente_comercial order by cliente_id DESC LIMIT 1";
	$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod=pg_fetch_array($result_cliente_cod);

	$cliente_id_sel=$row_cliente_cod[cliente_id]+1;
	$filial_id_sel=1;
}
else if ($valor=="novofl"){
		$query_cliente_cod="select filial_id from cliente_comercial where cliente_id=".$cod_cliente." order by filial_id DESC LIMIT 1";
		$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
		$row_cliente_cod=pg_fetch_array($result_cliente_cod);

		$filial_id_sel=$row_cliente_cod[filial_id]+1;
		$cliente_id_sel=$cod_cliente;

}else if($valor=="gravar" || $cod_cliente!="" || $cliente_id!=""){
			if($filial_id!=""){
				$filtro_filial='and filial_id='.$filial_id.'';
			}else{
				$filtro_filial='and filial_id=1';
			}
		$query="select * from cliente_comercial where cliente_id=".$cliente_id.$cod_cliente." $filtro_filial";
		$result=pg_query($query) or die ("Erro na query $query".pg_last_error($connect));
		$row=pg_fetch_array($result);
}

function ddd($ddd, $numero)
{
	$verifica=explode(" - ", $numero);
	if ($verifica[0]!=""){
		if($ddd!="")
		{
			if($verifica[1]=="")
			{
				$novo_numero=$ddd." -"." ".$numero;
				return $novo_numero;
			}
			else
			{
				$novo_numero=$ddd." -"." ".$verifica[1];
				return $novo_numero;
			}
		}
		else
		{
			$novo_numero=$numero;
			return $novo_numero;
		}
	}
}

if($_GET[cliente_id]){
   $sql = "SELECT * FROM orcamento WHERE cod_cliente = {$_GET['cliente_id']}";
   $result = pg_query($sql);
   $orc = pg_fetch_all($result);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="cache-control"   content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content = "-1" />

<title>::Sistema SESMT - Cadastro de Cliente - Simulador::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}

.relatorio {
position: absolute;
border: 3px solid black;
background: #097b42;
color: #FFFFFF;
width: 300px;
height: 400px;
}

.fontebranca{
   color: #FFFFFF;
}

.textorelatorio{
   color: #FFFFFF;
   font-size: 12px;
}

.trans{
filter:alpha(opacity=95);
-moz-opacity:0.95;
-khtml-opacity: 0.95;
opacity: 0.95;
}
</style>

<script>
 function fone(obj){
    if(obj.value.length == 2){
        obj.value = "" + obj.value + " - ";
    }
    if(obj.value.length == 9){
        obj.value = obj.value + " ";
    }
 }
</script>

<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="ajax.js"></script>
<script language="javascript" src="screen.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" tracingsrc="img/Sistema sesmt 3  (2).png" tracingopacity="0">
<script>
   window.onresize = function(){resize('test')};
   <?PHP
   if($_GET['relatorio']){
      echo "window.onload = function(){resize('test'); maximize();};";
   }else{
      echo "window.onload = function(){resize('test'); minimize();};";
   }
   ?>
   var save = 0;
</script>

<!-- DIV COM CONTEUDO DINAMICO -->
<div id="test" class="relatorio trans">
   <!-- ### DIV - TITULO DA JANELA -->
   <div id=titulo name=titulo style="background: #000000;">
      <table width=100%>
      <tr>
         <td class=fontebranca><b>Relatório de Atendimento</b></td>
         <td align=right width=40 valign=center>
         <img src="images/minimizar.jpg" style="cursor:pointer;" onClick="minimize();">
         </td>
      </tr>
      </table>
   </div>
   
   <div id=loading name=loading  style="position: absolute; display: none;" class="trans">
      <table width=570 height=380>
         <tr>
            <td align=center bgcolor=black><font color=white><b>Atualizando...</b></font></td>
         </tr>
      </table>
   </div>
   
   <div id=add style="display: none;">
      <table width=100%>
      <tr>
      <td width=30 class=textorelatorio><b>Título</b></td>
      <td><input type=text name=messagetitle id=messagetitle></td>
      </tr>
      <tr>
      <td width=30 class=textorelatorio><b>Comentário</b></td>
      <td><textarea name=comentario id=comentario style='width:100%;' rows='6'></textarea></td>
      </tr>
      </table>
      <br><center>
      <input type=button onclick='save_comment(<?PHP echo $_GET['cliente_id'];?>);' value='Adicionar'> &nbsp;
      <input type=button onclick='back_to_list(<?PHP echo $_GET['cliente_id'];?>);' value='Voltar'>
   </div>
   
   <div id=edit style="display: none;">
      <table width=100%>
      <tr>
      <td width=30 class=textorelatorio><b>Título</b></td>
      <td><input type=text name=messagetitleedit id=messagetitleedit></td>
      </tr>
      <tr>
      <td width=30 class=textorelatorio><b>Comentário</b></td>
      <td><textarea name=comentarioedit id=comentarioedit style='width:100%;' rows='6'></textarea></td>
      </tr>
      </table>
      <br><center>
      <input type=hidden name=editid id=editit value="">
      <input type=button onclick='save_comment_edit(<?PHP echo $_GET['cliente_id'];?>);' value='Salvar'> &nbsp;
      <input type=button onclick='back_to_list(<?PHP echo $_GET['cliente_id'];?>);' value='Voltar'>
   </div>
   
   <!-- ### DIV - CONTEÚDO DA JANELA -->
   <div id=conteudo name=conteudo class="textorelatorio" align=justify>
   <?PHP
   if($_GET['cliente_id']){
      $sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$_GET['cliente_id']}'";
      $r = pg_query($sql);
      $data = pg_fetch_array($r);

      if(pg_num_rows($r)<=0){
   ?>
   Em contato com o Sr.(ª)
   <input type=text size=20 id=contato_direto name=contato_direto value="<?PHP echo $row['nome_contato_dir'];?>">
   foi nos relatado ter
   <select name=apreciado id=apreciado>
   <option value="1">apreciado</option>
   <option value="0">não apreciado</option>
   </select>
    nossos preços que a empresa dele foi enviado.<br>
    <select name=reacao id=reacao onChange="reacao(this);">
    <option value="0">Selecione</option>
    <option value="1">Contudo alegou não estar no período de renovação.</option>
    <option value="2">Aceitou uma visita para melhor esplanação.</option>
    <option value="3">Aceitou uma visita por nunca ter realizado os programas.</option>
    <option value="4">Aceitou uma visita por faltar informações por parte de quem os atende.</option>
    </select>
    <br>
    
    <div id=razao_social style="display: none;">
    Razão Social de empresa prestadora dos serviços:
    <input type=text name=empresa id=empresa size=23><br>
    Data da última realização dos serviços:
    <input type=text size=2 name=dia_u id=dia_u maxlength=2 onKeyUp="if(this.value.length>=2){document.getElementById('mes_u').focus();}">/<input type=text size=2 maxlength=2 name=mes_u id=mes_u onKeyUp="if(this.value.length>=2){document.getElementById('ano_u').focus();}">/<input type=text size=4 name=ano_u id=ano_u maxlength=4>
    </div>
    
    <div id=aceitouvisita  style="display: block;">
    Aceitou visita?
    <input type=radio name=visita id=visita1 value=1 onClick="visita(this.value);"> Sim
    <input type=radio name=visita id=visita0 value=0 onClick="visita(this.value);"> Não
    </div>
    
    <div id=visitasim  style="display: none;">
    <table width=100%>
    <tr>
    <td class=textorelatorio width=150>Dia da visita:</td>
    <td class=textorelatorio>
    <input type=text size=2 name=dia id=dia maxlength=2  onkeyup="if(this.value.length>=2){document.getElementById('mes').focus();}">/<input type=text size=2 name=mes id=mes maxlength=2  onkeyup="if(this.value.length>=2){document.getElementById('ano').focus();}">/<input type=text size=4 name=ano id=ano maxlength=4  onkeyup="if(this.value.length>=4){document.getElementById('hora').focus();}"></td>
    </tr><tr>
    <td class=textorelatorio>Horário:</td>
    <td class=textorelatorio>
    <input type=text size=2 name=hora id=hora maxlength=2  onkeyup="if(this.value.length>=2){document.getElementById('min').focus();}">:<input type=text size=2 name=min id=min maxlength=2  onkeyup="if(this.value.length>=2){document.getElementById('pessoa').focus();}"></td>
    </tr><tr>
    <td class=textorelatorio>Pessoa de contato:</td><td class=textorelatorio><input type=text name=pessoa id=pessoa></td>
    </tr><tr>
    <td class=textorelatorio>Telefone:</td><td class=textorelatorio><input type=text name=telefone id=telefone onKeyPress="fone(this);"></td>
    </tr><tr>
    <td class=textorelatorio>Ponto de referência:</td><td class=textorelatorio><input type=text name=referencia id=referencia size=50></td>
    </table>
    Necessidade de brinde:<br>
    <input type=checkbox name=brinde[1] id=brinde[1] value="Porta Caneta">Porta Caneta <input type=checkbox name=brinde[7] id=brinde[7] value="Caneta">Caneta
    <input type=checkbox name=brinde[2] id=brinde[2] value="Régua">Régua <input type=checkbox name=brinde[8] id=brinde[8] value="Calendário de Mesa">Calendário de Mesa
    <input type=checkbox name=brinde[3] id=brinde[3] value="Risque Rabisque">Risque Rabisque <input type=checkbox name=brinde[9] id=brinde[9] value="Chaveiro">Chaveiro
    <input type=checkbox name=brinde[4] id=brinde[4] value="Mouse Pad">Mouse Pad <input type=checkbox name=brinde[10] id=brinde[10] value="Relógio de Parede">Relógio de Parede
    <input type=checkbox name=brinde[5] id=brinde[5] value="Agenda">Agenda <input type=checkbox name=brinde[11] id=brinde[11] value="Garrafa de Vinho">Garrafa de Vinho
    <input type=checkbox name=brinde[6] id=brinde[6] value="Adesivo">Adesivo
    </div>
    <br>
    <center>
    <input type=button onClick="simulador_first(<?PHP echo $_GET['cliente_id'];?>);" value="Salvar"> &nbsp;
    <input type=button onClick="if(save == 1){back_to_list(<?PHP echo $_GET['cliente_id'];?>);}else{alert('Este relatório não foi salvo ainda. Salve-o antes de continuar!');}" value="Voltar">

   <?PHP
      }else{

         echo "<p>";
         echo date("d/m/Y", strtotime($data['data_criacao']))." - <b><span style='cursor:pointer;' onclick=\"simulador_first_edit({$_GET[cliente_id]});\">Relatório de primeiro contato.</span></b>";
         echo "<p>";
         echo "<center><input type=button onclick=\"add_comment({$_GET[cliente_id]});\" value='Adicionar comentário'></center>";
         echo "<p>";
         $sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = '{$_GET['cliente_id']}'";
         $result = pg_query($sql);
         $dados = pg_fetch_all($result);

         for($x=0;$x<pg_num_rows($result);$x++){
            echo date("d/m/Y", strtotime($dados[$x]['data_criacao']))." <input type=button onclick='delete_message({$dados[$x][id]});' value='Excluir'> - <b><span style='cursor:pointer;' onclick=\"edit_message({$dados[$x][id]});\">{$dados[$x][titulo]}</span></b>";
            echo "<br>";
         }
         //echo "<script language=\"javascript\">back_to_list({$_GET['cliente_id']});alert('list');</script>";
      }
      }
   ?>
   </div>
  <!-- ### DIV - CONTEÚDO DA JANELA -->

</div>

<input type=hidden name=temptext id=temptext>

<!-- ################################################################################## -->
<script>

function add_comment(id){
   //document.getElementById("conteudo").innerHTML = "<table width=100%><tr><td width=30 class=textorelatorio><b>Título</b></td><td><input type=text name=titulo id=titulo></td></tr><tr><td width=30 class=textorelatorio><b>Comentário</b></td><td><textarea name=comentario id=comentario style='width:100%;' rows='6'></textarea></td></tr></table><br><center><input type=button onclick='save_comment("+id+");' value='Adicionar'> &nbsp;    <input type=button onclick='back_to_list("+id+");' value='Voltar'>";
   document.getElementById("add").style.display = "block";
   document.getElementById("conteudo").style.display = "none";
}

function visita(value){
  if(value == 1){
     document.getElementById("visitasim").style.display = "block";
  }else{
     document.getElementById("visitasim").style.display = "none";
  }
}

function reacao(obj){
   //alert(obj.options[obj.selectedIndex].value);
   var opt = obj.options[obj.selectedIndex].value;
   
   if(opt == "0"){
      document.getElementById("razao_social").style.display = "none";
   }else if(opt == 1){
      document.getElementById("razao_social").style.display = "block";
   }else if(opt == 2){
      document.getElementById("razao_social").style.display = "block";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }else if(opt == 3){
      document.getElementById("razao_social").style.display = "none";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }else if(opt == 4){
      document.getElementById("razao_social").style.display = "block";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }
}

function minimize(){
//alert(navigator.appName);
   div = document.getElementById('test');
   div.style.height = "20px";
   div.style.width = "210px";
   document.getElementById("titulo").innerHTML = "<table width=100%><tr><td  class=fontebranca><b><font size=1>Relatório de Atendimento</b></td><td align=right width=40 valign=center><img src='images/restaurar.jpg' style='cursor:pointer;' onclick=maximize(); alt='Maximizar' title='Maximizar'></td></tr></table>";
   document.getElementById("conteudo").style.display = "none";
   document.getElementById("edit").style.display = "none";
   document.getElementById("add").style.display = "none";
   if(navigator.appName =='Microsoft Internet Explorer')
   {
      div.style.left = (getWidth() - 215)+"px";
   }else{
      div.style.left = (getWidth() - 235)+"px";
   }
}

function maximize(){
   div = document.getElementById('test');
   div.style.height = "400px";
   div.style.width = "570px";
   document.getElementById("titulo").innerHTML = "<table width=100%><tr><td  class=fontebranca align=center><b>Relatório de Atendimento</b></td><td align=right width=40 valign=center><img src='images/minimizar.jpg'  style='cursor:pointer;' onclick=minimize(); alt='Minimizar' title='Minimizar'></td></tr></table>";
   document.getElementById("conteudo").style.display = "block";
   if(navigator.appName == 'Microsoft Internet Explorer')
   {
      div.style.left = (getWidth() - 575)+"px";
   }else{
      div.style.left = (getWidth() - 595)+"px";
   }
}

// ------------- AJAX --------------

function simulador_first_edit(cliente_id){
   var url = "simulador_first.php?id="+cliente_id;
   url = url + "&editar=1";
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_first_reply;
   http.send(null);
}

function simulador_first(cliente_id){
   var brindes = "";
   for(var x=11; x > 0;x--){
      var it = document.getElementById('brinde['+x+']');
      //alert(it.checked);
      if(it.checked){
         brindes += it.value + "|";
      }
   }

   var apreciado = document.getElementById("apreciado");
   apreciado = apreciado.options[apreciado.selectedIndex].value;
   var reacao = document.getElementById("reacao");
   reacao = reacao.options[reacao.selectedIndex].value;
   var data_programa = document.getElementById("dia_u").value + "/" + document.getElementById("mes_u").value + "/" + document.getElementById("ano_u").value;

   var dia_visita = document.getElementById("dia").value + "/" + document.getElementById("mes").value + "/" + document.getElementById("ano").value;
   var horario_visita = document.getElementById("hora").value + ":" + document.getElementById("min").value;
   var pessoa_contato = document.getElementById("pessoa").value;
   var telefone = document.getElementById("telefone").value;

   if(document.getElementById("visita1").checked == false && document.getElementById("visita0").checked == false){
     alert('Selecione se visita foi ou não aceita!');
     return false;
   }else{
      if(document.getElementById("visita1").checked == false){
         var visita = document.getElementById("visita0").value;
         dia_visita = "00/00/0000";
         horario_visita = "00:00";
      }else{
         var visita = document.getElementById("visita1").value;
         if(document.getElementById("dia").value == "" || document.getElementById("mes").value == "" || document.getElementById("ano").value == ""){
            alert('Selecione a data de visita!');
            return false;
         }
         if(document.getElementById("hora").value == "" || document.getElementById("min").value == ""){
            alert('Selecione a hora da visita!');
            return false;
         }
         if(pessoa_contato == ""){
            alert('Informe o nome de contato para a visita!');
            return false;
         }
         if(telefone == ""){
            alert('Informe um telefone de contato para a visita!');
            return false;
         }
      }
   }

   var url = "simulador_first.php?id="+cliente_id;
   url = url + "&contato=" + document.getElementById("contato_direto").value;
   url = url + "&apreciado=" + apreciado;
   url = url + "&reacao=" + reacao;
   url = url + "&prestadora=" + document.getElementById("empresa").value;
   url = url + "&data_programa=" + data_programa;
   url = url + "&visita=" + visita;
   url = url + "&dia_visita=" + dia_visita;
   url = url + "&horario_visita=" + horario_visita;
   url = url + "&pessoa_contato=" + pessoa_contato;
   url = url + "&telefone=" + telefone;
   url = url + "&referencia=" + document.getElementById("referencia").value;
   url = url + "&brindes=" + brindes;

   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_first_reply;
   http.send(null);
}
function simulador_first_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = msg;
    //alert(msg);
    if(data[0] == "1"){
       alert('Dados atualizados!');
       save = 1;
    }else if(data[0] == "2"){
       document.getElementById("conteudo").innerHTML = data[1];
    }else{
       alert('Erro ao armazenar dados!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function back_to_list(cliente_id){
   var url = "simulador_first_list.php?id="+cliente_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_list_reply;
   http.send(null);
}
function simulador_list_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    document.getElementById("add").style.display = "none";
    document.getElementById("edit").style.display = "none";
    document.getElementById("conteudo").style.display = "block";
    document.getElementById("conteudo").innerHTML = data[0];
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}





function save_comment(cliente_id){
   var url = "save_comment.php?id="+cliente_id;
   url = url + "&titulo=" + document.getElementById("messagetitle").value;
   url = url + "&mensagem=" + document.getElementById("comentario").value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = save_comment_reply;
   http.send(null);
}
function save_comment_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = data[0];
    if(data[1] == 1){
       alert('Comentário adicionado!');
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       document.getElementById("messagetitle").value = "";
       document.getElementById("comentario").value = "";
       back_to_list(data[0]);
    }else{
       alert('Erro ao adicionar comentário!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}





function save_comment_edit(cliente_id){
   var url = "save_comment_edit.php?id="+cliente_id;
   url = url + "&titulo=" + document.getElementById("messagetitleedit").value;
   url = url + "&mensagem=" + document.getElementById("comentarioedit").value;
   url = url + "&mid=" + document.getElementById("editit").value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = save_edit_reply;
   http.send(null);
}
function save_edit_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = data[0];
    if(data[1] == 1){
       alert('Comentário alterado!');
       document.getElementById("edit").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       document.getElementById("messagetitleedit").value = "";
       document.getElementById("comentarioedit").value = "";
       back_to_list(data[0]);
       document.getElementById("editit").value = 0;
    }else{
       alert('Erro ao alterar comentário!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}



function edit_message(message_id){
   document.getElementById("editit").value = message_id;
   var url = "edit_message.php?id="+message_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = edit_message_reply;
   http.send(null);
}
function edit_message_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
       document.getElementById("edit").style.display = "block";
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "none";
       document.getElementById("messagetitleedit").value = data[0];
       document.getElementById("comentarioedit").value = data[1];
       document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}



function delete_message(message_id){
   document.getElementById("editit").value = message_id;
   var url = "delete_message.php?id="+message_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = delete_message_reply;
   http.send(null);
}
function delete_message_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
       document.getElementById("edit").style.display = "none";
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       //document.getElementById("messagetitleedit").value = data[0];
       //document.getElementById("comentarioedit").value = data[1];
       document.getElementById("loading").style.display = "none";
       back_to_list(data[0]);
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function check_meall(){
   if(document.getElementById('cnae_digitado').value == ''){
      alert('Preencha o campo CNAE!');
      document.getElementById('cnae_digitado').focus();
      return false;
   }
   if(document.getElementById('numero_funcionarios').value == ''){
      alert('Preencha o campo Número de Funcionários!');
      document.getElementById('numero_funcionarios').focus();
      return false;
   }
   if(document.getElementById('cnpj').value == ''){
      alert('Preencha o campo CNPJ!');
      document.getElementById('cnpj').focus();
      return false;
   }
   return true;
}
<!-- ################################################################################## -->
</script>

<form action="simulador_cadastro_cliente.php" name="cadastro" target="_self" id="cadastro" >
    <table width="90%" border="0" cellpadding="0" align="center">
	<tr>
      <td class="fontebranca22bold"><div align="center">Cadastro de Cliente - Simulador</div></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Cod. Cliente </td>
      <td class="fontebranca10">Cod Filial </td>
      <td class="fontebranca10">Razão Social </td>
	  <td class="fontebranca10">Data </td>
      <td class="fontebranca10">Status </td>
    </tr>
<?php

if ($var_novo=="novo")
{
		$query_max = "SELECT max(cliente_id) as cliente_id FROM cliente_comercial";

		$result_max = pg_query($query_max) or die
				("Erro na busca da tabela produto!" . pg_last_error($connect));

		$row_max = pg_fetch_array($result_max);

		$cod_cliente_tela = $row_max[cliente_id] + 1;

}
else if($cliente_id != "")
{
	$cod_cliente_tela = $cliente_id;
}

if(!empty($row[data])){
$d = $row[data];
}elseif(!empty($dat)){
$d = $dat;
}else{
$d = date("d/m/Y");
}
?>
    <tr>
      <td class="fontebranca10"><input name="cod_cliente" type="text" <?php echo($leitura);?> id="cod_cliente" size="5" value="<?php if (!empty($cod_cliente)){echo $cod_cliente;} else{echo $cod_cliente_tela;}?>" readonly="true"></td>
      <td class="fontebranca10"><input name="filial_id" type="text" <?php echo($leitura);?> id="filial_id" size="5" value="<?php if($row[filial_id]==""){coloca_zeros($filial_id_sel);}else{coloca_zeros($row[filial_id]);}?>"></td>
      <td class="fontebranca10"><input name="razao_social" <?php echo($leitura);?> type="text" id="razao_social" value="<?php if(!empty($razao_social)) {echo convertwords($razao_social);} else{ echo convertwords($row[razao_social]);}?>" size="70"></td>
      <td class="fontebranca10"><input type="text" size="9" name="dat" maxlength="10" OnKeyPress="formatar(this, '##/##/####')" value="<?php echo $d;?>"></td>
	  <td><select name="status" id="status"><option value="inativo" <?php if($row[status]=="inativo"){echo "selected";} ?>>inativo</option></select></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Nome fantasia </td>
      <td class="fontebranca10">CEP</td>
      <td class="fontebranca10">Endereço</td>
	  <td class="fontebranca10">Nº</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nome_fantasia" type="text" <?php echo($leitura);?> id="nome_fantasia" value="<?php if(!empty($nome_fantasia)) {echo convertwords($nome_fantasia);} else{echo convertwords($row[nome_fantasia]);}?>" size="40"></td>
      <td class="fontebranca10"><input name="cep" type="text" id="cep" value="<?php if(!empty($cep)) {echo $cep;} else{echo $row[cep];}?>" size="10" onChange="showDataSimulador();" <?php echo($leitura);?> onkeyup="if(this.value.length == 5){this.value = this.value + '-';}else if(this.value.length >= 9){document.getElementById('num_end').focus();}"></td>
      <td class="fontebranca10"><input name="endereco" type="text" id="endereco" value="<?php if(!empty($endereco)) {echo convertwords($endereco);} else{echo convertwords($row[endereco]);}?>" <?php echo($leitura);?> size="50"></td>
	  <td class="fontebranca10"><input name="num_end" type="text" id="num_end" value="<?php if(!empty($num_end)) {echo $num_end;} else{echo $row[num_end];}?>" <?php echo($leitura);?> size="2"></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Bairro</td>
      <td class="fontebranca10">Cidade</td>
      <td class="fontebranca10">Estado</td>
      <td class="fontebranca10">Telefone</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="bairro" type="text" id="bairro" value="<?php if(!empty($bairro)) {echo convertwords($bairro);} else{echo convertwords($row[bairro]);}?>" <?php echo($leitura);?> size="20"></td>
      <td class="fontebranca10"><input name="municipio" <?php echo($leitura);?> type="text" id="municipio" value="<?php if(!empty($municipio)){echo convertwords($municipio);} else {echo convertwords($row[municipio]);}?>" size="20"></td>
      <td class="fontebranca10"><input name="estado" <?php echo($leitura);?> type="text" id="estado" value="<?php if(!empty($estado)){echo convertwords($estado);} else {echo convertwords($row[estado]);}?>" size="20"></td>
      <td class="fontebranca10"><input name="telefone" type="text" id="telefone" <?php echo($leitura);?> value="<?php if(!empty($telefone)){ echo $telefone;} else{ echo ddd($row_ddd[ddd], $row[telefone]);}?>" size="12" onKeyUp="fone(this);"></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
		<td class="fontebranca10">FAX</td>
      <td class="fontebranca10">Celular</td>
      <td class="fontebranca10">Email</td>
      <td class="fontebranca10">CNPJ</td>
      <!--
      <td class="fontebranca10">CNPJ Contratante</td>
      -->
    </tr>
    <tr>
		<td class="fontebranca10"><input name="fax" <?php echo($leitura);?> type="text" id="fax" value="<?php if(!empty($fax)){echo $fax;} else{ echo ddd($row_ddd[ddd], $row[fax]);}?>" size="12" onKeyUp="fone(this)"></td>
      <td class="fontebranca10"><input name="celular" type="text" id="celular" <?php echo($leitura);?> value="<?php if(!empty($celular)){echo $celular;} else{ echo ddd($row_ddd[ddd], $row[celular]);}?>" size="12" onKeyUp="fone(this)"></td>
      <td class="fontebranca10"><input name="email" onDblClick="parent.location='mailto:<?php echo $row[email]?>';" type="text" id="email" value="<?php if(!empty($email)){echo $email;} else{ echo $row[email];}?>" size="15" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="cnpj" type="text" onBlur="check_cnpj(this);" id="cnpj" value="<?php if(!empty($cnpj)){echo $cnpj;} else{ echo $row[cnpj];}?>" size="17" <?php echo($leitura);?> maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');"></td>
    <!--
    <td class="fontebranca10"><input name="cnpj_contratante" type="text" id="cnpj_contratante" value="<?php if(!empty($cnpj_contratante)){ echo $cnpj_contratante;} else {echo $row[cnpj_contratante];}?>" size="17" <?php echo($leitura)?> maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');"></td>
    -->
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Insc. Estadual </td>
      <td class="fontebranca10">Insc. Municipal </td>
      <td class="fontebranca10">CNAE</td>
      <td class="fontebranca10">Grupo</td>
      <td class="fontebranca10">G. Risco </td>
      <td class="fontebranca10">Descri&ccedil;&atilde;o Atividade </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="insc_estadual" type="text" id="insc_estadual" value="<?php if(!empty($insc_estadual)){echo $insc_estadual;} else{ echo $row[insc_estadual];}?>" size="15" maxlength="10" OnKeyPress="formatar(this, '##.###.###');" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="insc_municipal" type="text" id="insc_municipal" value="<?php if(!empty($insc_municipal)){echo $insc_municipal;} else{ echo $row[insc_municipal];}?>" size="15" maxlength="10" OnKeyPress="formatar(this, '###.###-##');" <?php echo($leitura);?>></td>
      <td class="fontebranca10">
	  <?php
	if($row[cnae_id]!=""){

	  $query_cnae="select * from cnae where cnae_id=".$row[cnae_id]."";
	  $result_cnae=pg_query($query_cnae)or die("Erro na query $query_cnae".pg_last_error($connect));
	  $row_cnae=pg_fetch_array($result_cnae);
	  $novo_cnae=$row_cnae[cnae];
	}
		  ?>
        <input type="text" value="<?php echo $novo_cnae?>" name="cnae_digitado" id="cnae_digitado" size="8" <?php echo($leitura);?> onBlur="check_cnae(this);" maxlength="7" OnKeyPress="formatar(this, '##.##-#');"></td>
      <td class="fontebranca10"><?php
		if ($row[cnae_id]!=""){
	  $query_grupo="select grupo_cipa, grau_risco, descricao from cnae where cnae_id=".$row[cnae_id]."";
	  $result_grupo=pg_query($query_grupo)or die("Erro na consulta de grupo".pg_last_error($connect));
	  $row_grupo=pg_fetch_array($result_grupo);

	  	  ?>
&nbsp;
<input name="grupo_cipa" id="grupo_cipa" type="text" value="<?php echo $row_grupo[grupo_cipa]?>" size="4" <?php echo($leitura);?>>
<?php
		}else{
		echo' <input name="grupo_cipa" id="grupo_cipa"  type="text" value="" size="4">';
		 }
?>

</select></td>
      <td class="fontebranca10"><input name="grau_de_risco" id="grau_de_risco" type="text" value="<?php echo $row_grupo[grau_risco]?>" size="5" <?php echo($leitura);?> ></td>
      <td class="fontebranca10"><input name="desc_atividade" id="desc_atividade" type="text" value="<?php echo convertwords($row_grupo[descricao])?>" size="30" <?php echo($leitura);?> ></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Classe - Brigada </td>
      <td class="fontebranca10">Membros Part. da Brigada</td>
      <td class="fontebranca10">Nº Func.</td>
      <td class="fontebranca10">Cipa (Func./Empresa)</td>
    </tr>
    <tr>
      <td class="fontebranca10">
	  <select name="classe" id="classe"  onchange="check_brigada(this);">

		  <?php
		  $query="select * from brigadistas order by classe";
		  $result=pg_query($query)or die("Erro na query".pg_last_error($connect));
          while($row_classe=pg_fetch_array($result)){
		  ?>
		<option value="<?php echo $row_classe[classe]?>" <?php if($row_classe[classe]==$row[classe]){echo "selected";}?>><?php echo $row_classe[classe]?></option>
		<?php
		}
		?>
        </select></td>
      <td class="fontebranca10"><input name="membros_brigada" type="text" id="membros_brigada" value="<?php echo $row[membros_brigada]; ?>" size="20" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="numero_funcionarios" type="text" id="numero_funcionarios" onBlur="check_brigada(this);" value="<?php echo $row[numero_funcionarios]?>" size="5" <?php echo($leitura);?>/></td>
      <td class="fontebranca10"><input name="num_rep" type="text" id="num_rep" value="<?php echo $row[num_rep]; ?>" size="15" style="text-align:center" <?php echo($leitura);?>></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Tel Cont. Dir. </td>
      <td class="fontebranca10">Nome Cont. Dir.</td>
      <td class="fontebranca10">Cargo Cont. Dir </td>
      <td class="fontebranca10">Email Cont. Dir </td>
      <td class="fontebranca10">Skype Cont. Dir </td>
      <td class="fontebranca10">MSN Cont. Dir </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="tel_contato_dir" type="text" id="tel_contato_dir" value="<?php if(!empty($tel_contato_dir)){echo $tel_contato_dir;} else{ echo ddd($row_ddd[ddd], $row[tel_contato_dir]);}?>" size="10" onKeyUp="fone(this);" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="nome_contato_dir" type="text" id="nome_contato_dir" value="<?php if($_GET[var_novo]){echo "Sr.(ª) ";};if(!empty($nome_contato_dir)){echo $nome_contato_dir;}else{ echo convertwords($row[nome_contato_dir]);}?>" size="15" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="cargo_contato_dir" type="text" id="cargo_contato_dir" value="<?php if(!empty($cargo_contato_dir)){echo $cargo_contato_dir;} else{ echo convertwords($row[cargo_contato_dir]);}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="email_contato_dir" onDblClick="parent.location='mailto:<?php echo $row[email_contato_dir]?>';" type="text" id="email_contato_dir" value="<?php if(!empty($email_contato_dir)){echo $email_contato_dir;} else{ echo $row[email_contato_dir];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="skype_contato_dir" type="text" id="skype_contato_dir" value="<?php if(!empty($skype_contato_dir)){echo $skype_contato_dir;} else{ echo $row[skype_contato_dir];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="msn_contato_dir" type="text" id="msn_contato_dir" value="<?php if(!empty($msn_contato_dir)){echo $msn_contato_dir;} else{ echo $row[msn_contato_dir];}?>" size="10" <?php echo($leitura);?>></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Nextel Cont. Dir</td>
      <td class="fontebranca10">ID. Nextel</td>
      <td class="fontebranca10">Escrit&oacute;rio Cont. </td>
      <td class="fontebranca10">Tel Contador </td>
      <td class="fontebranca10">Email Contador </td>
      <td class="fontebranca10">Skype Contador </td>
      <td class="fontebranca10">Nome Contador </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nextel_contato_dir" type="text" id="nextel_contato_dir" value="<?php if(!empty($nextel_contato_dir)){echo $nextel_contato_dir;} else{ echo ddd($row_ddd[ddd], $row[nextel_contato_dir]);}?>" size="10" onKeyUp="fone(this);" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="nextel_id_contato_dir" type="text" id="id_contato_dir" value="<?php if(!empty($nextel_id_contato_dir)){echo $nextel_id_contato_dir;} else{ echo $row[nextel_id_contato_dir];}?>" size="5" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="escritorio_contador" type="text" id="escritorio_contador" value="<?php if(!empty($escritorio_contador)){echo $escritorio_contador;} else{ echo convertwords($row[escritorio_contador]);}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="tel_contador" type="text" id="tel_contador" value="<?php if(!empty($tel_contador)){echo $tel_contador;} else{ echo $row[tel_contador];}?>" size="10" onKeyUp="fone(this);" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="email_contador" onDblClick="parent.location='mailto:<?php echo $row[email_contador]?>';" type="text" id="email_contador" value="<?php if(!empty($email_contador)){echo $email_contador;} else{ echo $row[email_contador];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="skype_contador" type="text" id="skype_contador" value="<?php if(!empty($skype_contador)){echo $skype_contador;} else{ echo $row[skype_contador];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="nome_contador" type="text" id="nome_contador" value="<?php if($_GET[var_novo]){echo "Sr.(ª) ";};if(!empty($nome_contador)){echo $nome_contador;} else{ echo convertwords($row[nome_contador]);}?>" <?php echo($leitura);?> size="8"></td>
    </tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Nome Cont Ind. </td>
      <td class="fontebranca10">Email Cont. Ind. </td>
      <td class="fontebranca10">Cargo Cont. Ind </td>
      <td class="fontebranca10"> Tel Cont. Ind </td>
      <td class="fontebranca10">Skype Cont. Ind </td>
      <td class="fontebranca10"> Vendedor </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nome_cont_ind" type="text" id="nome_cont_ind" value="<?php if($_GET[var_novo]){echo "Sr.(ª) ";};if(!empty($nome_cont_ind)){echo $nome_cont_ind;} else{ echo convertwords($row[nome_cont_ind]);}?>" <?php echo($leitura);?> size="10">
      <input name="valor" type="hidden" id="valor"></td>
      <td class="fontebranca10"><input name="email_cont_ind" onDblClick="parent.location='mailto:<?php echo $row[email_cont_ind]?>';" type="text" id="email_cont_ind" value="<?php if(!empty($email_cont_ind)){echo $email_cont_ind;} else{ echo $row[email_cont_ind];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="cargo_cont_ind" type="text" id="cargo_cont_ind" value="<?php if(!empty($cargo_cont_ind)){echo $cargo_cont_ind;} else{ echo convertwords($row[cargo_cont_ind]);}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="tel_cont_ind" type="text" id="tel_cont_ind" value="<?php if(!empty($tel_cont_ind)){echo $tel_cont_ind;} else{ echo $row[tel_cont_ind];}?>" size="10" onKeyUp="fone(this);" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><input name="skype_cont_ind" type="text" id="skype_cont_ind" value="<?php if(!empty($skype_cont_ind)){echo $skype_cont_ind;} else{ echo $row[skype_cont_ind];}?>" size="10" <?php echo($leitura);?>></td>
      <td class="fontebranca10"><select name="funcionario_id">
    <?php
	// aqui fazemos uma consulta para buscar os funcionários
	$query_usuario = "select funcionario_id, nome from funcionario where cargo_id=1 ";

	$result_usuario = pg_query($connect, $query_usuario)
		or die ("Erro na query: $query_usuario ==> " . pg_last_error($connect) );

    while($row_usuario = pg_fetch_array($result_usuario))
	{
		//if ( $_SESSION[usuario_id] == $row_usuario[funcionario_id] )
		if ( $row[funcionario_id] == $row_usuario[funcionario_id] )
		{
			echo "<option value=\"$row_usuario[funcionario_id]\" selected> $row_usuario[nome]</option>";
		}else{
		   if($_SESSION['usuario_id'] == $row_usuario[funcionario_id]){
			   echo "<option value=\"$row_usuario[funcionario_id]\" selected> $row_usuario[nome]</option>";
		   }else{
		       echo "<option value=\"$row_usuario[funcionario_id]\"> $row_usuario[nome]</option>";
		   }
		}
	}
	?>
      </select></td>
    </tr>
    </table>

    <table width="90%" border="0" cellpadding="0" align="center">
    <tr>
       <td width=100% align=left class="fontebranca10">
       Relatório de Atendimento
       </td>
    </tr>

    <tr>
       <td width=100%>
          <textarea name=relatorio rows=5 id=relatorio style="width:100%;"><?PHP echo $row[relatorio_de_atendimento];?></textarea>
       </td>
    </tr>
    </table>

	<table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	    <?
        if ($grupo=="administrador"){?>
		<td width=100 align=center><input type="submit" name="migrar" value="Migrar" style="width:100px; height:30px;"></td>
		<td width=100 align=center><input type=button value=Excluir style="width:100px; height:30px;" onClick="javascript:if(confirm('Tem certeza que deseja excluir este cadastro?')){ location.href='simulador_cadastro_cliente.php?act=del&cod_cliente=<?PHP echo $_GET['cliente_id'];?>&cod_filial=<?PHP echo $_GET['filial_id'];?>'};"></td>
	    <?

        } else { echo "&nbsp;";}

        if($_GET[cliente_id]){
           echo "<td width=100 align=center>
           <input type=button value='Orçamento' style=\"width:100px; height:30px;\" onclick=\"location.href='orcamento.php?cod_orcamento={$orc[0]['cod_orcamento']}&cliente_id={$_GET['cliente_id']}&filial_id={$_GET['filial_id']}' \"></td>";
        }

        ?>
	    

		<td width=100 align=center><a href="http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp" target="_blank"><img src="img/receitafederal.jpg" width="63" height="37" border="0"></a></td>
        <!--
        <td width=100 align=center><a href="http://www.sesmt-rio.com/cnae.pdf" target="_blank"><img src="img/cnae.jpg" width="63" height="37" border="0"></a></td>
        -->
		<td width=100 align=center><input name="procura" type="image" id="procura" src="img/localizar.gif" onClick="window.open('find_simulador.php', 'procura', 'status , scrollbars=yes ,width=300, height=350');return false;"></td>
		<td width=100 align=center><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onClick="if(check_meall()){valore('gravar');}else{return false;}"> </td>
		<td width=100 align=center><a href="simulador_cadastro_cliente.php?var_novo=novo"><img src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0"></a></td>
		<!--
        <td width=100 align=center><a href="simulador_cadastro_cliente.php?act=duplicar&cliente_id=139&filial_id=0"><img src="img/cadastro_cliente_verde_r22_c9.png" width="53" height="37" border="0"></a></td>
        -->
		<td width=100 align=center><a href="simulador_listagem.php"><img src="img/cadastro_cliente_verde_r21_c18.gif" alt="" name="cadastro_cliente_verde_r21_c18" width="41" height="58"  border="0" id="cadastro_cliente_verde_r21_c18" /></a></td>
	</tr>
	</table>
</form>
</body>
</html>
