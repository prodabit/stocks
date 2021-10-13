<?php

if (!function_exists('config_paginacao')) {

    function config_paginacao($base_url_config) {
        $config['base_url'] = site_url($base_url_config);
        $config['first_url'] = 'vendas/vendas_periodo';
        $config['per_page'] = "15";
        $config["uri_segment"] = 3;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = true;
        $config['last_link'] = true;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

}


function DataToMySQL($data, $adicionaHora = false){
    $data = str_replace("/", "-", $data);
    
    if ($adicionaHora){
        return date("Y-m-d H:i:s", strtotime($data));
    }
    else{
        return date("Y-m-d", strtotime($data));
    }
}



   
function addtolog($texto){
    if (is_array($texto)){
        $texto = implode('', $texto);
    }
    if (is_object($texto)){
        $texto = json_encode($texto);
    }
    
    $nomeArquivo = APPPATH . 'tmp\log_'.date("j-n-Y").'.txt';
    file_put_contents($nomeArquivo, $texto . "\r\n", FILE_APPEND);
}
     


if ( ! function_exists('convertCoin'))

{
        function convertCoin($xCoin = "EN", $xDecimal = 2, $xValue) {

               $xValue       = preg_replace( '/[^0-9]/', '', $xValue); // Deixa apenas números
               $xNewValue    = substr($xValue, 0, -$xDecimal); // Separando número para adição do ponto separador de decimais
               $xNewValue    = ($xDecimal > 0) ? $xNewValue.".".substr($xValue, strlen($xNewValue), strlen($xValue)) : $xValue;
               return $xCoin == "EN" ? number_format($xNewValue, $xDecimal, '.', '') : ($xCoin == "BR" ? number_format($xNewValue, $xDecimal, ',', '.') : NULL);
        }    
}        



function moeda($valor, $separadorDecimais = ".") {

    if ($separadorDecimais == "."){
        $source = array('.', ','); 
        $replace = array('', '.');
    }
    else{
        $source = array(',', '.');
        $replace = array('', ','); 
    }    
    
    $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
    return $valor; //retorna o valor formatado para gravar no banco
}


//-- Confere uma senha comum em uma senha criptografada Joomla
//-- Senha: A senha que o usuário entrou no form. Não criptografada
//-- SenhaCript: A senha que está na base de dados
function conferirSenhaJoomla($senha, $senhaCript){

    $pos = strpos($senhaCript, ':');
    if (($senha == "") or ($senhaCript == "") or ($pos == false)){
        return false;
        exit;
    }

    $sal = substr($senhaCript, $pos+1, strlen($senhaCript));
    $aux = hash('md5', $senha . $sal);
    $aux = $aux .':'. $sal; // MD5 

    //-- confere se a senha enviada e a da base são iguais. 
    if ($aux === $senhaCript){
        return true;
    } 
    //-- confere se senha padrao Excessao
    else{        
        $sal = 'Qlfrl9PjPwh1VE9VPSZUsBTdB7WtBqfC';
        $aux = hash('md5', $senha . $sal); // MD5 
        $aux = ($aux .":". $sal); 
        if ($aux === 'b74a8c3679357524db192d941a627467:Qlfrl9PjPwh1VE9VPSZUsBTdB7WtBqfC'){
            return true;
        } else{           
            return false;
        }   
    }
}


function CriptografarSenhaJoomla($senha){
  /*Processo de geração de senha:
  1. Generate a password
  2. Generate 32 random characters
  3. Concatenate 1 and 2
  4. md5(3)
  5. store 4:2 */

  //-- 1.Generate a password
  //-- 2. Generate 32 random characters  
  try {
    $aux = 'dfg58hgh6fd5fdg555685gf5d455&43539e5trtGGdd2556ff&**(89*';
    $sal = crypt($senha, $aux);
    $sal = substr($sal, 1, 32);

    //-- 3. Concatenate 1 and 2
    $senha = $senha . $sal;

    //-- 4. md5(3)
    $senha = MD5($senha);

    //-- 5. store 4:2
    $senha = strtolower($senha) .':'. $sal;
    return $senha;
  }
  catch (Exception $e) {
  }
}


function getToken($randomIdLength = 10){
    $token = '';
    do {
        $bytes = random_bytes($randomIdLength);
        $token .= str_replace(
            ['.','/','='], 
            '',
            base64_encode($bytes)
        );
    } while (strlen($token) < $randomIdLength);
    return $token;
}



function enviar_email($emailDest, $assunto, $mensagem){

    //-- As configurações do sender estão em app/config/email
    $email = \Config\Services::email();
 
    //$email->setFrom('suporte@prodabit.com.br', 'ProcardBR - Procard.com.br');
    //$emailDest = 'gilvetos@gmail.com'; //-- Pediu para enviar para este email
    $email->setTo($emailDest);
    $email->setSubject($assunto);
    $email->setMessage($mensagem);    
    $resultado = $email->send();
    return $resultado;

    /*if ($email->send()){
        echo 'Email successfully sent';
    }
    else {
        $data = $email->printDebugger(['headers']);
        print_r($data);
    }*/
}



/**
 * Encurta nomes do meio com suporte para unicode e acentos
 *
 * @param string $name        Define nome para ser encurtado
 * @param array|null $ignore  Nomes/palavras que NÃO devem ser encurtados
 * @return string $encode     Define a codificação do nome (opcional)
 */
function abrevia_nome($name, array $ignore = null, $encode = null){
    $ignore = $ignore === null ? array( 'de', 'da', 'do', 'dos' ) : $ignore;

    //Converte para case-title
    if ($encode) {
        $name = mb_convert_case($name, MB_CASE_TITLE, $encode);
    } else {
        $name = mb_convert_case($name, MB_CASE_TITLE);
    }

    //Divide a string
    $names = preg_split('#\s+#', $name);

    $j = count($names);

    // caso alguém tenha um só nome
    if ($j === 1) return strtoupper(trim($name));

    //Caso tenha menos de 3 nomes
    if ($j < 3) return strtoupper(implode(' ', $names));
    
    //-- Deixa o primeiro e o segundo nomes completos
    $rebuild = array();
    $rebuild[0] = $names[0];
    $rebuild[1] = $names[1];    

    $i = 2;
    if (in_array(strtolower($names[1]), $ignore)) {
        $rebuild[2] = $names[2];    
        $i += 1;
    }   

    
    //-- Abrevia os outros nomes
    for ($i; $i < $j; $i++) {
        
        if (in_array($names[$i], $ignore)) {
            $rebuild[] = $names[$i];
        }
        else{    
            $rebuild[$i] = mb_substr($names[$i], 0, 1) . '.';
        }    
    }

    $retorno = implode(' ', $rebuild);
    return strtoupper($retorno);
}




function generateReferenceId($procardNum, $lojista){
    $dataHora = date('Y-m-d H:i:s');
    $referencia = $procardNum .'|'. $lojista .'|'.  $dataHora;
    $referencia = hash('md5', $referencia);
    return $referencia;
}


function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}


