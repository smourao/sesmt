<?php
/***************************************************************************************************/
// --> INFORMAÇÕES SOBRE AÇÕES
// ID DE TESTES PARA RETORNO:
// 1 - O.S.
// 2 - Aniversários
/***************************************************************************************************/
/***************************************************************************************************/
// --> DEFINE / SESSION
/***************************************************************************************************/
    header("Content-Type: text/html; charset=ISO-8859-1",true);
/***************************************************************************************************/
// --> MAIN INCLUDES
/***************************************************************************************************/
    include("database/conn.php");
    include("functions.php");
    include("globals.php");
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
    $var = $_GET[user_id]."|";
    $nt = 2;//Número de cases para exibição de informação!
    $pt = rand(0, ($nt-1));
switch($pt){
/**********************************************************************************************/
// -> Verificação de mensagens nas ordens de serviço.
/**********************************************************************************************/
    case 0:
        $sql = "SELECT * FROM funcionario WHERE funcionario_id = $_GET[user_id]";
        $res = pg_query($sql);
        $fun = pg_fetch_array($res);

        $sql = "SELECT os.* FROM os_info os, funcionario f
                WHERE
                f.funcionario_id = os.para
                AND
                (os.para = $_GET[user_id] OR os.setor = $fun[cod_setor])
                AND os.status <> 1 AND os.status <> 3 AND os.status <> 4";
        $rsc = pg_query($sql);

        $mrd = 0;//armazena o número de mensagens não lidas

        while($row = pg_fetch_array($rsc)){
            if(!$row[readed])
                $mrd++;
        }

        if(pg_num_rows($rsc)){
            //exibe número de ordens de serviços não finalizadas
            if(pg_num_rows($rsc)==1)
                $var .= "Existe <span class='roundborderselected'><b>".@pg_num_rows($rsc)."</b></span> ordem de serviço não finalizada para você ou seu setor.";
            else
                $var .= "Existem <span class='roundborderselected'><b>".@pg_num_rows($rsc)."</b></span> ordens de serviço não finalizadas para você ou seu setor.";

            //exibe mensagens não lidas se existirem
            if($mrd){
                if($mrd>1)
                    $var .= "&nbsp;&nbsp;&nbsp;<span class='roundborderselected'><b>$mrd</b></span> mensagens não lidas.";
                else
                    $var .= "&nbsp;&nbsp;&nbsp;<span class='roundborderselected'><b>$mrd</b></span> mensagem não lida.";
            }
        }else{
            $var .= "0";
        }
    break;
/**********************************************************************************************/
// -> Verificação de datas de nascimento.
/**********************************************************************************************/
    case 1:
        $sql = "SELECT * FROM funcionario WHERE EXTRACT(month FROM nascimento) = '".date("m")."' ORDER BY EXTRACT(day FROM nascimento) ASC";
        $res = pg_query($sql);
        if(pg_num_rows($res)){
            $nivers = pg_fetch_all($res);
            $var .= "Aniversariante(s) do mês: ";
            for($x=0;$x<pg_num_rows($res);$x++){
                $tname = explode(" ", $nivers[$x][nome]);
                $sname = $tname[0]." ".$tname[1];
                if(strlen($tname[1]) <= 3)
                    $sname .= " ".$tname[2];

                if(date("d") == date("d", strtotime($nivers[$x][nascimento])) && $nivers[$x][funcionario_id] == $_GET[user_id]){
                    $var .= "<span class='roundborderselected'><b>{$sname}</b>, parabéns pelo seu aniversário</span>";
                }elseif(date("d") == date("d", strtotime($nivers[$x][nascimento]))){
                    $var .= "<span class='roundborderselected'><b>{$sname}</b> hoje</span>";
                }else
                    $var .= "<b>{$sname}</b> dia ".date("d", strtotime($nivers[$x][nascimento]));

                if($x<pg_num_rows($res)-1)
                    $var .= " - ";
            }
        }else{
            $var .= "0";
        }
    break;
/**********************************************************************************************/
}
/**********************************************************************************************/
// -> Variável retornada com conteudo do 'infobar'
/**********************************************************************************************/
    echo $var;
?>
