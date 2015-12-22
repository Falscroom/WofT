<div class="row">
  <?php foreach ($data["news"] as $value) { ?>
  <div class="col-sm-4 col-md-4">
    <div class="thumbnail">
      <img src="/images/<?php print $value['image']; ?>" class="img-rounded">
      <div class="caption" style="overflow: hidden;">
        <h3><a href='/news/viewnews/<?php print $value["id"]?>'><?php print $value["caption"]; ?></a></h3>
        <p><?php print $value["ntext"]; ?></p>
      </div>
    </div>
  </div>
  <?php } ?>
</div>