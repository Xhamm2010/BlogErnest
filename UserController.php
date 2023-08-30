<?php

require_once("Crud.php");
require_once("Session.php");
class UserController
{
    private  $crud;

    public function __construct()
    {
        $this->crud = new Crud();
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . md5($password) . "'";

        $user = $this->crud->read($sql);
        if (count($user)) {
            Session::start();
            Session::set("active_user", $user);
            header("location: admin/posts/index.php");
        } else {
            return false;
        }
    }

    public function logout()
    {
        Session::start();
        session_unset();
    }
}
