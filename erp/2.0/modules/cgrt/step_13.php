<?PHP
$sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
$result = pg_query($sql);
$cinfo = pg_fetch_array($result);

/***************************************************************************************************/
// --> ADD NEW SETOR
/***************************************************************************************************/
if($_POST && $_POST[btnSaveNewSetores]){
    //
    $sql = "SELECT * FROM histograma WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
    
    if(pg_num_rows(pg_query($sql))>0){
		$sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        $rcs = pg_query($sql);
        $csdata = pg_fetch_array($rcs);		
		
		$sql = "UPDATE histograma SET
				dimensoes     = $dimensao
				, postura 	  = $postura
				, ferramenta  = $ferramenta
				, maquina 	  = $maquina
				, prevencao   = $prevencao
				, ventilacao  = $ventilacao
				, temperatura = $temperatura
				, ruido 	  = $ruido
				, higiene     = $higiene
				, agentes     = $agentes
				, energetico  = $energetico
				, transporte  = $transporte
				, escada      = $escada
				, esforco     = $esforco
				, exigencia   = $exigencia
				, tarefa      = $tarefa
				, atencao     = $atencao
				, isolada     = $isolada
				, necessidade = $necessidade
				, requisito   = $requisito
				WHERE cod_cgrt = $_GET[cod_cgrt]";
        if(@pg_query($sql)){
			showMessage('Dados atualizados com sucesso!');
            makelog($_SESSION[usuario_id], "[CGRT] Atualização de dados para gerar o histograma ao relatório código {$csdata[cod_cgrt]} do cliente ".addslashes($cinfo[cliente_id]), 102);
        }else{
			showMessage('Não foi possível atualizar dados!',1);
        	makelog($_SESSION[usuario_id], "[CGRT] Erro ao atualizar dados, código do relatório {$csdata[cod_cgrt]} e código do cliente ".addslashes($cinfo[cliente_id]), 104);
    	}
	}else{
		       
        $sql = "INSERT INTO histograma
            (cod_cgrt, cod_cliente, dimensoes, postura, ferramenta, maquina, prevencao, ventilacao, temperatura, ruido, higiene, agentes,
			energetico, transporte, escada, esforco, exigencia, tarefa, atencao, isolada, necessidade, requisito)
            values
            (".(int)($_GET[cod_cgrt]).", ".(int)($_GET[cod_cliente]).", {$_POST[dimensao]}, {$_POST[postura]}, {$_POST[ferramenta]},
			{$_POST[maquina]}, {$_POST[prevencao]}, {$_POST[ventilacao]}, {$_POST[temperatura]}, {$_POST[ruido]}, {$_POST[higiene]},
			{$_POST[agentes]}, {$_POST[energetico]}, {$_POST[transporte]}, {$_POST[escada]}, {$_POST[esforco]}, {$_POST[exigencia]},
			{$_POST[tarefa]}, {$_POST[atencao]}, {$_POST[isolada]}, {$_POST[necessidade]}, {$_POST[requisito]})";
			if(@pg_query($sql)){
                showMessage('Dados adicionados com sucesso!');
                makelog($_SESSION[usuario_id], "[CGRT] Adição de dados para gerar o histograma ao relatório código {$csdata[cod_cgrt]} do cliente ".addslashes($cinfo[cliente_id]), 102);
            }else{
                showMessage('Não foi possível cadastrar dados. Por favor, entre em contato com o setor de suporte!',1);
                makelog($_SESSION[usuario_id], "[CGRT] Erro ao adicionar dados, código {$csdata[cod_cgrt]} do cliente ".addslashes($cinfo[cliente_id]), 103);
            }
    }
}

