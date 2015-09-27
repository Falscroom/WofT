<?php
class Controller_Calendar extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Calendar();
    }
    function action_index()
    {
        $this->model->getDates();
        $this->view->generate('calendar_view.php', 'template_view.php');
        print("\50");

    }
    function action_date() {
        header('Content-Type: application/json ');
        echo $this->model->getDates();
    }
}
