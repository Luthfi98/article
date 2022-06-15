<div class="container-lg">
  <div class="card mb-4">
    <div class="card-header"><strong><?= $title ?></strong></div>
    <form id="form">
      <div class="card-body">
        <div class="form-group mb-3">
          <label class="form-label" for="title">Title</label>
          <input type="text" name="title" id="title" value="<?= $data['title'] ?>" autofocus class="form-control">
          <span class="text-danger title_error"></span>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="content">Content</label>
          <textarea name="content" id="content" class="form-control" rows="10"><?= $data['content'] ?></textarea>
          <span class="text-danger content_error"></span>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="category">Category</label>
          <input type="text" name="category" id="category" value="<?= $data['category'] ?>" class="form-control">
          <span class="text-danger category_error"></span>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="old_status">Status</label>
          <input type="text" name="old_status" id="old_status" readonly value="<?= $data['status'] ?>" class="form-control">
        </div>
      </div>
      <div class="card-footer">
        <button type="button" id="btn-publish" class="btn btn-submit btn-success text-light" data-status="Publish">Publish</button>
        <button type="button" id="btn-draft" class="btn btn-submit btn-primary" data-status="Draft">Draft</button>
      </div>
    </form>
  </div>
</div>
<script src="<?= _assets()?>/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?= _assets()?>/vendors/summernote/summernote-bs4.min.css">
<script src="<?= _assets()?>/vendors/summernote/summernote-bs4.min.js"></script>


<script>

    $('#content').summernote({
      height: "300px",
      toolbar:[
        ['style', ['undo','redo', 'bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        // ['fontsize', ['fontname','fontsize']],
        // ['color', ['color']],
        ['para', ['ul', 'ol']],
        // ['height', ['height']],
        ['insert', ['link', 'hr']],
        ['misc', ['fullscreen']]
      ],
    })
  $('.btn-submit').click(function(e){
    e.preventDefault("submit")
    var status = $(this).data('status')
    var data = new FormData($('#form')[0]);
    data.append("status", status)
    $.ajax({
      url:"",
      cache: false,
      contentType: false,
      processData: false,
      dataType:'json',
      type:'POST',
      data:data,
      beforeSend:(response) => {
        $(".btn-submit").attr("disabled", true).html('Mengirim ....')
      },
      complete:(response) => {
          $("#btn-publish").attr("disabled", false).html('Publish')
          $("#btn-draft").attr("disabled", false).html('Draft')
      },
      success: (response) =>{

        if (response.status) {
          alert(response.alert);
          // $('#modal-device').modal('hide')
          // dt.ajax.reload()
          window.location.href=""
          
        }else{
          var error = response.error
          $.each(error, function(key, value) {
              $('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> </i> ${value}` : value)
              $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
            })
        }

      }
    })
  })
</script>
