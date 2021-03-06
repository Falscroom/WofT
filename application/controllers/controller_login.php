<?php
class Controller_Login extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Login();
    }
    function action_index()
    {
        if(isset($_POST['submit'])) {
            if($this->model->approveUser($_POST['login'],$_POST['password'])) {
                header("Location: /main");
            }
        }
        $data["login"] = $this->model->get_login();
        $this->view->generate('login_view.php', 'template_view.php',$data);
    }
}
