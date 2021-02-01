<?php
session_start();
ob_start();
include("../../include/database.php");
//include("include/functions.php");
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

if($_GET['act'] == "new"){

$atan = $_POST['d_atan'];
$ord = $_POST['d_ord'];
$anoi = $_POST['d_anoi'];
$anof = $_POST['d_anof'];
$empresa = $_POST['d_empresa'];
$end = $_POST['d_end'];
$num = $_POST['d_num'];
$cidade = $_POST['d_cidade'];
$municipio = $_POST['d_municipio'];
$estado = $_POST['d_estado'];
$dias = $_POST['d_dias'];
$mes = $_POST['d_mes'];
$ano = $_POST['d_ano'];
$hora = $_POST['d_hora'];
$min = $_POST['d_min'];
$sala = $_POST['d_sala'];
$pres = $_POST['d_pres'];
$vice = $_POST['d_vice'];
$svp = $_POST['d_svp'];
$sec = $_POST['d_sec'];
$topic = $_POST['d_titulos'];
$text = $_POST['d_textos'];

$sql = "INSERT INTO site_ata_cipa (d_atan, d_ord, d_anoi, d_anof, d_empresa, d_end, d_num,
d_cidade, d_municipio, d_estado, d_dias, d_mes, d_ano, d_hora, d_min, d_sala, d_pres, d_vice,
d_svp, d_sec, d_titulos, d_textos, cod_cliente, criacao, d_suplente_cipa) VALUES
       ('{$atan}','{$ord}','{$anoi}','{$anof}','{$empresa}','{$end}','{$num}','{$cidade}',
       '{$municipio}','{$estado}','{$dias}','{$mes}','{$ano}','{$hora}','{$min}','{$sala}',
       '{$pres}','{$vice}','{$svp}','{$sec}','{$topic}','{$text}', '".$_GET['cod_cliente']."',
       '".date("Y-m-d")."', '{$_POST[d_suplente]}')";
$resul = pg_query($sql);

if($resul){
   $sql = "SELECT MAX(id) as max FROM site_ata_cipa";
   $r = pg_query($sql);
   $b1 = pg_fetch_array($r);
   
   $sql = "SELECT * FROM site_ata_cipa WHERE id={$b1[max]}";
   $result = pg_query($sql);
   $buffer = pg_fetch_array($result);
   
   echo "<script>location.href='?act=view&id={$b1[max]}';</script>";
}
}else{
   $sql = "SELECT * FROM site_ata_cipa WHERE id={$_GET['id']}";
   $result = pg_query($sql);
   $buffer = pg_fetch_array($result);
   
   $sql = "SELECT * FROM site_ata_cipa WHERE id={$_GET[id]}";
    $result = pg_query($sql);
    $buffer = pg_fetch_array($result);

    $sql = "SELECT * FROM cliente WHERE cliente_id = ".$buffer[cod_cliente];
    $cdata = pg_fetch_array(pg_query($sql));
}

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
echo "<html>";
echo "<head>";
echo "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"/>";
echo "    <meta http-equiv=\"Pragma\" content=\"No-Cache\"/>";
echo "    <meta http-equiv=\"Cache-Control\" content=\"No-Cache,Must-Revalidate,No-Store\"/>";
echo "    <meta http-equiv=\"Expires\" content=\"-1\"/>";
echo "    <meta name=\"author\" content=\"Celso Leonardo - SL4Y3R\"/>";
echo "    <title>SIST - Software Integrado de Segurança no Trabalho</title>";
echo "    <link href=\"include/css/style.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "</head>";
echo "<body>";


