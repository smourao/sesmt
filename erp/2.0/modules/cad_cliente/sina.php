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
		/*if($_GET['seg_id']=="4"){
			echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
			echo "<tr>";
				echo "<td align=center class='text roundborderselected'><b>Localizar Produtos</b></td>";
			echo "</tr>";
			echo "</table>";
			
			echo "<form method='POST'>";
			echo "<table width=100% border=0 cellspacing=0 cellpadding=2>";
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Palavra chave:</td>";
				echo "<td class='text' height=30 align=left><input type=text name=word id=word value='{$_POST['word']}'></td>";
			echo "</tr>";
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Categoria:</td>";
				echo "<td class='text' height=30 align=left><select name=categori id=categori onchange=\"legendas_de_placas();\" style=\"width: 145px;\">
				<option></option>
				<option "; print $_POST['categoria'] == "Placas Segurança"? "selected":""; echo" value='Placas Segurança'>Placas Segurança</option>
				<option "; print $_POST['categoria'] == "Placas Reservado"? "selected":""; echo" value='Placas Reservado'>Placas Reservado</option>
				<option "; print $_POST['categoria'] == "Placas Radiação"? "selected":""; echo" value='Placas Radiação'>Placas Radiação</option>
				<option "; print $_POST['categoria'] == "Placas Proteja-se"? "selected":""; echo" value='Placas Proteja-se'>Placas Proteja-se</option>
				<option "; print $_POST['categoria'] == "Placas Perigo"? "selected":""; echo" value='Placas Perigo'>Placas Perigo</option>
				<option "; print $_POST['categoria'] == "Placas Pense"? "selected":""; echo" value='Placas Pense'>Placas Pense</option>
				<option "; print $_POST['categoria'] == "Placas Lembre-se"? "selected":""; echo" value='Placas Lembre-se'>Placas Lembre-se</option>
				<option "; print $_POST['categoria'] == "Placas Incêndio"? "selected":""; echo" value='Placas Incêndio'>Placas Incêndio</option>
				<option "; print $_POST['categoria'] == "Placas Importante"? "selected":""; echo" value='Placas Importante'>Placas Importante</option>
				<option "; print $_POST['categoria'] == "Placas Educação"? "selected":""; echo" value='Placas Educação'>Placas Educação</option>
				<option "; print $_POST['categoria'] == "Placas Economize"? "selected":""; echo" value='Placas Economize'>Placas Economize</option>
				<option "; print $_POST['categoria'] == "Placas Cuidado"? "selected":""; echo" value='Placas Cuidado'>Placas Cuidado</option>
				<option "; print $_POST['categoria'] == "Placas Aviso"? "selected":""; echo" value='Placas Aviso'>Placas Aviso</option>
				<option "; print $_POST['categoria'] == "Placas Atenção"? "selected":""; echo" value='Placas Atenção'>Placas Atenção</option>
				<option "; print $_POST['categoria'] == "Placa de Elevador"? "selected":""; echo" value='Placa de Elevador'>Placa de Elevador</option>
				<option "; print $_POST['categoria'] == "Cartões Temporários"? "selected":""; echo" value='Cartões Temporários'>Cartões Temporários</option>
				<option "; print $_POST['categoria'] == "Cavaletes"? "selected":""; echo" value='Cavaletes'>Cavaletes</option>
				<option "; print $_POST['categoria'] == "CIPA"? "selected":""; echo" value='CIPA'>CIPA</option>
				<option "; print $_POST['categoria'] == "Painel de Risco"? "selected":""; echo" value='Painel de Risco'>Painel de Risco</option>
				<option "; print $_POST['categoria'] == "Pedestal e Cone"? "selected":""; echo" value='Pedestal e Cone'>Pedestal e Cone</option>
				<option "; print $_POST['categoria'] == "Pictogramas"? "selected":""; echo" value='Pictogramas'>Pictogramas</option>
				<option "; print $_POST['categoria'] == "Placas Bilingüis"? "selected":""; echo" value='Placas Bilingüis'>Placas Bilingüis</option>
				<option "; print $_POST['categoria'] == "Placa de Aviso Ilustrada"? "selected":""; echo" value='Placas de Aviso Ilustradas'>Placas de Aviso Ilustradas</option>
				<option "; print $_POST['categoria'] == "Conservação de Energia"? "selected":""; echo" value='Conservação de Energia'>Placas de Conservação de Energia</option>
				<option "; print $_POST['categoria'] == "Placas de EPI"? "selected":""; echo" value='Placas de EPI'>Placas de EPI</option>
				<option "; print $_POST['categoria'] == "Placas de Higiene Ilustradas"? "selected":""; echo" value='Placas de Higiene Ilustradas'>Placas de Higiene Ilustradas</option>
				<option "; print $_POST['categoria'] == "Identificação de Andar"? "selected":""; echo" value='Identificação de Andar'>Placas de Identificação de Andar</option>
				<option "; print $_POST['categoria'] == "Identificação de Área"? "selected":""; echo" value='Identificação de Área'>Placas de Identificação de Área</option>
				<option "; print $_POST['categoria'] == "Placas de Meio Ambiente"? "selected":""; echo" value='Placas de Meio Ambiente'>Placas de Meio Ambiente</option>
				<option "; print $_POST['categoria'] == "Placas de Orientação de Veículos"? "selected":""; echo" value='Placas de Orientação de Veículos'>Placas de Orientação de Veículos</option>
				<option "; print $_POST['categoria'] == "Placa de Reciclagem"? "selected":""; echo" value='Placa de Reciclagem'>Placas de Reciclagem</option>
				<option "; print $_POST['categoria'] == "Placas de Risco"? "selected":""; echo" value='Placas de Risco'>Placas de Risco</option>
				<option "; print $_POST['categoria'] == "Placas de Risco de Fogo Internacional"? "selected":""; echo" value='Placas de Risco de Fogo Internacional'>Placas de Risco de Fogo Internacional</option>
				<option "; print $_POST['categoria'] == "Placas de Saúde"? "selected":""; echo" value='Placas de Saúde'>Placas de Saúde</option>
				<option "; print $_POST['categoria'] == "Sinalização Urbana e Rodoviária"? "selected":""; echo" value='Sinalização Urbana e Rodoviária'>Placas de Sinalização Urbana e Rodoviária</option>
				<option "; print $_POST['categoria'] == "Placa de Uso Obrigatório"? "selected":""; echo" value='Placa de Uso Obrigatório'>Placas de Uso Obrigatório</option>
				<option "; print $_POST['categoria'] == "Placas Dobráveis"? "selected":""; echo" value='Placas Dobráveis'>Placas Dobráveis</option>
				<option "; print $_POST['categoria'] == "Placas Ilustradas Conjugadas"? "selected":""; echo" value='Placas Ilustradas Conjugadas'>Placas Ilustradas Conjugadas</option>
				<option "; print $_POST['categoria'] == "Placas Tríplice"? "selected":""; echo" value='Placas Tríplice'>Placas Tríplice</option>
				<option "; print $_POST['categoria'] == "Setas Indicativas"? "selected":""; echo" value='Setas Indicativas'>Setas Indicativas</option>
				<option "; print $_POST['categoria'] == "Eletricidade"? "selected":""; echo" value='Eletricidade'>Sinalização de Eletricidade</option>
				<option "; print $_POST['categoria'] == "Sinalização de Incêndio"? "selected":""; echo" value='Sinalização de Incêndio'>Sinalização de Incêndio</option>
				<option "; print $_POST['categoria'] == "Rota de Incêndio"? "selected":""; echo" value='Rota de Incêndio'>Sinalização de Rota de Incêndio</option>
				<option "; print $_POST['categoria'] == "Educativa e Educativa Ilustrada"? "selected":""; echo" value='Educativa e Educativa Ilustrada'>Sinalização Educativa e Educativa Ilustrada</option>
				</select> </td>";
			echo "</tr>";
		
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Material:</td>";
				echo "<td class='text' height=30 align=left><select name=material style=\"width: 145px;\">
				<option></option>
				<option "; print $_POST['material'] == "PVC"? "selected":""; echo">PVC</option>
				<option "; print $_POST['material'] == "Poliestireno"? "selected":""; echo">Poliestireno</option>
				<option "; print $_POST['material'] == "Alumínio"? "selected":""; echo">Alumínio</option>
				<option "; print $_POST['material'] == "Acrílico"? "selected":""; echo">Acrílico</option>
				<option "; print $_POST['material'] == "Vinil"? "selected":""; echo">Vinil</option>
				</select> </td>";
			echo "</tr>";
		
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Espessura:</td>";
				echo "<td class='text' height=30 align=left><select name=espessura style=\"width: 145px;\">
				<option></option>
				<option "; print $_POST['espessura'] == "1mm"? "selected":""; echo">1mm</option>
				<option "; print $_POST['espessura'] == "2mm"? "selected":""; echo">2mm</option>
				<option "; print $_POST['espessura'] == "3mm"? "selected":""; echo">3mm</option>
				<option "; print $_POST['espessura'] == "0,50mm"? "selected":""; echo">0,50mm</option>
				</select> </td>";
			echo "</tr>";
		
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Acabamento:</td>";
				echo "<td class='text' height=30 align=left><select name=acabamento style=\"width: 145px;\">
				<option></option>
				<option "; print $_POST['acabamento'] == "Brilhante"? "selected":""; echo">Brilhante</option>
				<option "; print $_POST['acabamento'] == "Fosco"? "selected":""; echo">Fosco</option>
				<option "; print $_POST['acabamento'] == "Fosforescente"? "selected":""; echo">Fosforescente</option>
				<option "; print $_POST['acabamento'] == "Fluorescente"? "selected":""; echo">Fluorescente</option>
				</select> </td>";
			echo "</tr>";
		
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Tamanho:</td>";
				echo "<td class='text' height=30 align=left><select name=tamanho style=\"width: 145px;\">
				<option></option>
				<option "; print $_POST['tamanho'] == "0.01 x 0.02"? "selected":""; echo">0.01 x 0.02</option>
				<option "; print $_POST['tamanho'] == "0.025 x 0.045"? "selected":""; echo">0.025 x 0.045</option>
				<option "; print $_POST['tamanho'] == "0.05 x 0.07"? "selected":""; echo">0.05 x 0.07</option>
				<option "; print $_POST['tamanho'] == "0.05 x 0.15"? "selected":""; echo">0.05 x 0.15</option>
				<option "; print $_POST['tamanho'] == "0.06 x 0.12"? "selected":""; echo">0.06 x 0.12</option>
				<option "; print $_POST['tamanho'] == "0.08 x 0.02"? "selected":""; echo">0.08 x 0.02</option>
				<option "; print $_POST['tamanho'] == "0.08 x 0.06"? "selected":""; echo">0.08 x 0.06</option>
				<option "; print $_POST['tamanho'] == "0.08 x 0.12"? "selected":""; echo">0.08 x 0.12</option>
				<option "; print $_POST['tamanho'] == "0.08 x 0.17"? "selected":""; echo">0.08 x 0.17</option>
				<option "; print $_POST['tamanho'] == "0.1 x 0.18"? "selected":""; echo">0.1 x 0.18</option>
				<option "; print $_POST['tamanho'] == "0.1 x 0.2"? "selected":""; echo">0.1 x 0.2</option>
				<option "; print $_POST['tamanho'] == "0.1 x 0.3"? "selected":""; echo">0.1 x 0.3</option>
				<option "; print $_POST['tamanho'] == "0.11 x 0.25"? "selected":""; echo">0.11 x 0.25</option>
				<option "; print $_POST['tamanho'] == "0.12 x 0.35"? "selected":""; echo">0.12 x 0.35</option>
				<option "; print $_POST['tamanho'] == "0.15 x 0.15"? "selected":""; echo">0.15 x 0.15</option>
				<option "; print $_POST['tamanho'] == "0.15 x 0.3"? "selected":""; echo">0.15 x 0.3</option>
				<option "; print $_POST['tamanho'] == "0.17 x 0.24"? "selected":""; echo">0.17 x 0.24</option>
				<option "; print $_POST['tamanho'] == "0.17 x 0.27"? "selected":""; echo">0.17 x 0.27</option>
				<option "; print $_POST['tamanho'] == "0.17 x 0.47"? "selected":""; echo">0.17 x 0.47</option>
				<option "; print $_POST['tamanho'] == "0.18 x 0.18"? "selected":""; echo">0.18 x 0.18</option>
				<option "; print $_POST['tamanho'] == "0.19 x 0.13"? "selected":""; echo">0.19 x 0.13</option>
				<option "; print $_POST['tamanho'] == "0.19 x 0.25"? "selected":""; echo">0.19 x 0.25</option>
				<option "; print $_POST['tamanho'] == "0.19 x 0.38"? "selected":""; echo">0.19 x 0.38</option>
				<option "; print $_POST['tamanho'] == "0.2 x 0.2"? "selected":""; echo">0.2 x 0.2</option>
				<option "; print $_POST['tamanho'] == "0.2 x 0.4"? "selected":""; echo">0.2 x 0.4</option>
				<option "; print $_POST['tamanho'] == "0.22 x 0.35"? "selected":""; echo">0.22 x 0.35</option>
				<option "; print $_POST['tamanho'] == "0.23 x 0.67"? "selected":""; echo">0.23 x 0.67</option>
				<option "; print $_POST['tamanho'] == "0.24 x 0.34"? "selected":""; echo">0.24 x 0.34</option>
				<option "; print $_POST['tamanho'] == "0.25 x 0.19"? "selected":""; echo">0.25 x 0.19</option>
				<option "; print $_POST['tamanho'] == "0.25 x 0.45"? "selected":""; echo">0.25 x 0.45</option>
				<option "; print $_POST['tamanho'] == "0.27 x 0.17"? "selected":""; echo">0.27 x 0.17</option>
				<option "; print $_POST['tamanho'] == "0.27 x 0.37"? "selected":""; echo">0.27 x 0.37</option>
				<option "; print $_POST['tamanho'] == "0.3 x 0.23"? "selected":""; echo">0.3 x 0.23</option>
				<option "; print $_POST['tamanho'] == "0.3 x 0.3"? "selected":""; echo">0.3 x 0.3</option>
				<option "; print $_POST['tamanho'] == "0.3 x 0.4"? "selected":""; echo">0.3 x 0.4</option>
				<option "; print $_POST['tamanho'] == "0.3 x 0.5"? "selected":""; echo">0.3 x 0.5</option>
				<option "; print $_POST['tamanho'] == "0.37 x 0.27"? "selected":""; echo">0.37 x 0.27</option>
				<option "; print $_POST['tamanho'] == "0.37 x 0.47"? "selected":""; echo">0.37 x 0.47</option>
				<option "; print $_POST['tamanho'] == "0.4 x 0.11"? "selected":""; echo">0.4 x 0.11</option>
				<option "; print $_POST['tamanho'] == "0.4 x 0.4"? "selected":""; echo">0.4 x 0.4</option>
				<option "; print $_POST['tamanho'] == "0.47 x 0.37"? "selected":""; echo">0.47 x 0.37</option>
				<option "; print $_POST['tamanho'] == "0.47 x 0.67"? "selected":""; echo">0.47 x 0.67</option>
				<option "; print $_POST['tamanho'] == "0.5 x 0.29"? "selected":""; echo">0.5 x 0.29</option>
				<option "; print $_POST['tamanho'] == "0.5 x 0.5"? "selected":""; echo">0.5 x 0.5</option>
				<option "; print $_POST['tamanho'] == "0.6 x 0.15"? "selected":""; echo">0.6 x 0.15</option>
				<option "; print $_POST['tamanho'] == "0.6 x 0.6"? "selected":""; echo">0.6 x 0.6</option>
				<option "; print $_POST['tamanho'] == "0.67 x 0.47"? "selected":""; echo">0.67 x 0.47</option>
				<option "; print $_POST['tamanho'] == "0.67 x 0.97"? "selected":""; echo">0.67 x 0.97</option>
				<option "; print $_POST['tamanho'] == "0.7 x 1"? "selected":""; echo">0.7 x 1</option>
				<option "; print $_POST['tamanho'] == "0.7 x 1.2"? "selected":""; echo">0.7 x 1.2</option>
				<option "; print $_POST['tamanho'] == "0.75 x 0.4"? "selected":""; echo">0.75 x 0.4</option>
				<option "; print $_POST['tamanho'] == "0.8 x 0.25"? "selected":""; echo">0.8 x 0.25</option>
				<option "; print $_POST['tamanho'] == "0.8 x 0.8"? "selected":""; echo">0.8 x 0.8</option>
				<option "; print $_POST['tamanho'] == "1 x 1"? "selected":""; echo">1 x 1</option>
				<option "; print $_POST['tamanho'] == "1 x 1.2"? "selected":""; echo">1 x 1.2</option>
				<option "; print $_POST['tamanho'] == "1 x 1.5"? "selected":""; echo">1 x 1.5</option>
				<option "; print $_POST['tamanho'] == "1 x 2"? "selected":""; echo">1 x 2</option>
				</select> </td>";
			echo "</tr>";
		
			echo "<tr class='roundbordermix text'>";
				echo "<td class='text' height=30 align=left>Legenda:</td>";
				echo "<td class='text' height=30 align=left><select name=leg id=leg style=\"width: 145px;\"><option value='Sem Legenda'></option>";
			
				if($_POST['leg']){
				   echo "<option value='{$_POST['leg']}'>{$_POST['leg']}</option>";
				}
				
				echo "</select>	</td>";
			echo "</tr>";
		
			echo "</table>";
		
			echo "<center><input type=submit value=Procurar></center>";
		
			echo "</form>";
		}*/
               				
		echo "<P>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td align=center class='text roundborderselected'><b>Opções</b></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='butvol' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}';\"  onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para a tela de edição de orçamento.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
	/*	
	if($_POST){
        if($_POST[word]){
           if(is_numeric($_POST['word'])){
              $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND cod_prod ='{$_POST['word']}'";
           }else{
              $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
              (
			  LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categori'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              OR
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['categori'])."%".strtolower($_POST['word'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              )";
           }
        }else{
            $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
              (
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categori'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              OR
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['categori'])."%".strtolower($_POST['word'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              )";
        }
        $result = pg_query($sql);
        $buffer = pg_fetch_all($result);

		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
		echo "<b>Produto(s) encontrado(s)</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text' width=20><b>Adicionar</b></td>";
		echo "<td align=left class='text'><b>Descrição</b></td>";
		echo "<td align=left class='text' width=5><b>Quant.</b></td>";
		echo "</tr>";
		
		for($i=0;$i<pg_num_rows($result);$i++){
			if($buffer[$i]['g_max'] != "" && $buffer[$i]['g_min'] !=""){
				$grup = "<br>[<b>Grupo:</b> {$buffer[$i]['g_min']} à {$buffer[$i]['g_max']}.]";
			}else{
				$grup = "";
			}
			
			echo "<form name=formqtd method=post action='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&cod={$buffer[$i][cod_prod]}'>";
			echo "<tr class='text roundbordermix'>";
			echo "<td align=left class='text roundborder' ><input type='submit' class='btn' name='btnqtd' value='Adicionar' style=\"width: 60px;\"></td>";
			echo "<td align=justify class='text roundborder curhand'>{$buffer[$i]['desc_detalhada_prod']} {$grup}</td>";
			echo "<td align=left class='text roundborder' ><input type='text' name='quantidade' id='quantidade' size=3></td>";
			echo "</tr>";
			echo "</form>";	
		}
		echo "</table>";
	}
 */
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
            echo "<select class='inputTextobr' style=\"width: 220px;\" name=categoria id=categoria onchange=\"cgrt_sina_get_material(this.options[this.selectedIndex].text);\">";
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
        //echo "- Não é obrigatório o preenchimento de todos os campos acima para realizar uma busca.<BR>";
        
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