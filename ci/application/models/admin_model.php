<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    //登录
    class Admin_model extends CI_Model{
        public function check($username){
            $data=$this->db->get_where('admin',array('username' => $username))->result_array();
            return $data;
        }


        //修改密码
        public function update($uid,$data){
            $a=$this->db->update('admin',$data,array('uid' => $uid));
            return $a;
        }
    }

?>