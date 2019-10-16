<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);


if($_SESSION[grupo] == 'vendedor'){
    if($_POST[search] && !$_GET[o]){
        unset($_SESSION[cad_cliente_o]);
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_id = $_POST[search] OR lower(razao_social) LIKE '%".strtolower($_POST[search])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente_pedro_silva WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }
    }else{
        if($_GET[o]){
            $_SESSION[cad_cliente_o] = $_GET[o];
        }else{
            $_SESSION[cad_cliente_o] = '@none';//'@numeric';
        }

        if($_SESSION[cad_cliente_o] == '@numeric'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE substr(razao_social, 1, 1) ~ '^[0-9]+$' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@comercial'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 0 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@ativos'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 1 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
    	}elseif($_SESSION[cad_cliente_o] == '@parceria'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 2 AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@total'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente_pedro_silva WHERE lower(razao_social) LIKE '".strtolower($_SESSION[cad_cliente_o])."%' AND vendedor_id = {$_SESSION[usuario_id]} ORDER BY cliente_id";
        }
    }
}else{
    if($_POST[search] && !$_GET[o]){
        unset($_SESSION[cad_cliente_o]);
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_id = $_POST[search] OR lower(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente_pedro_silva WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY cliente_id";
        }
    }else{
        if($_GET[o]){
            $_SESSION[cad_cliente_o] = $_GET[o];
        }else{
            $_SESSION[cad_cliente_o] = '@none';//'@numeric';
        }

        if($_SESSION[cad_cliente_o] == '@numeric'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE substr(razao_social, 1, 1) ~ '^[0-9]+$' ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@comercial'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 0 ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@ativos'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 1 ORDER BY cliente_id";
    	}elseif($_SESSION[cad_cliente_o] == '@parceria'){
            $sql = "SELECT * FROM cliente_pedro_silva WHERE cliente_ativo = 2 ORDER BY cliente_id";
        }elseif($_SESSION[cad_cliente_o] == '@total'){
            $sql = "SELECT * FROM cliente_pedro_silva ORDER BY cliente_id";
        }else{
            $sql = "SELECT * FROM cliente_pedro_silva WHERE lower(razao_social) LIKE '".strtolower($_SESSION[cad_cliente_o])."%' ORDER BY cliente_id";
        }
    }
}

