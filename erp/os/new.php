<script>
function checkall(){
    if(document.getElementById("assunto").value == ""){
        alert('O campo Assunto deve ser preenchido!');
        document.getElementById("assunto").focus();
        return false;
    }
    if(document.getElementById("msg").value == ""){
        alert('O campo destinado a mensagem não deve ficar em branco!');
        document.getElementById("msg").focus();
        return false;
    }
    
    var formatado = document.getElementById("data_termino").value;
    if (formatado.length == 10){
        if(!formatado.match(/^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/\d{4}$/)){
            alert('Data Inválida! - ' + formatado);
            document.getElementById("data_termino").focus();
            return false;
        }
    }else{
        if(formatado.length > 0){
            alert('A previsão para término deve estar no formato: dd/mm/yyyy');
            return false;
        }
    }
    return true;
}

function fdata(objeto){
    if (objeto.value.length == 2 || objeto.value.length == 5 ){
        objeto.value = objeto.value+"/";
    }
}

</script>
<?PHP
//Se setor não for selecionado
if(!$_GET['s']){
    echo "<table width=100% BORDER=0 align=center>";
    echo "<tr>";
    echo "<td width=150 align=right>Selecione o setor:</td>";
    echo "<td>";
    $sql = "SELECT * FROM setor_sesmt";
    $r = pg_query($sql);
    $setores = pg_fetch_all($r);
    for($x=0;$x<pg_num_rows($r);$x++){
        echo "<a href='?action=new&s={$setores[$x]['id']}' class=fontebranca12><b>{$setores[$x]['nome_setor']}</b></a>";
        echo "<BR>";
    }
    echo "</td>";
    echo "</tr>";
    echo "</table>";
}




