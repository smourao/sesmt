<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP
/*****************   DATA   ****************/

//Recebendo o Ano Atual

if($_GET[y]){
	
	$ano = $_GET[y];

}else{
	
	$ano = date("Y");
	
}

//Recebendo Mes Atual para Numero

if($_GET[m]){
	
	$mes = $_GET[m];

}else{
	
	$mes = date("m");
	
}


if($mes >= 12){
	$n_mes = 01;
	$n_ano = $ano+1;
	$p_mes = $mes-1;
	$p_ano = $ano;
}elseif($mes <= 01){
	$n_mes = $mes+1;
	$n_ano = $ano;
	$p_mes = 12;
	$p_ano = $ano-1;
}else{
	$n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
	$n_ano = $ano;
	$p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
	$p_ano = $ano;
}

$p_ano = STR_PAD($p_ano, 2, "0", STR_PAD_LEFT);
$p_mes = STR_PAD($p_mes, 2, "0", STR_PAD_LEFT);
$n_ano = STR_PAD($n_ano, 2, "0", STR_PAD_LEFT);
$n_mes = STR_PAD($n_mes, 2, "0", STR_PAD_LEFT);




//Recebendo o Mes Atual para Nome
$mes_atual = $mes;


if($mes_atual == "01"){
$mes_atual = "Janeiro";
}
if($mes_atual == "02"){
$mes_atual = "Fevereiro";
}
if($mes_atual == "03"){
$mes_atual = "Mar?o";
}
if($mes_atual == "04"){
$mes_atual = "Abril";
}
if($mes_atual == "05"){
$mes_atual = "Maio";
}
if($mes_atual == "06"){
$mes_atual = "Junho";
}
if($mes_atual == "07"){
$mes_atual = "Julho";
}
if($mes_atual == "08"){
$mes_atual = "Agosto";
}
if($mes_atual == "09"){
$mes_atual = "Setembro";
}
if($mes_atual == "10"){
$mes_atual = "Outubro";
}
if($mes_atual == "11"){
$mes_atual = "Novembro";
}
if($mes_atual == "12"){
$mes_atual = "Dezembro";
}






/***************************************************************************************************/

$sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$_SESSION['usuario_id']}'";
        $r = pg_query($sql);
        $func = pg_fetch_array($r);
				
				

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Nova O.S.</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

   
		
		?>
		
		<form method="post">
		
        <?php
		
		
		if(!$_GET['s']){
     		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    		echo "<tr>";
    		echo "<td width=150 align=right>Selecione o setor:</td>";
   	 		echo "<td>";
    		$sql = "SELECT * FROM setor_sesmt";
    		$r = pg_query($sql);
    		$setores = pg_fetch_all($r);
    		for($x=0;$x<pg_num_rows($r);$x++){
        		echo "<a href='?dir=ordem_servico&p=index&action=new&s={$setores[$x]['id']}' class=fontebranca12><b>{$setores[$x]['nome_setor']}</b></a>";
        		echo "<BR>";
    		}
    		echo "</td>";
    		echo "</tr>";
    		echo "</table>";
		}

		
		
	if($_GET[s]){
    if(!$_POST){
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>D?:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b>$func[nome]<input type=hidden name=de value='{$_SESSION[usuario_id]}'>";
				
                echo "</td>";

            echo "</tr>";
			
            echo "<tr>";
			
				$sql = "SELECT * FROM setor_sesmt WHERE id = '$_GET[s]'";
        		$r = pg_query($sql);
        		$setor = pg_fetch_array($r);

				echo "<td class='text'>";

				echo "<b>Setor:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "{$setor[nome_setor]}<input type=hidden name=setor value='{$setor[id]}'>";
				
                echo "</td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Para:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";
				
				$sql = "SELECT * FROM funcionario WHERE cod_setor = '{$_GET[s]}' and status = 1 ORDER BY nome";
           	 	$r = pg_query($sql);
            	$fl = pg_fetch_all($r);
            	echo "<select name=para id=para>";
				
				if((pg_num_rows($r)) == 1){
					
					
            	for($x=0;$x<pg_num_rows($r);$x++){
             		echo "<option value='{$fl[$x][funcionario_id]}'>{$fl[$x][nome]}</option>";
           	 	}
					echo "<option value=0>Qualquer funcion?rio do setor</option>";
				
				}else{
            	echo "<option value=0>Qualquer funcion?rio do setor</option>";
            	for($x=0;$x<pg_num_rows($r);$x++){
             		echo "<option value='{$fl[$x][funcionario_id]}'>{$fl[$x][nome]}</option>";
           	 	}
				
				}
            	echo "</select>";
				
                echo "</td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Assunto:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<input type=text name=assunto id=assunto size=30>";
				
                echo "</td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Prioridade:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<select name=prioridade>";
				echo "<option value=1>Alta</option><option value=2 selected>M?dia</option><option value=3>Baixa</option></select>";
				
                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Previs?o T?rmino:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<input type=text size=10 maxlength=10 name=data_termino id=data_termino onkeypress=\"formatar(this, '##/##/####');\"> <font size=1>(Caso n?o haja previs?o de t?rmino, deixe em branco)</font>";
				
                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";
			
        		echo "<td colspan=2 align=center><textarea rows=5 id=msg name=msg style=\"width: 100%;\"></textarea></td>";

        	echo "</tr>";
			
			
		 echo "</table>";
		 
		 echo "<center>";
         echo "<input type=submit value='Enviar'>";
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
			
            echo "<center>Uma O.S. com o mesmo teor j? existe!</center>";
			
        }else{
            
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
                echo "<center>O.S. N?:<font color=red>".STR_PAD($max, 4, "0", STR_PAD_LEFT)."/".date("Y")."</font> cadastrada com sucesso!</center>";
/*********************************************************************************************************/
            
			
			
			
					if($_POST[para] == 0){
						
						
						$user_sqlss = "SELECT email FROM funcionario WHERE cod_setor = '{$_POST[setor]}' AND status = 1";
   						$user_resultss = pg_query($user_sqlss);
    					$grupocad = pg_fetch_all($user_resultss);
						$grupocadnum = pg_num_rows($user_resultss);
						
						$emailgrupo = '';
						
						for($j=0;$j<$grupocadnum;$j++){
						$emailgrupo .= $grupocad[$j]['email'];
						$emailgrupo .= ';';
						}
						
						$manda_email = $emailgrupo;
					
					}else{
						
						$pegardadossql = "SELECT email FROM funcionario WHERE funcionario_id = '{$_POST[para]}'";
						$pegardadosquery = pg_query($pegardadossql);
						$pegardados = pg_fetch_array($pegardadosquery);
						
						$manda_email = $pegardados['email'];
						
					}
			
			
			
			$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Abertura de Ordem de Servi?o</TITLE>
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
			   
            <table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>?</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVI?OS ESPECIALIZADOS DE SEGURAN?A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Ordem de Servi?o</b>
            </td>
	  </tr>
	</table>
			
			
			<br>
            <div align=\"center\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
            	<tr>
            		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
            		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
            		  <p align=justify>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Uma nova O.S. foi gerada no sistema com o t?tulo: <b>{$_POST[assunto]}</b> em ".date("d/m/Y H:i").". Com a mensagem: <b> ".$msg."</b>
            <p align=left>
            <p>
            <br></span>
                       </td>
            	</tr>
            </table></div>
            <p>
            <br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
               </BODY>
            </HTML>";
            
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            $headers .= "From: SESMT - Seguran?a do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
            mail($manda_email, 'Abertura de Ordem de Servi?o N? '.STR_PAD($max, 4, "0", STR_PAD_LEFT)."/".date("Y"), $msg, $headers);

            }else{
                echo "<center>Houve um erro ao gerar esta O.S.![erro s117]</center>";
            }
        }
    }
	}

   

    echo "</td>";

    echo "</tr>";

    echo "</table>";



?>
</body>
</html>