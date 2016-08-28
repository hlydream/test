<?php
	class Application{
		private static $data='';
		#1.定义错误显示
		private static function setErrors(){
			/*
			 *1.是否提示错误
			 *2.是否显示错误
			*/
			ini_set("errors_reporting",1);
			ini_set("display_errors",1);
		}
		#2.定义系统目录常量
		private static function setConst(){
			/*
			 *系统根目录
			 *核心类目录
			 *系统配置文件目录
			 *系统公共文件目录
			 *系统后台目录
			 *系统扩展插件目录
			 */
			define("ROOT_DIR",str_replace("/Core",'',str_replace("\\","/",__DIR__)));
			define("CORE_DIR",  ROOT_DIR.'/Core');
			define("CONF_DIR",  ROOT_DIR.'/Conf');
			define("PUBLIC_DIR",ROOT_DIR.'/Public');
			define("MODEL_DIR", ROOT_DIR.'/Model');
			define("ACTION_DIR",ROOT_DIR.'/Action');
		}
		#3.定义自动加载函数
		private static function setAutoLoad(){
			/*
			 *1.注册自动加载Application类下的LoadCore函数
			 *2.注册自动加载Application类下的LoadAdmin函数
			 *3.注册自动加载Application类下的LoadModel函数
			 *4.注册自动加载Application类下的LoadAction函数
			 *5.注册自动加载Application类下的LoadLib函数
			*/
			spl_autoload_register(array("Application","loadCore"));
			spl_autoload_register(array("Application","loadModel"));
			spl_autoload_register(array('Application','loadAction'));
		}
		/*自动加载函数
		 *1.自动加载核心类函数
		 *2.自动加载模型类函数
		 *3.自动加载后台类函数
		 *4.自动加载扩展函数(扩展函数是以扩展文件名首字母大写命名文件夹，加载非类的php文件)
		*/
		private static function loadCore($class){
			if(is_file(CORE_DIR."/$class.class.php")){
				include_once CORE_DIR."/$class.class.php";
			}
		}
		private static function loadModel($class){
			if(is_file(MODEL_DIR."/$class.class.php")){
				include_once MODEL_DIR."/$class.class.php";
			}
		}
		private static function loadAction($class){
			if(is_file(ACTION_DIR."/$class.class.php")){
				include_once ACTION_DIR."/$class.class.php";
			}
		}
		#4.加载配置文件
		private static function loadConfig(){
			$GLOBALS['config'] = include_once CONF_DIR."/config.php";
		}
		#5.RSA解密
		private static function rsaDecrypt(){
			$data_base64_encode = isset($_POST['data']) ? $_POST['data'] :'';
			$data_base64_decode = base64_decode($data_base64_encode);
			$private_key = $GLOBALS['config']['private_key'];
			$pi_key = openssl_pkey_get_private($private_key);
			openssl_private_decrypt($data_base64_decode,self::$data,$pi_key);
		}
		#6.权限检测
		private static function checkPrivilege($mod, $aim, $data_encode){
		    //如果mod不是privilege 就要检测是否存在token，token是否过期
		    if($mod!='Privilege'){
		        $token = $data_encode->token;
		        $time = time();
		        $token_action = new TokenAction();
		        $token_info = $token_action->checkToken($token);
		        if($token_info){
		            $time_login = $token_info['u_time'];
		            $time = time();
		            //设定三分钟token过期
		            if(($time-$time_login)/60 > 3){
		                die(json_encode(array('aim'=>$aim,'statu'=>'false','reson'=>'token:outdate')));
		            }else{
		                $token_action->updateToken($token);
		            }
		        }else{
		            die(json_encode(array('aim'=>$aim,'statu'=>'false','reson'=>'token:valid')));
		        }
		    }
		}
		#7.分配URL
		private static function setUrl(){
		    $data_encode = json_decode(self::$data);
		    $aim = strtolower($data_encode->aim);
		    $mod = ucfirst(strtolower($mod = $data_encode->mod));
		    Application::checkPrivilege($mod, $aim, $data_encode);
		    $modAction = $mod.'Action';
		    $module= new $modAction();
		    $module->$aim($data_encode);
		}
		#8.初始化
		public static function run(){
			self::setErrors();
			self::setConst();
			self::setAutoLoad();
			self::loadConfig();
			self::rsaDecrypt();
			self::setUrl();
		}
	}