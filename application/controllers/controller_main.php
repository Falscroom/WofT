<?php
class Controller_Main extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Main();
    }
    function action_index()
    {	$data = [];
        if($this->model->mainApproveLogin()) {
            $data['login'] = $_COOKIE['login'];
        }
        else
            $data['login'] = null;
        $this->view->generate('main_view.php', 'template_view.php',$data);
    }
    function action_logout() {
        Authorization::logOut();
    }
}