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
$mes_atual = "Mar�o";
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

$num_os = $_GET[os];

$sql = "SELECT i.*, s.nome_setor FROM os_info i, setor_sesmt s
    WHERE
    i.id = '$num_os'
    AND
    i.setor = s.id";
    $result = pg_query($sql);
    $info = pg_fetch_array($result);
	
	
	
				$status = "";
                $prioridade = "";
                switch($info[status]){
                    case 0:
                        $status = "Aberto";
                    break;
                    case 1:
                        $status = "Finalizado";
                    break;
                    case 2:
                        $status = "Em Execu��o";
                    break;
                    case 3:
                        $status = "Cancelado";
                    break;
                    case 4:
                        $status = "Exclu�do";
                    break;
                    case 5:
                        $status = "Pendente";
                    break;
                    default:
                        $status = "Indefinido";
                    break;
                }
                switch($info[prioridade]){
                    case 0:
                        $prioridade = "Indefinido";
                    break;
                    case 1:
                        $prioridade = "Alta";
                    break;
                    case 2:
                        $prioridade = "M�dia";
                    break;
                    case 3:
                        $prioridade = "Baixa";
                    break;
                    default:
                        $prioridade = "Indefinido";
                    break;
                }
    
                $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$info[para]}'";
                $result = pg_query($sql);
                $para = pg_fetch_array($result);
				
				$user_sql = "SELECT funcionario_id FROM funcionario WHERE funcionario_id = '{$_SESSION[usuario_id]}'";
   				$user_result = pg_query($user_sql);
    			$cadcria = pg_fetch_array($user_result);
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
	$sql = "SELECT status, para, readed, aberto_por, readed_owner FROM os_info WHERE id='{$_GET[os]}'";
    $result = pg_query($sql);
    $st = pg_fetch_array($result);
	
    if($_GET[s]>=0 && is_numeric($_GET[s])){
        $sql = "UPDATE os_info SET status='{$_GET[s]}' WHERE id='{$_GET[os]}'";
        $result = pg_query($sql);
        
        //atualiza como n�o lida quando msg postada
        if($_SESSION[usuario_id] != $st[para] && $st[readed] != 0){
            $sql = "UPDATE os_info SET readed = 0 WHERE id = '$num_os'";
            pg_query($sql);
        }
        if($_SESSION[usuario_id] != $st[aberto_por]){
            $sql = "UPDATE os_info SET readed_owner = 0 WHERE id = '$num_os'";
            pg_query($sql);
        }

        switch($_GET[s]){
            case  0:
                if($st[status] != 0){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#66000c\"><i>O.S. marcada como Aberta.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
            case  1:
                if($st[status] != 1){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#19cb72\"><i>O.S. marcada como Finalizada.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
            case  2:
                if($st[status] != 2){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#cbb819\"><i>O.S. marcada como Em Execu��o.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
            case  3:
                if($st[status] != 3){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#868580\"><i>O.S. marcada como Cancelada.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
            case  4:
                if($st[status] != 4){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#868580\"><i>O.S. marcada como Exclu�da.<p>Esta mensagem ficar� dispon�vel apenas para o administrador!</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
            case  5:
                if($st[status] != 5){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#cbb819\"><i>O.S. marcada como Pendente.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
            break;
        }
    }
				
				
	if($_POST){
        $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
        VALUES
        ('{$_GET[os]}', '".addslashes($_POST[msg])."', '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 0)";
        $postado = pg_query($sql);
        
        //atualiza como n�o lida quando msg postada pelo owner
        if($_SESSION[usuario_id] != $st[para] && $st[readed] != 0){
            $sql = "UPDATE os_info SET readed = 0 WHERE id = '$num_os'";
            pg_query($sql);
        }
        //atualiza como n�o lida quando msg postada pelo executor
        if($_SESSION[usuario_id] != $st[aberto_por]){
            $sql = "UPDATE os_info SET readed_owner = 0 WHERE id = '$num_os'";
            pg_query($sql);
        }
    }
				
				
				

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Visualiza��o</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

   
		
		?>
		
		<form action="" id="frm" method="post">
		
        <?php
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Setor:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b>$info[nome_setor]";
				
				if($para[nome]){
            	echo " - $para[nome]";
        		}else{
            //echo " - Qualquer funcion�rio do setor";
        		} echo"</b>";
				
                echo "</td>";

            echo "</tr>";
			
            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Data:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b> ".date("d/m/Y H:i", strtotime($info[data_abertura]))." </b>";
				
                echo "</td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>T�rmino:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b>";
				
				if($info[data_conclusao])
        		echo date("d/m/Y H:i", strtotime($info[data_conclusao]));
        		else
        		echo "Prazo para t�rmino n�o especificado.";
				
                echo "</b></td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Assunto:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b> $info[assunto] </b>";
				
                echo "</td>";

            echo "</tr>";

            echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Status:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b> $status </b>";
				
                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Prioridade:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b> $prioridade </b>";
				
                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";

				echo "<td class='text'>";

				echo "<b>Marcar como:</b>";
				
                echo "</td>";
				
				echo "<td class='text'>";

				echo "<b> 
				
				<a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=0' class=fontebranca12><b>Aberto</b></a> |
        		<a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=1' class=fontebranca12><b>Finalizado</b></a> |
        		<a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=2' class=fontebranca12><b>Em Execu��o</b></a> |
        		<a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=5' class=fontebranca12><b>Pendente</b></a>";
				if($info[aberto_por] == $cadcria[funcionario_id]){
        		echo " | <a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=3' class=fontebranca12><b>Cancelado</b></a> |
        		<a href='?dir=ordem_servico&p=index&action=view&os={$_GET[os]}&s=4' class=fontebranca12><b>Exclu�da</b></a> </b>";
				}
                echo "</td>";

            echo "</tr>";
			
			
		 echo "</table>";
		 
		 echo "</form>";
		 
		 $sql = "SELECT o.*, f.nome FROM os_msg o, funcionario f
        WHERE cod_os = '$num_os'
        AND
        o.postado_por = f.funcionario_id
        ORDER BY data_postagem
        ";
        $result = pg_query($sql);
        $msg = pg_fetch_all($result);
		 
		 echo "<table width=100% border=2 bordercolor='#61B72E' cellspacing=2 cellpadding=2>";
		 
		 echo "<tr>";
		 
		 echo "<td>";
		 
		 for($x=0;$x<pg_num_rows($result);$x++){
			 
			 if($x % 2 == 0){
				 
				 $bgcolor = "#000";
				 
			 }else{
				 
				 $bgcolor = "#FFF";
				 
			 }
			 
			 
			echo "<table width=100% cellspacing=2 cellpadding=2>";
			 
            echo "<tr>";
			
				if($msg[$x][postado_por] == $info[aberto_por]){

				echo "<td class='text' width=80% align=left bordercolor=".$bgcolor." bgcolor='#000'>";
				echo $msg[$x]['nome']." [Solicitante]" ;
				echo "</td>";
				echo "<td align=right class='text' bordercolor=".$bgcolor." bgcolor='#000'>";
				echo date("d/m/Y H:i", strtotime($msg[$x][data_postagem]));
				echo "</td>";
				
				}else{
					
				echo "<td class='text' width=80% align=left bordercolor=".$bgcolor." bgcolor='#66000A'>";
				echo $msg[$x]['nome']." [Executor do Servi�o]";
				echo "</td>";
				echo "<td align=right class='text' bordercolor=".$bgcolor." bgcolor='#66000A'>";
				echo date("d/m/Y H:i", strtotime($msg[$x][data_postagem]));
				echo "</td>";
				
				}
				
				
				
				echo "</tr>";
				
				echo "<tr>";
				
				echo "<td class='text' colspan='2' border=1 bgcolor='#007D3F' bordercolor=".$bgcolor.">";
				
				echo nl2br($msg[$x]['msg']);
				
				echo "</td>";
				
            	echo "</tr>";
				
				echo "<tr>";
				
				echo "<td class='text' colspan='2' bgcolor='#007D3F'>";
				
				echo "<small><small><i>".$msg[$x]['ip']."</i></small></small>" ;
				
				echo "</td>";
				
            	echo "</tr>";
			
				echo "</table>";
			
		 }
		 
		 
		echo "</td>";
		 
		echo "</tr>";
		 	
		echo "</table>";
		
		echo "<P>";
		
		if($info[status] == 0 || $info[status] == 2 || $info[status] == 5){
            echo "<form method=post>";
            echo "<table width=100% BORDER=0 cellspacing=0 cellpadding=0>";
            echo "<tr>";
            echo "<td align=left class=fontebranca12><b>Resposta:</b></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align=center><textarea rows=5 name=msg style=\"width: 100%;\"></textarea></td>";
            echo "<td>";
            echo "</tr>";
            echo "</table>";
            echo "<center>";
            echo "<input type=submit value='Responder'>";
            echo "</center>";
            echo "</form>";
        }

   

    echo "</td>";

    echo "</tr>";

    echo "</table>";



?>
</body>
</html>