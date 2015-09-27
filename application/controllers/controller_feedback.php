<?php
class Controller_Feedback extends Controller
{
    function action_index()
    {
        $this->view->generate('feedback_view.php', 'template_view.php');
    }
}
