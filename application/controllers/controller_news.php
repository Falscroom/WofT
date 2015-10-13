<?php
class Controller_News extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_News();
    }
    function action_index()
    {
        $this->view->generate('news_view.php', 'template_view.php');
    }
}
