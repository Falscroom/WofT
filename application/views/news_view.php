<div class="row">
	<div>
		<p align="right"><input name="button" type="button" class="btn btn-primary" value="Создать новость" onclick="(function() {window.location.replace('/news/addnews')})()"></p>
	</div>	
	<?php foreach ($data as $value) { ?>
	 	<div class="thumbnail">
      		<div class="caption">
        	<h3><?php print $value["caption"]; ?></h3>
        	<p><?php print $value["ntext"]; ?></p>
        	<?php if ($data["login"] == false /*true*/) { print '<p align="right"><a href="#" class="btn btn-default" role="button">Редактировать</a> <a href="#" class="btn btn-default" role="button">Удалить</a></p>'; } ?>
      		</div>
    	</div>
    	<?php } ?>
</div>