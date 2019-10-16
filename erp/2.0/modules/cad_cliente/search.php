<?PHP
include("../../common/database/conn.php");
include("../../common/functions.php");
include("../../common/globals.php");

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);

if($_SESSION[grupo] == 'vendedor'){
    if($_POST[search] && !$_GET[o]){
        unset($_SESSION[cad_cliente_o]);
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM cliente WHERE cliente_id = $_POST[search] OR lower(razao_social) LIKE '%".strtolower($_POST[search])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }
    }else{
        if($_GET[o]){
            $_SESSION[cad_cliente_o] = $_GET[o];
        }else{
            $_SESSION[cad_cliente_o] = '@none';//'@numeric';
        }

        if($_SESSION[cad_cliente_o] == '@numeric'){
            $sql = "SELECT * FROM cliente WHERE substr(razao_social, 1, 1) ~ '^[0-9]+$' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@comercial'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 0 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@ativos'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 1 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
    	}elseif($_SESSION[cad_cliente_o] == '@parceria'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 2 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@total'){
            $sql = "SELECT * FROM cliente WHERE vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '".strtolower($_SESSION[cad_cliente_o])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }
    }
}else{
    if($_POST[search] && !$_GET[o]){
        unset($_SESSION[cad_cliente_o]);
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM cliente WHERE cliente_id = $_POST[search] OR lower(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY cliente_id";
        }
    }else{
        if($_GET[o]){
            $_SESSION[cad_cliente_o] = $_GET[o];
        }else{
            $_SESSION[cad_cliente_o] = '@none';//'@numeric';
        }

        if($_SESSION[cad_cliente_o] == '@numeric'){
            $sql = "SELECT * FROM cliente WHERE substr(razao_social, 1, 1) ~ '^[0-9]+$' ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@comercial'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 0 ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@ativos'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 1 ORDER BY cliente_id";
    	}elseif($_SESSION[cad_cliente_o] == '@parceria'){
            $sql = "SELECT * FROM cliente WHERE cliente_ativo = 2 ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@total'){
            $sql = "SELECT * FROM cliente ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '".strtolower($_SESSION[cad_cliente_o])."%' ORDER BY cliente_id";
        }
    }
}

$result = pg_query($sql);
$list = pg_fetch_all($result);




?>

<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta http-equiv="Pragma" content="No-Cache"/>
    <meta http-equiv="Cache-Control" content="No-Cache,Must-Revalidate,No-Store"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta name="author" content="Celso Leonardo - SL4Y3R"/>
    <meta name="keywords" content="SESMT, Sesmt, sesmt, Medicina, medicina, Trabalho, trabalho, Higiene, higiene, Medicina Ocupacional, ASO, PPRA"/>
    <meta name="description" content="SESMT - Segurança do Trabalho e Higiene Ocupacional"/>
    <meta name="robots" content="all"/>
    <meta name="revisit" content="1 days"/>
    <meta name="distribution" content="Global"/>
    <meta name="MSSmartTagsPreventParsing" content="True"/>
    <title>SIST - Software Integrado de Segurança no Trabalho</title>

    <link href="../../layout/css/sist.css" rel="stylesheet" type="text/css">
    <link href="../../layout/css/custom.css" rel="stylesheet" type="text/css">
    <link href="../../layout/css/keyboard.css" rel="stylesheet" type="text/css">
<?php


echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=100% class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Localizar Cliente</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=cad_cliente&p=index&step=1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para pesquisar uma empresa.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=40 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                   if(pg_num_rows($result)) echo "<b>".pg_num_rows($result)."</b> "; if(pg_num_rows($result) > 1) echo "<b>Resultados<b>"; else echo "<b>Resultado<b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                /*
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                $sql = "SELECT * FROM cad_cliente ";
                    echo "<td class='roundbordermix text' height=30 align=center> texto</td>";
                    
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                */

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=20><b>Cód:</b></td>";
        echo "<td align=left class='text'><b>Empresa:</b></td>";
		echo "<td align=left class='text' width=40><b>Boleto:</b></td>";
        echo "</tr>";

        for($i=0;$i<pg_num_rows($result);$i++){

		  $sql = "SELECT distinct(p.razao_social) FROM cliente c, cliente_pc p WHERE p.cnpj = '{$list[$i][cnpj_contratante]}'";
		  $resultado = pg_query($sql);
		  $contratados = pg_fetch_array($resultado);
		    echo "<tr class='text roundbordermix'>";
            
			$urlwww = $_SERVER['SERVER_NAME'];
						
			if($urlwww == 'www.sesmt-rio.com'){
			
			
			echo "<td align=left class='text roundborder curhand' onclick=\"opener.location.href='http://www.sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\">".str_pad($list[$i]['cliente_id'], 4, "0", 0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"opener.location.href='http://www.sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\" alt='".addslashes($contratados[razao_social])."' title='".addslashes($contratados[razao_social])."'>{$list[$i]['razao_social']}</td>";
			echo "<td align=left class='text roundborder curhand' onclick=\"location.href='http://www.sesmt-rio.com/erp/2.0/modules/cad_cliente/cliente_boleto_search.php?cod_cliente={$list[$i]['cliente_id']}';\">Boleto</td>";
			
			}else{
				
			echo "<td align=left class='text roundborder curhand' onclick=\"opener.location.href='http://sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\">".str_pad($list[$i]['cliente_id'], 4, "0", 0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"opener.location.href='http://sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\" alt='".addslashes($contratados[razao_social])."' title='".addslashes($contratados[razao_social])."'>{$list[$i]['razao_social']}</td>";
			echo "<td align=left class='text roundborder curhand' onclick=\"location.href='http://sesmt-rio.com/erp/2.0/modules/cad_cliente/cliente_boleto_search.php?cod_cliente={$list[$i]['cliente_id']}';\">Boleto</td>";
				
				
			}
			
			
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
