<?php
class Controller_Profile extends Controller
{
    function __construct() {
        $this->view = new View;
        $this->model = new Model_Profile();
    }
    function action_index()
    {
        $this->view->generate('profile_view.php', 'template_view.php');
    }
}