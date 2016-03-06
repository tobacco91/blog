<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Data_model extends CI_Model{
        //显示
        public function get(){
           $data= $this->db->get('datas')->result_array();
            return $data;
        }


        //修改
        public function update($data,$did){
            $this->db->update('datas',$data,array('did' => $did));

        }
    }
 ?>