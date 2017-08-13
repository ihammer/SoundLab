<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class  OrderController  extends  FormController{
    
    public function __construct()
     {
    //      $this->model = '\Tag';
          $this->fields_show = [];
          $this->fields_edit = [];
          $this->fields_create = [];
          parent::__construct();
     }
    
    
    public function  index(){
        
        $models = 1;
                $recommand = 2;
        echo  '订单管理';
        return View::make('admin.index');
    }
    
    
}
