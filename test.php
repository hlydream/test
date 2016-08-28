<?php
		$config = include_once "Conf/config.php";	
		$public_key = $config['public_key'];
		#0.这个函数可用来判断公钥是否是可用的    
		if(!$pu_key = openssl_pkey_get_public($public_key)){
			$error_pub_key = array(
				'aim'=>'get_pub_key',
				'statu'=>'false',
				'reson'=>'public_key:valid'
			);
			die(json_decode($error_pub_key));
		}
		$data_encrypt='';
		$data=array(
				'name'=>'root',
				'password'=>'nokia1320',
				'aim'=>'login',
		        'mod'=>'privilege'
			);
		#1.将数组转为json
		$data_json_encode = json_encode($data);

		#2.使用公钥加密json
		if(!openssl_public_encrypt($data_json_encode,$data_encrypt,$pu_key)){
			$error_public_encrypt = array(
				'aim'=>'public_encrypt',
				'statu'=>'false',
				'reson'=>'unknown'
			);
			die(json_encode($error_public_encrypt));
		}

		#3.使用base64转换加密后的特殊字符
		$data_base64 = base64_encode($data_encrypt);

		#4.准备post的数据
		$postdata = http_build_query(array(
			'data'=>$data_base64
		));

		#5.登录地址
		$url = 'http://182.254.148.243/index.php';

		#6.header
        $opts = array('http' =>
                      array( 
                          'method'  => 'POST', 
                          'header'  => 'Content-type: application/x-www-form-urlencoded', 
                          'content' => $postdata
                      )
        );

		#7.数据流
        $context = stream_context_create($opts);

		#8.post登录
        $result = file_get_contents($url, false, $context);
		echo $result;
	