<?PHP

$data = date("Y/m/d");

if ($_POST[razao_social_clinica] != ""){
	$query_max = "SELECT max(cod_clinica) as cod_clinica FROM clinicas";
	$result_max = pg_query($connect, $query_max);
	$row_max = pg_fetch_array($result_max);
	
	$cod_clinica = $row_max[cod_clinica] + 1;
	
	$query_insert = "INSERT INTO clinicas 
		(cod_clinica, razao_social_clinica, nome_fantasia_clinica, inscricao_clinica, cnpj_clinica, endereco_clinica, num_end, bairro_clinica, tel_clinica, fax_clinica, email_clinica, cep_clinica, referencia_clinica, cidade, estado, contato_clinica, id_nextel_contato, tel_contato, nextel_contato, email_contato, cod_func_criacao, data_criacao, cod_func_alt, data_ultima_alt, cargo_responsavel, cargo_intermediario, ramal_responsavel, ramal_intermediario, fax_responsavel, fax_intermediario, contato_intermediario, email_intermediario, tel_intermediario, nextel_intermediario, id_nextel_intermediario, complemento)
		VALUES 
		($cod_clinica, '".addslashes($_POST[razao_social_clinica])."', '".addslashes($nome_fantasia_clinica)."', '$inscricao_clinica', 
			'$cnpj_clinica', '".addslashes($endereco)."', '$num_end', '".addslashes($bairro)."', '$tel_clinica', '$fax_clinica',
			'$email_clinica', '$cep', '".addslashes($referencia_clinica)."', '$municipio', '$estado', '".addslashes($contato_clinica)."',
			'$id_nextel_contato', '$tel_contato', '$nextel_contato', '$email_contato', '$usuario_id', '$data', '$usuario_id', '$data',
			'".addslashes($cargo_responsavel)."', '".addslashes($cargo_intermediario)."', '$ramal_responsavel', '$ramal_intermediario',
			'$fax_responsavel', '$fax_intermediario', '".addslashes($contato_intermediario)."', '$email_intermediario', '$tel_intermediario', 
			'$nextel_intermediario', '$id_nextel_intermediario', '$complemento')";
					 
	$result_insert = pg_query($connect, $query_insert);
	
	if($result_insert){
		redirectme("?dir=cad_clinicas&p=index&a=1");
	}else{
		redirectme("?dir=cad_clinicas&p=index&a=2");
	}
}	

/***************************************************************************************************/
// --> FUNCTION PARA COLOCAR ZEROS NOS CAMPOS NUMERICOS
/***************************************************************************************************/
function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

/***************************************************************************************************/
// --> BUSCA O RESPONS?VEL DO CADASTRO
/***************************************************************************************************/
$query_log = "SELECT c.cod_func_criacao, u.usuario_id, f.funcionario_id, f.nome
			  FROM usuario u, funcionario f, clinicas c, log l
			  WHERE c.cod_func_criacao = u.usuario_id
			  AND f.funcionario_id = u.funcionario_id
			  AND u.usuario_id = l.usuario_id
			  AND l.usuario_id = $usuario_id";
$result_log = pg_query($connect, $query_log) or die
	("Erro na Busca: ==> $query_log".pg_last_error($connect));
