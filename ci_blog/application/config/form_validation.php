<?php
    $config= array(
       'article'=> array(
            array(
                'field' => 'title',
                'lable' =>'标题',
                'rules' => 'required'
                ),
            array(
                'field' =>  'type',
                'label' => '类型',
                'rules' => 'required'
                ),
            
            array(
                'field' =>  'content',
                'label' => '内容',
                'rules' => 'required|max_length[10000]'
                ),
            ),
       'datas'=> array(
            array(
                'field' => 'nc',
                'lable' =>'昵称',
                'rules' => 'required'
                ),
            array(
                'field' =>  'gx',
                'label' => '故乡',
                'rules' => 'required'
                ),
            
            array(
                'field' =>  'yx',
                'label' => '邮箱',
                'rules' => 'required'
                ),
            array(
                'field' => 'nl',
                'lable' =>'年龄',
                'rules' => 'required'
                ),
            array(
                'field' =>  'gxqm',
                'label' => '个性签名',
                'rules' => 'required'
                ),
            
            array(
                'field' =>  'xb',
                'label' => '性别',
                'rules' => 'required'
                ),
            ),
       'message'=> array(
            array(
                'field' =>  'comment',
                'label' => '评论',
                'rules' => 'required|max_length[2000]'
                ),
            ),
        );
 ?>