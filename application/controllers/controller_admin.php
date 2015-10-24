<?php
class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Admin();
    }
    function create_event($data) {
        if(!isset($_POST["group"]))
            $_POST["group"] = $data["event"]["group_name"];
        if(!isset($_POST["professor"]))
            $_POST["professor"] = $data["event"]["user_info"];
        var_dump($_POST["professor"]);
        return (object) [
            "ev_text" => $_POST["event_text"],
            "group_id" => $this->model->get_id($data["groups"],$_POST["group"],"group_name"),
            "professor_id" => $this->model->get_id($data["professors"],$_POST["professor"],"user_info"),
            "ev_date" => $_POST["date"] // TODO date check
        ];
    }
    function action_index()
    {
        $data["login"] = $this->model->get_login();
        if($this->model->get_rights())
            $this->view->generate('admin_view.php', 'template_view.php',$data);
        else
            Route::ErrorPage404();
    }
    function action_create_event($date) {
        $data["login"] = $this->model->get_login();
        $date_arr = explode("-",$date[0]);
        if(strlen($date[0]) >= 8 && substr_count($date[0],"-") == 2) // TODO  написать нормальную проверку даты
            $data["date"] = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
        $data["professors"] = $this->model->get_professors();
        $data["groups"] = $this->model->get_groups();

        if(isset($_POST['submit'])) {
            $this->model->create_event($this->create_event($data));
        }

        if($this->model->get_rights())
            $this->view->generate('create_event_view.php', 'template_view.php',$data);
        else
            Route::ErrorPage404();
    }
    function action_delete_event($id) {
        $c_id = (int) $id[0];
        if($this->model->get_rights())
            $this->model->delete_event($c_id);
        else
            Route::ErrorPage404();
    }
    function action_update_event($id) {
        if(!$this->model->get_rights())
            Route::ErrorPage404();
        $int_id =(int) $id[0];
        $data["login"] = $this->model->get_login();
        $data["event"] = $this->model->get_event($int_id);
        $data["professors"] = $this->model->get_professors();
        $data["groups"] = $this->model->get_groups();
        if(isset($_POST['submit'])) {
            if($this->model->update_event($this->create_event($data),$int_id)) {
                header("Location: /calendar");
            }
        }
        $this->view->generate('update_event_view.php', 'template_view.php',$data);
    }
    function action_get_rights() {
        echo $this->model->get_rights();
    }
}
