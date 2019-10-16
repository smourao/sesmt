<?PHP
    switch(step){
        default:
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Selecione o tipo de agendamento:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=left class='text roundborderselected' width=100%>";
                echo "<select class='inputTextobr' name='tipo_agendamento' id='tipo_agendamento' onchange=\"if(this.value > 0){location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ag_cliente&step=1';}\">";
                    echo "<option value='0'></option>";
                    echo "<option value='1'>Cliente</option>";
                echo "</select>";
            echo "<td>";
            echo "</tr>";
            echo "</table>";
        break;
    }
?>
