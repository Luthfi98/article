<div class="container-lg">
  <div class="card mb-4">
    <div class="card-header"><strong><?= $title ?></strong></div>
    <form id="form">
      <div class="card-body">
        <div class="form-group mb-3">
          <label class="form-label" for="title">Title</label>
          <input type="text" name="title" id="title" autofocus class="form-control">
          <span class="text-danger title_error"></span>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="content">Content</label>
          <textarea name="content" id="content" class="form-control" rows="10"></textarea>
          <span class="text-danger content_error"></span>
        </div>
        <div class="form-group mb-3">
          <label class="form-label" for="category">Category</label>
          <input type="text" name="category" id="category" class="form-control">
          <span class="text-danger category_error"></span>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" id="btn-publish" class="btn btn-submit btn-success text-light" data-status="Publish">Publish</button>
        <button type="button" id="btn-draft" class="btn btn-submit btn-primary" data-status="Draft">Draft</button>
      </div>
    </form>
  </div>
</div>

<script>
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
          window.location.href=`${base_url}posts/new`;
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
