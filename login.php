<?php
	$config = include_once "config.php";	
	$private_key = $config['private_key'];
	$data_jiami = $_POST;
	$data = '';
	$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id 
	openssl_private_decrypt(base64_decode($data_jiami),$data,$pi_key);//私钥解密
	print_r($data);