<?php
class Controller_Profile extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Profile();
    }
    function action_index($login)
    {
        $data["login"] = $this->model->get_login();
        if($login)
            $data["user"] = $this->model->get_user($login[0]);
        $data["rights"] = $this->model->get_rights();
        $this->view->generate('profile_view.php', 'template_view.php',$data);
    }
}