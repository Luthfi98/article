<div class="container-lg">
  <div class="row">
      <div class="card" style="">
        <div class="card-body">
          <h5 class="card-title text-center"><?= $data['title'] ?></h5>
          <h6 class="card-subtitle mb-2 text-medium-emphasis"><?= $data['category'] ?></h6>
          <p class="card-text"><?= str_replace(['\n', '\/', '\r', '\"'], ['<br>', '/', '', '"'], json_encode($data['content']))  ?>
          </p>
          <!-- <a class="card-link" href="#">Another link</a> -->
        </div>
      </div>
    </div>
  </div>
</div>