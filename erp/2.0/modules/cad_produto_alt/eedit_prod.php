<?PHP
if(is_numeric($_GET[cod_prod])){
    if($_GET[add])
        showMessage('Produto adicionado com sucesso!');
    if($_POST[btnSaveProd] && $_POST){
        $price = str_replace('.', '', $_POST[preco]);
        $price = str_replace(',', '.', $price);
		
		
		
        $sql = "UPDATE produto_alt SET desc_resumida_prod = '".addslashes($_POST[desc_res])."',
        desc_detalhada_prod = '".addslashes($_POST[desc_det])."', preco_prod = '$price',
        cod_chave = '".addslashes($_POST[cod_chave])."', g_min = $_POST[gmin], g_max = $_POST[gmax], cod_atividade = $_POST[atividade]
        WHERE cod_prod = $_POST[cod_prod]";
		
		
		
        if(pg_query($sql)){
            showMessage('Produto alterado com sucesso!');
            makelog($_SESSION[usuario_id], 'Atualiza??o de produto c?digo: '.$_GET[cod_prod].'.', 303);
        }else{
            showMessage('N?o foi poss?vel atualizar este produto. Por favor, entre em contato com o setor de suporte!', 1);
            makelog($_SESSION[usuario_id], 'Erro ao atualizar produto c?digo: '.$_GET[cod_prod].'.', 304);
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
            showMessage('Os campos <b>Descri??o Resumida</b> e <b>Descri??o Detalhada</b> devem ser preenchidos!',2);
        }elseif(!is_numeric($price)){
            showMessage('O campo <b>Pre?o</b> n?o ? v?lido!',2);
        }elseif(!is_numeric($_POST[atividade])){
            showMessage('O campo <b>C?d. Atividade</b> n?o foi selecionado, ou ? inv?lido.',2);
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
			
			
			
			
			
			
			
			
			
			
			
            $sql = "INSERT INTO produto_alt (cod_prod, desc_resumida_prod, desc_detalhada_prod,
            preco_prod, g_min, g_max, grau_risco, cod_chave, cod_atividade) VALUES ($cod_produto, '".addslashes($_POST[desc_res])."',
            '".addslashes($_POST[desc_det])."', '$price', $_POST[gmin], $_POST[gmax], $grauderisco, '".addslashes($_POST[cod_chave])."', $_POST[atividade])";
			
			$irtabela = pg_query($sql);
			
			
			
			if(isset($_POST['numprod'])){
				
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
					
					
					
					
					
					$prices = str_replace('.', '', $_POST[$varipreco]);
        			$prices = str_replace(',', '.', $prices);
					
					
					
					$sqll = "INSERT INTO produto_alt (cod_prod, desc_resumida_prod, desc_detalhada_prod,
           			preco_prod, g_min, g_max, grau_risco, cod_chave, cod_atividade) VALUES ($_POST[$varicodprod], '".addslashes($_POST[$varidescresu])."',
            		'".addslashes($_POST[$varidesdeta])."', '$prices', $_POST[$varigmin], $_POST[$varigmax], $grauderisco, '".addslashes($_POST[$varicodchave])."', $_POST[$varicodativ])";
					
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

		echo "Repeti??es:<input type='text' size='1' name='numprod' id='numprod' value='$_POST[numprod]'>";

	}else{

		echo "Repeti??es:<input type='text' size='1' name='numprod' id='numprod'>";
	
	}
		echo "<input type='submit' value='Repetir' name='repetirvai' id='repetirvai'>";
	

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>C?d. Produto:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_prod id=cod_prod value='$cod_produto' readonly></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descri??o Resumida:</td>";
   
   
   if(isset($_POST['numprod'])){
	   
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res>{$_POST['desc_res']}</textarea></td>";
	
   }else{
	
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res></textarea></td>";
	
   }
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descri??o Detalhada:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det>{$_POST['desc_det']}</textarea></td>";
	
	}else{
		
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det></textarea></td>";	
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Pre?o:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".$_POST[preco]."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>C?d. Chave:</td>";
	
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
    echo "<td align=left class=text width='140'>C?d. Atividade:</td>";
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
			
			$codigorept = $cod_produto + $i;
			
			
			
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td align=center class='text roundborderselected'>";
			
			
			
			
			
			echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    		echo "<tr>";
    		echo "<td align=left class=text width='140'>C?d. Produto:</td>";
   		 	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name='$varicodprod' id='$varicodprod' value='$codigorept' readonly></td>";
   		 	echo "</tr>";
    
    		echo "<tr>";
    		echo "<td align=left class=text width='140'>Descri??o Resumida:</td>";
			
			
			
    		if(isset($_POST['numprod'])){
	   
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidescresu id=$varidescresu>{$_POST['desc_res']}</textarea></td>";
	
   }else{
	
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidescresu id=$varidescresu></textarea></td>";
	
   }
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descri??o Detalhada:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidesdeta id=$varidesdeta>{$_POST['desc_det']}</textarea></td>";
	
	}else{
		
	echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=$varidesdeta id=$varidesdeta></textarea></td>";	
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Pre?o:</td>";
	
	if(isset($_POST['numprod'])){
	
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varipreco id=$varipreco value='".$_POST[preco]."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
	
	}else{
	
	echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=$varipreco id=$varipreco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
		
	}
	
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>C?d. Chave:</td>";
	
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
    echo "<td align=left class=text width='140'>C?d. Atividade:</td>";
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
    echo "<td align=left class=text width='140'>C?d. Produto:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_prod id=cod_prod value='$prod[cod_prod]' readonly></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descri??o Resumida:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res>{$prod[desc_resumida_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descri??o Detalhada:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det>{$prod[desc_detalhada_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Pre?o:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>C?d. Chave:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_chave id=cod_chave value='{$prod[cod_chave]}'></td>";
    echo "</tr>";

    $sql = "SELECT cod_atividade, dsc_atividade FROM atividade ORDER BY dsc_atividade";
    $rat = pg_query($sql);
    $ativ = pg_fetch_all($rat);
    echo "<tr>";
    echo "<td align=left class=text width='140'>C?d. Atividade:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='atividade' id='atividade' class='inputTextobr'>";
            for($x=0;$x<pg_num_rows($rat);$x++){
                echo "<option "; print $prod[cod_atividade] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
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
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna ? lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar? todos os dados selecionados at? o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
