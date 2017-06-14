<?php
function showTemplate($data, $template){

if(file_exists(ROOT.'/'.$template.'.php')) {
    include_once ROOT.'/'.$template.'.php';//add once, for include both
}else
    exit('Error with templates');
}

function showHeader(){
    if(file_exists(ROOT.'/templates/header.php')) {
        include_once ROOT . '/templates/header.php';//add once, for include both
    }else
        exit('Error with templates');
}
function showFooter(){
    if(file_exists(ROOT.'/templates/footer.inc.php')) {
        include_once ROOT . '/templates/footer.inc.php';
    }else
        exit('Error with templates');
}
