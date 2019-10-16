<?PHP

if($_GET['cod_cliente'] == 'new'){
    $total = "''";
}else{
$funativ = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] and cod_status = 1";
$resultativ = pg_query($funativ);
$numativ = pg_num_rows($resultativ);
}


if($_GET['cod_cliente'] == 'new'){
    $total = "''";
}else{
	$sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] AND cod_status = 1";
		$result = pg_query($sql);
		$total = pg_num_rows($result);
}



if($_GET['cod_cliente'] != 'new'){
	
$numcgrtsql = "SELECT cod_cgrt FROM cgrt_info WHERE cod_cliente = $_GET[cod_cliente] ORDER BY ano DESC, data_criacao ASC";

$numcgrtquery = pg_query($numcgrtsql);

$numcgrt = pg_fetch_array($numcgrtquery);

$numcgrtnum = pg_num_rows($numcgrtquery);

$cod_cgrt = $numcgrt[cod_cgrt];


$pegarcomplementosql = "SELECT complemento FROM reg_pessoa_juridica WHERE cod_cliente = $_GET[cod_cliente] AND complemento != ''";
$pegarcomplementoquery = pg_query($pegarcomplementosql);
$pegarcomplemento = pg_fetch_array($pegarcomplementoquery);
$pegarcomplementonum = pg_num_rows($pegarcomplementoquery);

$enderecocliente = $buffer['endereco'];


	
$complemento = $pegarcomplemento['complemento'];
	
	




}












//if($total >= 1){
//	$mostra_func = $total;
//}else{
	$mostra_func = $buffer[numero_funcionarios];
//	}



if($numcgrtnum >= 1){
	
	$funccgrtsql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun 
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func 
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
$funccgrtquery = pg_query($funccgrtsql);
$funccgrt = pg_num_rows($funccgrtquery);

if($funccgrt >= 1){
	
	$mostra_func = $funccgrt;
	
}else{
	$mostra_func = $buffer[numero_funcionarios];
	}
}


