<?php
	$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC+wRuQopAlmbEej8zUIajLGMXnM8UVCRQpiFYWXXr5wmdo4HSN
ANIRF6wN6+dvFhN/gFLAe6udcJZuS74X18OdEf3pBNyRyWchglQevmFSwDM1mz0d
kFUle/TSJ4pFSPzNUWDeSo4QNoWmtJkT1MMjM1rZ87Uaod2iLa7uUadpTQIDAQAB
AoGAcGfk8W8KGE4f9E1yuxJ2n++iNyLnoQSvj+XaLOW7INBxFXkm1SxFnXLgnXeE
8o4EwV6B5RE7SNReoPIbO3uWtcS6GtXS4Ztu+NbJQFL4Qm8IEQDEfnd0n0TSZL6P
Nq1PEBqjrZQhXwoQn0xKOhlgY9WvbJ0kQCBvnpiJF/Dz3sECQQDgjXQlOsTwiEtQ
Ohfc84IaKmett0o8rLZVbhwFhxZJuS/8Ee/eCbvsWodqwQOMaUb8AB9odJf/RXdJ
rkEY/QmdAkEA2Xfv0cyqimuxCuQvwK9l9+d2BFe2rVvurHAmUe0WiH1qX12h+Xkt
qsXpDTubTJIDDC9/+WXm5GGDKokpZ/hncQJAD32SmpLgTRuJ3oHzbXma6wUr287+
HwtnFKOg6Ty1a+aLid8O5glT3m0sVE/2V7RXgkDb6c/JQIHhRcLwmLGz/QJAQ8uX
MRGcDQEbtWiD1o8Xu9wlt57crVjepFVmLN47yxtGISrghxSW/wkp6V0uwgU2/AKG
4+o3u/UGXilahjYzkQJBALW79JT4LhFW/n6Mlq5bRDe5sZSMR4Ac8T1/IuBQoCup
6YpnS9+f9dQyyjedhVLRyDtJctoHOgjD+bd8jtcf+RM=
-----END RSA PRIVATE KEY-----
';
	$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC+wRuQopAlmbEej8zUIajLGMXn
M8UVCRQpiFYWXXr5wmdo4HSNANIRF6wN6+dvFhN/gFLAe6udcJZuS74X18OdEf3p
BNyRyWchglQevmFSwDM1mz0dkFUle/TSJ4pFSPzNUWDeSo4QNoWmtJkT1MMjM1rZ
87Uaod2iLa7uUadpTQIDAQAB
-----END PUBLIC KEY-----
';
	//echo $private_key;  
	$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id  
	$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的  
	print_r($pi_key);echo "<br/>";  
	print_r($pu_key);echo "<br/>";

	$data = "nokia1320";//要加密的原始数据  
	$encrypted = "";  //已加密的数据 
	$decrypted = "";   //解密后的原始数据
	  
	echo "source data:".$data."<br/>";  
	  
	echo "private key encrypt:<br/>";  
	  
	openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
	$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
	echo $encrypted."<br/>";  
	  
	echo "public key decrypt:<br/>";  
	  
	openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来  
	echo $decrypted,"<br/>";  
	  
	echo "---------------------------------------<br/>";  
	echo "public key encrypt:<br/>";  
	  
	openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密  
	$encrypted = base64_encode($encrypted);  
	echo $encrypted,"<br/>";  
  
	echo "private key decrypt:<br/>";  
	openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密  
	echo $decrypted,"<br/>";
	
	$data=array(
			'name'=>'root',
			'password'=>'nokia1320',
			'aim'=>'login'
		);
		//准备post的数据
	    $postdata = http_build_query($data); 
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
	