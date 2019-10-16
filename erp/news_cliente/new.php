<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', texto: 'Test 1'},
        {title: 'Test template 2', texto: 'Test 2'}
    ]
});
</script>




<script>
function cs1(){
    if(document.getElementById("titulo").value == ""){
        document.getElementById("titulo").focus();
        alert('Informe um título para o newsletter!');
        return false;
    }
    
   /* if(document.getElementById("texto").value == ""){
        document.getElementById("texto").focus();
        alert('Insira um texto para o newsletter!');
        return false;
    } */
    
    if(document.getElementById("clientes").checked == false && document.getElementById("simulador").checked == false && document.getElementById("clinicas").checked == false){
        alert('Selecione um tipo de cadastro para envio! (Cliente, simulador ou ambos)');
        return false;
    }
    
    if(document.getElementById("princ").checked == false && document.getElementById("contador").checked == false && document.getElementById("direto").checked == false && document.getElementById("indireto").checked == false){
        alert('Selecione os campos de email para envio! (Principal, contadores, contato direto ou indireto)');
        return false;
    }

    return true;
}


</script>
<?PHP

    if(!$_GET[s]){
        echo "<center><b>Cadastro de Newsletter</b></center>";
        echo "<P>";

        echo "<FORM method=post action='?action=new&s=2'>";
        echo "<table width=100% BORDER=0 align=center>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Título:</b></td>";
        echo "<td>";
        echo "<input type=text name=titulo id=titulo value='$_POST[titulo]' size=35>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Mensagem:</b></td>";
        echo "<td>";
        echo "<textarea name=texto id=texto cols=60 rows=10></textarea>";
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Enviar para:</b></td>";
        echo "<td>";
        echo "<input type=checkbox name=clientes id=clientes checked><font size=1> Clientes &nbsp;&nbsp;";
        //echo "<input type=checkbox name=simulador id=simulador><font size=1> Simulador &nbsp;&nbsp;";
        //echo "<input type=checkbox name=parceiros id=parceiros><font size=1> Parceria Comercial &nbsp;&nbsp;";
        echo "<input type=checkbox name=clinicas id=clinicas><font size=1> Clínicas &nbsp;&nbsp;";
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>&nbsp;</b></td>";
        echo "<td>";
        echo "<input type=checkbox name=princ id=princ checked><font size=1> Email Principal &nbsp;&nbsp;";
        echo "<input type=checkbox name=contador id=contador checked><font size=1> Contadores &nbsp;&nbsp;";
        echo "<input type=checkbox name=direto id=direto checked><font size=1> Contato Direto &nbsp;&nbsp;";
        echo "<input type=checkbox name=indireto id=indireto checked><font size=1> Contato Indireto &nbsp;&nbsp;";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
        echo "<center><input type=submit value='Enviar Newsletter' name=continue onclick=\"return cs1();\"></center>";
        echo "</form>";
    }
    
    if($_GET[s]==2){
        echo "<center>Atualizando, aguarde...</center>";
            $sql = "INSERT INTO site_newsletter_msg (titulo, texto, data_criacao, enviado_por) VALUES
            ('".addslashes($_POST[titulo])."', '".addslashes($_POST[texto])."', '".date("Y/m/d")."', '{$_SESSION[usuario_id]}')";
            pg_query($sql);
            
            $sql = "SELECT max(id) as a FROM site_newsletter_msg";
            $result = pg_query($sql);
            $max = pg_fetch_array($result);
            $max = $max[a];
            $msql = array();
            if($_POST[clientes]){
                $msql[] = "SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente";
            }
            if($_POST[parceiros]){
                $msql[] = "SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente_pc";
            }
            if($_POST[simulador]){
                $msql[] = "SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente_comercial";
            }
            if($_POST[clinicas]){
                $msql[] = "SELECT email_clinica as email, cod_clinica as cliente_id, 0 as filial_id, email_contato as email_contato_dir, '' as email_contador, '' as email_cont_ind FROM clinicas";
            }
            $sql = "";
            for($i=0;$i<count($msql);$i++){
                if(!empty($msql[$i]))
                    $sql .= $msql[$i];
                if(!empty($msql[$i+1])){
                    $sql .= "
                    UNION ";
                }
            }

            //retorna vazio -> só pra não dar erro
            if(!$_POST[simulador] && !$_POST[clientes] && !$_POST[parceiros] && !$_POST[clinicas]){
                $sql = "SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente WHERE cliente_id < 0";
            }
            
            $result = pg_query($sql);
            $lista = pg_fetch_all($result);
            $allmail = array();
            $cl = array();
            for($x=0;$x<pg_num_rows($result);$x++){

                if($_POST[princ]){
                    if($lista[$x][email]){
                        $emails = explode(";", str_replace("/", ";", $lista[$x][email]));
                        for($l=0;$l<count($emails);$l++){
                            if($emails[$l]){
                                $cl[] = $emails[$l];//$lista[$x][email];
                            }
                        }
                    }
                }

                if($_POST[direto]){
                    if($lista[$x][email_contato_dir]){
                        $emails = explode(";", str_replace("/", ";", $lista[$x][email_contato_dir]));
                        for($l=0;$l<count($emails);$l++){
                            if($emails[$l]){
                                $cl[] = $emails[$l];//$lista[$x][email];
                            }
                        }
                    }
                }
                if($_POST[contador]){
                    if($lista[$x][email_contador]){
                        $emails = explode(";", str_replace("/", ";", $lista[$x][email_contador]));
                        for($l=0;$l<count($emails);$l++){
                            if($emails[$l]){
                                $cl[] = $emails[$l];//$lista[$x][email];
                            }
                        }
                    }
                }

                if($_POST[indireto]){
                    if($lista[$x][email_cont_ind]){
                        $emails = explode(";", str_replace("/", ";", $lista[$x][email_cont_ind]));
                        for($l=0;$l<count($emails);$l++){
                            if($emails[$l]){
                                $cl[] = $emails[$l];//$lista[$x][email];
                            }
                        }
                    }
                }

                $cl = array_flip($cl);
                $cl = array_flip($cl);
            }
            for($y=0;$y<count($cl);$y++){
                if(!empty($cl[$y])){
                    $sql = "INSERT INTO site_newsletter_mail
                    (email, noticia_id)
                    VALUES
                    ('{$cl[$y]}', '{$max}')";
                    pg_query($sql);
                    //echo $sql."<BR>";
					
					
					$titulonew = $_POST['titulo'];
					
					$textonew = $_POST['texto'];
					
					$datahoranew = date("Y-m-d H:i:s");
					
					
					
					
					$headers = "MIME-Version: 1.0\n";
   					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					if($y == 1){
    					$headers .= 'From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> ' . "\n" .
    					'Bcc: piccolo.dbz89@hotmail.com; comercial@sesmt-rio.com; suporte@sesmt-rio.com' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}else{
						$headers .= 'From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}
							
					$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>SESMT: ".$titulonew."</TITLE><META http-equiv=Content-type: text/html; charset=UTF-8\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
                    <BODY>";

                    $msg .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
					<font face='verdana,arial,sans-serif'>
                    <center><h1><strong>".$titulonew."</strong></h1></center>
					</font>
                    <p></p>
					<p></p>
					<p></p>
					<font face='verdana,arial,sans-serif' size='3'>
                    ".$textonew."
					</font>
                    </td>
                    </tr>
                    </table>";

                    $msg .= "
                    </BODY></HTML>";
                    // --> SEND EMAIL TO REGISTERED USER ------------------------------------------------
                    if(mail($cl[$y], "SESMT: ".$titulonew, $msg, $headers)){
						
						$updateenviosql = "UPDATE site_newsletter_mail SET data_envio='$datahoranew',status=1 WHERE email='$cl[$y]' AND noticia_id = $max ";
						$updateenvio = pg_query($updateenviosql);
						
						$error = 0;
					}else{
                        $error = 8;
					}
					
					sleep(1);
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
                }
            }
            echo "<script>location='?action=list';</script>";
    }


?>
