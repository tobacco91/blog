<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Data extends MY_Controller{
        //显示
        public function index(){
            $this->load->library('form_validation');
            $status=$this->form_validation->run('datas');
            $this->load->model('data_model','data');
            $data['datas']=$this->data->get();
            
            $this->load->view('admin/data_change.html',$data);


        }
        public function change(){
            $this->load->helper('form');
            $this->load->library('form_validation');
            $statusA=$this->form_validation->run('datas');
            
            if($statusA){
               
                $data=array(
                    'nc' => $this->input->post('nc'),
                    'xb' =>$this->input->post('xb'),
                    'gx' =>$this->input->post('gx'),
                    'nl' => $this->input->post('nl'),
                    'yx' =>$this->input->post('yx'),
                    'gxqm' => $this->input->post('gxqm'),
                    );
                $did= $this->input->post('did');
                $this->load->model('data_model','data');
                $this->data->update($data,$did);
        

                
                //图片上传配置
                $config['upload_path'] = './uploads/person/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000';
                $config['file_name'] = time() . mt_rand(1000,9999);
                
                // //载入上传类
                $this->load->library('upload', $config);
                // //执行上传
                $status = $this->upload->do_upload('tx');
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
                    $arr['width']     = 300;
                    $arr['height']   = 300;
                    $this->load->library('image_lib',$arr);
                    $status=$this->image_lib->resize();
                    $wrong = $this->upload->display_errors();
                    if($wrong){
                        error($wrong);
                    }
                    $dataP=array(
                        'tx'=>$info['file_name']
                        );
                    $this->data->update($dataP,$did);
                }
                success('admin/admin/index','发表成功');

            }else{
                $this->load->helper('form');
                $this->load->view('admin/data_change.html');
            }
            
        }



        



    }
?>