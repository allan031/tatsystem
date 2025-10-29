$(function () {
  //clear fields
  function ClearFields() {
    document.getElementById("first-name").value = "";
    document.getElementById("middle-name").value = "";
    document.getElementById("last-name").value = "";
    document.getElementById("emailAdd").value = "";
    document.getElementById("username").value = "";
    $("input[type=radio]").prop("checked", false);
    document.getElementById("dept").selectedIndex = 0;
    document.getElementById("birthDate").value = "";
  }

  //web users
  function Adduser(
    username,
    username,
    firstname,
    middlename,
    lastname,
    birthdate,
    emailAddress,
    department,
    createdBy,
    createdDate,
    Utype,
    AcctType,
    AccAccess
  ) {
    param = {
      Action: "AddUser",
      username: username,
      firstname: firstname,
      middlename: middlename,
      lastname: lastname,
      birthdate: birthdate,
      emailAddress: emailAddress,
      department: department,
      createdBy: createdBy,
      createdDate: createdDate,
      Utype: Utype,
      AcctType: AcctType,
      AccAccess:AccAccess
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/registration.inc.php",
      data: { data: param },
      success: function (data) {
        console.log(data);
        if (JSON.parse(data)[0].errormsg != "") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: JSON.parse(data)[0].errormsg,
            showConfirmButton: false,
            timer: 1500,
          });
        }
        if (JSON.parse(data)[0].successmsg != "") {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: JSON.parse(data)[0].successmsg,
            showConfirmButton: false,
            timer: 1500,
          });
          ClearFields();
        }
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  //disable user
  function DeleteUser(userid) {
    param = { Action: "DeleteUser", userid: userid };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/registration.inc.php",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        location.reload();
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  $("#btn-add-user").click(function (e) {
    e.preventDefault();
    let firstname = $("#first-name").val();
    let middlename = $("#middle-name").val();
    let lastname = $("#last-name").val();
    let department = $("#dept").find(":selected").val();
    let birthdate = $("#birthDate").val();
    let emailAddress = $("#emailAdd").val();
    let username = $("#username").val();
    let Utype = $("input[type='radio'].radioBtnClass:checked").val();
    let AcctType = $("input[type='radio'].radioBtnClassAccType:checked").val();
    let Ttype = $("input[type='radio'].radioBtnClassTtype:checked").val()
      ? $("input[type='radio'].radioBtnClassTtype:checked").val()
      : "";

    if (
      firstname == "" ||
      lastname == "" ||
      department == "" ||
      birthdate == "" ||
      emailAddress == "" ||
      username == "" ||
      Utype == "" ||
      AcctType == ""
    ) {
      Swal.fire("All fields are required!");
    } else {
      $("#registration-save-modal").toggleClass("hidden flex");
      //alert(AcctType);
    }
  });

  $("#btn-save").click(function (e) {
    e.preventDefault();

    //date time
    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    var time =
      today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + " " + time;

    let firstname = $("#first-name").val();
    let middlename = $("#middle-name").val();
    let lastname = $("#last-name").val();
    let department = $("#dept").find(":selected").val();
    let birthdate = $("#birthDate").val();
    let emailAddress = $("#emailAdd").val();
    let username = $("#username").val();
    let Utype = $("input[type='radio'].radioBtnClass:checked").val();
    let AcctType = $("input[type='radio'].radioBtnClassAccType:checked").val();
    let AccAccess = $("#accAccess").find(":selected").val();

    //created BY
    let uname = document.getElementById("createdBy");
    let createdBy = uname.innerHTML;

    Adduser(
      username,
      username,
      firstname,
      middlename,
      lastname,
      birthdate,
      emailAddress,
      department,
      createdBy,
      dateTime,
      Utype,
      AcctType,
      AccAccess
    );
    $("#registration-save-modal").toggleClass("flex hidden");
  });

  $(".btn-close").click(function (e) {
    e.preventDefault();
    $("#registration-save-modal").toggleClass("flex hidden");
  });

  //modal function for reset pass
  function ResetPassword(userid) {
    param = { Action: "ResetPassword", userid: userid };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/registration.inc.php",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Password has been reset",
          showConfirmButton: false,
          timer: 1500,
        }).then(function () {
          location.reload();
        });
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  $(document).on("click", ".btn-password-reset", function (e) {
    e.preventDefault();
    let userid = $(this).data("userid");
    ResetPassword(userid);
  });

  $(".btn-close").click(function (e) {
    e.preventDefault();
    $("#password-change-modal").toggleClass("flex hidden");
  });

  $(document).on("click", ".btn-user-delete", function (e) {
    e.preventDefault();
    let userid = $(this).data("userid");
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        DeleteUser(userid);
        location.reload();
      }
    });
  });

  $(document).on("click", ".btn-user-edit", function (e) {
    e.preventDefault();
    let userid = $(this).data("userid");
    $("#edit-save-modal").toggleClass("flex hidden");
    GetUserDetails(userid);
  });

  //close modal edit
  $(document).on("click", ".btn-edit-close", function (e) {
    e.preventDefault();
    $("#edit-save-modal").toggleClass("hidden flex");
    location.reload();
  });

  //function to get user's details
  function GetUserDetails(id) {
    param = { Action: "GetUser", id: id };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/registration.inc.php",
      data: { data: param },
      success: function (data) {
        console.log(data);
        $("#edit-first-name").val(JSON.parse(data)[0].EmpFirstName);
        $("#edit-middle-name").val(JSON.parse(data)[0].EmpMiddleName);
        $("#edit-last-name").val(JSON.parse(data)[0].EmpLastName);
        $("#dept :selected").text(JSON.parse(data)[0].EmpDeptName);
        $("#dept :selected").val(JSON.parse(data)[0].EmpDept);
        $("#edit-birthDate").val(JSON.parse(data)[0].EmpBirthDate);
        $("#edit-emailAdd").val(JSON.parse(data)[0].EmpEmailAddress);
        $("#edit-username").val(JSON.parse(data)[0].UserID);
        $("input[type='radio'].edit-radioBtnClass").val([
          JSON.parse(data)[0].Platform,
        ]);
        $("input[type='radio'].edit-radioBtnClassAccType").val([
          JSON.parse(data)[0].AccountType,
        ]);
        // $("input[type='radio'].edit-radioBtnClassTtype").val([
        //   JSON.parse(data)[0].TransactionType,
        // ]);
        $("#passValUserID").html(JSON.parse(data)[0].UserID);
        $("#accAccess :selected").text(JSON.parse(data)[0].AccAccess);
        $("#accAccess :selected").val(JSON.parse(data)[0].IsAccess);
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  //btn-edit-save function
  $(document).on("click", "#btn-edit", function (e) {
    e.preventDefault();
    let userid = document.getElementById("passValUserID");
    let id = userid.innerHTML;

    let cruserid = document.getElementById("passVal");
    let updateBy = cruserid.innerHTML;

    //date time
    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    var time =
      today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + " " + time;

    //user details
    let firstname = $("#edit-first-name").val();
    let middlename = $("#edit-middle-name").val();
    let lastname = $("#edit-last-name").val();
    let department = $("#dept").find(":selected").val();
    let birthdate = $("#edit-birthDate").val();
    let emailAddress = $("#edit-emailAdd").val();
    let Utype = $("input[type='radio'].edit-radioBtnClass:checked").val();
    let AcctType = $(
      "input[type='radio'].edit-radioBtnClassAccType:checked"
    ).val();
    let isAccess = $("#accAccess").find(":selected").val();

    param = {
      Action: "EditUser",
      id: id,
      firstname: firstname,
      middlename: middlename,
      lastname: lastname,
      department: department,
      birthdate: birthdate,
      emailAddress: emailAddress,
      updateBy: updateBy,
      updatedDate: dateTime,
      Utype: Utype,
      AcctType: AcctType,
      isAccess:isAccess
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/registration.inc.php",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "User details has been updated!",
          showConfirmButton: false,
          timer: 1500,
        }).then(function () {
          location.reload();
        });
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  });


  $("#user-datatable").DataTable();
  //load pagination table
  function LoadWithPagination() {
    param = {
      Action: "Load",
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/registration.inc.php",
      method: "POST",
      data: { data: param },
      success: function (data) {
        //console.log(data);
        $("#searchresultPD").html(data);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
  LoadWithPagination();


  $("#table-user-logs").DataTable();
  // load user logs data
  // function LoadUserLogs(){
  //   param = {
  //     Action : "Logs"
  //   };
  //   param = JSON.stringify(param);
  //   $.ajax({
  //     url: "/tatsystem/include/registration.inc.php",
  //     method: "POST",
  //     data: { data: param },
  //     success: function (data) {
  //       console.log(data);
  //       $("#table-logs").html(data);
  //     },
  //     error: function (error) {
  //       console.log(error);
  //     },
  //   })
  // }
  // LoadUserLogs();
});
