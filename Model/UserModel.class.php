<?php
    class UserModel extends DB{
        public function checkUsernameAndPassword($username,$password){
            if(!$user = $this->mQuery("select * from u_user where u_username='{$username}' and u_password='{$password}'")){
                return false;
            }
            return $user;
        }
    }