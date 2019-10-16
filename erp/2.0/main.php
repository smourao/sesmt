<?PHP
$sql    = "SELECT * FROM site_modules_info";
$result = pg_query($sql);
$menu   = pg_fetch_all($result);

echo '<center><img src="'.image_path.'main_title.png" border=0></center>';
echo '<BR>';
echo '<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>';
echo '<tr>';

/**********************************************************************************************/
// --> MENU GROUP - Medicina do Trabalho
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsmed">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'medicina-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 0 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Engenharia de Seguran�a
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsengseg">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'engseg-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 1 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Recep��o
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsrec">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'recepcao-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 2 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<BR>';
echo '<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>';
echo '<tr>';

/**********************************************************************************************/
// --> MENU GROUP - Comercial
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fscome">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'comercial-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 3 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index">'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP -  Relat�rios
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsrela">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'relatorios-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 4 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Cadastros
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fscadas">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'cadastros-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 5 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<BR>';

//if($_SESSION[grupo] == "administrador"){
echo '<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>';
echo '<tr>';

/**********************************************************************************************/
// --> MENU GROUP - Estat�sticas
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsestat">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'estatisticas-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 6 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Administra��o
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsadm">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'administracao-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 7 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Financeiro
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsfinan">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'financeiro-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 8 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<BR>';
echo '<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>';
echo '<tr>';
/**********************************************************************************************/
// --> MENU GROUP - Administra��o do Site
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fssiteadm">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'site-admin-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 9 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Edifica��o
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsedifica">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'edificacao-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 10 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP - Setorial
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fssetorial">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'setorial-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 11 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<BR>';

echo '<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>';
echo '<tr>';

/**********************************************************************************************/
// --> MENU GROUP - Pesquisas
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fspesq">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'pesquisas-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 12 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';

/**********************************************************************************************/
// --> MENU GROUP -  Medida Preventiva
/**********************************************************************************************/
echo '<td width=30% class="text roundborderselected" valign=top id="fsmedprev">';
echo '<div style="position: relative; top: -16px;left: 10px;"><img src="'.image_path.'medida-preventiva-ico.png" border=0 align=middle></div>';
echo '<ul>';
    for($x=0;$x<pg_num_rows($result);$x++){
        if($menu[$x][menu_group] == 13 && $menu[$x][enabled]){
            echo '<li><a href="?dir='.$menu[$x][internal_name].'&p=index"'; print $menu[$x][is_finished] ? '' : ' onclick="alert(\'Este m�dulo ainda est� em desenvolvimento!\');" '; echo '>'.$menu[$x][module_name].'</a></li>';
        }
    }
echo '</ul>';
echo '&nbsp;';
echo '</td>';

echo '<td width=5% class="text" valign=top>&nbsp;</td>';


echo '<td width=30% class="text roundborderselected" valign=top id="fsadm">&nbsp;</td>';
echo '</tr>';
echo '</table>';
//}
?>
