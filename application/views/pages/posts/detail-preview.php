<div class="container-lg">
  <div class="row">
      <div class="card" style="">
        <div class="card-body">
          <h3 class="card-title text-center"><?= $data['title'] ?></h3>
          <h6 class="card-subtitle mb-2 text-medium-emphasis"><?= $data['category'] ?></h6>
          <p class="card-text"><?= $data['content']  ?>
          </p>
          <!-- <p class="card-text"><?= str_replace(['\n', '\/', '\r', '\"'], ['<br>', '/', '', '"'], json_encode($data['content']))  ?>
          </p> -->
          <!-- <a class="card-link" href="#">Another link</a> -->
          <button class="btn btn-secondary text-light" onclick="Previous()">Back</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function Previous() {
              window.history.go(-1);
          }
</script>