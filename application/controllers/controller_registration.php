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
            "password" => $_POST["password"],
            "confirm_password" => $_POST["confirm_password"],
            "contacts" => $_POST["contacts"],
            "user_info" => $_POST["user_info"],
            "if_stuff" => $if_stuff,
            "group" => $group
        ];
    }
    function action_index()
    {
        if(isset($_POST['submit'])) {
            $this->model->add_user($this->create_user());
        }
        $data["options"] = $this->model->get_options();
        $this->view->generate('registration_view.php', 'template_view.php',$data);
    }
}