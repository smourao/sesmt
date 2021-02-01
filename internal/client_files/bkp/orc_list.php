<img src='images/sub-lista-orcamento.jpg' border=0>
<div class='novidades_text'>
<p align=justify>
A lista abaixo exibe todos os or�amentos gerados at� o momento. � poss�vel a visualiza��o, edi��o e exclus�o desde que
o or�amento em quest�o n�o tenha sido aprovado.
<?php
$csql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente])." ";
$cquery = pg_query($csql);
$carray = pg_fetch_array($cquery);			

if($carray[cliente_ativo] == 0){
echo "
<p align=justify>
Apenas s�o liberados para visualiza��o, edi��o ou exclus�o os or�amentos revisados pelo nosso setor t�cnico, ap�s gerar o or�amento aguarde at� que nossa equipe revise e libere o mesmo para visualiza��o.";
}
?>
<p align=justify>
Para aprovar um or�amento, clique no �cone <img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'>
que corresponde ao or�amento que deseja aprovar. Uma vez aprovado, caso necess�rio, o or�amento � automaticamente
inserido como adendo ao contrato vigente.

</div>
<?PHP
if(!$_GET[sa]){
    //$sql = "SELECT o.* FROM site_orc_info o WHERE o.cod_cliente = ".(int)($_SESSION[cod_cliente])." ORDER BY data_criacao, cod_orcamento";
    $sql = "SELECT o.*, g.status FROM site_orc_info o LEFT JOIN site_gerar_contrato g ON o.cod_orcamento = g.cod_orcamento WHERE o.cod_cliente = ".(int)($_SESSION[cod_cliente])." ORDER BY o.data_criacao, o.cod_orcamento";
    $res = pg_query($sql);
    $orc = pg_fetch_all($res);

    echo "<center><input type=button value='Criar novo or�amento' onclick=\"location.href='?do=orcamentos&act=list&sa=add_orc';\"></center>";


    echo "<p /><table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center width=60>C�digo</td>";
        echo "<td class='bgTitle' align=center>Status</td>";
        echo "<td class='bgTitle' align=center width=100>Gerado em</td>";
        echo "<td class='bgTitle' align=center width=100>Op��es</td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($res);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
		
        echo "<tr height = 30>";
            echo "<td class='$bgclass' align=center>{$orc[$x][cod_orcamento]}</td>";
            echo "<td class='$bgclass' align=left>";
                if($orc[$x][status]==1){
                    echo "Contrato gerado com base neste or�amento.";
                }else{
                    if($orc[$x][aprovado]){
                        echo "Or�amento aprovado.";
                    }else{
                        if($orc[$x][orc_request_time_sended]){
                            echo "Aguardando aprova��o do or�amento."; //enviado ao cliente
                        }else{
							if($carray[cliente_ativo] == 0)
								echo "Aguardando Libera��o do setor t�cnico.";
							else
                            	echo "Aguardando aprova��o do or�amento."; //aguardando envio
                        }
                    }
                }
            echo "</td>";
            echo "<td class='$bgclass' align=center>".date("d/m/Y", strtotime($orc[$x][data_criacao]))."</td>";
            echo "<td class='$bgclass' align=center>";
			
			//verifica se or�amento ja foi revisado
			if($carray[cliente_ativo] == 1 || ($orc[$x][orc_request_time_sended] || $orc[$x][aprovado])){
			
                        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
                        echo "<tr>";
                        //$sql = "SELECT id FROM site_orc_produto WHERE cod_orcamento = ".(int)($orc[$x][cod_orcamento]);
                        $sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE cod_orcamento = ".(int)($orc[$x][cod_orcamento])." AND op.cod_produto = p.cod_prod";

                        //CONFIRM
                        if(pg_num_rows(pg_query($sql)) && !$orc[$x][aprovado])
                            echo "<td width=20 align=center><a href='?do=orcamentos&act=confirm&cod_orc={$orc[$x][cod_orcamento]}'><img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'></a></td>";
                        else
                            echo "<td width=20 align=center>&nbsp;</td>";
                            
                        //VIEW
                        echo "<td width=20 align=center><a href='?do=orcamentos&act=view&cod_orc={$orc[$x][cod_orcamento]}'><img src='images/ico-view.png' border=0 alt='Visualizar or�amento' title='Visualizar or�amento'></a></td>";

                        //EDIT
                        if($orc[$x][status] || $orc[$x][aprovado])
                            echo "<td width=20 align=center>&nbsp;</td>";
                        else
                            echo "<td width=20 align=center><a href='?do=orcamentos&act=edit&cod_orc={$orc[$x][cod_orcamento]}'><img src='images/ico-edit.png' border=0 alt='Editar or�amento' title='Editar or�amento'></a></td>";

                        //DELETE
                        if($orc[$x][status] || $orc[$x][aprovado])
                            echo "<td width=20 align=center>&nbsp;</td>";
                        else
                            echo "<td width=20 align=center><a href='?do=orcamentos&act=del&cod_orc={$orc[$x][cod_orcamento]}' onclick=\"if(!confirm('Tem certeza que deseja excluir este or�amento?','')){ return false;}\"><img src='images/ico-del.png' border=0 alt='Excluir or�amento' title='Excluir or�amento'></a></td>";

                        echo "</tr>";
                        echo "</table>";
			}

            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<BR>";
    echo "<b>Legenda:</b>";
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
    echo "<td width=25><img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'></td><td><font size=1>Aprovar or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar or�amento' title='Visualizar or�amento'></td><td><font size=1>Visualizar or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-edit.png' border=0 alt='Editar or�amento' title='Editar or�amento'></td><td><font size=1>Editar or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir or�amento' title='Excluir or�amento'></td><td><font size=1>Excluir or�amento.</font></td>";
    echo "</tr>";
    echo "</table>";
}elseif($_GET[sa] == 'add_orc'){
    echo "<img src='images/sub-novo-orcamento.jpg' border=0>";
    //$sql = "SELECT i.cod_orcamento, count(p.cod_produto) as n FROM site_orc_info i LEFT JOIN site_orc_produto p ON p.cod_orcamento = i.cod_orcamento WHERE i.cod_cliente = ".(int)($_SESSION[cod_cliente])." GROUP BY i.cod_orcamento ORDER BY cod_orcamento";
    $sql = "SELECT * FROM site_orc_info WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND cod_orcamento NOT IN (SELECT cod_orcamento FROM site_orc_produto WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]).") ORDER BY cod_orcamento";
    $rlp = pg_query($sql);
    if(pg_num_rows($rlp)){
        $lorc = pg_fetch_all($rlp);
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Existem or�amentos criados que ainda n�o foram utilizados e n�o possuem items, por favor, utilize
        um dos or�amentos vazios listados abaixo:<BR>";
        echo "</div>";
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<tr>";
            echo "<td class='bgTitle' align=center width=60>C�digo</td>";
            echo "<td class='bgTitle' align=center width=100>Gerado em</td>";
            echo "<td class='bgTitle' align=center width=100>Op��es</td>";
        echo "</tr>";
        for($x=0;$x<pg_num_rows($rlp);$x++){
            if($x%2)
                $bgclass = 'bgContent1';
            else
                $bgclass = 'bgContent2';
            echo "<td class='$bgclass' align=center><a href='?do=orcamentos&act=edit&cod_orc={$lorc[$x][cod_orcamento]}'>".str_pad($lorc[$x][cod_orcamento], 4, "0",0)."</a></td>";
            echo "<td class='$bgclass' align=center><a href='?do=orcamentos&act=edit&cod_orc={$lorc[$x][cod_orcamento]}'>".date("d/m/Y", strtotime($lorc[$x][data_criacao]))."</a></td>";
            echo "<td class='$bgclass' align=center><a href='?do=orcamentos&act=edit&cod_orc={$lorc[$x][cod_orcamento]}'><img src='images/ico-edit.png' border=0 alt='Editar or�amento' title='Editar or�amento'></a></td>";
        }
        echo "</table>";
        echo "<BR>";
        echo "<center><input type='button' id='' name='' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
    }else{
        $sql = "SELECT MAX(cod_orcamento)as cod_orcamento FROM site_orc_info";
		$r = pg_query($sql);
		$max = pg_fetch_array($r);
		$sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM orcamento";
		$r2 = pg_query($sql);
		$max2 = pg_fetch_array($r2);
        $row_cod[cod_orcamento] = 0;
		if($max[cod_orcamento] > $max2[cod_orcamento])
		   $row_cod[cod_orcamento] = $max[cod_orcamento];
		else
		   $row_cod[cod_orcamento] = $max2[cod_orcamento];
		$sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM site_orc_medi_info";
		$r3 = pg_query($sql);
		$max3 = pg_fetch_array($r3);
        if($row_cod[cod_orcamento] < $max3[cod_orcamento])
            $row_cod[cod_orcamento] = $max3[cod_orcamento];
		$row_cod[cod_orcamento]++;
		
        $sql = "INSERT INTO site_orc_info (cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, aprovado, vendedor_id)
        VALUES
        ('$row_cod[cod_orcamento]', ".(int)($_SESSION[cod_cliente]).", 1, 0, '".date("Y-m-d")."',0, 0)";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        if(pg_query($sql)){
            makeLog($_SESSION[user_id], "Novo or�amento n�mero $row_cod[cod_orcamento] gerado pelo cliente.", 204, $sql);
            echo "Um novo or�amento foi criado com o n�mero: <a href='?do=orcamentos&act=edit&cod_orc={$row_cod[cod_orcamento]}'>$row_cod[cod_orcamento]</a> e pode ser acessado diretamente <a href='?do=orcamentos&act=edit&cod_orc={$row_cod[cod_orcamento]}'>clicando aqui</a> ou
            pela <a href='?do=orcamentos&act=list'>lista de or�amentos</a>.";
            echo "<BR>";
            echo "<center><input type='button' id='' name='' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
        }else{
            makeLog($_SESSION[user_id], "Houve um erro ao gerar um novo or�amento pelo cliente [$row_cod[cod_orcamento]].", 209, $sql);
            echo "Houve um problema ao criar um novo or�amento, por favor, tente novamente em alguns minutos. Se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "<BR>";
            echo "<center><input type='button' id='' name='' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
        }
        echo "</div>";
    }
}
?>
