<?php
//LIMPAR
function text_variable($variable){
    $variable = trim($variable);
    $variable = strip_tags($variable);
    $variable = str_replace(["'","\""], ["′","“"], $variable);
    return $variable;
}
?>