<?PHP
$data = date("Y/m/d");

if($_POST[razao_social_clinica] != ""){	
	$query_clinica = "UPDATE clinicas SET 
					 razao_social_clinica 	 = '$razao_social_clinica',
					 nome_fantasia_clinica 	 = '$nome_fantasia_clinica',
					 inscricao_clinica 		 = '$inscricao_clinica',
					 cnpj_clinica 			 = '$cnpj_clinica',
					 endereco_clinica 		 = '$endereco',
					 num_end 				 = '$num_end',
					 complemento 			 = '$complemento',
					 bairro_clinica 		 = '$bairro',
					 cidade 				 = '$municipio',
					 estado 				 = '$estado',
					 tel_clinica 			 = '$tel_clinica',
					 fax_clinica 			 = '$fax_clinica',
					 email_clinica 			 = '$email_clinica',
					 cep_clinica 			 = '$cep',
					 referencia_clinica 	 = '$referencia_clinica',
					 contato_clinica 		 = '$contato_clinica',
					 id_nextel_contato 		 = '$id_nextel_contato',
					 tel_contato 			 = '$tel_contato',
					 nextel_contato 		 = '$nextel_contato', 
					 email_contato 			 = '$email_contato',
					 cod_func_alt 			 = $usuario_id,
					 data_ultima_alt 		 = '$data',
					 cargo_responsavel 		 = '$cargo_responsavel',
					 cargo_intermediario 	 = '$cargo_intermediario',
					 ramal_responsavel 		 = '$ramal_responsavel',
					 ramal_intermediario 	 = '$ramal_intermediario',
					 fax_responsavel 		 = '$fax_responsavel',
					 fax_intermediario 		 = '$fax_intermediario',
					 contato_intermediario 	 = '$contato_intermediario',
					 email_intermediario 	 = '$email_intermediario',
					 tel_intermediario 		 = '$tel_intermediario',
					 nextel_intermediario 	 = '$nextel_intermediario',
					 id_nextel_intermediario = '$id_nextel_intermediario',
					 segunda 				 = '$segunda',
					 terca 					 = '$terca',
					 quarta 				 = '$quarta',
					 quinta 				 = '$quinta',
					 sexta 					 = '$sexta',
					 motivo                  = '$motivo'
					 WHERE cod_clinica 		 = ".$_GET[id];
	if(pg_query($connect, $query_clinica)){
		showmessage('Clínica Alterada com Sucesso!');
	}
}

/***************************************************************************************************/
// -> FAZ A COMPARAÇÃO PARA BUSCAR OS DADOS NECESSARIOS PARA ILUSTRAR A TELA
/***************************************************************************************************/
$query_cli = "SELECT *
			 FROM clinicas
			 WHERE cod_clinica = ".$_GET[id];

$result_cli = pg_query($connect, $query_cli);
$row_cli = pg_fetch_array($result_cli);

/***************************************************************************************************/
// -> FAZ A BUSCA DO RESPONSÁVEL PELO CADASTRO
/***************************************************************************************************/
$query_log = "SELECT c.cod_func_alt, u.usuario_id, f.funcionario_id, f.nome, c.cod_clinica
			  FROM usuario u, funcionario f, clinicas c
			  WHERE c.cod_func_alt = u.usuario_id
			  AND f.funcionario_id = u.funcionario_id
			  AND c.cod_clinica = ".$_GET[id];
