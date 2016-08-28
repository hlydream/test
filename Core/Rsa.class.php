<?php
    class Rsa{
        #成员变量 private_key 私钥
        #成员变量 pi_key用来存放私钥资源
       private $private_key='' ;
       private $pi_key='';
       /**
        * 初始化
        * 获取配置文件中的私钥和获取私钥资源
        */
       public function __construct(){
           $this->private_key = $GLOBALS['config']['private_key'];
           $this->pi_key = openssl_pkey_get_private($this->private_key);
       }
       /*
        * 私钥数据解密
        * @param 加密的数据
        * return 解密后的数据
        * */
       public function dataEncrypt($data){
           $data_encrypt='';
           openssl_private_encrypt($data, $data_encrypt,$this->pi_key);
           return $data_encrypt;
       }
       /*
        * base64_encode 
        * @param 要base64的数据
        * return base64后的数据
        * */
       public function dataBase64($data){
           return base64_encode($data);
       }
    }
   