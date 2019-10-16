<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);

if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $r = pg_query($sql);
    $clinfo = pg_fetch_array($r);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
         //só exibir caso seja pesquisa
         if(!$_GET[sp] || $_GET[sp] == 'lista'){
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=enc_med_clinicas&p=lista'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o número do encaminhamento no campo e clique em Busca para psquisar o ASO.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
         }
                
                /*echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text'>xxx:</td>";
                        echo "<td class='text' width=150 align=right></td>";
                        echo "</tr><tr>";
                        echo "<td class='text'>xxx:</td><td class='text' width=150 align=right></td>";
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_enc_med';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";*/
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
            if($_GET[sp] == 'new_enc_med'){
                echo "<b>Novo encaminhamento</b>";
            }elseif($_GET[sp] == 'new_enc_fl'){
                echo "<b>$clinfo[razao_social]</b>";
            }else{
                echo "<b>Alterar encaminhamento à clínica</b>";
            }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        $sp = current_module_path.anti_injection($_GET[sp]).".php";
        if(file_exists($sp)){
            @include($sp);
        }else{
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            if($_POST[search]){
        
                $sql = "SELECT * FROM aso WHERE $_POST[search] = cod_aso";
                $result_aso = pg_query($sql);
                $row = pg_fetch_all($result_aso);
        
                for($x=0;$x<pg_num_rows($result_aso);$x++){
                    $sql = "SELECT f.*, c.* FROM funcionarios f, cliente c
                    WHERE
                    f.cod_cliente = c.cliente_id AND
                    c.cliente_id = {$row[$x][cod_cliente]} AND
                    f.cod_func = {$row[$x][cod_func]}";
                    $result = pg_query($sql);
                    $buffer = pg_fetch_array($result);
                    echo "<tr>";
                    echo "  <th class='text roundbordermix' class=linksistema";
                    if($row[$x][enviado]){
                        echo " bgcolor=green alt='Enviado por email em: ".date("d/m/Y à\s H:i:s", strtotime($row[$x][data_envio])).".' title='Enviado por email em: ".date("d/m/Y à\s H:i:s", strtotime($row[$x][data_envio])).".'";
                    }else{
                        echo " bgcolor=red alt='Clique aqui para enviar por email.' title='Clique aqui para enviar por email.'";
                    }
                    echo "><a href=\"#\" onclick=\"var mmm = prompt('Enviar este ASO para:','{$buffer[email]}');
                    if(mmm){
                    location.href='?dir=gerar_aso&p=aso_mail&funcionario=$buffer[cod_func]&aso={$row[$x][cod_aso]}&cod_cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]&email='+mmm+'';
                    }\">Email</a> </th>";
                        
                    echo "  <th class='text roundbordermix' class=linksistema bgcolor='$color'><a href='?dir=gerar_aso&p=editar_aso&funcionario=$buffer[cod_func]&aso={$row[$x][cod_aso]}&cod_cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]' >Editar</a> </th>";
                    echo "  <td class='text roundbordermix curhand' bgcolor='$color' onmouseover=\"showtip('tipbox', 'ASO - Exibe o ASO criado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".base64_encode((int)($buffer[cod_cliente]))."&setor=".base64_encode((int)($buffer[cod_setor]))."&funcionario=".base64_encode((int)($buffer[cod_func]))."&aso=".base64_encode((int)($row[$x][cod_aso]))."');\">" . ucwords(strtolower($buffer[razao_social])) . "</td>";
                    echo "  <td class='text roundbordermix curhand' bgcolor='$color' onmouseover=\"showtip('tipbox', 'ASO - Exibe o ASO criado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".base64_encode((int)($buffer[cod_cliente]))."&setor=".base64_encode((int)($buffer[cod_setor]))."&funcionario=".base64_encode((int)($buffer[cod_func]))."&aso=".base64_encode((int)($row[$x][cod_aso]))."');\">" . ucwords(strtolower($buffer[nome_func])) . "</a> </td>";
                    echo "  <td class='text roundbordermix curhand' bgcolor='$color' onmouseover=\"showtip('tipbox', 'ASO - Exibe o ASO criado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".base64_encode((int)($buffer[cod_cliente]))."&setor=".base64_encode((int)($buffer[cod_setor]))."&funcionario=".base64_encode((int)($buffer[cod_func]))."&aso=".base64_encode((int)($row[$x][cod_aso]))."');\">" . date("d/m/Y", strtotime($row[$x][aso_data]))."</a> </td>";
                    echo "  <th class='text roundbordermix' class=linksistema bgcolor='$color'><a href='?dir=gerar_aso&p=lista_aso&step=1&aso={$row[$x][cod_aso]}&excluir=sim' >Excluir</a> </th>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>

