<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 14-12-8
 * Time: 下午1:54
 */
/**
 * 利用mcrypt做AES加密解密
 */

class Security {
    public static function encrypt($input, $key) {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = Security::pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    private static function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function decrypt($sStr, $sKey) {
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

    private static function hex2bin($h)
    {
        if (!is_string($h)) return null;
        $r='';
        for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
        return $r;
    }
}