$row_log = pg_fetch_array($result_log);

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
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
        echo "<td align=center class='text roundborderselected'><b>Cadastro de Cl?nicas</b></td>";
        echo "</tr>";
        echo "</table>";
	    
		/**************************************************************************************************/
		// --> DADOS DA CL?NICA
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<form name=form1 method=post onsubmit=\"return fuc_fdp();\" >";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados da cl?nica:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Raz?o Social:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='razao_social_clinica' type='text' name='razao_social_clinica' size='35' >
			  <input name=cod_clinica type=hidden id=cod_clinica value=$row_max[cod_clinica]></td>";
		echo "<td align=left class='text' width=100><b>Nome Fantasia:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='nome_fantasia_clinica' type='text' name='nome_fantasia_clinica' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='cep' type='text' name='cep' size='10' maxlength='9' OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
		echo "<td align=left class='text' width=100><b>Endere?o:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='endereco' type='text' name='endereco' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Complemento:</b></td>";
        echo "<td align=left class='text' width=220><input id='complemento' type='text' name='complemento' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>N?mero:</b></td>";
        echo "<td align=left width=220><input id='num_end' type='text' name='num_end' size='5' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Bairro:</b></td>";
        echo "<td align=left class='text' width=220><input id='bairro' type='text' name='bairro' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Munic?pio:</b></td>";
        echo "<td align=left width=220><input id='municipio' type='text' name='municipio' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left class='text' width=220><input id='estado' type='text' name='estado' size='18' ></td>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='tel_clinica' type='text' name='tel_clinica' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_clinica' type='text' name='fax_clinica' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
		echo "<td align=left class='text' width=100><b>E-mail Corporativo:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='email_clinica' type='text' name='email_clinica' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CNPJ:</b></td>";
        echo "<td align=left width=200><input class=inputTextobr id='cnpj_clinica' type='text' name='cnpj_clinica' size='18' maxlength='18' OnKeyPress=\"formatar(this, '##.###.###/####-##');\" ></td>";
		echo "<td align=left class='text' width=100><b>Insc. Est./Mun.:</b></td>";
        echo "<td align=left width=220><input id='inscricao_clinica' type='text' name='inscricao_clinica' size='18' ></td>";
		echo "</tr>";
		
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Ponto de Refer?ncia:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='referencia_clinica' type='text' name='referencia_clinica' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Respons?vel Pelo Cadastro:</b></td>";
        echo "<td align=left width=220><input type='text' value='{$row_log[nome]}' size='35' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS DO RESPONS?VEL
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados do respons?vel:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Respons?vel:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='contato_clinica' type='text' name='contato_clinica' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='cargo_responsavel' type='text' name='cargo_responsavel' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email_contato' type='text' name='email_contato' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Telefone Respons?vel:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='tel_contato' type='text' name='tel_contato' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Ramal:</b></td>";
        echo "<td align=left width=220><input id='ramal_responsavel' type='text' name='ramal_responsavel' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_responsavel' type='text' name='fax_responsavel' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nextel:</b></td>";
        echo "<td align=left width=220><input id='nextel_contato' type='text' name='nextel_contato' size='18' maxlength=14 onkeypress=\"fone(this);\" ></td>";
        echo "<td align=left class='text' width=100><b>ID:</b></td>";
        echo "<td align=left class='text' width=220><input id='id_nextel_contato' type='text' name='id_nextel_contato' size='18' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS DO RESPONS?VEL INTERMEDI?RIO
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados do contato intermedi?rio:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Contato Intermedi?rio:</b></td>";
        echo "<td align=left width=220><input id='contato_intermediario' type='text' name='contato_intermediario' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><input id='cargo_intermediario' type='text' name='cargo_intermediario' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email_intermediario' type='text' name='email_intermediario' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left class='text' width=220><input id='tel_intermediario' type='text' name='tel_intermediario' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Ramal:</b></td>";
        echo "<td align=left width=220><input id='ramal_intermediario' type='text' name='ramal_intermediario' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_intermediario' type='text' name='fax_intermediario' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nextel:</b></td>";
        echo "<td align=left width=220><input id='nextel_intermediario' type='text' name='nextel_intermediario' size='18' maxlength=14 onkeypress=\"fone(this);\" ></td>";
        echo "<td align=left class='text' width=100><b>ID:</b></td>";
        echo "<td align=left class='text' width=220><input id='id_nextel_intermediario' type='text' name='id_nextel_intermediario' size='18' ></td>";
        echo "</tr>";
		
        echo "</table>";
		
		echo "<p>";
		
		echo "&nbsp;<span class=inputTextobr>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta colora??o s?o de preenchimento obrigat?rio!</i></font><p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar? todos os dados selecionados at? o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados ser?o salvos, tem certeza que deseja continuar?','');\"
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</tr>";
		echo "</table>";

		echo "</form>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>