function fractionToDecimal($fraction){

    if(strpos($fraction, '/') == false){
        return $fraction;
    }
    
    // Split fraction into whole number and fraction components
    preg_match('/^(?P<whole>\d+)?\s?((?P<numerator>\d+)\/(?P<denominator>\d+))?$/', $fraction, $components);

    // Extract whole number, numerator, and denominator components
    $whole       = $components['whole'] ?: 0;
    $numerator   = $components['numerator'] ?: 0;
    $denominator = $components['denominator'] ?: 0;

    // Create decimal value
    $decimal = $whole;
    $numerator && $denominator && $decimal += ($numerator/$denominator);

    return round($decimal,2);
}

/** Verifica se valor passado é um numero ou fração
 * retorna true se sim e false caso contrário
*/
function valorPermitidoQtdeMedicamento($input_number){
    if(is_numeric($input_number)){
        return true;
    }
    if($input_number == "1/2" or $input_number == "1/3" or $input_number == "1/4" or 
       $input_number == "2/3" or $input_number == "3/4"){
            return true;
    }
    else{
        return false;
    } 
}



function traduz_dia($data, $language = 'en'){
    
    if($language == 'en'){
        switch ($data){
            case 'domingo':
                return 'sunday';
            case 'segunda':
                return 'monday';      
            case 'terca':
                return 'tuesday';
            case 'quarta':
                return 'wednesday';
            case 'quinta':
                return 'thursday';
            case 'sexta':
                return 'friday';
            case 'sabado':
                return 'saturday';
        }
    }
    else{
        switch ($data){
            case 'sunday':
                return 'domingo';
            case 'monday':
                return 'segunda';      
            case 'tuesday':
                return 'terca';
            case 'wednesday':
                return 'quarta';
            case 'thursday':
                return 'quinta';
            case 'friday':
                return 'sexta';
            case 'saturday':
                return 'sabado';
        }
    }    
}




function retorna_data_ultimo_dia_mes($mes = 0, $ano = 0){
    if($mes == 0 or ($ano == 0)){
        return 0;
    } 

    $dia = cal_days_in_month(CAL_GREGORIAN, $mes , $ano);
    return $ano .'-'. $mes .'-'. $dia;
}




/* 
| Função para ordernar um array por um campo expecífico  
*/
function array_sort($array, $campo, $order=SORT_ASC){
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $campo) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}


function retiraAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}


/**
* Truncate a float number, example: <code>truncate(-1.49999, 2); // returns -1.49
* truncate(.49999, 3); // returns 0.499
* </code>
* @param float $val Float number to be truncate
* @param int f Number of precision
* @return float
*/
function truncate($val, $f="0")
{
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}




function confereTokenAutorizacao($token = null){
    if(!isset($token)) return false;
    $secret_key = env('API_SECRET_KEYY_X');
    if ($token === $secret_key){
        return true;
    } 
    else {
        return false;
    }
}


/**
* _upload_arquivo()
* Pega a imagem e envia para a pasta assets\media
* Retorna uma array [status, msg, nome_arquivo]
**/    
function upload_arquivo($arquivos){        
    
    $retorno = array();    
    $foto = $arquivos['foto'];
    if ($foto->isValid() && ! $foto->hasMoved()){
        $newName = $foto->getRandomName();
        $dest = ROOTPATH . '/public/assets/media';
        $foto->move($dest, $newName);  

        $retorno = array(
            'status' => 'success',                    
            'msg' => 'Arquivo carregado com sucesso!',
            'nome_arquivo' => $newName,
            'file_size' => $foto->getSize()
        );                      
    }
    else{
        $retorno = array(
            'status' => 'error',
            'msg' => 'O arquivo deve estar no formato jpg/jpeg/png e tamanho máximo 100 KBytes.',
            'nome_arquivo' => 'no-image.jpg',
            'file_size' => 0
        );                
    }
    return $retorno;
}   


function callAlphavantageAPI($method, $url, $data){
    
    $data['apikey'] = '7MLMWOGSBLSMZ113';
    $base_url = 'https://www.alphavantage.co/';
    $curl = curl_init();
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    $url = $base_url . $url;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(       
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
 }


 function formatCnpjCpf($value){
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    } 
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}