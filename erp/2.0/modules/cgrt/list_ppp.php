<?PHP

if(is_numeric($_GET[cod_cliente])){

    $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_GET[cod_cliente]);

    $result = pg_query($sql);

    $cinfo = pg_fetch_array($result);

}



echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";

echo "<tr>";

/**************************************************************************************************/

// -->  LEFT SIDE STEP OF PPRA!!!

/**************************************************************************************************/

     echo "<td width=250 class='text roundborder' valign=top>";

/* --> [ STEP 0 ] *********************************************************************************/

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                echo "<td align=center class='text roundborderselected'>";

                    echo "<b>Busca</b>";

                echo "</td>";

                echo "</tr>";

                echo "</table>";



                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                echo "<form method=POST name='form1' action='?dir=cgrt&p=index'>";

                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para visualizar os relatórios gerados.');\" onmouseout=\"hidetip('tipbox');\">";

                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";

                        echo "&nbsp;";

                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";

                    echo "</td>";

                echo "</form>";

                echo "</tr>";

                echo "</table>";

                echo "<P>";

                

                $sMonth = $_GET[sMonth] > 0 && $_GET[sMonth] < 13 ? $_GET[sMonth] : date("m");

                $sYear  = is_numeric($_GET[sYear]) ? $_GET[sYear] : date("Y");

                

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                echo "<td align=center class='text roundborderselected'>";

                    echo "<b>Busca por data</b>";

                echo "</td>";

                echo "</tr>";

                echo "</table>";



                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Selecione o mês, informe o ano de referência e clique em Busca para visualizar os relatórios gerados.');\" onmouseout=\"hidetip('tipbox');\">";

                        echo "<table border=0 width=100% align=center>";

                        echo "<tr>";

                        echo "<td width=35 class='text'><b>Mês</b></td>";

                        echo "<td class='text'>";

                        echo "<select name='sMonth' id='sMonth'>";

                            echo "<option value='01'"; print $sMonth == 1 ? " selected ":""; echo ">Janeiro</option>";

                            echo "<option value='02'"; print $sMonth == 2 ? " selected ":""; echo ">Fevereiro</option>";

                            echo "<option value='03'"; print $sMonth == 3 ? " selected ":""; echo ">Março</option>";

                            echo "<option value='04'"; print $sMonth == 4 ? " selected ":""; echo ">Abril</option>";

                            echo "<option value='05'"; print $sMonth == 5 ? " selected ":""; echo ">Maio</option>";

                            echo "<option value='06'"; print $sMonth == 6 ? " selected ":""; echo ">Junho</option>";

                            echo "<option value='07'"; print $sMonth == 7 ? " selected ":""; echo ">Julho</option>";

                            echo "<option value='08'"; print $sMonth == 8 ? " selected ":""; echo ">Agosto</option>";

                            echo "<option value='09'"; print $sMonth == 9 ? " selected ":""; echo ">Setembro</option>";

                            echo "<option value='10'"; print $sMonth == 10 ? " selected ":""; echo ">Outubro</option>";

                            echo "<option value='11'"; print $sMonth == 11 ? " selected ":""; echo ">Novembro</option>";

                            echo "<option value='12'"; print $sMonth == 12 ? " selected ":""; echo ">Dezembro</option>";

                        echo "</select>";

                        echo "</td>";

                        

                        echo "<td rowspan=2 align=center class='text'>";

                        echo "<input type='button' class='btn' name='btnSearch2' value='Busca' onclick=\"if(document.getElementById('sYear').value==''){return false;}else{location.href='?dir=$_GET[dir]&p=$_GET[p]&sYear=' + document.getElementById('sYear').value + '&sMonth=' + document.getElementById('sMonth').options[document.getElementById('sMonth').selectedIndex].value;}\">";

                        echo "</td>";

                        

                        echo "</tr><tr>";

                        echo "<td class='text'><b>Ano</b></td>";

                        echo "<td class='text'>";

                        echo "<input type='text' class='inputText' name='sYear' id='sYear' value='{$sYear}' size=5 maxlength=4>";

                        echo "</td>";

                        echo "</tr>";



                        echo "</table>";

                        

                    echo "</td>";

                echo "</tr>";

                echo "</table>";

                echo "<P>";

                

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                echo "<td align=center class='text roundborderselected'>";

                    echo "<b>Opções</b>";

                echo "</td>";

                echo "</tr>";

                echo "</table>";



                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                    echo "<td class='roundbordermix text' height=30 align=left>";

                        echo "<table width=100% border=0>";

                        echo "<tr>";

