<?PHP

/**********************************************************************************************/
// --> EPI - FUNÇÃO UNION SETOR
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
                    echo '<option value="Placas Atenção" >Placas Atenção</option>';
                	echo '<option value="Placas Segurança" >Placas Segurança</option>';
                	echo '<option value="Placas Aviso" >Placas Aviso</option>';
                	echo '<option value="Placas Cuidado" >Placas Cuidado</option>';
                	echo '<option value="Placas Pense" >Placas Pense</option>';
                	echo '<option value="Placas Educação" >Placas Educação</option>';
                	echo '<option value="Placas Incêndio" >Placas Incêndio</option>';
                	echo '<option value="Placas Lembre-se" >Placas Lembre-se</option>';
                	echo '<option value="Placas Radiação">Placas Radiação</option>';
                	echo '<option value="Placas Importante" >Placas Importante</option>';
                	echo '<option value="Placas Proteja-se" >Placas Proteja-se</option>';
                	echo '<option value="Placas Economize" >Placas Economize</option>';
                	echo '<option value="Placas Reservado" >Placas Reservado</option>';
                	echo '<option value="Placa de Elevador" >Placas de Elevador</option>';
                    //echo '<option value="Sinalização de Eletricidade" >Sinalização de Eletricidade</option>';
                    echo '<option value="Placa de Eletricidade" >Sinalização de Eletricidade</option>';
                    echo '<option value="Cartões Temporários" >Cartões Temporários</option>';
                    echo '<option value="Placas Dobráveis" >Placas Dobráveis</option>';
                    echo '<option value="Placas de Orientação de Veículos" >Placas de Orientação de Veículos</option>';
                    echo '<option value="Setas Indicativas" >Setas Indicativas</option>';
                    echo '<option value="Rota de Incêndio" >Sinalização de Rota de Incêndio</option>';
                    echo '<option value="Sinalização de Incêndio" >Sinalização de Incêndio</option>';
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

                    echo '<option value="Placas de Sinalização Urbana e Rodoviária" >Placas de Sinalização Urbana e Rodoviária</option>';
                    echo '<option value="Sinalização Educativa e Educativa Ilustrada" >Sinalização Educativa e Educativa Ilustrada</option>';

                    /*<!--
                    <option value="Placas de Risco de Embalagens" >Placas de Risco de Embalagens</option>
                    -->*/

                    echo '<option value="Placas de Conservação de Energia" >Placas de Conservação de Energia</option>';
                    echo '<option value="Placas de Risco de Fogo Internacional" >Placas de Risco de Fogo Internacional</option>';
                    echo '<option value="Placas de Aviso Ilustradas" >Placas de Aviso Ilustradas</option>';
                    echo '<option value="Placas de Radiação" >Placas de Radiação</option>';
                    echo '<option value="Placas Ilustradas Conjugadas" >Placas Ilustradas Conjugadas</option>';
                    echo '<option value="CIPA" >CIPA</option>';
                    echo '<option value="Placas Bilingüis" >Placas Bilingüis</option>';
                    echo '<option value="Placas Tríplice" >Placas Tríplice</option>';
                /*<!--
                    <option value="Brindes CIPA" >Brindes CIPA</option>
                -->*/
                    echo '<option value="Placas de Uso Obrigatório" >Placas de Uso Obrigatório</option>';
                /*<!--
                    <option value="Indicativo Numérico" >Indicativo Numérico</option>
                    <option value="Placas de Mesa" >Placas de Mesa</option>
                    <option value="Sinalização de Frota" >Sinalização de Frota</option>
                -->*/
                    echo '<option value="Módulo com Placas Ilustrativas" >Módulo com Placas Ilustrativas</option>';
                    echo '<option value="Módulo para Sinalizaçã de Área" >Módulo para Sinalização de Área</option>';
                /*<!--
                    <option value="Placas Suspensas e Indicativa Especial" >Placas Suspensas e Indicativa Especial</option>
                --> */
                    echo '<option value="Totem" >Totem</option>';
                    echo '<option value="Gravação em Vidros" >Gravação em Vidros</option>';
                    echo '<option value="Placas de Interdição de Área" >Placas de Interdição de Área</option>';
                    echo '<option value="Placas de Reciclagem" >Placas de Reciclagem</option>';
                    echo '<option value="Placas de Identificação de Andar" >Placas de Identificação de Andar</option>';
                    echo '<option value="Placas de Meio Ambiente" >Placas de Meio Ambiente</option>';
                    echo '<option value="Placas de Saúde" >Placas de Saúde</option>';
                    echo '<option value="Placas de Higiene Ilustradas" >Placas de Higiene Ilustradas</option>';
                  /*
                  <option value='Placas Segurança' "; print $_POST['categoria'] == "Placas Segurança"? "selected":""; echo">Placas Segurança</option>
                  <option value='Placas Reservado' "; print $_POST['categoria'] == "Placas Reservado"? "selected":""; echo">Placas Reservado</option>
                  <option value='Placas Radiação' "; print $_POST['categoria'] == "Placas Radiação"? "selected":""; echo">Placas Radiação</option>
                  <option value='Placas Proteja-se' "; print $_POST['categoria'] == "Placas Proteja-se"? "selected":""; echo">Placas Proteja-se</option>
                  <option value='Placas Perigo' "; print $_POST['categoria'] == "Placas Perigo"? "selected":""; echo">Placas Perigo</option>
                  <option value='Placas Pense' "; print $_POST['categoria'] == "Placas Pense"? "selected":""; echo">Placas Pense</option>
                  <option value='Placas Lembre-se' "; print $_POST['categoria'] == "Placas Lembre-se"? "selected":""; echo">Placas Lembre-se</option>
                  <option value='Placas Incêndio' "; print $_POST['categoria'] == "Placas Incêndio"? "selected":""; echo">Placas Incêndio</option>
                  <option value='Placas Importante' "; print $_POST['categoria'] == "Placas Importante"? "selected":""; echo">Placas Importante</option>
                  <option value='Placas Educação' "; print $_POST['categoria'] == "Placas Educação"? "selected":""; echo">Placas Educação</option>
                  <option value='Placas Economize' "; print $_POST['categoria'] == "Placas Economize"? "selected":""; echo">Placas Economize</option>
                  <option value='Placas Cuidado' "; print $_POST['categoria'] == "Placas Cuidado"? "selected":""; echo">Placas Cuidado</option>
                  <option value='Placas Aviso' "; print $_POST['categoria'] == "Placas Aviso"? "selected":""; echo">Placas Aviso</option>
                  <option value='Placas Atenção' "; print $_POST['categoria'] == "Placas Atenção"? "selected":""; echo">Placas Atenção</option>
                  <option value='Placa de Elevador' "; print $_POST['categoria'] == "Placa de Elevador"? "selected":""; echo">Placa de Elevador</option>
                  <option value='Pictogramas' "; print $_POST['categoria'] == "Pictogramas" ? "selected":""; echo">Pictogramas</option>
                  <option value='Eletricidade' "; print $_POST['categoria'] == "Eletricidade" ? "selected":""; echo">Eletricidade</option>
                  <option value='Cartões Temporários' "; print $_POST['categoria'] == "Cartões Temporários" ? "selected":""; echo">Cartões Temporários</option>
                  <option value='Placas Dobráveis' "; print $_POST['categoria'] == "Placas Dobráveis" ? "selected":""; echo">Placas Dobráveis</option>
                  <option value='Placas de Orientação de Veículos' "; print $_POST['categoria'] == "Placas de Orientação de Veículos"? "selected":""; echo">Placas de Orientação de Veículos</option>
                  <option value='Setas Indicativas' "; print $_POST['categoria'] == "Setas Indicativas"? "selected":""; echo">Setas Indicativas</option>
                  <option value='Rota de Incêndio' "; print $_POST['categoria'] == "Rota de Incêndio"? "selected":""; echo">Rota de Incêndio</option>
                  <option value='Placas de Risco' "; print $_POST['categoria'] == "Placas de Risco"? "selected":""; echo">Placas de Risco</option>
                  <option value='Placas de EPI' "; print $_POST['categoria'] == "Placas de EPI"? "selected":""; echo">Placas de EPI</option>
                  <option value='Cavaletes' "; print $_POST['categoria'] == "Cavaletes"? "selected":""; echo">Cavaletes</option>
                  <option value='Pedestal e Cone' "; print $_POST['categoria'] == "Pedestal e Cone"? "selected":""; echo">Pedestal e Cone</option>
                  <option value='Sinalização Urbana e Rodoviária' "; print $_POST['categoria'] == "Sinalização Urbana e Rodoviária"? "selected":""; echo">Sinalização Urbana e Rodoviária</option>
                  <option value='Sinalização Educativa e Ilustrada' "; print $_POST['categoria'] == "Sinalização Educativa e Ilustrada"? "selected":""; echo">Sinalização Educativa e Ilustrada</option>
                  <option value='Conservação de Energia' "; print $_POST['categoria'] == "Conservação de Energia"? "selected":""; echo">Conservação de Energia</option>
                  <option value='Risco de Fogo Internacional' "; print $_POST['categoria'] == "Risco de Fogo Internacional"? "selected":""; echo">Risco de Fogo Internacional</option>
                  <option value='Placas de Aviso Ilustradas' "; print $_POST['categoria'] == "Placas de Aviso Ilustradas"? "selected":""; echo">Placas de Aviso Ilustradas</option>
                  <option value='Placas de Radiação' "; print $_POST['categoria'] == "Placas de Radiação"? "selected":""; echo">Placas de Radiação</option>
                  <option value='Placas Ilustradas Conjugadas' "; print $_POST['categoria'] == "Placas Ilustradas Conjugadas"? "selected":""; echo">Placas Ilustradas Conjugadas</option>
                  <option value='CIPA' "; print $_POST['categoria'] == "CIPA"? "selected":""; echo">CIPA</option>
                  <option value='Placas Tríplice' "; print $_POST['categoria'] == "Placas Tríplice"? "selected":""; echo">Placas Tríplice</option>
                  <option value='Placa de Uso Obrigatório' "; print $_POST['categoria'] == "Placa de Uso Obrigatório"? "selected":""; echo">Placa de Uso Obrigatório</option>
                  <option value='Placas de Interdição de Área' "; print $_POST['categoria'] == "Placas de Interdição de Área"? "selected":""; echo">Placas de Interdição de Área</option>
                  <option value='Placas de Reciclagem' "; print $_POST['categoria'] == "Placas de Reciclagem"? "selected":""; echo">Placas de Reciclagem</option>
                  <option value='Placas de Identificação de Andar' "; print $_POST['categoria'] == "Placas de Identificação de Andar"? "selected":""; echo">Placas de Identificação de Andar</option>
                  <option value='Placas de Meio Ambiente' "; print $_POST['categoria'] == "Placas de Meio Ambiente"? "selected":""; echo">Placas de Meio Ambiente</option>
                  <option value='Placas de Saúde' "; print $_POST['categoria'] == "Placas de Saúde"? "selected":""; echo">Placas de Saúde</option>
                  <option value='Placas de Higiene Ilustradas' "; print $_POST['categoria'] == "Placas de Higiene Ilustradas"? "selected":""; echo">Placas de Higiene Ilustradas</option>
                  <option value='Placas Bilingüis' "; print $_POST['categoria'] == "Placas Bilingüis"? "selected":""; echo">Placas Bilingüis</option>
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
        //echo "- Não é obrigatório o preenchimento de todos os campos acima para realizar uma busca.<BR>";
        
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
