<?php
require_once __DIR__.'/helpers/PersistanceManager.php';


define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','lm_system');
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', current_domain());
define('CURRENT_URL',current_url());
date_default_timezone_set('Asia/Colombo');
define('BORROW_DURATION_DAYS', 7);
define('FINE_PER_DAY', 100);


function current_domain(){
    $projectPath = '/lbm_system';
    return protocol() . $_SERVER['HTTP_HOST'] . $projectPath;
}

function current_url(){
    return current_domain().$_SERVER['REQUEST_URI'];
}

function protocol(){
    if(strpos($_SERVER['HTTP_HOST'],'https')!==false){
        return 'https://';
    }
    else {
        return 'http://';
    }
}

function asset($src){
    
     $domain = trim(CURRENT_DOMAIN,'/');
    $src = $domain.'/'.trim($src,'/');
    return $src;
}

function url ($url){
    $domain = trim(CURRENT_DOMAIN,'/');
    $url = $domain.'/'.trim($url,'/');
    return $url;
    
}




function dd($data, $comment = '')
{
    print('<pre>');
    print($comment);
    print('<br>');

    print_r($data);
    print('</pre>');

    die;
}

function pr($data, $comment = '')
{
    print('<pre>');
    print($comment);
    print('<br>');

    print_r($data);
    print('</pre>');
}


$pre_manager = new PersistanceManager();






