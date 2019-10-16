<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<center><font size=1>";
    
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_edificacao'"; print $_GET[sp] == 's6sp_edificacao' ? " class='roundborderselected' " : ""; echo ">Edificação</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_iluminancia'"; print $_GET[sp] == 's6sp_iluminancia' ? " class='roundborderselected' " : ""; echo ">Iluminância</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_agentes_nocivos'"; if( $_GET[sp] == 's6sp_agentes_nocivos' || $_GET[sp] == 's6sp_edit_agentes_nocivos') echo " class='roundborderselected' "; else echo ""; echo ">Agente Nocivo</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_avaliacao'"; if( $_GET[sp] == 's6sp_avaliacao' || $_GET[sp] == 's6sp_edit_avaliacao') echo " class='roundborderselected' "; else echo ""; echo ">Av. Ambiental</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_medidas_preventivas'"; print $_GET[sp] == 's6sp_medidas_preventivas' ? " class='roundborderselected' " : ""; echo ">Medida Preventiva</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_epc'"; print $_GET[sp] == 's6sp_epc' ? " class='roundborderselected' " : ""; echo ">EPC</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_extintores'"; print $_GET[sp] == 's6sp_extintores' ? " class='roundborderselected' " : ""; echo ">Extintor</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_mangueiras'"; print $_GET[sp] == 's6sp_mangueiras' ? " class='roundborderselected' " : ""; echo ">Mangueira</a> | ";
    echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_sinalizacao'"; print $_GET[sp] == 's6sp_sinalizacao' ? " class='roundborderselected' " : ""; echo ">Sinalização</a>";

    echo "</font></center>";
    
    echo "<BR>";
    
    if($_GET[sp]){
        if(file_exists(current_module_path.anti_injection($_GET[sp]).'.php')){
            include(anti_injection($_GET[sp]).'.php');
        }else{
            showMessage('A página solicitada não está disponível no servidor. Por favor, entre em contato com o setor de suporte!',2);
        }
    }
?>
