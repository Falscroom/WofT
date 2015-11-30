<div class="row">
	<div>
		<?php if ($data["rights"] & U_EDIT) {?>
		<p align="right"><input name="button" type="button" class="btn btn-primary" value="Создать новость" onclick="(function() {window.location.replace('/news/addnews')})()"></p>
		<?php }; ?>
	</div>	
	<?php foreach ($data["news"] as $value) { ?>
 	<div class="thumbnail">
  		<div class="caption">
      		<div style="margin: 0px 10px 0px 0px; float: left">
      			<a href="http://goo.gl/BW3wHh"><img src="http://goo.gl/BW3wHh" alt="..." class="img-rounded" width="100"></a>
      		</div>
      		<div style="display: table-cell">
        		<h3><?php print $value["caption"]; ?></h3>
        		<p><?php print $value["ntext"]; ?></p>
        		
        	</div>
        	<p align="right"><a href='/news/viewnews/<?php print $value["id"]?>'>Перейти к новости</a></p>
  		</div>
	</div>
	<?php } ?>
</div>