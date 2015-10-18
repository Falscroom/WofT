<?php
class Controller_Registration extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Authorization();
    }
    function create_user() {
        $if_stuff = $_POST["if_stuff"] == "Да";
        $group = NULL;
        if($_POST["group"] != "Не знаю / Я преподаватель" && !$if_stuff)
            $group = $_POST["group"];

        return (object) [
            "login" => $_POST["login"],
            "password" => $_POST["password"],
            "confirm_password" => $_POST["confirm_password"],
            "contacts" => $_POST["contacts"],
            "user_info" => $_POST["user_info"],
            "if_stuff" => $if_stuff,
            "user_group" => $group
        ];
    }
    function action_index()
    {
        if(isset($_POST['submit']))
            $this->model->add_user($this->create_user());
        $data["login"] = $this->model->get_login();
        $data["options"] = $this->model->get_options();
        $this->view->generate('registration_view.php', 'template_view.php',$data);
    }
}