<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Comment_model extends CI_Model{
    /*添加评论*/
    public function add($data){
            $this->db->insert('message',$data);
        }
    }
 ?>