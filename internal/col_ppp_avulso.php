<div class='novidades_text'>
<p align=justify>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">



<?PHP


/*************************************************************************************************************/
// --> POST FUNC DATA - SAVE/ADD
/*************************************************************************************************************/
if($_POST && $_POST[btnSaveFunc]){
	
	
	
	$dadospegarsql = "SELECT rpj.razao_social, rpj.cnpj, rpj.cnae, rpj.responsavel, cl.grau_de_risco FROM reg_pessoa_juridica rpj, cliente cl WHERE cl.cliente_id = rpj.cod_cliente AND rpj.cod_cliente = ".(int)($_SESSION[cod_cliente]);
            $dadospegarquery = pg_query($dadospegarsql);
            $dadospegar = pg_fetch_array($dadospegarquery);
			
			$razao_social = $dadospegar['razao_social'];
			$razao_social = ucwords(strtolower($razao_social));
			$cnpj = $dadospegar['cnpj'];
			$cnae = $dadospegar['cnae'];
			$nome_contato_dir = $dadospegar['responsavel'];
			$nome_contato_dir = ucwords(strtolower($nome_contato_dir));
			$grau_de_risco = $dadospegar['grau_de_risco'];
			
			$cod_cliente = $_SESSION[cod_cliente];
			$nome_func = $_POST['nome'];
			$nome_func = ucwords(strtolower($nome_func));
			$nit_empresa = $_POST['nit_empresa'];
			$nit = $_POST['nit'];
			$sexo = $_POST['sexo'];
			$ctps = $_POST['ctps'];
			$ctps_serie = $_POST['serie'];
			$ctps_uf = $_POST['ctps_uf'];
			$setor = $_POST['setor'];
			$funcao = $_POST['funcao'];
			$cbo = $_POST['cbo'];
			$dsc_funcao = $_POST['dinamica_funcao'];
			$pdh = $_POST['pdh'];
			$revezamento = $_POST['revezamento'];
			$num_cat = $_POST['num_cat'];
			$num_cat2 = $_POST['num_cat2'];
			
			
			
			$data_lancamento = date('Y-m-d');
			$data_nascimento = date('Y-m-d', strtotime($_POST['data_nascimento']));
			$data_admissao = date('Y-m-d', strtotime($_POST['data_admissao']));
			$data_desligamento = date('Y-m-d', strtotime($_POST['data_desligamento']));
			$data_registro_cat = date('Y-m-d', strtotime($_POST['data_registro_cat']));
			$data_registro_cat2 = date('Y-m-d', strtotime($_POST['data_registro_cat2']));
			
	
	
	
	$pegarnofunsql = "SELECT nome_funcao FROM funcao WHERE cod_funcao = ".$funcao."";
	$pegarnofunquery = pg_query($pegarnofunsql);
	$pegarnofun = pg_fetch_array($pegarnofunquery);
	
	$nomefuncao = $pegarnofun['nome_funcao'];
	
	
	
	
	
	
	
	
	
    $_GET[funid] = (int)(anti_injection($_GET[funid]));
    // -- EDIT FUNC DATA -------------------------------------------------------------------------------------
   
       if($_GET[updfun]){
		
		
		
		$updpppsql = "UPDATE ppp_avulso SET
        nome_func = '".$nome_func."', nit_empresa = '".$nit_empresa."', data_nascimento = '".$data_nascimento."', nit = '".$nit."', sexo = '".$sexo."', ctps = '".$ctps."', ctps_serie = '".$ctps_serie."', ctps_uf = '".$ctps_uf."', data_admissao = '".$data_admissao."', data_desligamento = '".$data_desligamento."', setor = '".$setor."', cargo = '".$funcao."', funcao = '".$funcao."', cbo = '".$cbo."', dsc_funcao = '".$dsc_funcao."', data_registro_cat = '".$data_registro_cat."', data_registro_cat2 = '".$data_registro_cat2."', num_cat = '".$num_cat."', num_cat2 = '".$num_cat2."', pdh = '".$pdh."', revezamento = '".$revezamento."' WHERE cod_func = $_GET[funid] AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
		
		$updppp = pg_query($updpppsql);
	   
		
		
    }else{
    // -- ADD FUNC DATA --------------------------------------------------------------------------------------
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND num_ctps_func = '".anti_injection($_POST[ctps])."' AND serie_ctps_func = '".anti_injection($_POST[serie])."'";
        if(pg_num_rows(pg_query($sql)) <= 0){
            $sql = "SELECT MAX(cod_func) as cod_func FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]);
            $max = pg_fetch_array(pg_query($sql));
            $max = $max[cod_func] + 1;
			
			
			$numpppsql = "SELECT MAX(id_ppp) as id_ppp FROM ppp_avulso";
            $numpppmax = pg_fetch_array(pg_query($numpppsql));
            $numpppmax = $numpppmax[id_ppp] + 1;
			
			
			
			
			
            $funcsql = "INSERT INTO funcionarios
            (cod_func, nome_func, num_ctps_func, serie_ctps_func, cbo, cod_funcao, cod_setor,
            dinamica_funcao, cod_cliente,
           cod_status)
            VALUES
            ('$max',
			'$nome_func',
            '$ctps',
            '$ctps_serie',
			'$cbo',
            '$funcao',
            '0',
            '$dsc_funcao',
            '$cod_cliente', 1)";
			
			
			
			
			
			$pppinsertsql = "INSERT INTO ppp_avulso (razao_social, nome_func, data_lancamento, cnpj, cnae, nome_contato_dir, nit_empresa, grau_de_risco, data_nascimento, nit, sexo, ctps, ctps_serie, ctps_uf, data_admissao, data_desligamento, setor, cargo, funcao, cbo, dsc_funcao, id_ppp, cod_cliente, cod_func)
						VALUES ('$razao_social','$nome_func','$data_lancamento','$cnpj','$cnae','$nome_contato_dir','$nit_empresa','$grau_de_risco','$data_nascimento','$nit','$sexo','$ctps','$ctps_serie','$ctps_uf','$data_admissao','$data_desligamento','$setor','$nomefuncao','$nomefuncao','$cbo','$dsc_funcao', '$numpppmax', '$_SESSION[cod_cliente]', '$_GET[funid]')";
			
			
			
            if(pg_query($funcsql)){
				
				
				 if(pg_query($pppinsertsql)){
					 
					 
					$msg = "Olá Luciana, foi solicitado um encaminhamento para PPP avulso através do site, entre no ambiente <b>'Gerar PPP Avulso'</b> no sistema e procure pelo <b>código: $numpppmax </b>para completar as informações necessárias e enviar o encaminhamento para o cliente.";
					 
					 
					 
					 
					$headers = "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\n";
					$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> \n";
					 
					 
					if(mail("suporte@ti-seg.com;medicotrab@sesmt-rio.com", "Agendamento PPP AVULSO", $msg, $headers)){
    					
	  					$m = 1;
	  
	  
   					}else{
      					$m = 0;
   					}
				
				
				
				 }
			
				$ctpss = $_POST[ctps];
			
                echo "<br />Dados do colaborador cadastrados com sucesso!, <a href=\"?do=ppp_avulso\">Clique aqui para voltar. </a>";
           		   
		    }else{
			$setorcliente;
                echo "Houve um erro ao tentar cadastrar os dados deste colaborador. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
            }
        }else{
            echo "Já existe um funcionário cadastrado com o mesmo CTPS informado.";
        }
    }
}
/*************************************************************************************************************/
// --> GET FUNC DATA
/*************************************************************************************************************/
if($_GET[funid] && is_numeric($_GET[funid])){
    $_GET[funid] = (int)(anti_injection($_GET[funid]));
	
	if($_GET[complppp]){
    $sql = "SELECT * FROM funcionarios WHERE cod_func = $_GET[funid] AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
    $res = pg_query($sql);
    $dadoppp = pg_fetch_array($res);
	}else{
	$dadopppsql = "SELECT * FROM ppp_avulso WHERE cod_func = $_GET[funid] AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
	$dadopppquery = pg_query($dadopppsql);
	$dadoppp = pg_fetch_array($dadopppquery);
	}
    echo "Preencha todos os campos obrigatórios e clique no botão salvar dados para <b>atualizar os dados</b> deste colaborador.";
}else{
    echo "Para realizar um <b>novo cadastro</b> de um colaborador, preencha todos os campos obrigatórios abaixo. Lembrando, que não é possível o cadastro se a CTPS já estiver cadastrada.";
}
?>
</div>