$result = pg_query($sql);
$list = pg_fetch_all($result);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=cad_cliente_pedro_silva&p=index&step=1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para pesquisar uma empresa.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
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
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                $sql = "SELECT count(*) as total FROM cliente_pedro_silva";
                $rtotal = pg_query($sql);
                $total = pg_fetch_array($rtotal);
                $total = $total[total];
                $sql = "SELECT count(*) as total FROM cliente_pedro_silva WHERE cliente_ativo = 1";
                $rativo = pg_query($sql);
                $ativo = pg_fetch_array($rativo);
                $ativo = $ativo[total];
				$sql = "SELECT count(*) as total FROM cliente_pedro_silva WHERE cliente_ativo = 0";
                $rcomercial = pg_query($sql);
                $comercial = pg_fetch_array($rcomercial);
                $comercial = $comercial[total];
				$sql = "SELECT count(*) as total FROM cliente_pedro_silva WHERE cliente_ativo = 2";
                $rparceria = pg_query($sql);
                $parceria = pg_fetch_array($rparceria);
                $parceria = $parceria[total];

                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo do cadastro de clientes.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                      /*  echo "<td class='text'>Clientes Ativos:</td><td class='text' width=40 align=right><a href='?dir=cad_cliente_pedro_silva&p=index&o=@ativos'>".$ativo."</a></td>";
                        echo "</tr><tr>";
                        echo "<td class='text'>Cliente Comercial:</td><td class='text' width=40 align=right><a href='?dir=cad_cliente_pedro_silva&p=index&o=@comercial'>".($comercial)."</a></td>";
                        echo "</tr><tr>";
						echo "<td class='text'>Cliente Parceiro:</td><td class='text' width=40 align=right><a href='?dir=cad_cliente_pedro_silva&p=index&o=@parceria'>".($parceria)."</a></td>";
                        echo "</tr><tr>"; */
                        echo "<td class='text'>Total:</td><td class='text' width=40 align=right><a href='?dir=cad_cliente_pedro_silva&p=index&o=@total'>".$total."</a></td>";
                        echo "</tr></table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                
                // OPÇÕES DO CLIENTE
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=cad_cliente_pedro_silva&p=detalhe_cliente&cod_cliente=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Lista de Clientes</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<center><font size=1>";
        echo "[ <a href='?dir=cad_cliente_pedro_silva&p=index&o=@numeric'";
        print $_SESSION[cad_cliente_o] == '@numeric' ? " class='roundborderselected' " : "";
        echo ">#</a> | ";
        for($x='A';$x != 'AA';$x++){
            echo "<a href='?dir=cad_cliente_pedro_silva&p=index&o=$x'";
            print $_SESSION[cad_cliente_o] == $x ? " class='roundborderselected' " : "";
            echo ">".$x."</a>";
            if($x != 'Z')
                echo " | ";
            else
                echo " ]";
        }
        echo "</font></center>";
        echo "<p>";
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=20><b>Cód:</b></td>";
        echo "<td align=left class='text'><b>Empresa:</b></td>";
        //echo "<td align=left class='text' width=100><b>Exibir no site:</b></td>";
		
		
		
        echo "</tr>";
		
		
		
		if($_SESSION[grupo] == 'administrador'){
			
        for($i=0;$i<pg_num_rows($result);$i++){
		
		  $sql = "SELECT distinct(p.razao_social) FROM cliente_pedro_silva c, cliente_pc p WHERE p.cnpj = '{$list[$i][cnpj_contratante]}'";
		  $resultado = pg_query($sql);
		  $contratados = pg_fetch_array($resultado);
		  
		  $codigodeletar = $list[$i][cliente_id];
		  
		
		
		 
			
		 
		  
		    echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cad_cliente_pedro_silva&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\">".str_pad($list[$i]['cliente_id'], 4, "0", 0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cad_cliente_pedro_silva&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\" alt='".addslashes($contratados[razao_social])."' title='".addslashes($contratados[razao_social])."'>{$list[$i]['razao_social']}</td>";
            /*echo "<td align=left class='text roundborder' id='dcont".$list[$i][cliente_id]."'>";

            echo "<input type='checkbox' disabled id='showsite".$list[$i][cliente_id]."' name='showsite".$list[$i][cliente_id]."'";
            print $list[$i][showsite] ? " checked " : "";
            echo " onclick=\"show_in_website('".$list[$i][cliente_id]."');\"> <a href=\"javascript:show_in_website('".$list[$i][cliente_id]."');\">Exibir</a>";
			
            echo "</td>"; */
            echo "</tr>";
        }
		}else{
			
			for($i=0;$i<pg_num_rows($result);$i++){
		
		  $sql = "SELECT distinct(p.razao_social) FROM cliente_pedro_silva c, cliente_pc p WHERE p.cnpj = '{$list[$i][cnpj_contratante]}'";
		  $resultado = pg_query($sql);
		  $contratados = pg_fetch_array($resultado);
		    echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cad_cliente_pedro_silva&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\">".str_pad($list[$i]['cliente_id'], 4, "0", 0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cad_cliente_pedro_silva&p=detalhe_cliente&cod_cliente={$list[$i]['cliente_id']}';\" alt='".addslashes($contratados[razao_social])."' title='".addslashes($contratados[razao_social])."'>{$list[$i]['razao_social']}</td>";
            echo "<td align=left class='text roundborder' id='dcont".$list[$i][cliente_id]."'>";

            echo "<input type='checkbox' disabled id='showsite".$list[$i][cliente_id]."' name='showsite".$list[$i][cliente_id]."'";
            print $list[$i][showsite] ? " checked " : "";
            echo " onclick=\"show_in_website('".$list[$i][cliente_id]."');\"> <a href=\"javascript:show_in_website('".$list[$i][cliente_id]."');\">Exibir</a>";

            echo "</td>";
            echo "</tr>";
        }
			
			
		}
        echo "</table>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
/*
$s = "SELECT * FROM produto WHERE lower(desc_detalhada_prod) LIKE '%treinamento%' OR lower(desc_resumida_prod) LIKE '%palestra%' OR lower(desc_resumida_prod) LIKE '%ministração%' ORDER BY cod_prod";
$q = pg_query($s);
$arr = pg_fetch_all($q);
echo '<table width="100%">';
for($k=0;$k<=pg_num_rows($q);$k++){
	echo '<tr><td width="10%">'.$arr[$k][cod_prod].'</td><td width="90%">'.$arr[$k][desc_detalhada_prod].'</td></tr>';
}
echo '</table>';
*/
?>
