$(function () {
  //patient get details from db using patID
  function GetPatxDetails(id) {
    param = {
      Action: "GetPatient", 
      id: id,
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "../include/patient.inc.php",
      method: "POST",
      data: { data: param },
      success: function (data) {
        console.log(data);
        $("#patientID_FK").val(JSON.parse(data)[0].BizBoxID);
        $("#lname").val(JSON.parse(data)[0].PatLastName);
        $("#fname").val(JSON.parse(data)[0].PatFirstName);
        $("#mname").val(JSON.parse(data)[0].PatMiddleName);
        $("#bDate").val(JSON.parse(data)[0].PatBirthDate);
        $("#patx-sex").val(JSON.parse(data)[0].PatientSex);
        $("#age-group").val(JSON.parse(data)[0].PatientAgeGroup);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
  //open edit modal
  $(document).on("click", ".btn-edit-patx", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-userid");
    $("#passval").html(id);
    GetPatxDetails(id);
    $("#edit-patient-modal").toggleClass("flex hidden");
  });

  //open function print
  $(document).on("click", ".btn-print-qr", function (e) {
    e.preventDefault();
    let id = $(this).attr("data-userid");
    $("#qr-code-generation").toggleClass("flex hidden");
    qrGen(id);
  });

  //close modal print
  $(document).on("click", ".btn-close-qr", function (e) {
    e.preventDefault();
    $("#qr-code-generation").toggleClass("hidden flex");
  });

  //edit modal btn-s

  //close edit modal
  $(".btn-close-edit").click(function (e) {
    e.preventDefault();
    $("#edit-patient-modal").hide();
    location.reload();
  });

  //save btn
  $("#btn-edit-save").click(function (e) {
    e.preventDefault();
    var fname = $("#fname").val();
    var mname = $("#mname").val();
    var lname = $("#lname").val();
    var bDay = $("#bDate").val();
    var patID_FK = $("#patientID_FK").val();

    //get div passval value
    var id = document.getElementById("passval");
    var userid = id.innerHTML;

    //get logged in user
    var name = document.getElementById("uname");
    var uname = name.innerHTML;

    //date time now
    //date time
    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    var time = today.getHours() + ":" + today.getMinutes();
    var dateTime = date + " " + time;

    if (fname == "" || lname == "" || bDay == "" || patID_FK == "") {
      Swal.fire("Please complete all fields!");
    } else {
      EditPatientDetails(
        userid,
        fname,
        mname,
        lname,
        bDay,
        patID_FK,
        uname,
        dateTime
      );
    }
  });

$("#patient-dataTable").DataTable();



  //edit patient details
  function EditPatientDetails(
    id,
    fname,
    mname,
    lname,
    bDay,
    patID_FK,
    updateBy,
    updateDate
  ) {
    param = {
      Action: "EditPatxDetails",
      id: id,
      fname: fname,
      mname: mname,
      lname: lname,
      bDay: bDay,
      patID_FK,
      updateBy: updateBy,
      updateDate: updateDate,
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/patient.inc.php",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        Swal.fire({
          title: "Are you sure?",
          text: "You want to save this info",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, save it!",
        }).then((result) => {
          if (result.isConfirmed) {
            //Swal.fire("Save!", "Patient details was updated.", "success");
            location.reload();
          } else if (result.dismiss === Swal.DismissReason.cancel) {
          }
        });
        //location.reload();
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  //for qr code generation
  function qrGen(patID) {
    param = {
      Action: "Generate",
      patID: patID,
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "../include/patient.inc.php",
      dataType: "json",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        $("#qrcode-holder").attr("src", "./" + data.qrcode);
        $("#qrcode-label-holder").text(data.id);
        // $("#qr-code-generation").toggleClass("flex hidden ml-[300px]");
        $("#qr-code-generation").show();
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  // $(document).ready(function () {
  //   $(".btn-print").click(function (e) {
  //     e.preventDefault();
  //     //print
  //     var printContents = document.getElementById("print-container").innerHTML;
  //     var originalContents = document.body.innerHTML;

  //     document.body.innerHTML = printContents;

  //     window.print();

  //     document.body.innerHTML = originalContents;
  //     //location.reload();
  //   });
  // });

  $(".btn-print").click(function (e) {
    e.preventDefault();
    //print
    var printContents = document.getElementById("print-container").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
  });











});
