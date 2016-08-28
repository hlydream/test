<?php
    class TokenModel extends DB{
        public function saveToken($token,$username){
            $time = time();
            $sql = "select * from u_token where u_username='{$username}' limit 1 ";
            $token_assoc = mysqli_fetch_assoc($this->mQuery($sql));
            if(!$token_assoc){
                $sql = "insert into u_token (u_username,u_token,u_time) values('{$username}','{$token}',{$time}) ";
                $token_insert_result = $this->mQuery($sql);
                if(!$token_insert_result){
                    $error_insert_token = array(
                        'aim'=>'insert_token',
                        'statu'=>'false',
                        'reson'=>mysqli_error($con)
                    );
                    die(json_encode($error_insert_token));
                }
            }else{
                $sql = "update u_token set u_time={$time},u_token='{$token}' where u_username='{$username}'";
                $result_update_token = $this->mQuery($sql);
                if(!$result_update_token){
                    $error_update_token = array(
                        'aim'=>'update_token',
                        'statu'=>'false',
                        'reson'=>mysqli_error($this->con)
                    );
                    die(json_encode($error_update_token));
                }
            }
            return true;
        }
    }