echo "<td class='text' align=center><input type='button' class='btn' name='butVtr' value='Voltar' onclick=\"location.href='?dir=cgrt&p=index'";

					echo ";\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para a tela anterior.');\" onmouseout=\"hidetip('tipbox');\"></td>";                        

					echo "</tr>";

                        echo "</table>";

                    echo "</td>";

                echo "</tr>";

                echo "</table>";

                echo "<P>";

                // --> TIPBOX

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";

                echo "<tr>";

                    echo "<td class=text height=30 valign=top align=justify>";

                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";

                    echo "</td>";

                echo "</tr>";

                echo "</table>";

/**************************************************************************************************/

// -->  RIGHT SIDE STEP OF PPRA!!!

/**************************************************************************************************/

    echo "<td class='text roundborder' valign=top>";



if($_GET[sMonth]){

if($_POST || $_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

    $searchtxt = anti_injection($_POST[search]);

    if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

    //Busca por Mês e Ano

        $sql = "SELECT

                    i.*, c.*

                FROM

                    cgrt_info i, cliente c

                WHERE

                    i.cod_cliente = c.cliente_id

                AND

                    i.ano = {$_GET[sYear]}

                AND

                    EXTRACT(month FROM data_criacao) = '{$_GET[sMonth]}'

                ";

    }else{

    //Busca por texto ou cód cliente
	
	$clienteppp = $_GET["cod_cliente"];

        if(is_numeric($searchtxt)){

            $sql = "SELECT

                        i.cod_cgrt, i.ano, c.cliente_id, c.razao_social

                    FROM

                        cgrt_info i, cliente c

                    WHERE

                        i.cod_cliente = c.cliente_id
						
					AND

						c.cliente_id = $clienteppp	

                    AND(

                        c.cliente_id = $searchtxt

                    OR

                        lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'

                    )

					ORDER BY i.ano desc";

        }else{

            $sql = "SELECT

                        i.cod_cgrt, i.ano, c.cliente_id, c.razao_social

                    FROM

                        cgrt_info i, cliente c

                    WHERE

                        i.cod_cliente = c.cliente_id

                    AND

						c.cliente_id = $clienteppp	

                    AND

                        lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'

					ORDER BY i.ano desc";

        }

    }

    $result = pg_query($sql);

    $clist = pg_fetch_all($result);

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        if($_POST[search]){

            echo "<b>Resultado de busca por</b> $searchtxt";

        }elseif($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

            echo "<b>Resultado de busca por data</b> ".$_GET[sMonth]."/".$_GET[sYear];

        }



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

    if(@pg_num_rows($result)>0){

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=40 align=left class='text'>";

				echo "<b>CGRT</b>";

				echo "</td>";

                echo "<td align=left class='text'>";

                echo "<b>Empresa</b>";

                echo "</td>";

                echo "<td width=40 align=left class='text'>";

                echo "<b>Ano</b>";

                echo "</td>";

                echo "<td width=240 colspan=5 align=left class='text'>";

                echo "<b>Relatórios</b>";

                echo "</td>";

            echo "</tr>";

        for($x=0;$x<pg_num_rows($result);$x++){

                echo "<tr>";

                echo "<td align=left class='text roundbordermix curhand' alt='{$clist[$x][cod_cgrt]}' title='{$clist[$x][cod_cgrt]}' onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";

                    echo str_pad($clist[$x][cod_cgrt], 3, '0', 0);

                echo "</td>";

				echo "<td align=left class='text roundbordermix curhand' alt='{$clist[$x][razao_social]}' title='{$clist[$x][razao_social]}' onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";

                    echo substr($clist[$x][razao_social], 0, 45);

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";

                    echo $clist[$x][ano];

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'PPRA - Exibe o relatório do Programa de Prevenção de Riscos Ambientais.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/ppra/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."');\">";

                    echo "PPRA";

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=list_ppp&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";

                    echo "PPP";

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'PCMSO - Exibe o relatório do Programa de Controle Médico de Saúde Ocupacional.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/pcmso/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."');\">";

                    echo "PCMSO";

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'APGRE - Exibe o relatório da Avaliação Preliminar e Gerenciamento de Riscos Ergonômicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/apgre/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."')\">";

                    echo "APGRE";

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";

                    echo "LTCAT";

                echo "</td>";

                echo "<td width=40 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";

                    echo "PCMAT";

                echo "</td>";

                echo "</tr>";

        }

        echo "</table>";

    }else{

    //caso não seja encontrado nenhum registro

        if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

            echo "Não foram encontrados registros para a data informada.";

        }else{

            echo "Não foram encontrados relatórios para o termo informado.";

        }

    }

    echo "<td>";

    echo "</tr>";

    echo "</table>";

}else{



    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        echo "<b>Busca por relatórios</b>";

    echo "</td>";

    echo "</tr>";

    echo "</table>";

}

}else{

$cliente = $_GET["cod_cliente"];



if($_GET[cod_cliente] != '' && !$_POST){

	 $query_razao = "select nome_func, cod_func, cod_cliente, cod_setor

	 				from funcionarios

					WHERE cod_cliente = $cliente";

}

else

{

   if(is_numeric($_POST[pesq])){

	  $query_razao = "select nome_func, cod_func, cod_cliente, cod_setor

					  from funcionarios

					  WHERE cod_cliente = $_POST[pesq]";

   }else{

	  $query_razao = "select f.nome_func, f.cod_func, f.cod_func, f.cod_cliente, f.cod_setor

					  from funcionarios f, cliente c

					  WHERE f.cod_cliente = c.cliente_id

					  AND lower(razao_social) like '%".strtolower(addslashes($pesq))."%'";

   }

}

$query_razao.=" ORDER BY nome_func";





?>

<table width=100% border=0 cellspacing=2 cellpadding=2>

    <tr>

    <td align=center class='text roundborderselected' width=100%>

            <b>Lista de funcionários para PPP </b>

    </td>

    </tr>

</table>

<table width=100% border=0 cellspacing=2 cellpadding=2>

  <tr>

    <td  width="100%" class="text" align="center" height="30"><b><?php echo $cinfo[razao_social]; ?></b></td>

  </tr>

<?php

$sql = "SELECT

			i.cod_cgrt, i.ano, c.cliente_id, c.razao_social

		FROM

			cgrt_info i, cliente c

		WHERE

			i.cod_cliente = ".(int)($_GET[cod_cliente])."

		AND

			lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'

		ORDER BY i.ano desc";

$result = pg_query($sql);

$clist = pg_fetch_all($result);



if (!empty($query_razao)){

	$result_razao = pg_query($query_razao) or die

		("erro na query!" .pg_last_error($connect));



	while($row=pg_fetch_array($result_razao)){



echo "<tr>

   <td  class='text roundbordermix curhand' align=left  onclick=\"newWindow('".current_module_path."relatorios/ppp/?cliente=".base64_encode((int)($row[cod_cliente]))."&setor=".base64_encode((int)($row[cod_setor]))."&funcionario=".base64_encode((int)($row[cod_func]))."&cod_cgrt=".base64_encode((int)($clist[0][cod_cgrt]))."');\">&nbsp;$row[nome_func]</td>

	 </tr>";

	}

}

  $fecha = pg_close($connect);

?>

</table>

<?php

}

/**************************************************************************************************/

// -->

/**************************************************************************************************/

    echo "</td>";

echo "</tr>";

echo "</table>";

?>