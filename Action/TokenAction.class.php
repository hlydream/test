<?php
    class TokenAction extends Action{
        /*
         * 生成token
         * return token
         * */
        public function getToken(){
            #1.生成token
            $str = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKOMNOPQRSTUVWXYZ0123456789";
            $token = '';
            for($i=0;$i<18;$i++){
                $token = $token.$str[rand(0,60)];
            }
            return $token;
        }
        /*
         * 将token入库
         * @param token  @username 用户名
         * return 成功返回true
         * */
        public function savaToken($token,$username){
            $token_model = new TokenModel();
            if($token_model->saveToken($token, $username)){
                return true;
            }
        }
        /*
         * 查询token
         * @param token
         * return 查询结果
         * */
        public function checkToken($token){
            $sql = "select * from u_token where u_token='{$token}' limit 1";
            $token_model = new TokenModel();
            $token_result = $token_model->mQuery($sql);
            return mysqli_fetch_assoc($token_result);
        }
        /*
         * 更新token时间
         * @param token
         * */
        public function updateToken($token){
            $time = time();
            $sql = "update u_token set u_time={$time} where u_token = '{$token}'";
            $token_model = new TokenModel();
            $token_model->mQuery($sql);
        }
    }