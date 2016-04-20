<?php
function decrypt($sStr, $sKey)
{
    $sStr = str_replace(chr(32),'+',$sStr);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $sKey, $iv);
    $decrypted = trim(mdecrypt_generic($td, base64_decode($sStr))) ;
    $decrypted = preg_replace( '/[^[:print:]]/', '',$decrypted);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $decrypted;
}


?>
