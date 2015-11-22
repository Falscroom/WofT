<?php
Class Model_News extends Authorization {
	public function get_news() {
		$this->prepare("SELECT * FROM news ORDER BY id DESC");
		return $this->execute_all();
	}
	public function addnews($news) {
		$this->prepare("INSERT INTO news(id, caption, ntext) VALUES (NULL, :caption, :ntext)");
		$this->query->bindParam(":caption",$news->caption,PDO::PARAM_STR);
		$this->query->bindParam(":ntext",$news->ntext,PDO::PARAM_STR);
		$this->execute_simple();
	}
}