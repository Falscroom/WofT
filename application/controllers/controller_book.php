<?php
class Controller_Book extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Book();
    }
    function action_index()
    {	
        $this->view->generate('book_view.php', 'template_view.php');
    }
}