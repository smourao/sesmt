<?PHP
        echo "<FORM method='post'>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "</FORM>";
        echo "<br>";
        if($_POST){
            $sql = "SELECT c.razao_social, c.ano_contrato, ci.* FROM site_gerar_contrato ci, cliente c WHERE
            c.cliente_id = ci.cod_cliente AND
            LOWER(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY id";
        }else{
            $sql = "SELECT c.razao_social, c.ano_contrato, ci.* FROM site_gerar_contrato ci, cliente c WHERE
            c.cliente_id = ci.cod_cliente ORDER BY id";
        }
        $r = pg_query($sql);
        $buffer = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><b>Nº</b></td>";
        echo "<td align=center class=fontebranca12><b>Razão Social</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>Contrato</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>Resumo</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Vencimento</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Orçamento</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Status</b></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                echo "<tr>";
                echo "<td class=fontebranca12 align=center><font size=1>".($x+1)."</td>";
                echo "<td class=fontebranca12 align=left>
                <a class=fontebranca12 target=_blank href='http://sesmt-rio.com/contratos/aberto.php?cod_cliente={$buffer[$x][cod_cliente]}&cid={$buffer[$x][cod_orcamento]}/{$buffer[$x][ano_orcamento]}&tipo_contrato={$buffer[$x][tipo_contrato]}&sala={$buffer[$x][atendimento_medico]}&parcelas={$buffer[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($buffer[$x][vencimento]))."&rnd=".rand(10000, 99999)."'>
                <b>".$buffer[$x][razao_social]."</b>
                </a></td>";
                echo "<td class=fontebranca12 align=center>".$buffer[$x][ano_contrato].".".str_pad($buffer[$x][cod_cliente], 4, "0", 0)."</td>";
                echo "<td class=fontebranca12 align=center>
                <a class=fontebranca12 href='?action=propriedade_de_contrato&cod_cliente={$buffer[$x][cod_cliente]}'>
                <b>Visualizar</b></a></td>";
                 echo "<td class=fontebranca12 align=center><font size=1>".date("d/m/Y", strtotime($buffer[$x][vencimento]))."</td>";
                $orc = $buffer[$x][cod_orcamento];//explode("/", $buffer[$x][cod_orcamento]);
                echo "<td class=fontebranca12 align=center>
                <a class=fontebranca12 target=_blank href='http://www.sesmt-rio.com/erp/cria_orcamento.php?act=edit&cod_cliente={$buffer[$x][cod_cliente]}&cod_filial=1&orcamento={$orc}'>
                <b>".$buffer[$x][cod_orcamento]."/".$buffer[$x][ano_orcamento]."
                </b></a></td>";
                echo "<td class=fontebranca12 align=center>";
                echo "<select id=status name=status onchange=\"cStatus('{$buffer[$x][id]}', this.value);\">";
                    echo "<option value=0"; print $buffer[$x][status] == 0 ? " selected ":" "; echo ">Aguardando</option>";
                    echo "<option value=1"; print $buffer[$x][status] == 1 ? " selected ":" "; echo ">Finalizado</option>";
                    echo "<option value=2"; print $buffer[$x][status] == 2 ? " selected ":" "; echo ">Cancelado</option>";
                echo "</select>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhuma informação encontrada!</b></span></center>";
        }
?>
