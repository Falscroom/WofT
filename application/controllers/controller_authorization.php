<?php
class Controller_Authorization extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Authorization();
    }
    function action_index()
    {

        if(isset($_POST['submit'])) {
            echo $_POST["login"],$_POST["pass"],$_POST["info"],$_POST["passtwo"];
            if(!$this->model->addUser($_POST["login"],$_POST["pass"],$_POST["info"],$_POST["passtwo"]))
                echo "Ne smog";
        }
        $this->view->generate('auth_view.php', 'template_view.php');
    }
}