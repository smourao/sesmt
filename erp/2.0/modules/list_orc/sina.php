<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
/*if($_GET[cod]){
	$sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = {$cod_orcamento} AND cod_produto = {$cod}";
	$rr = pg_query($sql);
	$rsql = pg_fetch_array($rr);
	
	if(pg_num_rows($rr)){		
		$iupdt = "UPDATE site_orc_produto SET
		quantidade = {$_POST[quantidade]}
		WHERE cod_orcamento = {$cod_orcamento}
		AND cod_produto = {$cod}";
		if(pg_query($iupdt))
			showmessage('Produto atualizado com sucesso!');
	}else{
		$pdt = "SELECT * FROM produto WHERE cod_prod = {$cod}";
		$res = pg_query($pdt);
		$rush = pg_fetch_array($res);
	
		$iinsert = "INSERT INTO site_orc_produto
		(cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
		VALUES
		({$_GET[cod_orcamento]}, {$_GET[cod_cliente]}, 0, {$_GET[cod]}, {$_POST[quantidade]}, 0, '', '$rush[preco_prod]')";
		if(pg_query($iinsert))
			showmessage('Produto cadastrado com sucesso!');
	}
}*/

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
               				
		echo "<P>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td align=center class='text roundborderselected'><b>Op��es</b></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='butvol' value='Voltar' onclick=\"location.href='?dir=list_orc&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}';\"  onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para a tela de edi��o de or�amento.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>";
			echo "</td>";
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
 /**********************************************************************************************/