<?php
if($_GET[funid]){
	
	echo '<form enctype="multipart/form-data" method="post" action="?do=col_ppp_avulso&funid='.$_GET[funid].'&updfun=true">';
	
}else{

echo '<form enctype="multipart/form-data" method="post" name="frmAddFunc" onsubmit="return check_func_form(this);">';

}
?>

<img src='images/sub-dados-pessoais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
    <td width=180>Nome:</td>
    
    <?php
	if($_GET[funid]){
		?>
        
        <td><input type=text class='required' name='nome' id='nome' value='<?=$dadoppp[nome_func]?>' size='40' onkeyup="change_classname('nome', 'required'); disabled"></td>
        
		<?php
		
	}else{
	?>
    
    
    
    
    <td><input type=text class='required' name='nome' id='nome' value='<?=$dadoppp[nome_func]?>' size='40' onkeyup="change_classname('nome', 'required');"></td>
    
    
    <?php
	}
	?>
    
    
    
</tr>


<tr>
    <td width=180>Data de Nascimento:</td>
    <td><input type=text class='required' name='data_nascimento' id='data_nascimento' value='<?=$dadoppp[data_nascimento]?>' onkeydown="return only_number(event);" OnKeyPress="formatar(this, '##/##/####')" maxlength='10'  size='10' required></td>
