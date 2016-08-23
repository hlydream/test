<?php
		$data=array(
			'name'=>'root',
			'password'=>'nokia1320',
			'aim'=>'login'
		);
		//准备post的数据
	    $postdata = http_build_query($data); 
		//数据头
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