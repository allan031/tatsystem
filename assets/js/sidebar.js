$(function () {
  $("#management").click(function (e) {
    e.preventDefault();
    $("#nav-user").toggleClass("hidden flex");
  });

  $("#nav-transac").click(function (e) {
    e.preventDefault();
    $("#sub-nav-transac").toggleClass("hidden flex");
  });

  $("#nav-report").click(function (e) {
    e.preventDefault();
    $("#sub-nav-report").toggleClass("hidden flex");
  });

  $("#logout").click(function (e){
    e.preventDefault();
    //alert("test");
    $("#logout-modal").toggleClass("hidden flex");
    //$("#side-menu").toggleClass("fixed hidden");
  })

  $("#btn-cancel-logout").click(function (e){
    e.preventDefault();
    //$("#logout-modal").toggleClass("flex hidden");
    location.reload();
  })

  $("#btn-confirm-logout").click(function (e){
    e.preventDefault();
    window.location.href = "/tatsystem/logout.php";
  })

  //get department
  function GetDept(deptID) {
    param = {
      Action: "GetDept",
      deptID: deptID,
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "/tatsystem/qrcode.php",
      // dataType: "json",
      data: { data: param },
      success: function (data) {
        // console.log("success: " + data);
        $("#dept-container").html(
          JSON.parse(data)[0].DeptAbb + "&nbspDepartment"
        );
        // console.log(JSON.parse(data)[0].DeptAbb);
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }
  var id = document.getElementById("dept-value");
  var deptID = id.innerHTML;
  GetDept(deptID);
});

$(function () {
  $("#btn-menu").click(function (e) {
    e.preventDefault();
    $("#side-menu").toggleClass("xs:hidden sm:hidden md:hidden");
    //alert("asdsad");
  });
});