/**************************************************************************************************/
// --> DADOS DA EMPRESA
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da empresa:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post id='frmcadcliente' name='frmcadcliente' action='?dir={$_GET[dir]}&p={$_GET[p]}&cod_cliente={$_GET[cod_cliente]}' onsubmit=\"return cad_cliente_check_fields(this);\">";
    echo "<input type=hidden name='cod_cliente' value='{$buffer[cliente_id]}'>";
    echo "<input type=hidden name='ano_contrato' value='{$buffer[ano_contrato]}'>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Vendedor:</td>";
    if($_SESSION[grupo] == 'administrador'){
        $sql = "SELECT * FROM funcionario WHERE associada_id = 1 AND status = 1";
        $rfg = pg_query($sql);
        $bfg = pg_fetch_all($rfg);
        
        echo "<td align=left class=text width='220'>";
        echo "<select class='inputText' name=vendedor id=vendedor>";
            for($x = 0; $x < pg_num_rows($rfg);$x++){
                   if($_GET[cod_cliente] == 'new' && $bfg[$x][funcionario_id] == 18){
                       echo "<option value='{$bfg[$x][funcionario_id]}' selected>{$bfg[$x][nome]}</option>";
                   }else{
                       if($ff[funcionario_id] == $bfg[$x][funcionario_id]){
                           echo "<option value='{$bfg[$x][funcionario_id]}' selected>{$bfg[$x][nome]}</option>";
                       }else{
                           echo "<option value='{$bfg[$x][funcionario_id]}'>{$bfg[$x][nome]}</option>";
                       }
                   }
            }
        echo "</select>";
        echo "</td>";
    }else{
        if($_GET[cod_cliente] == 'new'){
        //echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=vendedor id=vendedor value='$ff[nome]'></td>";
            if($_SESSION[grupo] == 'vendedor'){
                 $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$_SESSION[usuario_id]}";
                 $rfg = pg_query($sql);
                 $bfg = pg_fetch_all($rfg);
            }
            echo "<td align=left class=text width='220'>";
            echo "<select class='inputText' name=vendedor id=vendedor disabled>";
            echo "<option value='{$bfg[0][funcionario_id]}'>{$bfg[0][nome]}</option>";
            echo "</select>";
            echo "</td>";
        }else{
            echo "<td align=left class=text width='220'>";
            echo "<select class='inputText' name=vendedor id=vendedor disabled>";
            echo "<option value='$ff[funcionario_id]'>$ff[nome]</option>";
            echo "</select>";
            echo "</td>";
        }
    }
    echo "<td align=left class=text width='100'>Data:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=9 maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" name=dat id=dat value='$d'></td>";
    echo "</tr>";

	echo "<tr>";
    echo "<td align=left class=text width='100'><span id='txtRazao'>Razão Social:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value=\"".addslashes($buffer[razao_social])."\"></td>";
    echo "<td align=left class=text width='100'>Nome Fantasia:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=nome_fantasia id=nome_fantasia value='$buffer[nome_fantasia]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'><span id='txtCnpj'>CNPJ:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" "; if(!is_numeric($_GET[cod_cliente])) echo " onBlur=\"check_cnpj_cliente(this);\" "; echo ">&nbsp;<span id='verify_cnpj' class=''></span></td>";
    echo "<td align=left class=text width='100'>CNAE:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=cnae id=cnae value='$buf[cnae]'  maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\">&nbsp;<span id='verify_cnae'></span></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Insc. Estadual:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_estadual id=insc_estadual value='$buffer[insc_estadual]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###');\"></td>";
    echo "<td align=left class=text width='100'>Insc. Municipal:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_municipal id=insc_municipal value='$buffer[insc_municipal]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '###.###-##');\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Grupo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grupo_cipa id=grupo_cipa value='$buf[grupo_cipa]'></td>";
    echo "<td align=left class=text width='100'>Grau Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grau_risco id=grau_risco value='$buf[grau_risco]' maxlength='2' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Atividade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=descricao_atividade id=descricao_atividade value='$buffer[descricao_atividade]'></td>";
    echo "<td align=left class=text width='100'>Nº Funcionário:</td>";
	
	
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=numero_funcionarios id=numero_funcionarios value='$mostra_func' onkeydown=\"return only_number(event);\" onBlur=\"check_brigada(this);\">&nbsp;<span id='verify_brigada'></span></td>";
	
	
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Memb. Brigada:</td>";
	
	
	
	
	
	$quantidade = $mostra_func;
	$classe     = $buffer[classe];
    $cnae       = $buf[cnae];


    if(!empty($cnae)){
    	$query_cnae="select cnae_id from cnae where cnae='$cnae'";
    	$result_cnae=pg_query($query_cnae);
		
    	$qtd_cnae=pg_num_rows($result_cnae);
    	if($qtd_cnae==1){
    		$row_cnae=pg_fetch_array($result_cnae);
    		$cnae_id=$row_cnae[cnae_id];
    	}
    }


    
	if($classe != ""){
    	$query_clac="select * from brigadistas where classe = '$classe'";
    	$result_calc=pg_query($query_clac);
    	$row_calc=pg_fetch_array($result_calc);

    	 $menor=$row_calc[ate_10];
    	 $maior=$row_calc[mais_10];

    		if($quantidade<=10)
    		{
    			$calculo=$quantidade*($menor/100);
    		}
    		else
    		{
    			$calculo=10*($menor/100)+($quantidade-10)*($maior/100);
    		}

    	if($membros=round($calculo, 0) <= 0)
    	{
    		$membros="0";
    	}
    	else
    	{
    		$membros=round($calculo, 0);
    	}
    }else{
	
		$membros="0";	
		
	}
	
	
	

    if($cnae_id != ""){
    	 $query_cnae="select * from cnae where cnae_id='".$cnae_id."'";
    	 $result_cnae=pg_query($query_cnae);
    	 $row_cnae=pg_fetch_array($result_cnae);

    	 $query_cont="select * from cipa where grupo='".$row_cnae[grupo_cipa]."'";
    	 $result_cont=pg_query($query_cont);
    	while($row_cont=pg_fetch_array($result_cont)){
     		$numero=explode(" a ", $row_cont[numero_empregados]);
    		if($quantidade>$numero[0] && $numero[1]>$quantidade || $quantidade==$numero[0] || $quantidade==$numero[1]){
    			if($row_cont[numero_membros_cipa]>="19"){
    				$efetivo_empregador=1;
    				$suplente_empregador=0;
    				$efetivo_empregado=0;
    				$suplente_empregado=0;
    			}else{
    				$efetivo_empregador=$row_cont[numero_membros_cipa];
    				$suplente_empregador=$row_cont[suplente];
    				$efetivo_empregado=$row_cont[numero_membros_cipa];
    				$suplente_empregado=$row_cont[suplente];
    			}

    		  }
     		}
    $total1 = $efetivo_empregador+$suplente_empregador;
    $total2 = $efetivo_empregado+$suplente_empregado;
	$tmp = $total1."|".$total2;
	
    }else{

    $tmp = "1|0";
	}

	
	
	
	
	
	
	
	
	
	
	
	
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=membros_brigada id=membros_brigada value='$membros' onkeydown=\"return only_number(event);\"></td>";
    echo "<td align=left class=text width='100'>CIPA:</td>";
	
	
	
    echo "<td align=left class=text width='220'><input style=\"text-align:center;\"  type='text' class='inputTextobr' size=5 name=membros_cipa id=membros_cipa value='$tmp'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Classe Brigada:</td>";
    echo "<td align=left class=text width='220'>";
        echo "<select name=classe id=classe class='inputTextobr' onchange=\"check_brigada(this);\">";
            for($x=0;$x<pg_num_rows($res_brig);$x++){
                echo "<option value='{$classes_brigada[$x][classe]}' ";
                print $buffer[classe] == $classes_brigada[$x][classe] ? " selected " : "";
                echo " >{$classes_brigada[$x][classe]}</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "<td align=left class=text width='100'>CNPJ Contratante:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=cnpj_contratante id=cnpj_contratante value='$buffer[cnpj_contratante]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" ></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> DADOS DE LOCALIZAÇÃO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados de localização e contato:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>CEP:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=10 name=cep id=cep value='$buffer[cep]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
    echo "<td align=left class=text width='100'>Estado:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=estado id=estado value='$buffer[estado]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Endereço:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco value='$enderecocliente'></td>";
    echo "<td align=left class=text width='100'>Número:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=num_end id=num_end value='$buffer[num_end]' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Bairro:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=bairro id=bairro value='$buffer[bairro]'></td>";
    echo "<td align=left class=text width='100'>Município:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=municipio id=municipio value='$buffer[municipio]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Complemento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=complemento id=complemento value='$complemento'></td>";
    echo "<td align=left class=text width='100'>Fax:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=fax id=fax value='$buffer[fax]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
    echo "</tr>";

    echo "<tr>";
     echo "<td align=left class=text width='100'>Telefone:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=telefone id=telefone value='$buffer[telefone]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>E-Mail:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[email]';\" class='inputTextobr' size=35 name=email id=email value='$buffer[email]'></td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Celular:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=celular id=celular value='$buffer[celular]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
	echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Atendimento:</td>";
    echo "<td align=left class=text colspan=3><textarea name=relatorio id=relatorio style=\"width:100%;\">$buffer[relatorio_de_atendimento]</textarea></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> CONTATO DIRETO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados de contato direto:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Contato Direto:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nome_contato_dir id=nome_contato_dir value='$buffer[nome_contato_dir]'></td>";
    echo "<td align=left class=text width='100'>Cargo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=cargo_contato_dir id=cargo_contato_dir value='$buffer[cargo_contato_dir]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Telefone:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=tel_contato_dir id=tel_contato_dir value='$buffer[tel_contato_dir]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>E-Mail:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[email_contato_dir]';\" class='inputText' size=35 name=email_contato_dir id=email_contato_dir value='$buffer[email_contato_dir]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Skype:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=skype_contato_dir id=skype_contato_dir value='$buffer[skype_contato_dir]'></td>";
    echo "<td align=left class=text width='100'>MSN:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[msn_contato_dir]';\" class='inputText' size=35 name=msn_cont_dir id=msn_contato_dir value='$buffer[msn_contato_dir]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nextel:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_cont_dir id=nextel_contato_dir value='$buffer[nextel_contato_dir]' maxlength='15' OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>Nextel ID:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_id_contato_dir id=nextel_id_contato_dir value='$buffer[nextel_id_contato_dir]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> CONTATO INDIRETO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados de contato indireto:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Cont. Indireto:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=nome_cont_ind id=nome_cont_ind value='$buffer[nome_cont_ind]'></td>";
    echo "<td align=left class=text width='100'>Cargo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=cargo_cont_ind id=cargo_cont_ind value='$buffer[cargo_cont_ind]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Telefone:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=tel_cont_ind id=tel_cont_ind value='$buffer[tel_cont_ind]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>E-Mail:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[email_cont_ind]';\" class='inputText' size=35 name=email_cont_ind id=email_cont_ind value='$buffer[email_cont_ind]'></td>";
    echo "</tr>";
/*
    echo "<tr>";
    echo "<td align=left class=text width='100'>Skype:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=skype_cont_ind id=skype_cont_ind value='$buffer[skype_cont_ind]'></td>";
    echo "<td align=left class=text width='100'>MSN:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[msn_cont_ind]';\" class='inputText' size=35 name=msn_cont_ind id=msn_cont_ind value='$buffer[msn_cont_ind]'></td>";
    echo "</tr>";
*/
    echo "<tr>";
    echo "<td align=left class=text width='100'>Nextel:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_cont_ind id=nextel_cont_ind value='$buffer[nextel_cont_ind]' maxlength='15' OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>Nextel ID:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_id_cont_ind id=nextel_id_cont_ind value='$buffer[nextel_id_cont_ind]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> CONTATO ESCRITÓRIO CONTABILIDADE
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados de contabilidade:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Escritório:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=escritorio_contador id=escritorio_contador value='$buffer[escritorio_contador]'></td>";
    echo "<td align=left class=text width='100'>Contador:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nome_contador id=nome_contador value='$buffer[nome_contador]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Telefone:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=tel_contador id=tel_contador value='$buffer[tel_contador]' maxlength='15' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>E-Mail:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[email_contador]';\" class='inputText' size=35 name=email_contador id=email_contador value='$buffer[email_contador]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Skype:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=skype_contador id=skype_contador value='$buffer[skype_contador]'></td>";
    echo "<td align=left class=text width='100'>MSN:</td>";
    echo "<td align=left class=text width='220'><input type='text' ondblClick=\"parent.location='mailto: $buffer[msn_contador]';\" class='inputText' size=35 name=msn_contador id=msn_contador value='$buffer[msn_contador]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nextel:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_contador id=nextel_contador value='$buffer[nextel_contador]' maxlength='15' OnKeyPress=\"fone(this);\"></td>";
    echo "<td align=left class=text width='100'>Nextel ID:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=nextel_id_contador id=nextel_id_contador value='$buffer[nextel_id_contador]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<P>";

echo "&nbsp;<span class='inputTextobr'>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta coloração são de preenchimento obrigatório!</i></font>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
            //echo "<input type='submit' class='btn' name='btnSave' value='TESTE' onclick=\"return showAlert('Mensagem de teste!');\" onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";

if($regresult){
    echo "<script>location.href='?dir={$_GET[dir]}&p={$_GET[p]}&cod_cliente={$data[cliente_id]}&register_done=1';</script>";
    //redirectme("?dir={$_GET[dir]}&p={$_GET[p]}&cod_cliente={$data[cliente_id]}&register_done=1");
}

if($_GET[register_done]){
    showMessage('<p align=justify>Cadastro realizado com sucesso.</p>');
}
?>
