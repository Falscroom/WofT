<?php
class Controller_News extends Controller
{
    function __construct() {
        $this->view = new View();
        $this->model = new Model_News();
    }
    function addnews($id, $news) {
    	return (object) [
    		"caption" => $_POST["newsCaption"],
    		"ntext" => $_POST["newsText"],
    		"id" => $id
    	];
    }
    function action_index() {
        $data = $this->model->get_news();
        $this->view->generate('news_view.php', 'template_view.php',$data);
    }
    function action_addnews() {
    	if (isset($_POST['submit'])) {
    		$this->model->addnews($this->addnews($news));
    		header("Location: /news");
    	}
    	$this->view->generate('create_news_view.php', 'template_view.php');
    }
    function action_viewnews($id) {
    	$data = $this->model->viewnews($id['0']);
    	$this->view->generate('viewnews_view.php', 'template_view.php', $data);
    }
    function action_deletenews($id) {
    	if ($this->model->deletenews($id['0'])) {
    		header("Location: /news");
    	};
    }
    function action_editnews($id) {
    	$data = $this->model->viewnews($id['0']);
    	if (isset($_POST['submit'])) {
    		$this->model->editnews($this->addnews($id['0'], $news));
    		header("Location: /news");
    	}
    	$this->view->generate('edit_news_view.php', 'template_view.php', $data);
    }
}