/***************************************************************************************************/
// --> FORM - CONFIGURAÇÃO DOS SETORES
/***************************************************************************************************/
//Seleciona todos os dados do histograma
$sql = "SELECT * FROM histograma where cod_cgrt = $cod_cgrt";
$res = pg_query($sql);
$set = pg_fetch_array($res);

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
	echo "<td><b>Concepção</b></td>";
	echo "</tr>";
	
	echo "<tr class='roundbordermix text'>";
    echo "<form method='POST' name='frmAdd'>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Dimensões:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='dimensao' id='dimensao' class='inputTextobr'>";
            echo "<option value='1'"; if($set[dimensoes] == "1" ) echo " selected "; echo ">Suficiência ótima 100%</option>";
            echo "<option value='2'"; if($set[dimensoes] == "2" ) echo " selected "; echo ">Suficiência boa 85%</option>";
			echo "<option value='3'"; if($set[dimensoes] == "3" ) echo " selected "; echo ">Suficiência média 55%</option>";
			echo "<option value='4'"; if($set[dimensoes] == "4" ) echo " selected "; echo ">Suficiência baixa 35%</option>";
			echo "<option value='5'"; if($set[dimensoes] == "5" ) echo " selected "; echo ">Suficiência péssima 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Postura:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='postura' id='postura' class='inputTextobr'>";
            echo "<option value='1'"; if($set[postura] == "1" ) echo " selected "; echo ">Ótima 100%</option>";
            echo "<option value='2'"; if($set[postura] == "2" ) echo " selected "; echo ">Boa 80%</option>";
			echo "<option value='3'"; if($set[postura] == "3" ) echo " selected "; echo ">Regular 60%</option>";
			echo "<option value='4'"; if($set[postura] == "4" ) echo " selected "; echo ">Ruim 40%</option>";
			echo "<option value='5'"; if($set[postura] == "5" ) echo " selected "; echo ">Muito ruim 25%</option>";
			echo "<option value='6'"; if($set[postura] == "6" ) echo " selected "; echo ">Péssima 5%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Ferramenta:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='ferramenta' id='ferramenta' class='inputTextobr'>";
            echo "<option value='1'"; if($set[ferramenta] == "1" ) echo " selected "; echo ">Ótima conservação 100%</option>";
            echo "<option value='2'"; if($set[ferramenta] == "2" ) echo " selected "; echo ">Boa conservação 80%</option>";
			echo "<option value='3'"; if($set[ferramenta] == "3" ) echo " selected "; echo ">Regular conservação 60%</option>";
			echo "<option value='4'"; if($set[ferramenta] == "4" ) echo " selected "; echo ">Ruim conservação 40%</option>";
			echo "<option value='5'"; if($set[ferramenta] == "5" ) echo " selected "; echo ">Muito ruim conservação 25%</option>";
			echo "<option value='6'"; if($set[ferramenta] == "6" ) echo " selected "; echo ">Péssima conservação 5%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Máq. e Equip.:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='maquina' id='maquina' class='inputTextobr'>";
            echo "<option value='1'"; if($set[maquina] == "1" ) echo " selected "; echo ">Ótima conservação 100%</option>";
            echo "<option value='2'"; if($set[maquina] == "2" ) echo " selected "; echo ">Boa conservação 80%</option>";
			echo "<option value='3'"; if($set[maquina] == "3" ) echo " selected "; echo ">Regular conservação 60%</option>";
			echo "<option value='4'"; if($set[maquina] == "4" ) echo " selected "; echo ">Ruim conservação 40%</option>";
			echo "<option value='5'"; if($set[maquina] == "5" ) echo " selected "; echo ">Muito ruim conservação 25%</option>";
			echo "<option value='6'"; if($set[maquina] == "6" ) echo " selected "; echo ">Péssima conservação 5%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
    
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Prev. Segurança:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='prevencao' id='prevencao' class='inputTextobr'>";
            echo "<option value='1'"; if($set[prevencao] == "1" ) echo " selected "; echo ">Ótima política 100%</option>";
            echo "<option value='2'"; if($set[prevencao] == "2" ) echo " selected "; echo ">Boa política 90%</option>";
			echo "<option value='3'"; if($set[prevencao] == "3" ) echo " selected "; echo ">Regular política 75%</option>";
			echo "<option value='4'"; if($set[prevencao] == "4" ) echo " selected "; echo ">Ruim política 50%</option>";
			echo "<option value='5'"; if($set[prevencao] == "5" ) echo " selected "; echo ">Muito ruim política 35%</option>";
			echo "<option value='6'"; if($set[prevencao] == "6" ) echo " selected "; echo ">Péssima política 25%</option>";
        echo "</select>";
    echo "</td>";
	echo "</tr>";
	
    echo "</table>";
	
	echo "<p>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
	echo "<td><b>Ambiente</b></td>";
	echo "</tr>";
	
	echo "<tr class='roundbordermix text'>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Ventilação:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='ventilacao' id='ventilacao' class='inputTextobr'>";
            echo "<option value='1'"; if($set[ventilacao] == "1" ) echo " selected "; echo ">Ótima 100%</option>";
            echo "<option value='2'"; if($set[ventilacao] == "2" ) echo " selected "; echo ">Boa 85%</option>";
			echo "<option value='3'"; if($set[ventilacao] == "3" ) echo " selected "; echo ">Regular 65%</option>";
			echo "<option value='4'"; if($set[ventilacao] == "4" ) echo " selected "; echo ">Ruim 40%</option>";
			echo "<option value='5'"; if($set[ventilacao] == "5" ) echo " selected "; echo ">Insuficiente 25%</option>";
			echo "<option value='6'"; if($set[ventilacao] == "6" ) echo " selected "; echo ">Péssima 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Temperatura:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='temperatura' id='temperatura' class='inputTextobr'>";
            echo "<option value='1'"; if($set[temperatura] == "1" ) echo " selected "; echo ">Ótima 100%</option>";
            echo "<option value='2'"; if($set[temperatura] == "2" ) echo " selected "; echo ">Boa 85%</option>";
			echo "<option value='3'"; if($set[temperatura] == "3" ) echo " selected "; echo ">Regular 65%</option>";
			echo "<option value='4'"; if($set[temperatura] == "4" ) echo " selected "; echo ">Ruim 40%</option>";
			echo "<option value='5'"; if($set[temperatura] == "5" ) echo " selected "; echo ">Insuficiente 25%</option>";
			echo "<option value='6'"; if($set[temperatura] == "6" ) echo " selected "; echo ">Péssima 15%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Nível do Ruído:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='ruido' id='ruido' class='inputTextobr'>";
            echo "<option value='1'"; if($set[ruido] == "1" ) echo " selected "; echo ">Abaixo da tolerância 100%</option>";
            echo "<option value='2'"; if($set[ruido] == "2" ) echo " selected "; echo ">Dentro da tolerância 85%</option>";
			echo "<option value='3'"; if($set[ruido] == "3" ) echo " selected "; echo ">Pouco acima da tolerância 65%</option>";
			echo "<option value='4'"; if($set[ruido] == "4" ) echo " selected "; echo ">Acima da tolerância 40%</option>";
			echo "<option value='5'"; if($set[ruido] == "5" ) echo " selected "; echo ">Muito acima da tolerância 25%</option>";
			echo "<option value='6'"; if($set[ruido] == "6" ) echo " selected "; echo ">Altíssimo 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Higiene:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='higiene' id='higiene' class='inputTextobr'>";
            echo "<option value='1'"; if($set[higiene] == "1" ) echo " selected "; echo ">Ótima 100%</option>";
            echo "<option value='2'"; if($set[higiene] == "2" ) echo " selected "; echo ">Boa 85%</option>";
			echo "<option value='3'"; if($set[higiene] == "3" ) echo " selected "; echo ">Regular 65%</option>";
			echo "<option value='4'"; if($set[higiene] == "4" ) echo " selected "; echo ">Ruim 40%</option>";
			echo "<option value='5'"; if($set[higiene] == "5" ) echo " selected "; echo ">Insuficiente 25%</option>";
			echo "<option value='6'"; if($set[higiene] == "6" ) echo " selected "; echo ">Péssima 15%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
    
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Agentes contaminantes:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='agentes' id='agentes' class='inputTextobr'>";
            echo "<option value='1'"; if($set[agentes] == "1" ) echo " selected "; echo ">Não existentes 100%</option>";
            echo "<option value='2'"; if($set[agentes] == "2" ) echo " selected "; echo ">Existentes não nocivos 85%</option>";
			echo "<option value='3'"; if($set[agentes] == "3" ) echo " selected "; echo ">Existentes controlados65%</option>";
			echo "<option value='4'"; if($set[agentes] == "4" ) echo " selected "; echo ">Existe em análise 40%</option>";
			echo "<option value='5'"; if($set[agentes] == "5" ) echo " selected "; echo ">Existe sem controle 25%</option>";
			echo "<option value='6'"; if($set[agentes] == "6" ) echo " selected "; echo ">Descontrole dos agentes 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "</tr>";
	
    echo "</table>";

    echo "<p>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
	echo "<td><b>Carga Física</b></td>";
	echo "</tr>";
	
	echo "<tr class='roundbordermix text'>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Gasto energético:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='energetico' id='energetico' class='inputTextobr'>";
            echo "<option value='1'"; if($set[energetico] == "1" ) echo " selected "; echo ">Tarefa moderada 100%</option>";
            echo "<option value='2'"; if($set[energetico] == "2" ) echo " selected "; echo ">Tarefa moderada repetitiva 75%</option>";
			echo "<option value='3'"; if($set[energetico] == "3" ) echo " selected "; echo ">Tarefa lenta repetitiva 65%</option>";
			echo "<option value='4'"; if($set[energetico] == "4" ) echo " selected "; echo ">Tarefa frenética repetitiva 45%</option>";
			echo "<option value='5'"; if($set[energetico] == "5" ) echo " selected "; echo ">Tarefa sedentária 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Manuseio de carga e transporte:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='transporte' id='transporte' class='inputTextobr'>";
            echo "<option value='1'"; if($set[transporte] == "1" ) echo " selected "; echo ">Tarefa moderada 100%</option>";
            echo "<option value='2'"; if($set[transporte] == "2" ) echo " selected "; echo ">Tarefa moderada repetitiva 75%</option>";
			echo "<option value='3'"; if($set[transporte] == "3" ) echo " selected "; echo ">Tarefa lenta repetitiva 65%</option>";
			echo "<option value='4'"; if($set[transporte] == "4" ) echo " selected "; echo ">Tarefa frenética repetitiva 45%</option>";
			echo "<option value='5'"; if($set[transporte] == "5" ) echo " selected "; echo ">Tarefa excessiva 15%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Deslocamento uso de escadas:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='escada' id='escada' class='inputTextobr'>";
            echo "<option value='1'"; if($set[escada] == "1" ) echo " selected "; echo ">Tarefa moderada 100%</option>";
            echo "<option value='2'"; if($set[escada] == "2" ) echo " selected "; echo ">Tarefa moderada repetitiva 75%</option>";
			echo "<option value='3'"; if($set[escada] == "3" ) echo " selected "; echo ">Tarefa lenta repetitiva 65%</option>";
			echo "<option value='4'"; if($set[escada] == "4" ) echo " selected "; echo ">Tarefa frenética repetitiva 45%</option>";
			echo "<option value='5'"; if($set[escada] == "5" ) echo " selected "; echo ">Tarefa excessiva 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Esforço repetitivo:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='esforco' id='esforco' class='inputTextobr'>";
            echo "<option value='1'"; if($set[esforco] == "1" ) echo " selected "; echo ">Tarefa moderada 100%</option>";
            echo "<option value='2'"; if($set[esforco] == "2" ) echo " selected "; echo ">Tarefa moderada repetitiva 75%</option>";
			echo "<option value='3'"; if($set[esforco] == "3" ) echo " selected "; echo ">Tarefa lenta repetitiva 65%</option>";
			echo "<option value='4'"; if($set[esforco] == "4" ) echo " selected "; echo ">Tarefa frenética repetitiva 45%</option>";
			echo "<option value='5'"; if($set[esforco] == "5" ) echo " selected "; echo ">Tarefa excessiva 15%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
    
    echo "</table>";
	
	echo "<p>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
	echo "<td><b>Carga Mental</b></td>";
	echo "</tr>";
	
	echo "<tr class='roundbordermix text'>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Exigência de tempo:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='exigencia' id='exigencia' class='inputTextobr'>";
            echo "<option value='1'"; if($set[exigencia] == "1" ) echo " selected "; echo ">Pouca exigência 100%</option>";
            echo "<option value='2'"; if($set[exigencia] == "2" ) echo " selected "; echo ">Exigência moderada 80%</option>";
			echo "<option value='3'"; if($set[exigencia] == "3" ) echo " selected "; echo ">Exigência eventual 65%</option>";
			echo "<option value='4'"; if($set[exigencia] == "4" ) echo " selected "; echo ">Muita exigência 35%</option>";
			echo "<option value='5'"; if($set[exigencia] == "5" ) echo " selected "; echo ">Exigência excessiva 10%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Complexidade de realização da tarefa:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='tarefa' id='tarefa' class='inputTextobr'>";
            echo "<option value='1'"; if($set[tarefa] == "1" ) echo " selected "; echo ">Pouca exigência 100%</option>";
            echo "<option value='2'"; if($set[tarefa] == "2" ) echo " selected "; echo ">Exigência moderada 70%</option>";
			echo "<option value='3'"; if($set[tarefa] == "3" ) echo " selected "; echo ">Exigência eventual 55%</option>";
			echo "<option value='4'"; if($set[tarefa] == "4" ) echo " selected "; echo ">Muita exigência 25%</option>";
			echo "<option value='5'"; if($set[tarefa] == "5" ) echo " selected "; echo ">Exigência excessiva 5%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Exigência de Atenção:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='atencao' id='atencao' class='inputTextobr'>";
            echo "<option value='1'"; if($set[atencao] == "1" ) echo " selected "; echo ">Pouca exigência 100%</option>";
            echo "<option value='2'"; if($set[atencao] == "2" ) echo " selected "; echo ">Exigência moderada 70%</option>";
			echo "<option value='3'"; if($set[atencao] == "3" ) echo " selected "; echo ">Exigência eventual 55%</option>";
			echo "<option value='4'"; if($set[atencao] == "4" ) echo " selected "; echo ">Muita exigência 25%</option>";
			echo "<option value='5'"; if($set[atencao] == "5" ) echo " selected "; echo ">Exigência excessiva 5%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Tarefa com Exigência de Realização Isolada:</b></td>";
	echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='isolada' id='isolada' class='inputTextobr'>";
            echo "<option value='1'"; if($set[isolada] == "1" ) echo " selected "; echo ">Sem exigência 100%</option>";
            echo "<option value='2'"; if($set[isolada] == "2" ) echo " selected "; echo ">Exigência moderada 75%</option>";
			echo "<option value='3'"; if($set[isolada] == "3" ) echo " selected "; echo ">Exigência eventual 60%</option>";
			echo "<option value='4'"; if($set[isolada] == "4" ) echo " selected "; echo ">Muita exigência 35%</option>";
			echo "<option value='5'"; if($set[isolada] == "5" ) echo " selected "; echo ">Exigência excessiva 15%</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
    
	echo "<tr>";
    echo "<td class='roundbordermix text' width=25% align=left><b>Necessidade de Fator Organização:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='necessidade' id='necessidade' class='inputTextobr'>";
            echo "<option value='1'"; if($set[necessidade] == "1" ) echo " selected "; echo ">Exigência moderada 100%</option>";
            echo "<option value='2'"; if($set[necessidade] == "2" ) echo " selected "; echo ">Pouca exigência 75%</option>";
			echo "<option value='3'"; if($set[necessidade] == "3" ) echo " selected "; echo ">Exigência eventual 60%</option>";
			echo "<option value='4'"; if($set[necessidade] == "4" ) echo " selected "; echo ">Muita exigência 35%</option>";
			echo "<option value='5'"; if($set[necessidade] == "5" ) echo " selected "; echo ">Exigência excessiva 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "<td class='roundbordermix text' width=25% align=left><b>Exigência de Requisitos para Exercício da Função:</b></td>";
    echo "<td align=left class='roundbordermix text' width=25%>";
        echo "<select name='requisito' id='requisito' class='inputTextobr'>";
            echo "<option value='1'"; if($set[requisito] == "1" ) echo " selected "; echo ">Sem exigência 100%</option>";
            echo "<option value='2'"; if($set[requisito] == "2" ) echo " selected "; echo ">Experiência técnica 75%</option>";
			echo "<option value='3'"; if($set[requisito] == "3" ) echo " selected "; echo ">Exigência técnica 35%</option>";
			echo "<option value='4'"; if($set[requisito] == "4" ) echo " selected "; echo ">Exigência superior 15%</option>";
        echo "</select>";
    echo "</td>";
	echo "</tr>";
	
    echo "</table>";
    
    echo "<p>";
    
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
                echo "<input type='submit' class='btn' name='btnSaveNewSetores' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\">";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";
    
    echo "</form>";
?>