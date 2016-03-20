<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Login extends CI_Controller{
        public function index(){
            //验证码制作
            //验证码辅助函数
            $this->load->helper('captcha');

            $speed='1234567890r5t6y7u8jiwertgyuhjiozxsfdgbhjukiswe';
            $word='';
            for($i=0;$i<4;$i++){
                $word.=$speed[mt_rand(0,strlen($speed)-1)];
            }
            //配置
            $vals=array(
                'word' => $word,
                'img_path' => './captcha/',
                'img_url' => base_url().'/captcha/',
                'img_width' => 80,
                'img_height' =>30,
                'expiration' => 60,
                'font_size' => 16,
                );
            //创建验证码
            $cap = create_captcha($vals);
           
            $data['captcha']=$cap['image'];

            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['code']=$cap['word'];
            
            $this->load->view('admin/login.html',$data);
        }



        //登录
        public function login_in(){
            
            $code=$this->input->post('captcha');
            
            //判断
           if(strtoupper($code)!=strtoupper($_SESSION['code'])) error('验证码错误');
            $username=$this->input->post('username');
            $passwd=$this->input->post('passwd');
            $this->load->model('admin_model','admin');
            $userData=$this->admin->check($username);
            
             //= =为真才执行 绕绕绕>.<~
            if(!$userData || $userData[0]['passwd']!=md5($passwd)) error('用户名或密码错误');

            //session储存
            $sessiondata=array(
                'username' => $username,
                'uid' =>$userData[0]['uid'],
                'logintime' => time()
                );
            $this->session->set_userdata($sessiondata);
            success('admin/admin/index','登录成功');
        
        }



        //退出
        public function login_out(){
            $this->session->sess_destroy();
            success('admin/login/index','退出成功');
        }
    }
?>