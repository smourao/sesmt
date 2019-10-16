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
$mes_atual = "Março";
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

if($_GET[o]){
	$ord = $_GET[o];
}else{
	$ord = "data_abertura";
}

	
	if(empty($_GET[page]) || $_GET[page] < 0) $_GET[page] = 1;
	
	$rpp = 50;
	
	$sql = "SELECT count(*) as n FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                aberto_por = '{$_SESSION[usuario_id]}'";

	$respage = pg_query($sql);
    $nitems = pg_fetch_array($respage);
    $nitems = $nitems[n];
	
	
	$user_sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$_SESSION[usuario_id]}'";
    $user_result = pg_query($user_sql);
    $user_data = pg_fetch_array($user_result);
	
	
	
		
			
				if(!$_GET[page]){
				$os_infosql = "SELECT os.*, ss.nome_setor FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                aberto_por = '{$_SESSION[usuario_id]}'
                ORDER BY id DESC LIMIT 50 OFFSET 0";
				
				}else{
					
				$offsets = ($_GET[page] - 1)*$rpp;
					
				$os_infosql = "SELECT os.*, ss.nome_setor FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                aberto_por = '{$_SESSION[usuario_id]}'
                ORDER BY id DESC LIMIT 50 OFFSET $offsets";
					
					
				}
						
						
		
						
	$os_infoquery = pg_query($os_infosql);
	
	$os_info = pg_fetch_all($os_infoquery);
	
	$os_infonum = pg_num_rows($os_infoquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Lista de Pedidos</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

   
		
		
		 echo "<table width=100%>";
		 	echo "<tr>";
				echo "<td>";
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
		echo "<center><font size=1>";
if(ceil($nitems/$rpp)>=5){
    echo "[ ";
    if($_GET[page] > 2){
        if($_GET[page]<=(ceil($nitems/$rpp)-2)){
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=1'>Primeira</a> |";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".($_GET[page]-2)."'>".($_GET[page]-2)."</a> |";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".($_GET[page]-1)."'>".($_GET[page]-1)."</a> |";
            echo " <a class='roundborderselected' href='?dir=ordem_servico&p=index&action=minha_ordem&page=".($_GET[page])."'>".($_GET[page])."</a> | ";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".($_GET[page]+1)."'>".($_GET[page]+1)."</a> | ";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".($_GET[page]+2)."'>".($_GET[page]+2)."</a> | ";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp))."'>Última</a>";
        }else{
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=1'>Primeira</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 4 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp)-4)."'>".(ceil($nitems/$rpp)-4)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 3 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp)-3)."'>".(ceil($nitems/$rpp)-3)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 2 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp)-2)."'>".(ceil($nitems/$rpp)-2)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 1 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp)-1)."'>".(ceil($nitems/$rpp)-1)."</a> | ";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=".ceil($nitems/$rpp)."'>".ceil($nitems/$rpp)."</a> | ";
            echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp))."'>Última</a>";
        }
        //echo round($nitems/$rpp);
    }else{ 
        echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=1'>Primeira</a> |";
        echo " <a"; print $_GET[page]== 1 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=1'>1</a> |";
        echo " <a"; print $_GET[page]== 2 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=2'>2</a> |";
        echo " <a"; print $_GET[page]== 3 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=3'>3</a> |";
        echo " <a"; print $_GET[page]== 4 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=4'>4</a> | ";
        echo " <a"; print $_GET[page]== 5 ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=5'>5</a> | ";
        echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp))."'>Última</a>";
    }
    echo " ]";
    echo "<BR>";
    echo " <div style=\"display: inline;\">";
        echo "<span class='curhand' onclick=\"changeDivVis(document.getElementById('gotopage'), 2);\" alt='Permite que seja acessado uma página específica da busca.' title='Permite que seja acessado uma página específica da busca.'>
        <font size=1>Selecionar página</font></span>";
        echo "<div id='gotopage' style=\"display: none;\">";
        echo "<table border=0><tr><td valign=middle>";
        echo "<input type='text' name='topagenum' id='topagenum' value='$_GET[page]' size=4 style=\"height: 14px; font-size: 9px;\">";
        echo "</td><td valign=middle>";
        echo "<input type=button value='Ir' style=\"height: 16px; width: 20px; font-size: 10px;\" onclick=\"location.href='?dir=ordem_servico&p=index&action=minha_ordem&page='+document.getElementById('topagenum').value;\">";
        echo "</td></tr></table>";
        echo "</div>";
    echo "</div>";
}elseif(($nitems/$rpp)<=1){
   //nothing to show
}else{
    echo "[ ";
    echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=1'>Primeira</a> |";
    for($x=1;$x<=ceil($nitems/$rpp);$x++){
        echo " <a"; print $_GET[page]== $x ? " class='roundborderselected' ":""; echo " href='?dir=ordem_servico&p=index&action=minha_ordem&page=$x'>$x</a> |";//echo ($x+1)." | ";
    }
    echo " <a href='?dir=ordem_servico&p=index&action=minha_ordem&page=".(ceil($nitems/$rpp))."'>Última</a>";
    echo " ]";
}
echo "</font></center>";
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
				
				echo "</td>";
			echo "<tr>";
		 echo "</table>";
		 
		
		 
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=10% align=center class='text'>";

				echo "<b>O.S.</b>";

				echo "</td>";
				
				echo "<td width=20% align=center class='text'>";

                echo "<b>Data Abertura</b>";

                echo "</td>";

                echo "<td width=30% align=center class='text'>";

                echo "<b>Assunto</b>";

                echo "</td>";

				echo "<td width=20% align=center class='text'>";

                echo "<b>Setor</b>";

                echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

                echo "<b>Status</b>";

                echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

                echo "<b>Prioridade</b>";

                echo "</td>";

            echo "</tr>";
			
			for($x=0;$x<$os_infonum;$x++){
			
			$br_data1 = explode('-',($pacnpj[$x][data_lancamento]));
			$br_data2 = $br_data1[2].'/'.$br_data1[1].'/'.$br_data1[0];	
				
				
			
			echo "<tr>";
		
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo STR_PAD($os_info[$x][id], 4, "0", STR_PAD_LEFT)."/".date("Y", strtotime($os_info[$x][data_abertura]) );

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo date("d/m/Y H:i", strtotime($os_info[$x][data_abertura]) );

                echo "</td>";
				
				
				
				
				
				
				$sqlcarta = "SELECT o.*, f.nome FROM os_msg o, funcionario f
                WHERE cod_os = '{$os_info[$x][id]}'
                AND
                o.postado_por = f.funcionario_id
                ORDER BY o.data_postagem
                ";
                $rmsg = pg_query($sqlcarta);
                $lmsg = pg_fetch_all($rmsg);
                $l = pg_num_rows($rmsg)-1;
                
                
                
                //exibir cartinha se tiver msg de outro usuário como última
                if($_SESSION[usuario_id] != $lmsg[$l][postado_por] && $_SESSION[usuario_id] == $os_info[$x][para] && $os_info[$x][readed] == 0){
                    //se for pra qualquer 1 ou pra mim
                    if($_SESSION[usuario_id] == $os_info[$x][para] || $os_info[$x][para] == 0){
                        //se não tiver finalizado nem cancelado
                        if($os_info[$x][status] == 0 || $os_info[$x][status] == 2){
                            $new = "<img src='modules/ordem_servico/new.gif' border=0 width=21 height=12>";
                        }else{
                            $new = "<img src='modules/ordem_servico/nonew.gif' width=21 height=12 border=0>";
                        }
                    }else{
                        $new = "<img src='modules/ordem_servico/nonew.gif' width=21 height=12 border=0>";
                    }
                }else{
                    //Se owner logado
                    if($_SESSION[usuario_id] == $os_info[$x][aberto_por]){
                        if($os_info[$x][readed_owner]){
                            $new = "<img src='modules/ordem_servico/nonew_readed.png' border=0 width=21 height=16>";
                        }else{
                            $new = "<img src='modules/ordem_servico/new.gif' border=0 width=21 height=12>";
                        }
                        
                    //Se usuário diferente de owner
                    }else{
                       
                            if($os_info[$x][readed]){
                                $new = "<img src='modules/ordem_servico/nonew_readed.png' width=21 height=16 border=0>";
                            }else{
                                $new = "<img src='modules/ordem_servico/nonew.gif' width=21 height=12 border=0>";
                            }
                        
                    }
                    
                }
                $lnome = explode(" ", $lmsg[$l][nome]);
                if(strlen($lnome[1])>3){
                    $nomecurto = $lnome[0]." ".$lnome[1];
                }else{
                    $nomecurto = $lnome[0]." ".$lnome[1]." ".$lnome[2];
                }
				
				
				
				
				
				
				
				
				
				
				
				
				

                echo "<td align=center class='text roundbordermix curhand'> $new  ";

                     echo "&nbsp;<b>
						<a href='?dir=ordem_servico&p=index&action=view&os={$os_info[$x][id]}' class=fontebranca12><b>{$os_info[$x][assunto]}</b></a></b>
						<BR><font size=1><b>Última mensagem: </b>{$nomecurto}</font>";

                echo "</td>";
				
				
				$sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$os_info[$x][para]}'";
                $result = pg_query($sql);
                $para = pg_fetch_array($result);
                
                if($para[nome]){
                $n = explode(" ", $para[nome]);
                if(strlen($n[1])>3){
                    $nome = $n[0]." ".$n[1];
                }else{
                    $nome = $n[0]." ".$n[1]." ".$n[2];
                }
                }
				
				
				
				
				$sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$os_info[$x][aberto_por]}'";
                $result = pg_query($sql);
                $by = pg_fetch_array($result);

                if($by[nome]){
                $n = explode(" ", $by[nome]);
                if(strlen($n[1])>3){
                    $por = $n[0]." ".$n[1];
                }else{
                    $por = $n[0]." ".$n[1]." ".$n[2];
                }
                }
				
				
				
				 echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<font size=1>Por: {$por}</font><BR>{$os_info[$x][nome_setor]}"; print $para[nome] ? "<br><font size=1>Para: $nome</font>" : "<br><font size=1>&nbsp;</font>";

                echo "</td>";
				
				switch($os_info[$x][status]){
                    case 0:
                        $status = "Aberto";
                    break;
                    case 1:
                        $status = "Finalizado";
                    break;
                    case 2:
                        $status = "Em Execução";
                    break;
                    case 3:
                        $status = "Cancelado";
                    break;
                    case 4:
                        $status = "Excluído";
                    break;
                    case 5:
                        $status = "Pendente";
                    break;
                    default:
                        $status = "Indefinido";
                    break;
                }
				
				
				
				 echo "<td class=fontebranca12 align=center ";
                switch($os_info[$x][status]){
                    case 0:
                        echo " bgcolor='#66000c' ";
                    break;
                    case 1:
                        echo " bgcolor='#19cb72' ";
                    break;
                    case 2:
                        echo " bgcolor='#cbb819' ";
                    break;
                    case 3:
                        echo " bgcolor='#868580' ";
                    break;
                    case 4:
                        echo " bgcolor='#868580' ";
                    break;
                    case 5:
                        echo " bgcolor='#cbb819' ";
                    break;
                    default:
                        echo " bgcolor='#006633' ";
                    break;
                }
                echo " >$status</td>";
				
				
				
				switch($os_info[$x][prioridade]){
                    case 0:
                        $prioridade = "Indefinido";
                    break;
                    case 1:
                        $prioridade = "Alta";
                    break;
                    case 2:
                        $prioridade = "Média";
                    break;
                    case 3:
                        $prioridade = "Baixa";
                    break;
                    default:
                        $prioridade = "Indefinido";
                    break;
                }
				
				
				
				 echo "<td align=center class='text roundbordermix curhand'>";

                    echo $prioridade;

                echo "</td>";
				
			
			echo "</tr>";
			
			}
			
		echo "</table>";

   

    echo "</td>";

    echo "</tr>";

    echo "</table>";



?>
</body>
</html>