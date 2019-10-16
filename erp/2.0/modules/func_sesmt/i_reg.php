<?PHP
$cod_vendedor = rand(1000,9999);

if($_POST[nome] != ""){
	$query_max = "SELECT max(funcionario_id) as funcionario_id FROM funcionario";
	$result_max = pg_query($connect, $query_max);
	$row_max = pg_fetch_array($result_max);
	
	$funcionario_id = $row_max[funcionario_id] + 1;
	
	if($_POST[dtad]){
		$tmp = explode("/", $_POST[dtad]);
		$dtad = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	if($_POST[dtdm] == ""){
		$tmp = explode("/", $_POST[dtdm]);
		$dtdm = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}

	if($_POST[dtn]){
		$tmp = explode("/", $_POST[dtn]);
		$dtn = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	$query_incluir="INSERT INTO funcionario 
					(funcionario_id, cargo_id, associada_id, grupo_id, nome, cpf, ctps, telefone, celular, email, msn, skype, assinatura, cod_vendedor,
					registro, nome_pai, nome_mae, serie, ident, orgao, titulo, zona, reserva, sexo, civil, foto, conjuge, ";
					if($_POST[dtad] != ""){
						$query_incluir.="admissao, ";
					}
					if($_POST[dtdm] != ""){
						$query_incluir.="demissao, ";
					}
					if($_POST[dtn] != ""){
						$query_incluir.="nascimento, ";
					}
					$query_incluir.="endereco, num)
					VALUES 
					($funcionario_id, $cargo_id, $associada_id, $grupo_id, '".addslashes($_POST[nome])."', '$cpf', '$ctps', '$telefone', '$celular', '$email',
					'$msn', '$skype', '$assinatura', $cod_vendedor, '$registromtb', '".addslashes($nome_pai)."', '".addslashes($nome_mae)."', '$serie', '$ident',
					'$orgao', '$titulo', '$zona', '$reserva', '$sexo', '$civil', '$pic', '".addslashes($conjuge)."', ";
					if($_POST[dtad] != ""){
						$query_incluir.="'$dtad',"; 
					}
					if($_POST[dtdm] != ""){
						$query_incluir.="'$dtdm',"; 
					}
					if($_POST[dtn] != ""){
						$query_incluir.="'$dtn',"; 
					}
					$query_incluir.="'".addslashes($endereco)."', '$num')";
		
	if(pg_query($connect, $query_incluir)){
		$query_incluir_usuario="INSERT INTO usuario 
								(usuario_id, funcionario_id, grupo_id, login, senha)
								VALUES
								($funcionario_id, $funcionario_id, $grupo_id, '$login', '$senha')";
		pg_query($connect, $query_incluir_usuario);
	}
	
	showmessage('Colaborador Incluído com Sucesso!');
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
        echo "<td align=center class='text roundborderselected'><b>Registro de Colaboradores</b></td>";
        echo "</tr>";
        echo "</table>";
	    
		echo "<table width=15% border=1 >";
		echo "<form name=form1 method=post onsubmit=\"return fuc();\">";
		echo "<tr>";
		echo "<td onclick=\"window.open('common/ajax_upload_func_pic.php', 'upload_pic', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=350,height=250')\" style=\"cursor: pointer;\" align=center width=100 height=120>";
		echo "<div id=foto name=foto><b>foto</b><p><font size=1>Clique para inserir!</font></p></div>";
		echo "</td></tr></table>";
		echo "<input name=pic id=pic value='' type=hidden>";


		/**************************************************************************************************/
		// --> DADOS PESSOAIS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados pessoais:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nome:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='nome' type='text' name='nome' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>CPF:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='cpf' type='text' name='cpf' size='35' maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nome do pai:</b></td>";
        echo "<td align=left width=220><input id='nome_pai' type='text' name='nome_pai' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Nome da mãe:</b></td>";
        echo "<td align=left class='text' width=220><input id='nome_mae' type='text' name='nome_mae' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='telefone' type='text' name='telefone' size='18' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "<td align=left class='text' width=100><b>Celular:</b></td>";
        echo "<td align=left class='text' width=220><input id='celular' type='text' name='celular' size='18' maxlength='13' OnKeyPress=\"formatar(this, '##-##### ####');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email' type='text' name='email' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>MSN:</b></td>";
        echo "<td align=left class='text' width=220><input id='msn' type='text' name='msn' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CTPS:</b></td>";
        echo "<td align=left width=220><input id='ctps' type='text' name='ctps' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Serie:</b></td>";
        echo "<td align=left class='text' width=220><input id='serie' type='text' name='serie' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>RG:</b></td>";
        echo "<td align=left width=220><input id='ident' type='text' name='ident' size='18' maxlength='10' OnKeyPress=\"formatar(this, '########-#');\"></td>";
        echo "<td align=left class='text' width=100><b>Órgão emissor:</b></td>";
        echo "<td align=left width=200><select name=orgao id=orgao style=\"width: 100px\">
              <option value=1>Detran</option>
			  <option value=2>IFP</option>
            </select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Título:</b></td>";
        echo "<td align=left width=220><input id='titulo' type='text' name='titulo' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Zona eleitoral:</b></td>";
        echo "<td align=left class='text' width=220><input id='zona' type='text' name='zona' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cert. reservista:</b></td>";
        echo "<td align=left width=220><input id='reserva' type='text' name='reserva' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Nascimento:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtn' type='text' name='dtn' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Sexo:</b></td>";
        echo "<td align=left width=200><select name=sexo id=sexo style=\"width: 100px\">
              <option value=1>Masculino</option>
			  <option value=2>Feminino</option>
            </select></td>";
        echo "<td align=left class='text' width=100><b>Est. civil:</b></td>";
        echo "<td align=left width=200><select name=civil id=civil style=\"width: 100px\">
              <option value=1>Casado(a)</option>
			  <option value=2>Solteiro(a)</option>
			  <option value=3>Divórciado(a)</option>
			  <option value=4>Viúvo(a)</option>
            </select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cônjuge:</b></td>";
        echo "<td align=left width=220><input id='conjuge' type='text' name='conjuge' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left class='text' width=220><input id='endereco' type='text' name='endereco' size='25' >&nbsp;<input id='num' type='text' name='num' size='5' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS COMPLEMENTARES
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados complementares:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Associada:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=associada_id id=associada_id style=\"width: 220px\">
			 <option value=''>Associada</option>";
			 $query_associada="SELECT * FROM associada ORDER BY nome";
			 $result_associada=pg_query($connect, $query_associada);
			 while($row_associada=pg_fetch_array($result_associada)){ 
			 	echo "<option value=$row_associada[associada_id]> $row_associada[nome] </option>";
			 }	
		echo "</select></td>";
        echo "<td align=left class='text' width=100><b>Grupo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=grupo_id id=grupo_id style=\"width: 100px\">
			 <option value=''>Grupo</option>";
			 $query_grupo="SELECT * FROM grupo ORDER BY nome";
			 $result_grupo=pg_query($connect, $query_grupo);
			 while($row_grupo=pg_fetch_array($result_grupo)){ 
			 	 echo "<option value=$row_grupo[grupo_id]> $row_grupo[nome] </option>";
			 }
		echo "</select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=cargo_id id=cargo_id style=\"width: 220px\">
			 <option value=''>Cargo</option>";
			 $query_cargo="SELECT * FROM cargo ORDER BY nome";
			 $result_cargo=pg_query($connect, $query_cargo);
			 while($row_cargo=pg_fetch_array($result_cargo)){ 
			 	echo "<option value=$row_cargo[cargo_id]> $row_cargo[nome] </option>";
			 }
		echo "</select></td>";
        echo "<td align=left class='text' width=100><b>Registro MTB:</b></td>";
        echo "<td align=left class='text' width=220><input id='registromtb' type='text' name='registromtb' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Login:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='login' type='text' name='login' size='33' ></td>";
        echo "<td align=left class='text' width=100><b>Senha:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='senha' type='password' name='senha' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Admissão:</b></td>";
        echo "<td align=left width=220><input id='dtad' type='text' name='dtad' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "<td align=left class='text' width=100><b>Demissão:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtdm' type='text' name='dtdm' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Assinatura:</b></td>";
        echo "<td align=left width=220 colspan=3><input id='assinatura' type='file' name='assinatura' size='35' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";
		
		echo "&nbsp;<span class=inputTextobr>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta coloração são de preenchimento obrigatório!</i></font><p>";
		
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