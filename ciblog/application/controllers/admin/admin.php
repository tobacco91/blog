<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends MY_Controller{
        //后台首页
        public function index(){
            $this->load->view('admin/index.html');
        }
    
        //修改密码
        public function change(){
            $this->load->view('admin/change_passwd.html');
        }



        //修改密码动作
        public function change_passwd(){
            //验证原密码
            $username=$this->session->userdata('username');
            $this->load->model('admin_model','admin');
            $userData=$this->admin->check($username);
            $passwd=$this->input->post('passwd');
            if(md5($passwd) != $userData[0]['passwd']) error('密码错误');
            //记录新密码
            $uid=$this->session->userdata('uid');
            $passwdF=$this->input->post('passwdF');
            $passwdS=$this->input->post('passwdS');
            if(md5($passwdF) == md5($passwdS)){
                $data=array(
                    'passwd' => md5($passwdF)
                    );
                $this->admin->update($uid,$data);
                success('admin/admin/change', '修改成功');
            }else{
                error('两次密码不同');
            }
        }

    }
?>