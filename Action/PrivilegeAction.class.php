<?php
    class PrivilegeAction extends Action{
        /*
         * 登录验证并且返回token
         * @param data 客户端post过来的数据
         * return 登录成功返回加密RSA加密的token
         * */
        public function login($data){
            $username = $data->name;
            $password = md5($data->password);
            $user_model = new UserModel();
            $user = $user_model->checkUsernameAndPassword($username, $password);
            if(!$user){
                $this->failed('login', 'identity:valid');
            }
            $tokenaciton = new TokenAction();
            $token='';
            $token = $tokenaciton->getToken($token,$username);
            $tokenaciton->savaToken($token, $username);
            $token_data = array(
                'aim'=>'getToken',
                'statu'=>'success',
                'token'=>$token
            );
            $token_data_encode = json_encode($token_data);
            $rsa = new Rsa();
            $token_encrypt = $rsa->dataEncrypt($token_data_encode);
            $token_encrypt_base64_encode = $rsa->dataBase64($token_encrypt);
            $token_base64_encode = array(
                'aim'=>'getToken',
                'statu'=>'success',
                'data'=>$token_encrypt_base64_encode
            );
            echo  json_encode($token_base64_encode);
        }
    }