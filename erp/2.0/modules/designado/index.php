<?PHP
if($_GET[remove]){
	$del = "DELETE FROM agenda_cipa_part WHERE id = {$_GET[remove]}";
	if(pg_query($connect, $del)){
		showmessage('Funcionário excluido do curso com sucesso!');
	}
}

//LISTA DOS FUNCIONÁRIOS NO CURSO
$query_edi = "SELECT a.*, f.nome_func, c.razao_social FROM agenda_cipa_part a, funcionarios f, cliente c
			 WHERE a.status = 0 AND a.cod_funcionario = f.cod_func AND a.cod_cliente = f.cod_cliente AND a.cod_cliente = c.cliente_id";
$result_edi = pg_query($connect, $query_edi);
$list = pg_fetch_array($result_edi);

//INSERT NA TABELA BT_TREINAMENTO
if($_GET[confirm]){
	$curso = "SELECT count(*) as x FROM bt_treinamento WHERE cod_curso = 13";
	$cur = pg_query($curso);
	$cc = pg_fetch_array($cur);
	//PEGA A QUANTIDADE DE REGISTROS E ARREDONDA PARA CIMA
	$fls = ceil($cc[x]/100);
	
	$mxm = "SELECT max(numero_certificado) as num FROM bt_treinamento";
	$max = pg_query($mxm);
	$mx = pg_fetch_array($max);
	$maxi = $mx[num] + 1;
	
	$enter = "INSERT INTO bt_treinamento
			 (cod_curso, numero_certificado, livro, folha, data_inicio, data_termino, cod_cliente, cod_filial, empresa, tipo_treinamento, nome_instrutor,
			 profissao_instrutor, cod_funcionario, data_criacao, reg_instrutor, cert_empresa)
			 VALUES
			 ({$list[cod_curso]}, ".($maxi+1).", 1, $fls, '$list[data_realizacao]', '$list[data_realizacao]', $list[cod_cliente], 1, '$list[razao_social]', 'Curso',
			 'Diuliane Cunha Marques', 'Técnico em Segurança do Trabalho', $list[cod_funcionario], '$list[data_inscricao]', 'RJ/11883 DSSD/SIT/MTE', $maxi)";
	if(pg_query($connect, $enter)){
		$updt = "UPDATE agenda_cipa_part SET
				status = 1 WHERE id = ".$_GET[confirm];
	pg_query($connect, $updt);
	}
	showmessage('Cadastro finalizado com sucesso!');
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
					//echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=edificacao&p=i_edif';\"  onmouseover=\"showtip('tipbox', '- Permite incluir uma edificação.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Agenda do Curso de Designado</b></td>";
        echo "</tr>";
        echo "</table>";
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=150><b>Nome:</b></td>";
        echo "<td align=left class='text' width=90><b>data:</b></td>";
        echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
		echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_edi);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=designado&p=a_designado&id={$list['id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list['nome_func']}</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=designado&p=a_designado&id={$list['id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>".date("d-m-Y", strtotime($list['data_realizacao']))."</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=designado&p=index&remove={$list['id']}' >Excluir</a></td>";
			echo "<td align=center class='text roundborder '><a href='?dir=designado&p=index&confirm={$list['id']}' >Finalizar</a></td>";
            echo "</tr>";
        }
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>