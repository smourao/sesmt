<?PHP
if(is_numeric($_GET[cod_prod])){
    if($_GET[add])
        showMessage('Produto adicionado com sucesso!');
    if($_POST[btnSaveProd] && $_POST){
        $price = str_replace('.', '', $_POST[preco]);
        $price = str_replace(',', '.', $price);
		
		
		
		
		if($_POST[gmin] >=1){
				
				$gmin = $_POST[gmin];
				
			}else{
			
			$gmin = 0;	
				
			}
			
			
			
			if($_POST[gmax] >=1){
				
				$gmax = $_POST[gmax];
				
			}else{
			
			$gmax = 0;	
				
			}
		
		
		
		
		
        $sql = "UPDATE produto_alt SET desc_resumida_prod = '".addslashes($_POST[desc_res])."',
        desc_detalhada_prod = '".addslashes($_POST[desc_det])."', preco_prod = '$price',
        cod_chave = '".addslashes($_POST[cod_chave])."', g_min = $gmin, g_max = $gmax, cod_atividade = $_POST[atividade], cod_tipo = $_POST[tipo_prod], nivel_tabela = $_POST[nivel_tabela]
        WHERE cod_prod = $_POST[cod_prod]";
		
		
		
        if(pg_query($sql)){
            showMessage('Produto alterado com sucesso!');
            makelog($_SESSION[usuario_id], 'Atualização de produto código: '.$_GET[cod_prod].'.', 303);
        }else{
            showMessage('Não foi possível atualizar este produto. Por favor, entre em contato com o setor de suporte!', 1);
            makelog($_SESSION[usuario_id], 'Erro ao atualizar produto código: '.$_GET[cod_prod].'.', 304);
        }
    }
    $sql = "SELECT * FROM produto_alt WHERE cod_prod = $_GET[cod_prod]";
    $res = @pg_query($sql);
    $prod = @pg_fetch_array($res);
}elseif($_GET[cod_prod] == "new"){
    $sql = "SELECT MAX(cod_prod)+1 as cod_prod FROM produto_alt";
    $res = @pg_query($sql);
    $prod = @pg_fetch_array($res);
	
	if($prod[cod_prod] >= 1){
	
		$cod_produto = $prod[cod_prod];
	
	}else{
		
		$cod_produto = 1;
		
	}
	
    if($_POST[btnSaveProd] && $_POST){
        $price = str_replace('.', '', $_POST[preco]);
        $price = str_replace(',', '.', $price);
        if(empty($_POST[desc_res]) || empty($_POST[desc_det])){
            showMessage('Os campos <b>Descrição Resumida</b> e <b>Descrição Detalhada</b> devem ser preenchidos!',2);
        }elseif(!is_numeric($price)){
            showMessage('O campo <b>Preço</b> não é válido!',2);
        }elseif(!is_numeric($_POST[atividade])){
            showMessage('O campo <b>Cód. Atividade</b> não foi selecionado, ou é inválido.',2);
        }else{
			
			
			
			
			
			
			if($_POST[cod_chave] == "Risco 1" || $_POST[cod_chave] == "risco 1" || $_POST[cod_chave] == "Risco I" || $_POST[cod_chave] == "risco I"){
						
						$grauderisco = 1;
						
					}else if($_POST[cod_chave] == "Risco 2" || $_POST[cod_chave] == "risco 2" || $_POST[cod_chave] == "Risco II" || $_POST[cod_chave] == "risco II"){
						
						$grauderisco = 2;
						
					}else if($_POST[cod_chave] == "Risco 3" || $_POST[cod_chave] == "risco 3" || $_POST[cod_chave] == "Risco III" || $_POST[cod_chave] == "risco III"){
						
						$grauderisco = 3;
						
					}else if($_POST[cod_chave] == "Risco 4" || $_POST[cod_chave] == "risco 4" || $_POST[cod_chave] == "Risco IV" || $_POST[cod_chave] == "risco IV"){
						
						$grauderisco = 4;
						
					}else{
						
						$grauderisco = 10;
					
					}
			
			
			
			if($_POST[gmin] >=1){
				
				$gmin = $_POST[gmin];
				
			}else{
			
			$gmin = 0;	
				
			}
			
			
			
			if($_POST[gmax] >=1){
				
				$gmax = $_POST[gmax];
				
			}else{
			
			$gmax = 0;	
				
			}
			
			
			
			
			
			
			
            $sql = "INSERT INTO produto_alt (cod_prod, desc_resumida_prod, desc_detalhada_prod,
            preco_prod, g_min, g_max, grau_risco, cod_chave, cod_atividade, cod_tipo) VALUES ($cod_produto, '".addslashes($_POST[desc_res])."',
            '".addslashes($_POST[desc_det])."', '$price', $gmin, $gmax, $grauderisco, '".addslashes($_POST[cod_chave])."', $_POST[atividade], $_POST[tipo_prod])";
			
			$irtabela = pg_query($sql);
			
			
			
			if($_POST['numprod'] > 1 ){
				
				$numrepetir = $_POST['numprod'];
				
				for($j=1;$j<$numrepetir;$j++){
					
					$varicodprod = "prod".$j;
					$varidescresu = "descresu".$j;
					$varidesdeta = "desdeta".$j;
					$varipreco = "preco".$j;
					$varicodchave = "codchave".$j;
					$varicodativ = "codativ".$j;
					$varigmin = "gmin".$j;
					$varigmax = "gmax".$j;
					$varitipoprod = "tipoprod".$j;
					$varinivtab = "nivtab".$j;
					
					
					
					
					
					$prices = str_replace('.', '', $_POST[$varipreco]);
        			$prices = str_replace(',', '.', $prices);
					
					
					
					
					
			if($_POST[$varigmin] >=1){
				
				$gminn = $_POST[$varigmin];
				
			}else{
			
			$gminn = 0;	
				
			}
			
			
			
			if($_POST[$varigmax] >=1){
				
				$gmaxx = $_POST[$varigmax];
				
			}else{
			
			$gmaxx = 0;	
				
			}
					
					
					
					
					
					
					$sqll = "INSERT INTO produto_alt (cod_prod, desc_resumida_prod, desc_detalhada_prod,
           			preco_prod, g_min, g_max, grau_risco, cod_chave, cod_atividade, cod_tipo, nivel_tabela) VALUES ($_POST[$varicodprod], '".addslashes($_POST[$varidescresu])."',
            		'".addslashes($_POST[$varidesdeta])."', '$prices', $gminn, $gmaxx, $grauderisco, '".addslashes($_POST[$varicodchave])."', $_POST[$varicodativ], $_POST[$varitipoprod], $_POST[$varinivtab])";
					
					$irtabela = pg_query($sqll);
					
					
					
				}
				
				echo "<script>location.href='?dir=cad_produto_alt&p=index&sp=edit_prod&page=1&cod_prod=new';</script>";
				
			}else{
				
				echo "<script>location.href='?dir=cad_produto_alt&p=index&sp=edit_prod&page=1&cod_prod=new';</script>";
					
			}
			
			
            
        }
    }
}
/**************************************************************************************************/
// -->
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do produto:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// NOVO CADASTRO!!!
	
	
	if($_GET[cod_prod] == "new"){
	
    echo "<form method=post id='frmcadprod' name='frmcadprod'>";
	
	
	
	if(isset($_POST['numprod'])){

		echo "Repetições:<input type='text' size='1' name='numprod' id='numprod' value='$_POST[numprod]'>";

	}else{

		echo "Repetições:<input type='text' size='1' name='numprod' id='numprod'>";
	
	}
		echo "<input type='submit' value='Repetir' name='repetirvai' id='repetirvai'>";
	

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Produto:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_prod id=cod_prod value='$cod_produto' readonly></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Resumida:</td>";
   
   
   if(isset($_POST['numprod'])){
	   
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res>{$_POST['desc_res']}</textarea></td>";
	
   }else{
	
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res></textarea></td>";
	
   }
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Detalhada:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det>{$_POST['desc_det']}</textarea></td>";
	
	}else{
		
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det></textarea></td>";	
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Preço:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".$_POST[preco]."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Chave:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_chave id=cod_chave value='{$_POST[cod_chave]}'></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_chave id=cod_chave value='{$prod[cod_chave]}'></td>";	
		
	}
	
    echo "</tr>";

    $sql = "SELECT cod_atividade, dsc_atividade FROM atividade ORDER BY dsc_atividade";
    $rat = pg_query($sql);
    $ativ = pg_fetch_all($rat);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Atividade:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='atividade' id='atividade' class='inputTextobr'>";
            for($x=0;$x<pg_num_rows($rat);$x++){
				
				if(isset($_POST['numprod'])){
				
                echo "<option "; print $_POST['atividade'] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
				
				}else{
				
				echo "<option "; print $prod[cod_atividade] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
					
				}
				
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	
	echo "<tr>";
    echo "<td align=left class=text width='140'>Tabela:</td>";
	echo "<td align=left class=text width='500'>";
	
	echo "<select name='nivel_tabela' id='nivel_tabela' class='inputTextobr'>";
	
	if(isset($_POST['numprod'])){
		echo "<option "; print $_POST['nivel_tabela'] == 2 ? " selected ":""; echo "> </option>";
		
		echo "<option "; print $_POST['nivel_tabela'] == 0 ? " selected ":""; echo " value='0'>Cliente</option>";
		
		echo "<option "; print $_POST['nivel_tabela'] == 1 ? " selected ":""; echo " value='1'>Comercial</option>";
		
	}else{
		echo "<option "; print $prod[nivel_tabela] == 2 ? " selected ":""; echo "> </option>";
		
		echo "<option "; print $prod[nivel_tabela] == 0 ? " selected ":""; echo " value='0'>Cliente</option>";
		
		echo "<option "; print $prod[nivel_tabela] == 1 ? " selected ":""; echo " value='1'>Comercial</option>";
		
	}
	echo "</select>";
		
	echo "</td>";
    echo "</tr>";
	
	
	
	
	$sqlclass = "SELECT cod_tipo, dsc_tipo FROM tipo_produto ORDER BY dsc_tipo";
    $ratclass = pg_query($sqlclass);
    $ativclass = pg_fetch_all($ratclass);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Classificação:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='tipo_prod' id='tipo_prod' class='inputTextobr'>";
            echo "<option> </option>";
		
            for($x=0;$x<pg_num_rows($ratclass);$x++){
				
				if(isset($_POST['numprod'])){
				
                echo "<option "; print $_POST['tipo_prod'] == $ativclass[$x][cod_tipo] ? " selected ":""; echo " value='{$ativclass[$x][cod_tipo]}'>{$ativclass[$x][dsc_tipo]}</option>";
				
				}else{
				
				echo "<option "; print $prod[cod_tipo] == $ativclass[$x][cod_tipo] ? " selected ":""; echo " value='{$ativclass[$x][cod_tipo]}'>{$ativclass[$x][dsc_tipo]}</option>";
					
				}
				
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	
	echo "<tr>";
    echo "<td align=left class=text width='140'>Grupo:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=gmin id=gmin value='{$_POST[gmin]}'> - <input type='text' class='inputTextobr' size=5 name=gmax id=gmax value='{$_POST[gmax]}'></td>";
	
	
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=gmin id=gmin value='{$prod[g_min]}'> - <input type='text' class='inputTextobr' size=5 name=gmax id=gmax value='{$prod[g_max]}'></td>";
		
	}
	
    echo "</tr>";
	
	
	
	
/*	echo "<tr>";
    echo "<td align=left class=text width='140'>Grau de Risco:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=graurisc id=graurisc value='{$_POST[graurisc]}'></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=graurisc id=graurisc value='{$prod[grau_risco]}'></td>";	
		
	}
	
    echo "</tr>";  */
	
	
	
	
	
	

    echo "</table>";
	
	echo "</td>";
echo "</tr>";
echo "</table>";

	
	
	
	if(isset($_POST['repetirvai'])){
	
		$numrept = $_POST['numprod'];



		for($i=1;$i<$numrept;$i++){ 
			
			$varicodprod = "prod".$i;
			$varidescresu = "descresu".$i;
			$varidesdeta = "desdeta".$i;
			$varipreco = "preco".$i;
			$varicodchave = "codchave".$i;
			$varicodativ = "codativ".$i;
			$varigmin = "gmin".$i;
			$varigmax = "gmax".$i;
			$varigraurisc = "graurisc".$i;
			$varitipoprod = "tipoprod".$i;
			$varinivtab = "nivtab".$i;
			
			$codigorept = $cod_produto + $i;
			
			
			
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td align=center class='text roundborderselected'>";
			
			
			
			
			
			echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    		echo "<tr>";
    		echo "<td align=left class=text width='140'>Cód. Produto:</td>";
   		 	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name='$varicodprod' id='$varicodprod' value='$codigorept' readonly></td>";
   		 	echo "</tr>";
    
    		echo "<tr>";
    		echo "<td align=left class=text width='140'>Descrição Resumida:</td>";
			
			
			
    		if(isset($_POST['numprod'])){
	   
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidescresu id=$varidescresu>{$_POST['desc_res']}</textarea></td>";
	
   }else{
	
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidescresu id=$varidescresu></textarea></td>";
	
   }
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Detalhada:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidesdeta id=$varidesdeta>{$_POST['desc_det']}</textarea></td>";
	
	}else{
		
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidesdeta id=$varidesdeta></textarea></td>";	
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Preço:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varipreco id=$varipreco value='".$_POST[preco]."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varipreco id=$varipreco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Chave:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varicodchave id=$varicodchave value='{$_POST[cod_chave]}'></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varicodchave id=$varicodchave value='{$prod[cod_chave]}'></td>";	
		
	}
	
    echo "</tr>";

    $sql = "SELECT cod_atividade, dsc_atividade FROM atividade ORDER BY dsc_atividade";
    $rat = pg_query($sql);
    $ativ = pg_fetch_all($rat);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Atividade:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='$varicodativ' id='$varicodativ' class='inputTextobr'>";
            for($x=0;$x<pg_num_rows($rat);$x++){
				
				if(isset($_POST['numprod'])){
				
                echo "<option "; print $_POST['atividade'] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
				
				}else{
				
				echo "<option "; print $prod[cod_atividade] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
					
				}
            }
        	echo "</select>";
    		echo "</td>";
    		echo "</tr>";
			
			
			
			echo "<tr>";
    echo "<td align=left class=text width='140'>Tabela:</td>";
	echo "<td align=left class=text width='500'>";
	
	echo "<select name='$varinivtab' id='$varinivtab' class='inputTextobr'>";
	
	if(isset($_POST['numprod'])){
		echo "<option "; print $_POST['nivel_tabela'] == 2 ? " selected ":""; echo "> </option>";
		
		echo "<option "; print $_POST['nivel_tabela'] == 0 ? " selected ":""; echo " value='0'>Cliente</option>";
		
		echo "<option "; print $_POST['nivel_tabela'] == 1 ? " selected ":""; echo " value='1'>Comercial</option>";
		
	}else{
		echo "<option "; print $prod[nivel_tabela] == 2 ? " selected ":""; echo "> </option>";
		
		echo "<option "; print $prod[nivel_tabela] == 0 ? " selected ":""; echo " value='0'>Cliente</option>";
		
		echo "<option "; print $prod[nivel_tabela] == 1 ? " selected ":""; echo " value='1'>Comercial</option>";
		
	}
	echo "</select>";
		
	echo "</td>";
    echo "</tr>";
			
			
			
			
			
	$sqlclass = "SELECT cod_tipo, dsc_tipo FROM tipo_produto ORDER BY dsc_tipo";
    $ratclass = pg_query($sqlclass);
    $ativclass = pg_fetch_all($ratclass);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Classificação:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='$varitipoprod' id='$varitipoprod' class='inputTextobr'>";
		
		echo "<option> </option>";
		
            for($x=0;$x<pg_num_rows($ratclass);$x++){
				
				
				if(isset($_POST['numprod'])){
				
                echo "<option "; print $_POST['tipo_prod'] == $ativclass[$x][cod_tipo] ? " selected ":""; echo " value='{$ativclass[$x][cod_tipo]}'>{$ativclass[$x][dsc_tipo]}</option>";
				
				}else{
				
				echo "<option "; print $prod[cod_tipo] == $ativclass[$x][cod_tipo] ? " selected ":""; echo " value='{$ativclass[$x][cod_tipo]}'>{$ativclass[$x][dsc_tipo]}</option>";
					
				}
				
            }
        	echo "</select>";
    		echo "</td>";
    		echo "</tr>";
			
			
			
			
			
			
			
			
			echo "<tr>";
    echo "<td align=left class=text width='140'>Grupo:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=$varigmin id=$varigmin value='{$_POST[gmin]}'> - <input type='text' class='inputTextobr' size=5 name=$varigmax id=$varigmax value='{$_POST[gmax]}'></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=$varigmin id=$varigmin value='{$prod[g_min]}'> - <input type='text' class='inputTextobr' size=5 name=$varigmax id=$varigmax value='{$prod[g_max]}'></td>";
		
	}
	
    echo "</tr>";
	
	
	
	
/*	echo "<tr>";
    echo "<td align=left class=text width='140'>Grau de Risco:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=$varigraurisc id=$varigraurisc value='{$_POST[graurisc]}'></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=$varigraurisc id=$varigraurisc value='{$prod[grau_risco]}'></td>";	
		
	}
	
    echo "</tr>"; */
			
			
			
			
			
			
			
			

    		echo "</table>";
	
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			
			
			
			
			
			
		}
	
	
	
	
	
	
	
	}
	
	
	
	
	
	
	}else{
		
	
	
	
	
	
	
	
	//EDITAR!!!!
	
	
	
	echo "<form method=post id='frmcadprod' name='frmcadprod'>";
	

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Produto:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_prod id=cod_prod value='$prod[cod_prod]' readonly></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Resumida:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res>{$prod[desc_resumida_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Detalhada:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det>{$prod[desc_detalhada_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Preço:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Chave:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_chave id=cod_chave value='{$prod[cod_chave]}'></td>";
    echo "</tr>";

    $sql = "SELECT cod_atividade, dsc_atividade FROM atividade ORDER BY dsc_atividade";
    $rat = pg_query($sql);
    $ativ = pg_fetch_all($rat);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Atividade:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='atividade' id='atividade' class='inputTextobr'>";
            for($x=0;$x<pg_num_rows($rat);$x++){
                echo "<option "; print $prod[cod_atividade] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='140'>Tabela:</td>";
	echo "<td align=left class=text width='500'>";
	
	echo "<select name='nivel_tabela' id='nivel_tabela' class='inputTextobr'>";
	
		echo "<option "; print $prod[nivel_tabela] == 2 ? " selected ":""; echo "> </option>";
	
		echo "<option "; print $prod[nivel_tabela] == 0 ? " selected ":""; echo " value='0'>Cliente</option>";
		
		echo "<option "; print $prod[nivel_tabela] == 1 ? " selected ":""; echo " value='1'>Comercial</option>";
	echo "</select>";	

	
		
	echo "</td>";
    echo "</tr>";
	
	
	
	
	
	$sqlclass = "SELECT cod_tipo, dsc_tipo FROM tipo_produto ORDER BY dsc_tipo";
    $ratclass = pg_query($sqlclass);
    $ativclass = pg_fetch_all($ratclass);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Classificação:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='tipo_prod' id='tipo_prod' class='inputTextobr'>";
		
		echo "<option> </option>";
		
            for($x=0;$x<pg_num_rows($ratclass);$x++){
                echo "<option "; print $prod[cod_tipo] == $ativclass[$x][cod_tipo] ? " selected ":""; echo " value='{$ativclass[$x][cod_tipo]}'>{$ativclass[$x][dsc_tipo]}</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	
	
	
	
	
	
	
	echo "<tr>";
    echo "<td align=left class=text width='140'>Grupo:</td>";
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=gmin id=gmin value='{$prod[g_min]}'> - <input type='text' class='inputTextobr' size=5 name=gmax id=gmax value='{$prod[g_max]}'></td>";
	
	echo "</tr>";
	
	
/*	echo "<tr>";
    echo "<td align=left class=text width='140'>Grau de Risco:</td>";
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=5 name=graurisc  id=graurisc  value='{$prod[grau_risco]}'></td>";	
	
	
	echo "</tr>"; */

    echo "</table>";
	
	
	echo "</td>";
echo "</tr>";
echo "</table>";

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
		
		
	}
	
	

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
