<?php
openssl_pkey_get_public() #从证书中提取公钥,给其它函数使用
openssl_verify(string $data , string $signature , mixed $pub_key_id [, mixed $signature_alg = OPENSSL_ALGO_SHA1 ])
/*
该函数用于验证签名
$data ：用于生成签名的数据字符串
$signature  ：二进制字符串签名
$pub_key_id ：函数openssl_get_publickey()返回的公钥对象
$signature_alg ：签名算法
*/
base64_encode($data) :使用base64对$data进行编码,可使二进制数据非纯8-bit的传输层传输
base64_decode($data) :对 base64 编码的 $data 进行解码

?>