if($_GET[s]){
    if(!$_POST){
        //print_r($_SESSION);
        $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$_SESSION['usuario_id']}'";
        $r = pg_query($sql);
        $func = pg_fetch_array($r);

        $sql = "SELECT * FROM setor_sesmt WHERE id = '$_GET[s]'";
        $r = pg_query($sql);
        $setor = pg_fetch_array($r);
        echo "<form method=post>";
        echo "<table width=100% BORDER=0 align=center>";
        echo "<tr>";
        echo "<td width=200 align=right><b>Dê:</b></td>";
        echo "<td>{$func[nome]}<input type=hidden name=de value='{$_SESSION[usuario_id]}'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=200 align=right><b>Setor:</b></td>";
        echo "<td>{$setor[nome_setor]}<input type=hidden name=setor value='{$setor[id]}'></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=200 align=right><b>Para:</b></td>";
        echo "<td>";
            $sql = "SELECT * FROM funcionario WHERE cod_setor = '{$_GET[s]}' ORDER BY nome";
            $r = pg_query($sql);
            $fl = pg_fetch_all($r);
            echo "<select name=para id=para>";
            echo "<option value=0>Qualquer funcionário do setor</option>";
            for($x=0;$x<pg_num_rows($r);$x++){
                echo "<option value='{$fl[$x][funcionario_id]}'>{$fl[$x][nome]}</option>";
            }
            echo "</select>";
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=200 align=right><b>Assunto:</b></td>";
        echo "<td><input type=text name=assunto id=assunto size=30></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=200 align=right><b>Prioridade:</b></td>";
        echo "<td><select name=prioridade><option value=1>Alta</option><option value=2 selected>Média</option><option value=3>Baixa</option></select></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=200 align=right><b>Previsão Término:</b></td>";
        echo "<td><input type=text size=10 maxlength=10 name=data_termino id=data_termino onkeyup='fdata(this);'> <font size=1>(Caso não haja previsão de término, deixe em branco)</font></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=2 align=center><textarea rows=5 id=msg name=msg style=\"width: 100%;\"></textarea></td>";

        echo "</tr>";
        echo "</table>";
        echo "<center>";
        echo "<input type=submit value='Enviar' onclick=\"return checkall();\">";
        echo "</center>";
        echo "</form>";
    }else{
        $sql = "SELECT * FROM os_info
        WHERE
        aberto_por = '{$_SESSION['usuario_id']}'
        AND
        assunto = '{$_POST[assunto]}'
        AND
        msg = '{$_POST[msg]}'
        AND
        setor = '$_POST[setor]'
        AND
        para = '{$_POST[para]}'";
        $result = pg_query($sql);
        if(pg_num_rows($result)>0){
            echo "<center>Uma O.S. com o mesmo teor já existe!</center>";
        }else{
            //
            $msg = addslashes($_POST[msg]);
            $de = $_POST[de];
            $assunto = addslashes($_POST[assunto]);
            
            if(empty($_POST[data_termino])){
                $termino = 'null';
            }else{
                $tmp = explode("/", $_POST[data_termino]);
                $termino = "'".$tmp[2]."/".$tmp[1]."/".$tmp[0]." 18:00:00'";
            }
            
            $sql = "INSERT INTO os_info
            (aberto_por, setor, assunto, prioridade, para, msg, data_abertura, data_conclusao, status)
            VALUES
            ('{$de}', '{$_POST[setor]}', '{$assunto}', '{$_POST[prioridade]}',
            '{$_POST[para]}', '{$msg}', '".date('r')."',{$termino}, '0')";
            //echo $sql;
            $s1 = pg_query($sql);
            if($s1){
                $sql = "SELECT MAX(id) as max FROM os_info";
                $result = pg_query($sql);
                $max = pg_fetch_array($result);
                $max = $max[max];
                $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip)
                VALUES
                ('{$max}', '{$msg}', '".date("r")."', '{$de}', '{$_SERVER[REMOTE_ADDR]}')";
                $s2 = pg_query($sql);
            }
            if($s1 && $s2){
                echo "<center>O.S. Nº:<font color=red>".STR_PAD($max, 4, "0", STR_PAD_LEFT)."/".date("Y")."</font> cadastrada com sucesso!</center>";
/*********************************************************************************************************/
            $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Abertura de Ordem de Serviço</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
            <style type=\"text/css\">
            td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
            .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
            .style13 {font-size: 14px}
            .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
            .style16 {font-size: 9px}
            .style17 {font-family: Arial, Helvetica, sans-serif}
            .style18 {font-size: 12px}
            </style>
               </HEAD>
               <BODY>
            <div align=\"center\">
            <table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
            	<tr>
            		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
            		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
            		  Monitoramento de Atividades no Trabalho Ltda.</span>
            		  </font><br><br>
            		  <p class=\"style18\">
            		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
            		  <p>
            </td>
            	</tr>
            </table></div>
            <p>
            <br>
            <center><b>
            <span style='background: #008000; color: #FFFFFF;'>
            Abertura de Ordem de Serviço Nº ".STR_PAD($max, 4, "0", STR_PAD_LEFT)."/".date("Y")."
            </span></b></center>
            <p>
            <center>
            ************************************************<br>
            Mensagem Automática: Por favor, não responder   <br>
            ************************************************<br>
            <br>
            <div align=\"center\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
            	<tr>
            		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
            		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
            		  <p align=justify>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Uma nova O.S. foi gerada no sistema com o título: <b>{$_POST[assunto]}</b> em ".date("d/m/Y H:i").".
            <p align=left>
            <p>
            <br></span>
                       </td>
            	</tr>
            </table></div>
            <p>
            <br><p>
            <center>
            ************************************************<br>
            Mensagem Automática: Por favor, não responder   <br>
            ************************************************<br>
            </center>
            <p>
            <br>

            <br><p>
            <br>
            <div align=\"center\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
            	<p>
            		<tr>
            		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
            		<br /><br /><br /><br /><br /><br />
            		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
            		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
                      <p class=\"style17\">
            		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
                      www.sesmt-rio.com / www.shoppingsesmt.com<br />

            	    </td>
            		<td width=\"35%\" align=\"right\">
                    <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
            	</tr>
            </table></div>
               </BODY>
            </HTML>";
            
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
            //mail('celso.leo@gmail.com', 'Abertura de Ordem de Serviço Nº '.STR_PAD($max, 4, "0", STR_PAD_LEFT)."/".date("Y"), $msg, $headers);

            }else{
                echo "<center>Houve um erro ao gerar esta O.S.![erro s117]</center>";
            }
        }
    }
}
