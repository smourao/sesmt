<center><img src='images/relatorios_ppra.jpg' border=0></center>
<?PHP
if($_GET[cod_cgrt] && is_numeric($_GET[cod_cgrt])){
    $sql = "SELECT * FROM cgrt_info WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND cod_cgrt = ".(int)($_GET[cod_cgrt])."ORDER BY ano DESC"; //AND cgrt_finished = 1
    $res = pg_query($sql);
    $buf = pg_fetch_array($res);
    if($buf[ppra_enabled]){
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Voc� est� visualizando o relat�rio do PPRA refer�nte ao ano de <b>{$buf[ano]}</b>. Caso haja a necessidade de uma
        vers�o impressa, por favor, solicite a impress�o junto � nossa <a href='?do=contato'>central de atendimento</a><BR>";
        echo "</div>";
        echo "<br><center><span id='ppra_loading'><i>Aguarde, o documento est� sendo carregado...</i></span></center><BR>";
        echo "<iframe scrolling='yes' onload=\"document.getElementById('ppra_loading').style.display = 'none';\" src='http://sesmt-rio.com/erp/2.0/modules/cgrt/relatorios/ppra/?cod_cgrt=".base64_encode((int)($_GET[cod_cgrt]))."&html=0' frameborder=0 width=100% height=500 allowtransparency='true'></iframe>";
        echo "<p>";
        echo "<center>";
        echo "<input value='Voltar' type='button' onclick=\"location.href='?do=rel_ppra';\">";
        echo "</center>";
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O relat�rio do PPRA selecionado n�o est� dispon�vel ou n�o foi finalizado.
        Em caso de d�vidas, entre em contato com nossa <a href='?do=contato'>central de atendimento</a><BR>";
        echo "</div>";
        echo "<p>";
        echo "<center>";
        echo "<input value='Voltar' type='button' onclick=\"location.href='?do=rel_ppra';\">";
        echo "</center>";
    }
}else{
    $sql = "SELECT * FROM cgrt_info WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." ORDER BY ano DESC"; //AND cgrt_finished = 1
    $res = pg_query($sql);
    $buf = pg_fetch_all($res);
    if(pg_num_rows($res)){
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Selecione abaixo o ano de refer�ncia do PPRA que deseja exibir:";
        echo "</div>";
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<tr>";
            echo "<td class='bgTitle' align=center width=80>Refer�ncia</td>";
            echo "<td class='bgTitle' align=center>Status</td>";
            echo "<td class='bgTitle' align=center width=180>Progresso</td>";
            echo "<td class='bgTitle' align=center width=50>Op��es</td>";
        echo "</tr>";
        for($x=0;$x<pg_num_rows($res);$x++){
            if($x % 2)
                $bg = 'bgContent1';
            else
                $bg = 'bgContent2';

            echo "<tr>";
                echo "<td class='$bg' align=center>{$buf[$x][ano]}</td>";
                echo "<td class='$bg' align=left>";
                if($buf[$x][cgrt_finished]){
                    if($buf[$x][ppra_enabled])
                        echo "Relat�rio finalizado.";
                    else
                        echo "<span class='curhand' alt='Este relat�rio n�o est� dispon�vel, pois n�o consta no contrato vigente. Para contratar este servi�o entre em contato com a SESMT�.' title='Este relat�rio n�o est� dispon�vel, pois n�o consta no contrato vigente. Para contratar este servi�o entre em contato com a SESMT�.'>Este relat�rio n�o foi contratato.</span>";
                }else{
                    echo "<span class='curhand' alt='Este relat�rio est� em fase de contru��o e ainda n�o pode ser visualizado. Em caso de d�vidas, entre em contato com a SESMT�.' title='Este relat�rio est� em fase de contru��o e ainda n�o pode ser visualizado. Em caso de d�vidas, entre em contato com a SESMT�.'>Relat�rio em andamento.</span>";
                }
                echo "</td>";
                echo "<td class='$bg' align=left>";
                    echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=0 style=\"height: 5px;\">";
                    echo "<tr>";
                    $fatmult = cgrt_progress($buf[$x][cod_cgrt]);
                    $concluido = ($fatmult * 180)/100;
                    echo "<td style=\"border: 1px #000000 solid; height: 5px;\" height=5 alt='{$fatmult}% conclu�do' title='{$fatmult}% conclu�do'><img src=\"images/bar.png\" width='{$concluido}' height=5 border=0></td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</td>";
                echo "<td class='$bg' align=center>";
                if($buf[$x][ppra_enabled])
                    //echo "<a href='#' onclick=\"location.href='?do=$_GET[do]&cod_cgrt={$buf[$x][cod_cgrt]}';\"><img src='images/ico-view.png' border=0 alt='Visualizar relat�rio' title='Visualizar relat�rio'></a>";
                    echo "<a href='#' onclick=\"window.open('http://sesmt-rio.com/erp/2.0/modules/cgrt/relatorios/ppra/?cod_cgrt=".base64_encode((int)($buf[$x][cod_cgrt]))."', '');\"><img src='images/ico-view.png' border=0 alt='Visualizar relat�rio' title='Visualizar relat�rio'></a>";
                else
                    echo "&nbsp;";
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<BR>";
        echo "<b>Legenda:</b>";
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<tr>";
        echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar relat�rio' title='Visualizar relat�rio'></td><td><font size=1>Visualizar relat�rio.</font></td>";
        echo "</tr>";
        echo "</table>";
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "N�o foram encontrados relat�rios do PPRA para sua empresa. Se existem relat�rios em andamento, estes ainda n�o foram finalizados.";
        echo "</div>";
    }
}
?>
