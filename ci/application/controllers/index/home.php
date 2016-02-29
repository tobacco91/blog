<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Home extends CI_Controller{
        public function index(){
            //前端主界面
            $this->load->model('article_model','art');
            $data['article']=$this->art->limit_article(3);
            $this->load->view('index/home.html',$data);
        }
        

        //显示文章
        public function article(){
            $aid=$this->uri->segment(4);
            
            $this->load->model('article_model','art');
            $data['article']=$this->art->aid_article($aid);
            //p($data);
            $this->load->view('index/article.html',$data);
        }


        //查看文章
        public function check_article(){
        $this->config->set_item('url_suffix', '');



        //载入分页类
        $this->load->library('pagination');
        $perPage = 10;
        //配置项设置
        $config['base_url'] = site_url('index/home/check_article');//分页类方法的url
        $config['total_rows'] = $this->db->count_all_results('article');//总行数
        $config['per_page'] = $perPage;
        $config['uri_segment'] = 4;
        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';

        $this->pagination->initialize($config);

        $data['links'] = $this->pagination->create_links();
        // p($data);die;
        $offset = $this->uri->segment(4);//从uri中获取指定段
        $this->db->limit($perPage, $offset);


        $this->load->model('article_model', 'art');
        $data['article'] = $this->art->read();

         //p($data);die;
        $this->load->view('index/check_article.html', $data);
        }




        //查看个人资料
        public function display(){
            $this->load->library('form_validation');
            $status=$this->form_validation->run('datas');
            $this->load->model('data_model','data');
            $data['da']=$this->data->get();
            
            $this->load->view('index/data.html',$data);
        }


    }
 ?>


