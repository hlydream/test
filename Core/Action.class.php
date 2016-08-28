<?php
    class Action{
        public function success($aim,$data){
            $success_info = array(
                'aim' => $aim,
                'statu'=>'success',
                'data'=>$data       
            );
            echo json_encode($success_info);
        }
        public function failed($aim,$reson){
            $error_info = array(
                'aim'=>$aim,
                'statu'=>'false',
                'reson'=>$reson
            );
            die(json_encode($error_info));
        }
    }