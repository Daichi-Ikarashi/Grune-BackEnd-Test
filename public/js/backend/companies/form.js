$(function () {
  // init: side menu for current page
  $("li#menu-companies").addClass("menu-open active");
  $("li#menu-companies").find(".treeview-menu").css("display", "block");
  $("li#menu-companies")
    .find(".treeview-menu")
    .find(".edit-companies a")
    .addClass("sub-menu-active");

  $("#company-form").validationEngine("attach", {
    promptPosition: "topLeft",
    scroll: false,
  });

  // init: show tooltip on hover
  $('[data-toggle="tooltip"]').tooltip({
    container: "body",
  });

  //Automatically enter the address with the entered Postcode
  $("#searchBtn").click(() => {
    const postcode = $("#postcode").val();
    $.ajax({
      type: "get",
      url: "/getPostcodeData/" + postcode,
      dataType: "json",
      data: {
        postcode: postcode,
      },
    })
      .done((res) => {
        $("#city").val(res[0].city);
        $("#local").val(res[0].local);

        $("select[name='prefecture_id'] option")
          .filter(function () {
            return $(this).text() === res[0].prefecture;
          })
          .prop("selected", true);
      })
      .fail((err) => {
        console.log(err.statusText);
      });
  });

  // Preview the selected image file
  $("[name='image']").on("change", function (e) {
    let reader = new FileReader();
    reader.onload = function (e) {
      $("#preview").attr("src", e.target.result);
    };
    reader.readAsDataURL(e.target.files[0]);
    // 選択したら消す
    $("#image-alert").hide();
  });
});
