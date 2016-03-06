<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Article_model extends CI_Model{
        //添加文章
        public function add($data){
            $this->db->insert('article',$data);
        }
        
        //查看文章
        public function read(){
            $data=$this->db->select('aid,title,time')->from('article')->order_by('aid','asc')->get()->result_array();
            return $data;
        }

        //编辑文章
        public function edit_article($aid){
            $data=$this->db->get_where('article',array('aid' => $aid))->result_array();
            return $data;
        }


        //修改文章
        public function update($aid,$data){
            $this->db->update('article',$data,array('aid' => $aid));

        }


        //删除文章
        public function del($aid){
            $this->db->delete('article', array('aid'=>$aid));
        }


        //调取主页文章
        public function limit_article($limit){
           $data= $this->db->limit($limit)->order_by('time','desc')->get('article')->result_array();
           return $data;
        }


        //通过aid调取文章
        public function aid_article($aid){
            $data=$this->db->get_where('article',array('aid' => $aid))->result_array();
            return $data;
        }
    }
?>