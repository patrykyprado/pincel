<?php
function limpar_string($str) {
    $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);
    return $str;
}
function format_data($al)
{
    $exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4);
    return $exib;
}

function format_data_us($data)
{
    $exib = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
    return $exib;
}

function format_data_hora($al)
{
    $exib = substr($al,8,2)."/".substr($al,5,2)."/".substr($al,0,4)." ".substr($al,11,10);
    return $exib;
}
function formatar_sms($cel)
{
    $cel_filtrado = preg_replace("/[^0-9]/", "", $cel);
    if(strlen($cel_filtrado) <= 11&&strlen($cel_filtrado>0)){
        if(substr($cel_filtrado,0,1)==3){
            $cel_filtrado = "N�mero Inv�lido";
            return $cel_filtrado;
        }
        if(substr($cel_filtrado,0,2)==273){
            $cel_filtrado = "N�mero Inv�lido";
            return $cel_filtrado;
        }
        if(substr($cel_filtrado,0,1)==9){
            $cel_filtrado = "5527".$cel_filtrado;
            return $cel_filtrado;
        }

        $cel_filtrado = "55".$cel_filtrado;
    } else {
        $cel_filtrado = "N�mero Inv�lido";
    }
    return $cel_filtrado;
}
function not($al)
{
    $exib = $al;
    return $exib;
}

function format_email($al)
{
    $exib = strtolower($al);
    return $exib;
}

function format_valor($al)
{
    $exib = number_format($al,2,",",".");
    return $exib;
}

function format_curso($al)
{
    $exib = ucwords(strtolower($al));
    return $exib;
}

function format_mes($data_mes)
{
    if($data_mes == '01'){
        $data_mes_nome = "Janeiro";
    }
    if($data_mes == '02'){
        $data_mes_nome = "Fevereiro";
    }
    if($data_mes == '03'){
        $data_mes_nome = "Mar�o";
    }
    if($data_mes == '04'){
        $data_mes_nome = "Abril";
    }
    if($data_mes == '05'){
        $data_mes_nome = "Maio";
    }
    if($data_mes == '06'){
        $data_mes_nome = "Junho";
    }
    if($data_mes == '07'){
        $data_mes_nome = "Julho";
    }
    if($data_mes == '08'){
        $data_mes_nome = "Agosto";
    }
    if($data_mes == '09'){
        $data_mes_nome = "Setembro";
    }
    if($data_mes == '10'){
        $data_mes_nome = "Outubro";
    }
    if($data_mes == '11'){
        $data_mes_nome = "Novembro";
    }
    if($data_mes == '12'){
        $data_mes_nome = "Dezembro";
    }
    return $data_mes_nome;
}

function format_data_escrita($data){
    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,2);

    $mes_escrito = format_mes($mes);

    return $dia." de ".$mes_escrito." de ".$ano;
}
function remover_acentos($string) {
    return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($string));

}

function converter_data($string){
    return substr($string,6,4)."-".substr($string,3,2)."-".substr($string,0,2);
}

function format_letra($letra)
{
    if($letra == '1'){
        $letra_exib = "A)";
    }
    if($letra == '2'){
        $letra_exib = "B)";
    }
    if($letra == '3'){
        $letra_exib = "C)";
    }
    if($letra == '4'){
        $letra_exib = "D)";
    }
    if($letra == '5'){
        $letra_exib = "E)";
    }
    if($letra == '6'){
        $letra_exib = "F)";
    }
    if($letra == '7'){
        $letra_exib = "G)";
    }
    if($letra == '8'){
        $letra_exib = "H)";
    }
    if($letra == '9'){
        $letra_exib = "I)";
    }
    return $letra_exib;
}

function memedCache($consulta, $tempo = 7200) {
    $chave = md5($consulta);

    $mem = new Memcache;
    $mem->addServer($_SERVER['HTTP_HOST']);

    $query = $mem->get($chave);
    if ($query === false) {
        $query = mysql_query($consulta);
        $mem->set($chave, $query, 0, $tempo);
    }

    return $query;
}

function gerarNomeDocumentoTurma($dadosTurma,$extensao){
    $curso_exp = explode(' ', $dadosTurma['nivel']);
    $pt1 = substr($curso_exp[0],0,1).substr($curso_exp[1],0,1);
    $pt2 = strtoupper(substr($dadosTurma['curso'],0,3)).$dadosTurma['modulo'];
    $pt3 = '('.$dadosTurma['turno'].str_replace('/', '',$dadosTurma['grupo']).')';

    return $pt1.'-'.$pt2.' '.$pt3.' '.date('dmY His').'.'.$extensao;
}

function calcularTempoExecucao($tempoInicio, $tempoFim){
    $tempoInicio = DateTime::createFromFormat('H:i:s', $tempoInicio);
    $tempoFim = DateTime::createFromFormat('H:i:s', $tempoFim);
    return  $tempoInicio->diff($tempoFim)->format('%H:%I:%S');
}
?>