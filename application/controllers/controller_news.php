<?php
class Controller_News extends Controller
{
    function action_index()
    {
        $this->view->generate('news_view.php', 'template_view.php');
    }
}
