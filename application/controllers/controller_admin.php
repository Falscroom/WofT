<?php
class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new Model_Admin();
    }
    function create_event($data) {
        $professor_id = array_search($_POST["professor"],array_column($data["professors"], 'user_info') );
        $professor_id = $data["professors"][$professor_id]["id"];

        $group_id = array_search($_POST["group"],array_column($data["groups"], 'group_name') );
        $group_id = $data["groups"][$group_id]["id"];

        return (object) [
            "ev_text" => $_POST["event_text"],
            "group_id" => $group_id,
            "professor_id" => $professor_id,
            "ev_date" => $_POST["date"] // TODO date check
        ];
    }
    function action_index()
    {
        if($this->model->get_rights())
            $this->view->generate('create_event_view.php', 'template_view.php');
        else
            Route::ErrorPage404();
    }
    function action_create_event($date) {
        $date_arr = explode("-",$date[0]);
        if(strlen($date[0]) >= 9 && substr_count($date[0],"-") == 2) // TODO  написать нормальную проверку даты
            $data["date"] = $date_arr[2].".".$date_arr[0].".".$date_arr[1];
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
}
