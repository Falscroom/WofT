<?php
class Controller_Registration extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Authorization();
    }
    function create_user() {
        $group = false;
        if($_POST["group"] != "Не знаю / Я преподаватель")
            $group = $_POST["group"];
        $if_stuff = $_POST["if_stuff"] == "Да";

        return (object) [
            "login" => $_POST["login"],
            "password" => $_POST["pass"],
            "confirm_password" => $_POST["passtwo"],
            "contacts" => $_POST["info"],
            "user_info" => $_POST["nmf"],
            "if_stuff" => $if_stuff,
            "group" => $group
        ];
    }
    function action_index()
    {
        if(isset($_POST['submit'])) {
            $group = false;
            if($_POST["if_stuff"] == "Нет") {
                if(!$_POST["group"] == "Не знаю / Я преподаватель")
                    $group = $_POST["group"];
                $this->model->addUser($_POST["login"], $_POST["pass"], $_POST["info"], $_POST["passtwo"],$_POST["nmf"],$group);
            }
            else
                $this->model->addUser($_POST["login"], $_POST["pass"], $_POST["info"], $_POST["passtwo"],$_POST["nmf"],$group,true);


        }
        $data["options"] = $this->model->getOptions();
        $this->view->generate('registration_view.php', 'template_view.php',$data);
    }
}