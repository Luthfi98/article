<div class="container-lg">
  <!-- <div class="row">
    <div class="col-2">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          Show
          <svg class="icon me-2">
            <use xlink:href="<?= _assets() ?>/vendors/@coreui/icons/svg/free.svg#cil-filter"></use>
          </svg>
        </span>
        <select class="form-select" name="limit" id="limit">
          <option>5</option>
          <option>10</option>
          <option>15</option>
        </select>
      </div>
    </div>
    <div class="col-10">
      <div class="input-group mb-3">
        <input type="text" name="keyword" class="form-control" id="keyword">
        <button class="btn btn-primary input-group-text" id="btn-search">Search</button>
      </div>
    </div>
  </div> -->
  <div class="row justify-content-center">
    <?php if ($data): ?>
      <?php foreach ($data as $dt): ?>
      <div class="col-4 mb-3">
        <div class="card h-100" style="">
          <div class="card-body">
            <h5 class="card-title text-center"><?= $dt['title'] ?></h5>
            <h6 class="card-subtitle mb-2 text-medium-emphasis"><?= $dt['category'] ?></h6>
            <p class="card-text"><?= substr(strip_tags($dt['content']), 0,50)."..." ?>
              <a class="card-link" href="<?= base_url('preview/detail/'.$dt['id']) ?>">View More</a>
            </p>
            <!-- <a class="card-link" href="#">Another link</a> -->
          </div>
        </div>
      </div>
      <?php endforeach ?>
    <?php else: ?>
      <h3 class="text-center">Data Not Found</h3>
    <?php endif ?>
    <nav aria-label="Page navigation example">
      <?= $pagination ?>
      <!-- <ul class="pagination justify-content-center">
        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul> -->
    </nav>
  </div>
</div>