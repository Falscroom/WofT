<div class="row">
  <?php foreach ($data["news"] as $value) { ?>
  <div class="col-sm-4 col-md-4">
    <div class="thumbnail">
      <img src="/images/<?php print $value['image']; ?>" class="img-rounded" alt="...">
      <div class="caption">
        <h3><?php print $value["caption"]; ?></h3>
        <p><?php print $value["ntext"]; ?></p>
      </div>
    </div>
  </div>
  <?php } ?>
</div>