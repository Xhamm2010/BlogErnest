<?php

    require_once("Crud.php");

    class CommentController{
        private $crud;
        
        public function __construct()
        {
            $this->crud = new Crud();
        }

        public function getAllComments(){
            
        }
    }