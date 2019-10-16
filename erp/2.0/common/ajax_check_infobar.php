<?php
/***************************************************************************************************/
// --> INFORMA��ES SOBRE A��ES
// ID DE TESTES PARA RETORNO:
// 1 - O.S.
// 2 - Anivers�rios
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
    $nt = 2;//N�mero de cases para exibi��o de informa��o!
    $pt = rand(0, ($nt-1));
switch($pt){
/**********************************************************************************************/
// -> Verifica��o de mensagens nas ordens de servi�o.
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

        $mrd = 0;//armazena o n�mero de mensagens n�o lidas

        while($row = pg_fetch_array($rsc)){
            if(!$row[readed])
                $mrd++;
        }

        if(pg_num_rows($rsc)){
            //exibe n�mero de ordens de servi�os n�o finalizadas
            if(pg_num_rows($rsc)==1)
                $var .= "Existe <span class='roundborderselected'><b>".@pg_num_rows($rsc)."</b></span> ordem de servi�o n�o finalizada para voc� ou seu setor.";
            else
                $var .= "Existem <span class='roundborderselected'><b>".@pg_num_rows($rsc)."</b></span> ordens de servi�o n�o finalizadas para voc� ou seu setor.";

            //exibe mensagens n�o lidas se existirem
            if($mrd){
                if($mrd>1)
                    $var .= "&nbsp;&nbsp;&nbsp;<span class='roundborderselected'><b>$mrd</b></span> mensagens n�o lidas.";
                else
                    $var .= "&nbsp;&nbsp;&nbsp;<span class='roundborderselected'><b>$mrd</b></span> mensagem n�o lida.";
            }
        }else{
            $var .= "0";
        }
    break;
/**********************************************************************************************/
// -> Verifica��o de datas de nascimento.
/**********************************************************************************************/
    case 1:
        $sql = "SELECT * FROM funcionario WHERE EXTRACT(month FROM nascimento) = '".date("m")."' ORDER BY EXTRACT(day FROM nascimento) ASC";
        $res = pg_query($sql);
        if(pg_num_rows($res)){
            $nivers = pg_fetch_all($res);
            $var .= "Aniversariante(s) do m�s: ";
            for($x=0;$x<pg_num_rows($res);$x++){
                $tname = explode(" ", $nivers[$x][nome]);
                $sname = $tname[0]." ".$tname[1];
                if(strlen($tname[1]) <= 3)
                    $sname .= " ".$tname[2];

                if(date("d") == date("d", strtotime($nivers[$x][nascimento])) && $nivers[$x][funcionario_id] == $_GET[user_id]){
                    $var .= "<span class='roundborderselected'><b>{$sname}</b>, parab�ns pelo seu anivers�rio</span>";
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
// -> Vari�vel retornada com conteudo do 'infobar'
/**********************************************************************************************/
    echo $var;
?>
