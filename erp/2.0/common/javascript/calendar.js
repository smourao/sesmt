// construindo o calendário
function popdate(obj,div,tam,ddd, m, y){
    tam = 150
    if (ddd){
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        //coloca a data passada (dd/mm/yyyy) separadas por dia mes e ano - passado por ddd
        for (s=0;s<parseInt(ddd.length);s++){
            char = ddd.substr(s,1)
            if (char == "/") {
                c++;
                s++;
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }

        if ( typeof m != 'undefined' && typeof y != 'undefined'){
           ddd = m + "/" + day + "/" + y
        }else{
           ddd = mmonth + "/" + day + "/" + ano
        }
    }

    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}

    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)

    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)

    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}

    motxt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam +"'>"
    motxt += "<tr bgcolor='#FFFFFF'><td class=text colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    motxt += "<td class=text width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    motxt += "<td class=text width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    motxt += "<td class=text width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    motxt += "<td class=text width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    motxt += "<td class=text width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>x</b></a></td></tr></table></td></tr>"

    motxt += "<tr><td class=text colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    motxt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    motxt += "<tr bgcolor='#330099'><td class=text width='14%' class='dia' align=center><b>Dom</b></td><td class=text width='14%' class='dia' align=center><b>Seg</b></td><td class=text width='14%' class='dia' align=center><b>Ter</b></td><td class=text width='14%' class='dia' align=center><b>Qua</b></td><td class=text width='14%' class='dia' align=center><b>Qui</b></td><td class=text width='14%' class='dia' align=center><b>Sex<b></td><td class=text width='14%' class='dia' align=center><b>Sab</b></td></tr>"

    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;

    for (n=1;n<= 42;n++){
        if (week == 1)  motxt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start){
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = dat//date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = dat.getFullYear ()//date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" ) //(mmonth+1).toString()
            //motxt += "<td"+colorcell+" align=center><a href=javascript:block('"+  pad(d.toString(), 2, "0", 0) + "/" + pad((mmonth+1).toString(), 2, "0", 0) + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            motxt += "<td"+colorcell+" align=center>"+ d.toString() + "</td>"
            d ++
        }else{
            motxt += "<td class=text class='data' align=center> </td>"
        }
        week ++
        if (week == 8){
            week = 1; motxt += "</tr>"
        }
    }
        motxt += "</table>"
        div2 = eval (div)
        div2.innerHTML = motxt
}

// função para exibir a janela com os meses
function pop_month(obj, div, tam, ano)
{
  motxt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { motxt += "<tr><td class=text align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"') class=mes>" + umonth[n] +"</a></td></tr>" }
  motxt += "</table>"
  popd.innerHTML = motxt
}

// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  motxt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) motxt += "<tr>"
     motxt += "<td class=text align=center class=mes><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"') class=mes>" + n + "</a></td>"
     l++
     if (l == 4)
        {motxt += "</tr>"; l = 1 }
  }
  motxt += "</tr></table>"
  popd.innerHTML = motxt
}

// função para fechar o calendário
function force_close(div)
    { div2 = eval (div); div2.innerHTML = ''}

// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div){
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data
}
