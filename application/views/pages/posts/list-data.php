<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<div class="container-lg">
  <div class="card mb-4">
    <div class="card-header"><strong><?= $title ?></strong></div>
    <div class="card-body">
      <div class="example">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-coreui-toggle="tab" href="#publish" onclick="loadPublish()" role="tab">
              <svg class="icon me-2">
                <use xlink:href="<?= _assets() ?>/vendors/@coreui/icons/svg/free.svg#cil-cloud-upload"></use>
              </svg>Publish 
              <span class="badge badge-sm bg-info ms-auto" id="count-publish"><?= $publish ?></span></a>
          </li>
          <li class="nav-item"><a class="nav-link" data-coreui-toggle="tab" href="#draft" onclick="loadDraft()" role="tab">
              <svg class="icon me-2">
                <use xlink:href="<?= _assets() ?>/vendors/@coreui/icons/svg/free.svg#cil-save"></use>
              </svg>Draft
              <span class="badge badge-sm bg-info ms-auto" id="count-draft"><?= $draft ?></span>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" data-coreui-toggle="tab" href="#trash" onclick="loadTrash()" role="tab">
              <svg class="icon me-2">
                <use xlink:href="<?= _assets() ?>/vendors/@coreui/icons/svg/free.svg#cil-trash"></use>
              </svg>Trash
              <span class="badge badge-sm bg-info ms-auto" id="count-trash"><?= $trash ?></span>
            </a>
          </li>
        </ul>
        <div class="tab-content rounded-bottom">
          <div class="tab-pane p-3 active preview" role="tabpanel" id="publish">
            <table class="table" id="list-data-publish" width="100%">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="tab-pane p-3" role="tabpanel" id="draft">
            <table class="table" id="list-data-draft" width="100%">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="tab-pane p-3" role="tabpanel" id="trash">
            <table class="table" id="list-data-trash" width="100%">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

  $(document).ready(function(){
    loadPublish()
    // loadDraft()
    // loadTrash()
  })
  function loadPublish(){
    var listdatapublish = $('#list-data-publish').DataTable({
      processing: true,
      serverSide: true,
      destroy:true,
      columnDefs: [
          {
              targets : [-1,0],
              orderable: false
          },
          {
              targets : [-1,0],
              class: 'text-nowrap text-center'
          }
      ],
      ajax: {
        url:`${base_url}posts/getData?status=Publish`,
        method: 'POST',
      },
    })
  }
  function loadDraft(){
    var listdatadraft = $('#list-data-draft').DataTable({
      processing: true,
      serverSide: true,
      destroy:true,
      columnDefs: [
          {
              targets : [-1,0],
              orderable: false
          },
          {
              targets : [-1,0],
              class: 'text-nowrap text-center'
          }
      ],
      ajax: {
        url:`${base_url}posts/getData?status=Draft`,
        method: 'POST',
      },
    })
  }
  function loadTrash(){
    var listdatatrash = $('#list-data-trash').DataTable({
      processing: true,
      serverSide: true,
      destroy:true,
      columnDefs: [
          {
              targets : [-1,0],
              orderable: false
          },
          {
              targets : [-1,0],
              class: 'text-nowrap text-center'
          }
      ],
      ajax: {
        url:`${base_url}posts/getData?status=Trash`,
        method: 'POST',
      },
    })
  }

</script>