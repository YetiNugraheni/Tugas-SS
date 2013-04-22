<?php
class Character{
    function CheckLengthCharacter ($string, $length){
        if (strlen($string)<=$length){
            return true;
        } else {
            return false;
        }
    }    
    
    function CheckSpecialCharacter ($string){
        $data = PREG_REPLACE("/[^0-9a-zA-Z]/i", '', $string);
        if ($string==$data){
            return true;
        } else {
            return false;
        }
    }    
    
    function CheckWhitespace ($string){
        if ($string==trim($string)){
            return true;
        } else {
            return false;
        }
    }     
    
    function GenerateSession (){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < 10; $i++) {
            $pos = rand(0, strlen($chars)-1);
            $string .= $chars{$pos};
        }
        return MD5($string);
    }
}
?>
