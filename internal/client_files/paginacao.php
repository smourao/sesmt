<?php
    $quant_pg = ceil($quantreg/$numreg);
    $quant_pg++;
    
    // Verifica se esta na primeira p�gina, se nao estiver ele libera o link para anterior
    if ( $pg > 0) { 
        echo "<a href=?do=geraso&pg=".($pg-1) ."class=pg><b>&laquo; anterior</b></a>";
    } else { 
        echo "<font color=#CCCCCC>&laquo; anterior</font>";
    }
    
    // Faz aparecer os numeros das p�gina entre o ANTERIOR e PROXIMO
    for($i_pg=1;$i_pg<$quant_pg;$i_pg++) { 
        // Verifica se a p�gina que o navegante esta e retira o link do n�mero para identificar visualmente
        if ($pg == ($i_pg)) { 
            echo "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";
        } else {
            $i_pg2 = $i_pg-1;
            echo "&nbsp;<a href=?do=geraso&pg=$i_pg2 class=pg><b>$i_pg</b></a>&nbsp;";
        }
    }
    
    // Verifica se esta na ultima p�gina, se nao estiver ele libera o link para pr�xima
    if (($pg) < $quant_pg) { 
        echo "<a href=?do=geraso&pg=".($pg+1)." class=pg><b>pr�ximo &raquo;</b></a>";
    } else { 
        echo "<font color=#CCCCCC>pr�ximo &raquo;</font>";
    }
?>