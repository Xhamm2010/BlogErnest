<?php

// require_once("DbConfig.php");
// require_once("Crud.php");
require_once("PostController.php");

// getDbConnection();
// $crud = new Crud();
$post_controller = new PostController();
$post = $post_controller->getPosts();
var_dump($post);


// $crud->delete("DELETE FROM posts WHERE id = 8");

// $crud->update("UPDATE posts SET post_content = 'content_1' WHERE id = 8");

// $data_array = [
//     "post_title" => "Ali and Simbi",
//     "post_content" => "Ali and Simbi are enjoying theirselves ",
//     "cat_id" => 4
// ];

// $crud->create($data_array, "posts");

// $results = $crud->read("SELECT * FROM posts");
// var_dump($results);