$result_log = pg_query($connect, $query_log);
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
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
					echo "<td class='text' align=center></td>";
                echo "</tr>";
                echo "</table>";
				echo "<p>";

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
        echo "<td align=center class='text roundborderselected'><b>Cadastro de Clínicas</b></td>";
        echo "</tr>";
        echo "</table>";
	    
		/**************************************************************************************************/
		// --> DADOS DA CLÍNICA
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<form name=form1 method=post onsubmit=\"return fuc_fdp();\" >";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados da clínica:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Razão Social:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='razao_social_clinica' type='text' name='razao_social_clinica' value='".addslashes($row_cli[razao_social_clinica])."' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Nome Fantasia:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='nome_fantasia_clinica' type='text' name='nome_fantasia_clinica' value='".addslashes($row_cli[nome_fantasia_clinica])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='cep' type='text' name='cep' value='$row_cli[cep_clinica]' size='18' maxlength='9' OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
		echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='endereco' type='text' name='endereco' value='".addslashes($row_cli[endereco_clinica])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Complemento:</b></td>";
        echo "<td align=left class='text' width=220><input id='complemento' type='text' name='complemento' value='".addslashes($row_cli[complemento])."' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Número:</b></td>";
        echo "<td align=left width=220><input id='num_end' type='text' name='num_end' value='{$row_cli[num_end]}' size='5' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Bairro:</b></td>";
        echo "<td align=left class='text' width=220><input id='bairro' type='text' name='bairro' value='".addslashes($row_cli[bairro_clinica])."' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Município:</b></td>";
        echo "<td align=left width=220><input id='municipio' type='text' name='municipio' value='".addslashes($row_cli[cidade])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left class='text' width=220><input id='estado' type='text' name='estado' value='".addslashes($row_cli[estado])."' size='18' ></td>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='tel_clinica' type='text' name='tel_clinica' value='$row_cli[tel_clinica]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_clinica' type='text' name='fax_clinica' value='$row_cli[fax_clinica]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
		echo "<td align=left class='text' width=100><b>E-mail Corporativo:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='email_clinica' type='text' name='email_clinica' value='".addslashes($row_cli[email_clinica])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CNPJ:</b></td>";
        echo "<td align=left width=200><input class=inputTextobr id='cnpj_clinica' type='text' name='cnpj_clinica' value='$row_cli[cnpj_clinica]' size='18' maxlength='18' OnKeyPress=\"formatar(this, '##.###.###/####-##');\" ></td>";
		echo "<td align=left class='text' width=100><b>Insc. Est./Mun.:</b></td>";
        echo "<td align=left width=220><input id='inscricao_clinica' type='text' name='inscricao_clinica' value='$row_cli[inscricao_cnpj]' size='18' ></td>";
		echo "</tr>";
		
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Ponto de Referência:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='referencia_clinica' type='text' name='referencia_clinica' value='".addslashes($row_cli[referencia_clinica])."' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Responsável Pelo Cadastro:</b></td>";
        echo "<td align=left width=220><input type='text' value='{$row_log[nome]}' size='35' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS DO RESPONSÁVEL
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados do responsável:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Responsável:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='contato_clinica' type='text' name='contato_clinica' value='".addslashes($row_cli[contato_clinica])."' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='cargo_responsavel' type='text' name='cargo_responsavel' value='".addslashes($row_cli[cargo_responsavel])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email_contato' type='text' name='email_contato' value='".addslashes($row_cli[email_contato])."' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Telefone Responsável:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='tel_contato' type='text' name='tel_contato' value='$row_cli[tel_contato]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Ramal:</b></td>";
        echo "<td align=left width=220><input id='ramal_responsavel' type='text' name='ramal_responsavel' value='$row_cli[ramal_responsavel]' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_responsavel' type='text' name='fax_responsavel' value='$row_cli[fax_responsavel]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nextel:</b></td>";
        echo "<td align=left width=220><input id='nextel_contato' type='text' name='nextel_contato' value='$row_cli[nextel_contato]' size='18' maxlength=14 onkeypress=\"fone(this);\" ></td>";
        echo "<td align=left class='text' width=100><b>ID:</b></td>";
        echo "<td align=left class='text' width=220><input id='id_nextel_contato' type='text' name='id_nextel_contato' value='$row_cli[id_nextel_contato]' size='18' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS DO RESPONSÁVEL INTERMEDIÁRIO
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados do contato intermediário:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Contato Intermediário:</b></td>";
        echo "<td align=left width=220><input id='contato_intermediario' type='text' name='contato_intermediario' value='".addslashes($row_cli[contato_intermediario])."' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><input id='cargo_intermediario' type='text' name='cargo_intermediario' value='".addslashes($row_cli[cargo_intermediario])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email_intermediario' type='text' name='email_intermediario' value='".addslashes($row_cli[email_intermediario])."' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left class='text' width=220><input id='tel_intermediario' type='text' name='tel_intermediario' value='$row_cli[tel_intermediario]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Ramal:</b></td>";
        echo "<td align=left width=220><input id='ramal_intermediario' type='text' name='ramal_intermediario' value='$row_cli[ramal_intermediario]' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>FAX:</b></td>";
        echo "<td align=left class='text' width=220><input id='fax_intermediario' type='text' name='fax_intermediario' value='$row_cli[fax_intermediario]' size='18' maxlength='14' OnKeyPress=\"fone(this);\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nextel:</b></td>";
        echo "<td align=left width=220><input id='nextel_intermediario' type='text' name='nextel_intermediario' value='$row_cli[nextel_intermediario]' size='18' maxlength=14 onkeypress=\"fone(this);\" ></td>";
        echo "<td align=left class='text' width=100><b>ID:</b></td>";
        echo "<td align=left class='text' width=220><input id='id_nextel_intermediario' type='text' name='id_nextel_intermediario' value='$row_cli[id_nextel_intermediario]' size='18' ></td>";
        echo "</tr>";
		
        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS DO ATENDIMENTO DA CLÍNICA // SOMENTE ADM PODE VER ESSA ÁREA
		/**************************************************************************************************/
		if($_SESSION["grupo"] == "administrador"){
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td class='text'>";
			echo "<b>Selecione os dias que a clínica não poderá atender:</b>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
	        echo "<tr>";
	        echo "<td align=left width=150><input type='checkbox' name='segunda' value='segunda' ".($row_cli['segunda']=='segunda'?'checked':'')." size='35' > Segunda-feira</td>";
	        echo "<td align=left class='text' width=50><b>Motivo:</b></td>";
        	echo "<td align=left class='text' rowspan='5' width=220><textarea name='motivo' rows='9' cols='75'>".$row_cli['motivo']."</textarea></td>";
	        echo "</tr>";

			echo "<tr>";
	        echo "<td align=left width=150><input type='checkbox' name='terca' value='terca' ".($row_cli['terca']=='terca'?'checked':'')." size='35' > Terça-feira</td>";
	        echo "</tr>";

	        echo "<tr>";
	        echo "<td align=left width=150><input type='checkbox' name='quarta' value='quarta' ".($row_cli['quarta']=='quarta'?'checked':'')." size='35' > Quarta-feira</td>";
	        echo "</tr>";

	        echo "<tr>";
	        echo "<td align=left width=150><input type='checkbox' name='quinta' value='quinta' ".($row_cli['quinta']=='quinta'?'checked':'')." size='35' > Quinta-feira</td>";
	        echo "</tr>";

	        echo "<tr>";
	        echo "<td align=left width=150><input type='checkbox' name='sexta' value='sexta' ".($row_cli['sexta']=='sexta'?'checked':'')." size='35' > Sexta-feira</td>";
	        echo "</tr>";        
			
	        echo "</table>";
			
			echo "<p>";
		}
		
		echo "&nbsp;<span class=inputTextobr>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta coloração são de preenchimento obrigatório!</i></font><p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Alterar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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
