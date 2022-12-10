$("#submit-soporte").on("click", function(event){
  event.preventDefault();
  var form = $("#soporte-form");
  var data = form.data("yiiActiveForm");
  var _url = form.attr("action");
  $.each(data.attributes, function() { this.status = 3; });
  form.yiiActiveForm("validate");
  if (!(form.find(".has-error").length)) {
    var _data = new FormData(form[0]);
    $.ajax({
      url: _url,
      type: "post",
      enctype: 'multipart/form-data',
      data: _data,
      processData: false,
      contentType: false,
      cache: false,
      timeout: 800000,
      success: function (response) {
        if(response){
          $("#close-main-modal").click();
        }
      }
    });
    return false;
  }
});

