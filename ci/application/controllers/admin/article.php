<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Article extends MY_Controller{
        //查看文章
        public function index(){
        $this->config->set_item('url_suffix', '');



        //载入分页类
        $this->load->library('pagination');
        $perPage = 10;
        //配置项设置
        $config['base_url'] = site_url('admin/article/index');//分页类方法的url
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

        // p($data);die;
        $this->load->view('admin/check_article.html', $data);
        }



        
        //发表文章
        public function send_article(){
            $this->load->helper('form');
            $this->load->view('admin/article.html');
        }
        //发表文章动作
        public function send(){


            //文件上传
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10000';
            $config['file_name'] = time() . mt_rand(1000,9999);

            // //载入上传类
            $this->load->library('upload', $config);
            // //执行上传
            $status = $this->upload->do_upload('thumb');
            //print_r($status);die;
            $wrong = $this->upload->display_errors();

            if($wrong){
                error($wrong);
            }
            //返回信息
            $info = $this->upload->data();



            // //缩略图

            $arr['source_image'] = $info['full_path'];
            $arr['create_thumb'] = FALSE;
            $arr['maintain_ratio'] = TRUE;
            $arr['width']     = 400;
            $arr['height']   = 400;
            $this->load->library('image_lib',$arr);
            $status=$this->image_lib->resize();
            $wrong = $this->upload->display_errors();
            if($wrong){
                error($wrong);
            }
            

            //表单验证
            $this->load->helper('form');
            $this->load->library('form_validation');
            $status=$this->form_validation->run('article');

            
            if($status){
                $this->load->model('article_model','art');
                $data=array(
                    'title' => $this->input->post('title'),
                    'type' =>$this->input->post('type'),
                    'thumb' =>$info['file_name'],
                    'content' =>$this->input->post('content'),
                    'time' => time()
                    );
                
                $this->art->add($data);
                 success('admin/article/index','上传成功');

            }else{
                $this->load->helper('form');
                $this->load->view('admin/article.html');
            }
        }


        //编辑文章
        public function edit_article(){
            $this->load->helper('form');
            $aid=$this->uri->segment(4);
            $this->load->model('article_model','article');
            $data['article']=$this->article->edit_article($aid);
            $this->load->view('admin/edit_article.html',$data);
        }

        public function edit(){
            $this->load->helper('form');
            $this->load->library('form_validation');
            $statusA=$this->form_validation->run('article');
            if($statusA){


                //文字更新
                $this->load->model('article_model','article');
                $data=array(
                'title' => $this->input->post('title'),
                'type' =>$this->input->post('type'),
                'content' =>$this->input->post('content'),
                'time' => time()
                );
               $aid = $this->input->post('aid');
               $this->article->update($aid,$data);




                //图片上传配置
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000';
                $config['file_name'] = time() . mt_rand(1000,9999);
                
                // //载入上传类
                $this->load->library('upload', $config);
                // //执行上传
                $status = $this->upload->do_upload('thumb');
                //如果用户上传了图片
                if($status){
                    $wrong = $this->upload->display_errors();

                    if($wrong){
                        error($wrong);
                    }
                    //返回信息
                    $info = $this->upload->data();


                    // //缩略图

                    $arr['source_image'] = $info['full_path'];
                    $arr['create_thumb'] = FALSE;
                    $arr['maintain_ratio'] = TRUE;
                    $arr['width']     = 400;
                    $arr['height']   = 400;
                    $this->load->library('image_lib',$arr);
                    $status=$this->image_lib->resize();
                    $wrong = $this->upload->display_errors();
                    if($wrong){
                        error($wrong);
                    }
                    $dataP=array(
                        'thumb'=>$info['file_name']
                        );
                    $this->article->update($aid,$dataP);
                }
                success('admin/article/index','发表成功');

            }else{
                 $this->load->helper('form');
                 $this->load->view('admin/edit_article.html');
            }
        }
                           

        


        //删除文章
        public function del(){
            $aid=$this->uri->segment(4);
            $this->load->model('article_model','art');
            $this->art->del($aid);
            success('admin/article/index','删除成功');
        }
    }    
?>