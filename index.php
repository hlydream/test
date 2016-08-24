<?php
		$config = include_once "config.php";	
		$public_key = $config['public_key'];
		//echo $private_key;   
		$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的  
		$data_jiami='';
		$data=array(
				'name'=>'root',
				'password'=>'nokia1320',
				'aim'=>'login'
			);
			//序列化数组
		$data = serialize($data);
		if(!openssl_public_encrypt($data,$data_jiami,$pu_key)){
			echo "加密失败";
			exit;
		}
		$data_jiami = base64_encode($data_jiami);
		//准备post的数据
	    $postdata = http_build_query($data_jiami); 
		//数据头
		$url = 'http://182.254.148.243/login.php';
        $opts = array('http' =>
                      array( 
                          'method'  => 'POST', 
                          'header'  => 'Content-type: application/x-www-form-urlencoded', 
                          'content' => $postdata
                      )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
		print_r($result);
	