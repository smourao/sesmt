<?PHP
$number = rand(1000,9999);
if($_POST[nome] != ""){
	$query_incluir="INSERT into associada (nome, responsavel, telefone, fax, endereco, bairro, cidade, uf, cep, nome_fantasia, cnpj_franquia,
					insc_munic, email_franquia, rg_resp, cpf_resp, tel_resp, cel_resp, nextel_resp, id_resp, email_resp, skype_resp,
					cep_resp, end_resp, bairro_resp, uf_resp, cidade_resp, random)
					values
					('$_POST[nome]', '$responsavel', '$telefone', '$fax', '$endereco', '$bairro', '$cidade', '$uf', '$cep', '$nome_fantasia',
					'$cnpj_franquia', '$insc_munic', '$email_franquia', '$rg_resp', '$cpf_resp', '$tel_resp', '$cel_resp', '$nextel_resp', '$id_resp',
					'$email_resp', '$skype_resp', '$cep_resp', '$end_resp', '$bairro_resp', '$uf_resp', '$cidade_resp', $number)";
	
	if(pg_query($connect, $query_incluir)){
		showmessage('Franquia Incluída com Sucesso!');
	}
}

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
        echo "<td align=center class='text roundborderselected'><b>Franqueada SESMT</b></td>";
        echo "</tr>";
        echo "</table>";
        
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
		
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Razão Social:</b></td>";
        echo "<td align=left width=220><input id='nome' type='text' name='nome' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Nome Fantasia:</b></td>";
        echo "<td align=left class='text' width=220>SESMT</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CNPJ:</b></td>";
        echo "<td align=left width=220><input id='cnpj_franquia' type='text' name='cnpj_franquia' size='35' maxlength='18' OnKeyPress=\"formatar(this, '##.###.###/####-##');\"></td>";
		echo "<td align=left class='text' width=100><b>Insc. Municipal:</b></td>";
		echo "<td align=left width=220><input id='insc_munic' type='text' name='insc_munic' size='35' maxlength='9' OnKeyPress=\"formatar(this, '###.###-#');\"></td>";
		echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left width=220><input id='cep' type='text' name='cep' size='35' maxlength='9' OnKeyPress=\"formatar(this, '#####-##');\"></td>";
		echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
		echo "<td align=left width=220><input id='endereco' type='text' name='endereco' size='35' ></td>";
		echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Bairro:</b></td>";
        echo "<td align=left width=220><input id='bairro' type='text' name='bairro' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Cidade:</b></td>";
		echo "<td align=left width=220><input id='cidade' type='text' name='cidade' size='35' ></td>";
		echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left width=220><input id='uf' type='text' name='uf' size='35' ></td>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
		echo "<td align=left width=220><input id='telefone' type='text' name='telefone' size='35' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
		echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Fax:</b></td>";
        echo "<td align=left width=220><input id='fax' type='text' name='fax' size='35' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
		echo "<td align=left width=220><input id='email_franquia' type='text' name='email_franquia' size='35' ></td>";
		echo "</tr>";

        echo "</table>";
		
		echo"<p>";
		
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
        echo "<td align=left width=220><input id='responsavel' type='text' name='responsavel' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>RG:</b></td>";
        echo "<td align=left width=220><input id='rg_resp' type='text' name='rg_resp' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>CPF:</b></td>";
        echo "<td align=left width=220><input id='cpf_resp' type='text' name='cpf_resp' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left width=220><input id='cep_resp' type='text' name='cep_resp' size='35' maxlength='9' OnKeyPress=\"formatar(this, '#####-##');\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left width=220><input id='end_resp' type='text' name='end_resp' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Bairro:</b></td>";
        echo "<td align=left width=220><input id='bairro_resp' type='text' name='bairro_resp' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Cidade:</b></td>";
        echo "<td align=left width=220><input id='cidade_resp' type='text' name='cidade_resp' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left width=220><input id='uf_resp' type='text' name='uf_resp' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input id='tel_resp' type='text' name='tel_resp' size='35' maxlength='12' onkeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "<td align=left class='text' width=100><b>Celular:</b></td>";
        echo "<td align=left width=220><input id='cel_resp' type='text' name='cel_resp' size='35' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Nextel:</b></td>";
        echo "<td align=left width=220><input id='nextel_resp' type='text' name='nextel_resp' size='35' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "<td align=left class='text' width=100><b>ID:</b></td>";
        echo "<td align=left width=220><input id='id_resp' type='text' name='id_resp' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email_resp' type='text' name='email_resp' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Skype:</b></td>";
        echo "<td align=left width=220><input id='skype_resp' type='text' name='skype_resp' size='35' ></td>";
        echo "</tr>";
		
		echo"</table>";
				
		echo"<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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