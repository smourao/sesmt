<?PHP

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
            echo "<select class='inputTextobr' style=\"width: 220px;\" name=categoria id=categoria onchange=\"cgrt_sin_get_material(this.options[this.selectedIndex].text);\">";
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
                  /*
                  <option value='Placas Seguran�a' "; print $_POST['categoria'] == "Placas Seguran�a"? "selected":""; echo">Placas Seguran�a</option>
                  <option value='Placas Reservado' "; print $_POST['categoria'] == "Placas Reservado"? "selected":""; echo">Placas Reservado</option>
                  <option value='Placas Radia��o' "; print $_POST['categoria'] == "Placas Radia��o"? "selected":""; echo">Placas Radia��o</option>
                  <option value='Placas Proteja-se' "; print $_POST['categoria'] == "Placas Proteja-se"? "selected":""; echo">Placas Proteja-se</option>
                  <option value='Placas Perigo' "; print $_POST['categoria'] == "Placas Perigo"? "selected":""; echo">Placas Perigo</option>
                  <option value='Placas Pense' "; print $_POST['categoria'] == "Placas Pense"? "selected":""; echo">Placas Pense</option>
                  <option value='Placas Lembre-se' "; print $_POST['categoria'] == "Placas Lembre-se"? "selected":""; echo">Placas Lembre-se</option>
                  <option value='Placas Inc�ndio' "; print $_POST['categoria'] == "Placas Inc�ndio"? "selected":""; echo">Placas Inc�ndio</option>
                  <option value='Placas Importante' "; print $_POST['categoria'] == "Placas Importante"? "selected":""; echo">Placas Importante</option>
                  <option value='Placas Educa��o' "; print $_POST['categoria'] == "Placas Educa��o"? "selected":""; echo">Placas Educa��o</option>
                  <option value='Placas Economize' "; print $_POST['categoria'] == "Placas Economize"? "selected":""; echo">Placas Economize</option>
                  <option value='Placas Cuidado' "; print $_POST['categoria'] == "Placas Cuidado"? "selected":""; echo">Placas Cuidado</option>
                  <option value='Placas Aviso' "; print $_POST['categoria'] == "Placas Aviso"? "selected":""; echo">Placas Aviso</option>
                  <option value='Placas Aten��o' "; print $_POST['categoria'] == "Placas Aten��o"? "selected":""; echo">Placas Aten��o</option>
                  <option value='Placa de Elevador' "; print $_POST['categoria'] == "Placa de Elevador"? "selected":""; echo">Placa de Elevador</option>
                  <option value='Pictogramas' "; print $_POST['categoria'] == "Pictogramas" ? "selected":""; echo">Pictogramas</option>
                  <option value='Eletricidade' "; print $_POST['categoria'] == "Eletricidade" ? "selected":""; echo">Eletricidade</option>
                  <option value='Cart�es Tempor�rios' "; print $_POST['categoria'] == "Cart�es Tempor�rios" ? "selected":""; echo">Cart�es Tempor�rios</option>
                  <option value='Placas Dobr�veis' "; print $_POST['categoria'] == "Placas Dobr�veis" ? "selected":""; echo">Placas Dobr�veis</option>
                  <option value='Placas de Orienta��o de Ve�culos' "; print $_POST['categoria'] == "Placas de Orienta��o de Ve�culos"? "selected":""; echo">Placas de Orienta��o de Ve�culos</option>
                  <option value='Setas Indicativas' "; print $_POST['categoria'] == "Setas Indicativas"? "selected":""; echo">Setas Indicativas</option>
                  <option value='Rota de Inc�ndio' "; print $_POST['categoria'] == "Rota de Inc�ndio"? "selected":""; echo">Rota de Inc�ndio</option>
                  <option value='Placas de Risco' "; print $_POST['categoria'] == "Placas de Risco"? "selected":""; echo">Placas de Risco</option>
                  <option value='Placas de EPI' "; print $_POST['categoria'] == "Placas de EPI"? "selected":""; echo">Placas de EPI</option>
                  <option value='Cavaletes' "; print $_POST['categoria'] == "Cavaletes"? "selected":""; echo">Cavaletes</option>
                  <option value='Pedestal e Cone' "; print $_POST['categoria'] == "Pedestal e Cone"? "selected":""; echo">Pedestal e Cone</option>
                  <option value='Sinaliza��o Urbana e Rodovi�ria' "; print $_POST['categoria'] == "Sinaliza��o Urbana e Rodovi�ria"? "selected":""; echo">Sinaliza��o Urbana e Rodovi�ria</option>
                  <option value='Sinaliza��o Educativa e Ilustrada' "; print $_POST['categoria'] == "Sinaliza��o Educativa e Ilustrada"? "selected":""; echo">Sinaliza��o Educativa e Ilustrada</option>
                  <option value='Conserva��o de Energia' "; print $_POST['categoria'] == "Conserva��o de Energia"? "selected":""; echo">Conserva��o de Energia</option>
                  <option value='Risco de Fogo Internacional' "; print $_POST['categoria'] == "Risco de Fogo Internacional"? "selected":""; echo">Risco de Fogo Internacional</option>
                  <option value='Placas de Aviso Ilustradas' "; print $_POST['categoria'] == "Placas de Aviso Ilustradas"? "selected":""; echo">Placas de Aviso Ilustradas</option>
                  <option value='Placas de Radia��o' "; print $_POST['categoria'] == "Placas de Radia��o"? "selected":""; echo">Placas de Radia��o</option>
                  <option value='Placas Ilustradas Conjugadas' "; print $_POST['categoria'] == "Placas Ilustradas Conjugadas"? "selected":""; echo">Placas Ilustradas Conjugadas</option>
                  <option value='CIPA' "; print $_POST['categoria'] == "CIPA"? "selected":""; echo">CIPA</option>
                  <option value='Placas Tr�plice' "; print $_POST['categoria'] == "Placas Tr�plice"? "selected":""; echo">Placas Tr�plice</option>
                  <option value='Placa de Uso Obrigat�rio' "; print $_POST['categoria'] == "Placa de Uso Obrigat�rio"? "selected":""; echo">Placa de Uso Obrigat�rio</option>
                  <option value='Placas de Interdi��o de �rea' "; print $_POST['categoria'] == "Placas de Interdi��o de �rea"? "selected":""; echo">Placas de Interdi��o de �rea</option>
                  <option value='Placas de Reciclagem' "; print $_POST['categoria'] == "Placas de Reciclagem"? "selected":""; echo">Placas de Reciclagem</option>
                  <option value='Placas de Identifica��o de Andar' "; print $_POST['categoria'] == "Placas de Identifica��o de Andar"? "selected":""; echo">Placas de Identifica��o de Andar</option>
                  <option value='Placas de Meio Ambiente' "; print $_POST['categoria'] == "Placas de Meio Ambiente"? "selected":""; echo">Placas de Meio Ambiente</option>
                  <option value='Placas de Sa�de' "; print $_POST['categoria'] == "Placas de Sa�de"? "selected":""; echo">Placas de Sa�de</option>
                  <option value='Placas de Higiene Ilustradas' "; print $_POST['categoria'] == "Placas de Higiene Ilustradas"? "selected":""; echo">Placas de Higiene Ilustradas</option>
                  <option value='Placas Biling�is' "; print $_POST['categoria'] == "Placas Biling�is"? "selected":""; echo">Placas Biling�is</option>
                  */
                  echo "</select>";
            echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td class='text' width=100>Material:</td>";
        echo "<td class='text'><select class='inputTexto' style=\"width: 120px;\" name='material' id='material' onchange=\"cgrt_sin_get_espessura(this.value);\" disabled><option></option></select><span id='loadmat' style=\"display: none;\"><img src='images/load.gif' border=0></span></td>";
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
            echo "<input type='button' class='btn' name='btnSearchSin' value='Pesquisar' onclick=\"cgrt_sin_get_result();\">";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<BR><p align=justify class=text>";
        //echo "- N�o � obrigat�rio o preenchimento de todos os campos acima para realizar uma busca.<BR>";
        
        echo "<div id='imgex'></div>";

    echo "</td>";
    echo "<td width=50% class='roundborderselected' valign=top>";
        echo "<div id='sincontent' class='text' style=\"border: 0px solid #ffffff; width: 100%; height: 280px;overflow: auto;\">
        </div>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div id='addeditems' class='text' style=\"border: 0px solid #ffffff; width: 100%;\"></div>";
    
    echo "<p>";
    
    echo "<input type=hidden name=cod_cliente id=cod_cliente value='".(int)($_GET[cod_cliente])."'>";
    echo "<input type=hidden name=cod_setor id=cod_setor value='".(int)($_GET[cod_setor])."'>";
    echo "<input type=hidden name=cod_cgrt id=cod_cgrt value='".(int)($_GET[cod_cgrt])."'>";
    
    echo "<script>ajax_cgrt_sin_update_placas();</script>";

?>