// --> EPI - FUN��O UNION SETOR
/**********************************************************************************************/

    echo "<table width=100% height=300 border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'><b>Pesquisa:</b></td>";
    echo "<td class='text'><b>Resultado:</b></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=50% class='roundborderselected' valign=top>";
        echo "<table width=100% cellspacing=0 cellpadding=0>";
        echo "<tr>";
            echo "<td class='text' width=100>Categoria:</td>";
            echo "<td>";
            echo "<select class='inputTextobr' style=\"width: 220px;\" name=categoria id=categoria onchange=\"cgrt_sina_get_material(this.options[this.selectedIndex].text);\">";
                  echo"<option></option>";
                  	echo '<option value="Placas Perigo">Placas Perigo</option>';
                    echo '<option value="Placas Aten��o" >Placas Aten��o</option>';
                	echo '<option value="Placas Seguran�a" >Placas Seguran�a</option>';
                	echo '<option value="Placas Aviso" >Placas Aviso</option>';
                	echo '<option value="Placas Cuidado" >Placas Cuidado</option>';
                	echo '<option value="Placas Pense" >Placas Pense</option>';
                	echo '<option value="Placas Educa��o" >Placas Educa��o</option>';
                	echo '<option value="Placas Inc�ndio" >Placas Inc�ndio</option>';
                	echo '<option value="Placas Lembre-se" >Placas Lembre-se</option>';
                	echo '<option value="Placas Radia��o">Placas Radia��o</option>';
                	echo '<option value="Placas Importante" >Placas Importante</option>';
                	echo '<option value="Placas Proteja-se" >Placas Proteja-se</option>';
                	echo '<option value="Placas Economize" >Placas Economize</option>';
                	echo '<option value="Placas Reservado" >Placas Reservado</option>';
                	echo '<option value="Placa de Elevador" >Placas de Elevador</option>';
                    //echo '<option value="Sinaliza��o de Eletricidade" >Sinaliza��o de Eletricidade</option>';
                    echo '<option value="Placa de Eletricidade" >Sinaliza��o de Eletricidade</option>';
                    echo '<option value="Cart�es Tempor�rios" >Cart�es Tempor�rios</option>';
                    echo '<option value="Placas Dobr�veis" >Placas Dobr�veis</option>';
                    echo '<option value="Placas de Orienta��o de Ve�culos" >Placas de Orienta��o de Ve�culos</option>';
                    echo '<option value="Setas Indicativas" >Setas Indicativas</option>';
                    echo '<option value="Rota de Inc�ndio" >Sinaliza��o de Rota de Inc�ndio</option>';
                    echo '<option value="Sinaliza��o de Inc�ndio" >Sinaliza��o de Inc�ndio</option>';
                    echo '<option value="Pictogramas" >Pictogramas</option>';
                /*
                    Todas em pictogramas
                    <option value="Pictogramas de Risco" >Pictogramas de Risco</option>
                    <option value="Pictogramas Esportivos" >Pictogramas Esportivos</option>
                */
                    echo '<option value="Placas de Risco" >Placas de Risco</option>';
                    echo '<option value="Painel de Risco" >Painel de Risco</option>';
                    echo '<option value="Placas de EPI" >Placas de EPI</option>';

                    echo '<option value="Cavaletes" >Cavaletes</option>';
                    echo '<option value="Pedestal e Cone" >Pedestal e Cone</option>';

                    echo '<option value="Placas de Sinaliza��o Urbana e Rodovi�ria" >Placas de Sinaliza��o Urbana e Rodovi�ria</option>';
                    echo '<option value="Sinaliza��o Educativa e Educativa Ilustrada" >Sinaliza��o Educativa e Educativa Ilustrada</option>';

                    /*<!--
                    <option value="Placas de Risco de Embalagens" >Placas de Risco de Embalagens</option>
                    -->*/

                    echo '<option value="Placas de Conserva��o de Energia" >Placas de Conserva��o de Energia</option>';
                    echo '<option value="Placas de Risco de Fogo Internacional" >Placas de Risco de Fogo Internacional</option>';
                    echo '<option value="Placas de Aviso Ilustradas" >Placas de Aviso Ilustradas</option>';
                    echo '<option value="Placas de Radia��o" >Placas de Radia��o</option>';
                    echo '<option value="Placas Ilustradas Conjugadas" >Placas Ilustradas Conjugadas</option>';
                    echo '<option value="CIPA" >CIPA</option>';
                    echo '<option value="Placas Biling�is" >Placas Biling�is</option>';
                    echo '<option value="Placas Tr�plice" >Placas Tr�plice</option>';
                /*<!--
                    <option value="Brindes CIPA" >Brindes CIPA</option>
                -->*/
                    echo '<option value="Placas de Uso Obrigat�rio" >Placas de Uso Obrigat�rio</option>';
                /*<!--
                    <option value="Indicativo Num�rico" >Indicativo Num�rico</option>
                    <option value="Placas de Mesa" >Placas de Mesa</option>
                    <option value="Sinaliza��o de Frota" >Sinaliza��o de Frota</option>
                -->*/
                    echo '<option value="M�dulo com Placas Ilustrativas" >M�dulo com Placas Ilustrativas</option>';
                    echo '<option value="M�dulo para Sinaliza�� de �rea" >M�dulo para Sinaliza��o de �rea</option>';
                /*<!--
                    <option value="Placas Suspensas e Indicativa Especial" >Placas Suspensas e Indicativa Especial</option>
                --> */
                    echo '<option value="Totem" >Totem</option>';
                    echo '<option value="Grava��o em Vidros" >Grava��o em Vidros</option>';
                    echo '<option value="Placas de Interdi��o de �rea" >Placas de Interdi��o de �rea</option>';
                    echo '<option value="Placas de Reciclagem" >Placas de Reciclagem</option>';
                    echo '<option value="Placas de Identifica��o de Andar" >Placas de Identifica��o de Andar</option>';
                    echo '<option value="Placas de Meio Ambiente" >Placas de Meio Ambiente</option>';
                    echo '<option value="Placas de Sa�de" >Placas de Sa�de</option>';
                    echo '<option value="Placas de Higiene Ilustradas" >Placas de Higiene Ilustradas</option>';
                  echo "</select>";
            echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Material:</td>";
        echo "<td class='text'><select class='inputTexto' style=\"width: 120px;\" name='material' id='material' onchange=\"cgrt_sina_get_espessura(this.value);\" disabled><option></option></select><span id='loadmat' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Espessura:</td>";
        echo "<td class='text'><select class='inputTexto' style=\"width: 120px;\" name='espessura' id='espessura' disabled><option></option></select><span id='loadesp' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Acabamento:</td>";
        echo "<td class='text'><select class='inputTexto' style=\"width: 120px;\" name='acabamento' id='acabamento' disabled><option></option></select><span id='loadaca' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Tamanho:</td>";
        echo "<td class='text'><select class='inputTexto' style=\"width: 120px;\" name='tamanho' id='tamanho' disabled><option></option></select><span id='loadtam' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Legenda:</td>";
        echo "<td class='text'><select class='inputTexto' onchange=\"this.title = this.options[this.selectedIndex].text;\" style=\"width: 220px;\" name='legenda' id='legenda' disabled><option></option></select><span id='loadleg' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
        echo "</tr>";
        
        echo "</table>";
        
        echo "<BR><p><BR>";

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text'>";
            echo "<input type='button' class='btn' name='btnSearchSin' value='Pesquisar' onclick=\"cgrt_sina_get_result();\">";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<BR><p align=justify class=text>";
        //echo "- N�o � obrigat�rio o preenchimento de todos os campos acima para realizar uma busca.<BR>";
        
        echo "<div id='imgex'></div>";

    echo "</td>";
    echo "<td width=50% class='roundborderselected' valign=top>";
        echo "<div id='sinconten' class='text' style=\"border: 0px solid #ffffff; width: 100%; height: 280px;overflow: auto;\">
        </div>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div id='addeditens' class='text' style=\"border: 0px solid #ffffff; width: 100%;\"></div>";
    
    echo "<p>";
    
    echo "<input type=hidden name=cod_cliente id=cod_cliente value='".(int)($_GET[cod_cliente])."'>";
    echo "<input type=hidden name=cod_orcamento id=cod_orcamento value='".(int)($_GET[cod_orcamento])."'>";
    //echo "<input type=hidden name=cod_cgrt id=cod_cgrt value='".(int)($_GET[cod_cgrt])."'>";
    
    echo "<script>ajax_orc_sin_update_placas();</script>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>