</tr>


<tr>
    <td width=180>Sexo:</td>
    <td><input type=text class='required' name='sexo' id='sexo' value='<?=$dadoppp[sexo]?>' size='10' maxlength="1" placeholder="M / F" required></td>
</tr>

<tr>
    <td width=180>Data da Admissão:</td>
    <td><input type=text class='required' name='data_admissao' id='data_admissao' value='<?=$dadoppp[data_admissao]?>' onkeydown="return only_number(event);" OnKeyPress="formatar(this, '##/##/####')" maxlength='10' size='10' required></td>
</tr>


<tr>
    <td width=180>Data do Desligamento:</td>
    <td><input type=text class='required' name='data_desligamento' id='data_desligamento' value='<?=$dadoppp[data_desligamento]?>' onkeydown="return only_number(event);" OnKeyPress="formatar(this, '##/##/####')" maxlength='10' size='10' required></td>
</tr>


</table>

<p><BR>

<img src='images/sub-dados-profissionais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>

<tr>
<td width=180>Função:</td>
<td>
<?PHP
	
	$fu_cl = "SELECT * FROM funcao ORDER BY nome_funcao";
	$fu_cli = pg_query($fu_cl);
	$fun_cli = pg_fetch_all($fu_cli);
	
    $sql = "SELECT cod_funcao, nome_funcao, dsc_funcao FROM funcao ORDER BY nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);
    
	echo "<select class='required' name='funcao' id='funcao' style=\"width: 308px;\" onchange=\"get_dinamica_funcao(this.value);\" onkeyup=\"change_classname('funcao', 'required');\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($fu_cli);$y++){
		if($fun_cli[$y][cod_funcao] != $fun_cli[$y-1][cod_funcao]){
			echo "<option value='{$fun_cli[$y][cod_funcao]}'";
			if($fun[cod_funcao] == $fun_cli[$y][cod_funcao]){
			echo " selected ";
			$dinamica = $fun_cli[$y][dsc_funcao];
			}else{
			 "";
			 }
			 echo ">".substr($fun_cli[$y][nome_funcao], 0, 71)."</option>";
			 echo ">{$funcoes[$y][nome_funcao]}</option>";
		}
    }
    echo "</select>&nbsp;<span id='loading_funcao'></span>";

