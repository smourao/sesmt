<center><img src='images/senhasadicionais.jpg' border=0></center>
<div class='novidades_text'>
<p align=justify>
Editando a permissão da senha adicional interna, é possível limitar acesso a diversas áreas do site, bem como,
permitir ou restringir a alteração de dados em cada uma das áreas listadas.
<?PHP
if($_POST && $_POST[btnChangePassPerm]){
    $sql = "UPDATE site_acesso_secundario
    SET
    acesso_colaboradores = ".(int)($_POST[opt_colaboradores]).",
    acesso_rel_pcmso     = ".(int)($_POST[opt_rel_pcmso]).",
    acesso_rel_ppra      = ".(int)($_POST[opt_rel_ppra]).",
	acesso_rel_apgre	 = ".(int)($_POST[opt_rel_apgre])."
    WHERE id = ".(int)($_GET[said])." AND cod_cliente = $_SESSION[cod_cliente]";
    if(pg_query($sql)){
        echo "<p align=justify>";
        echo "Permissões de acesso alteradas com sucesso.";
    }else{
        echo "<p align=justify>";
        echo "Houve um erro ao alterar permissões de acesso para esta senha adicional. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
    }
}
?>
</div>
<form method='POST' id='frmChangePassPerm' name='frmChangePassPerm'>
<p align=justify>
<img src='images/sub-edit-pass-perm.jpg' border=0><BR>
<?PHP
    $id = (int)($_GET[said]);
    $sql = "SELECT * FROM site_acesso_secundario WHERE id = $id AND cod_cliente = $_SESSION[cod_cliente]";
    $res = pg_query($sql);
    $buf = pg_fetch_array($res);
    echo "&nbsp;<b>$buf[email]</b>";
    if($id > 0 && pg_num_rows($res) && $buf[tipo_acesso] == 1){
            echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
            echo "<tr>";
                echo "<td class='bgTitle' align=center>Área</td>";
                echo "<td class='bgTitle' align=center width=180>Permissão</td>";
                echo "<td class='bgTitle' align=center width=50>&nbsp;</td>";
            echo "</tr>";
            //Colaboradores
            echo "<tr>";
                echo "<td class='bgContent1' valign=top>
                <center><b>Colaboradores</b></center>
                <BR>
                Acesso à área <b><i>colaboradores</i></b> do site, onde é possível visualizar, editar, inserir e excluir
                os colaboradores da empresa.
                </td>";
                echo "<td class='bgContent1'><input type=radio id='opt_colaboradores' name='opt_colaboradores' value='0' "; print $buf[acesso_colaboradores] == 0 ? "checked":""; echo" > Sem acesso<BR><input type=radio id='opt_colaboradores' name='opt_colaboradores' value='2' "; print $buf[acesso_colaboradores] == 2 ? "checked":""; echo" > Visualizar<BR><input type=radio id='opt_colaboradores' name='opt_colaboradores' value='1' "; print $buf[acesso_colaboradores] == 1 ? "checked":""; echo" > Acesso total</td>";
                echo "<td class='bgContent1' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            //Relatório PCMSO
            echo "<tr>";
                echo "<td class='bgContent2' valign=top>
                <center><b>Relatório do PCMSO</b></center>
                <BR>
                Acesso à área <b><i>PCMSO</i></b> do site, onde é possível visualizar os relatórios PCMSO da empresa.
                </td>";
                echo "<td class='bgContent2'><input type=radio id='opt_rel_pcmso' name='opt_rel_pcmso' value='0' "; print $buf[acesso_rel_pcmso] == 0 ? "checked":""; echo" > Sem acesso<BR><input type=radio id='opt_rel_pcmso' name='opt_rel_pcmso' value='2' "; print $buf[acesso_rel_pcmso] == 2 ? "checked":""; echo" > Visualizar<BR><input type=radio id='opt_rel_pcmso' name='opt_rel_pcmso' value='1' "; print $buf[acesso_rel_pcmso] == 1 ? "checked":""; echo" > Acesso total</td>";
                echo "<td class='bgContent2' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            //Relatório PPRA
            echo "<tr>";
                echo "<td class='bgContent1' valign=top>
                <center><b>Relatório do PPRA</b></center>
                <BR>
                Acesso à área <b><i>PPRA</i></b> do site, onde é possível visualizar os relatórios PPRA da empresa.
                </td>";
                echo "<td class='bgContent1'><input type=radio id='opt_rel_ppra' name='opt_rel_ppra' value='0' "; print $buf[acesso_rel_ppra] == 0 ? "checked":""; echo" > Sem acesso<BR><input type=radio id='opt_rel_ppra' name='opt_rel_ppra' value='2' "; print $buf[acesso_rel_ppra] == 2 ? "checked":""; echo" > Visualizar<BR><input type=radio id='opt_rel_ppra' name='opt_rel_ppra' value='1' "; print $buf[acesso_rel_ppra] == 1 ? "checked":""; echo" > Acesso total</td>";
                echo "<td class='bgContent1' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            //Relatório APGRE
            echo "<tr>";
                echo "<td class='bgContent2' valign=top>
				<center><b>Relatório do APGRE</b></center>
                <BR>
                Acesso à área <b><i>APGRE</i></b> do site, onde é possível visualizar os relatórios APGRE da empresa.
				</td>";
                echo "<td class='bgContent2'><input type=radio id=opt_rel_apgre name=opt_rel_apgre value='0' "; print $buf[acesso_rel_apgre] == 0 ? "checked":""; echo" > Sem acesso<BR><input type=radio id=opt_rel_apgre name=opt_rel_apgre value='2' "; print $buf[acesso_rel_apgre] == 2 ? "checked":""; echo" > Visualizar<BR><input type=radio id=opt_rel_apgre name=opt_rel_apgre value='1' "; print $buf[acesso_rel_apgre] == 1 ? "checked":""; echo" > Acesso total</td>";
                echo "<td class='bgContent2' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            /*
			echo "<tr>";
                echo "<td class='bgContent1'></td>";
                echo "<td class='bgContent1'><input type=radio id=opt1 name=opt1 value=''> Sem acesso<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar e editar</td>";
                echo "<td class='bgContent1' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td class='bgContent2'></td>";
                echo "<td class='bgContent2'><input type=radio id=opt1 name=opt1 value=''> Sem acesso<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar e editar</td>";
                echo "<td class='bgContent2' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td class='bgContent1'></td>";
                echo "<td class='bgContent1'><input type=radio id=opt1 name=opt1 value=''> Sem acesso<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar<BR><input type=radio id=opt1 name=opt1 value=''> Visualizar e editar</td>";
                echo "<td class='bgContent1' align=center><img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='.' title='.'></td>";
            echo "</tr>";
            */
            echo "</table>";
            echo "<BR><p><BR>";
            echo "<center><input type=submit id='btnChangePassPerm' name='btnChangePassPerm' value='Alterar permissões' onclick=\"if(document.getElementById('newpass').value != document.getElementById('newpass2').value){ document.getElementById('newpass').className = 'required_wrong'; document.getElementById('newpass2').className = 'required_wrong'; document.getElementById('newpass').focus();}\"></center>";
    }else{
        //deu merda em algum teste acima...
    }
?>
</form>
