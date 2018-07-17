<?php
if(!isset($seg)){
    exit;
}
function vazioTag($dados){
    $dados_tr = array_map('trim', $dados);
    if(in_array('', $dados_tr)){
        return false;
    }else{
        return $dados_tr;
    }
}