?>
</td>
</tr>
<tr>
<td width=180>Dinâmica da função:</td>
<td><textarea id='dinamica_funcao' name='dinamica_funcao' class='required' rows=4 style="width: 300px;" readonly><?=$dinamica?></textarea></td>
</tr>


<tr>
    <td width=180>Setor:</td>
    <td><input type=text class='required' name='setor' id='setor' value='<?=$dadoppp[setor]?>' size='10' required></td>
</tr>

<tr>
    <td width=180>Revezamento:</td>
    <td><input type=text class='required' name='revezamento' id='revezamento' value='<?=$dadoppp[revezamento]?>' size='10' placeholder="5x2" required></td>
</tr>


<tr>
<td width=180>CBO:</td>
<td><input onpaste="return false;" type=text id='cbo' name='cbo' value='<?=$dadoppp[cbo]?>' size=10 maxlength="9" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('cbo', 'required');"></td>
</tr>


<tr>
    <td width=180>PIS:</td>
    <td><input type=text class='required' name='nit' id='nit' value='<?=$dadoppp[nit]?>' size='10' required></td>
</tr>


<tr>
<td width=180>CTPS:</td>
<td><input type=text id='ctps' name='ctps' value='<?=$dadoppp[ctps]?>' size=10 maxlength="10" onkeydown="return only_number(event);" class='required'></td>
</tr>
<tr>
<td width=180>Série:</td>
<td><input type=text id='serie' name='serie' value='<?=$dadoppp[ctps_serie]?>' size=10 maxlength="10" onkeydown="return only_number(event);" class='required'></td>
</tr>

<tr>
<td width=180>UF:</td>
<td><input type=text class='required' name='ctps_uf' id='ctps_uf' value='<?=$dadoppp[ctps_uf]?>' size='10'  maxlength="2" placeholder="RJ" required></td>
</tr>

<tr>
    <td width=180>PIS Representante:</td>
    <td><input type=text class='required' name='nit_empresa' id='nit_empresa' value='<?=$dadoppp[nit_empresa]?>' size='10' required></td>
</tr>

<tr>
    <td width=180>BR/PDH:</td>
    <td><input type=text class='required' name='pdh' id='pdh' value='<?=$dadoppp[pdh]?>' size='10' placeholder="BR,PDH ou N/A" required></td>
</tr>

<tr>
    <td width=180>Data do Registro do CAT:</td>
    <td><input type=text  name='data_registro_cat' id='data_registro_cat' value='<?=$dadoppp[data_registro_cat]?>' onkeydown="return only_number(event);" OnKeyPress="formatar(this, '##/##/####')" maxlength='10' size='10'></td>
</tr>    
    
<tr>    
    <td width=180>Número do CAT:</td>
    <td><input type=text name='num_cat' id='num_cat' value='<?=$dadoppp[num_cat]?>' size='10'></td>
    
</tr>


<tr>
    <td width=180>Data do Registro do Segundo CAT:</td>
    <td><input type=text  name='data_registro_cat2' id='data_registro_cat2' value='<?=$dadoppp[data_registro_cat2]?>' onkeydown="return only_number(event);" OnKeyPress="formatar(this, '##/##/####')" maxlength='10' size='10'</td>
</tr>    
 
<tr>  
    <td width=180>Número do Segundo CAT:</td>
    <td><input type=text name='num_cat2' id='num_cat2' value='<?=$dadoppp[num_cat2]?>' size='10'></td>
    
</tr>




</table>
<BR><p>
<center><input type=submit name=btnSaveFunc id=btnSaveFunc value='Salvar dados'></center>
</form>

