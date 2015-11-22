<?php
class Controller_News extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_News();
    }
    function addnews($news) {
    	return (object) [
    		"caption" => $_POST["newsCaption"],
    		"ntext" => $_POST["newsText"]
    	];
    }
    function action_index() {
        //$data["login"] = $this->model->get_login();
        $data = $this->model->get_news();
        $this->view->generate('news_view.php', 'template_view.php',$data);
    }
    function action_addnews() {
    	if (isset($_POST['submit'])) {
    		$this->model->addnews($this->addnews($news));
    	}
    	$this->view->generate('create_news_view.php', 'template_view.php');
    }
}