echo "<table border=0 width=755 align=center>";//height=1122,5
echo "<tr>";
echo "<td style=\"vertical-align: top;\">";
    echo"<table border=0 width=755 height=200 align=top style=\"vertical-align: middle;\">";
    echo "<tr>";
        echo "<td height=200></td>";
        echo "<td width=220 height=189><!--<img src=\"images/cipa0.jpg\" width=220 height=189>--></td>";
    echo "</tr>";
    echo "</table>";

    echo "<table border=0 width=755 height=120 align=top>";
    echo "<tr>";
        echo "<td style='vertical-align: top;'>";
        echo "<b>ATA DA REUNIÃO Nº $buffer[d_atan]</b>";
        echo "<p align=justify>";
        echo "Reunião $buffer[d_ord] da CIPA Gestão $buffer[d_anoi]/$buffer[d_anof], da empresa
        <b>$cdata[razao_social]</b>, Endereço: <b>$cdata[endereco]</b>, Nº <b>$cdata[num_end]</b>
        Bairro: <b>$cdata[bairro]</b> Municípo: <b>$cdata[municipio]</b> Estado:
        <b>$cdata[estado].</b>";
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>";
        echo "<p align=justify>";
        echo "Aos dias <b>$buffer[d_dias]</b> de <b>";
        if(is_numeric($buffer[d_mes]))
            echo $meses[ltrim($buffer[d_mes], "0")];
        else
            echo $buffer[d_mes];
        echo "</b> de
        <b>$buffer[d_ano]</b> às <b>$buffer[d_hora]</b>h<b>$buffer[d_min]</b>min na sala
        de reunião da <b>$buffer[d_sala]</b> realizou-se a reunião de nº&nbsp;$buffer[d_atan]
        &nbsp;com a presença dos Srs. <b>$buffer[d_pres]</b> - Presidente da CIPA;
        <b>$buffer[d_suplente_cipa]</b> - Suplente da CIPA;
        <b>$buffer[d_vice]</b> - Vice Presidente da CIPA;
        <b>$buffer[d_svp]</b> - Suplente Vice - Presidente;
        <b>$buffer[d_sec]</b> - Secretário(a) da CIPA.";
        echo "</td>";
    echo "</tr>";

    $titulos = explode("|", $buffer[d_titulos]);
    $textos = explode("|", $buffer[d_textos]);

    for($x=0;$x<count($titulos);$x++){
        echo"<tr><td>";
        echo "<p align=justify>";
        echo "<div class=title1 align=center><b>{$titulos[$x]}</b></div>";
        echo "</td>";
        echo "</tr><tr>";
        echo "<td>";
        echo "<div>".$textos[$x]."</div>";
        echo "</td></tr>";
        echo "<tr><td>";
        echo "<br>";
        echo "</td></tr>";
    }

    $sql = "SELECT * FROM site_ata_topic WHERE cod_ata = $_GET[id]";
    $rat = pg_query($sql);
    if(pg_num_rows($rat)){
        $topicos = pg_fetch_all($rat);
        for($y=0;$y<pg_num_rows($rat);$y++){
            echo"<tr><td>";
            echo "<p align=justify>";
            echo "<div class=title1 align=center><b>{$topicos[$y][title]}</b></div>";
            echo "</td>";
            echo "</tr><tr>";
            echo "<td>";
            echo "<div>".nl2br($topicos[$y][msg])."</div>";
            echo "</td></tr>";
            echo "<tr><td>";
            echo "<br>";
            echo "</td></tr>";
        }
    }

    echo "<tr>";
    echo "<td>";
    echo "<p align=justify>";
    echo "Nada mais havendo a relatar ou discutir o Sr. Presidente deu por encerrada a reunião,
     sendo lavrada a presente Ata, que após discutida e aprovada passa a ser assinada pelos
     membros representantes.";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>";
    echo "<br>";
    echo "<br>";
    echo "<table border=0 align=center width=755>";
    echo "<tr>";
           echo "<td><center>________________________<br>Presidente - CIPA</td>";
           echo "<td><center>________________________<br>Vice - Presidente - CIPA</td>";
           echo "<td><center>________________________<br>1º Secretária da CIPA</td>";
    echo "</tr>";
    echo "</table>";

    echo "<br><br><br><br>";

    echo "<table border=0 align=center width=755>";
    echo "<tr>";
           echo "<td><center>________________________<br>Suplente do Pres.</td>";
           echo "<td><center>________________________<br>Suplente do Vice - Pres.</td>";
    echo "</tr>";
    echo "</table>";

    echo "<br><br><br><br>";

    echo "</td></tr>";

echo "</table>";

echo "</td></tr></table>";

echo "</body>";
echo "</html>";

?>


