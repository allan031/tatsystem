$(function () {
//Data Table 
 // $('#table-patient-history').DataTable();
 new DataTable('#patient-history-datatable',{ 
  scrollX: true,
  scrollY: '350px'
})
  
  function AddQR(patID, sex, ageGroup, createdBy, createdDate) {
    param = {
      Action: "InsertQR", 
      patID: patID,
      sex: sex,
      ageGroup: ageGroup,
      createdBy: createdBy,
      createdDate: createdDate,
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "/tatsystem/qrcode.php",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        //location.reload();
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  //for qr code generation
  function qrGen() {
    param = {
      Action: "Generate",
      patID: $("#patID").val(),
      sex: $("input[type='radio'].radioBtnClass:checked").val(),
      ageGroup: $("#ageGroup").find(":selected").val(),
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "/tatsystem/qrcode.php",
      dataType: "json",
      data: { data: param },
      success: function (data) {
        console.log("success: " + data);
        $("#qrcode-holder").attr("src", "../" + data.qrcode);
        $("#qrcode-label-holder").text(data.id);
        $("#qr-code-generation").toggleClass("hidden flex");
      },
      error: function (data) {
        console.log("error: " + data);
      },
    });
  }

  //call function AddQr & qrGen
  $("#generate-qr").click(function (e) {
    e.preventDefault();

    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    var time = today.getHours() + ":" + today.getMinutes();
    var dateTime = date + " " + time;

    let patID = $("#patID").val();
    let sex = $("input[type='radio'].radioBtnClass:checked").val();
    let ageGroup = $("#ageGroup").find(":selected").val();
    let uname = document.getElementById("username");
    let createdBy = uname.innerHTML;
    if (patID == "" || sex == "" || ageGroup == "") {
      Swal.fire("Please complete all fields!");
    } else {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to save this Patient!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Save!",
      }).then((result) => {
        if (result.isConfirmed) {
          AddQR(patID, sex, ageGroup, createdBy, dateTime);
          qrGen();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          //location.reload();
        }
      });
    }
  });


//remove trailing spaces in text area Remarks
function removeTextAreaWhiteSpace() {
  var myTxtArea = document.getElementById('txtremarks');
  myTxtArea.value = myTxtArea.value.replace(/^\s*|\s*$/g,'');
}
removeTextAreaWhiteSpace();



  $("#qr-code-btn").click(function (e) {
    e.preventDefault();
    $("#qr-code-generation").toggleClass("hidden flex ml-[300px]");
  });

 // $("#patient-history-datatable").DataTable();
});


$(document).ready(function () {
  $(".btn-close-qr").click(function (e) {
    e.preventDefault();
    $("#qr-code-generation").toggleClass("flex hidden");
    location.reload();
  });

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

  //close modal print
  $(document).on("click", ".btn-close-qr", function (e) {
    e.preventDefault();
    $("#qr-code-generation").toggleClass("hidden flex");
  });

  //DR order sub list
  // the selector will match all input controls of type :checkbox
  // and attach a click event handler
  $("input:checkbox").change(function () {
    //dept id of user
    var id = document.getElementById("dept-value");
    var deptID = id.innerHTML;
    // in the handler, 'this' refers to the box clicked on
    var $boxval = $(this).val();
    var $box = $(this);
    let row_item = document.getElementById("dro-sublist");
    let row_item2 = document.getElementById("droc-sublist");
    let row_item3 = document.getElementById("ready-sublist");
    $("#passVal-proc").html($(this).val());
    if ($box.is(":checked")) {
      // the name of the box is retrieved using the .attr() method
      // as it is assumed and expected to be immutable
      var group = "input:checkbox[name='" + $box.attr("name") + "']";
      // the checked state of the group/box on the other hand will change
      // and the current value is retrieved using .prop() method
      $(group).prop("checked", false);
      $box.prop("checked", true);
      if ($boxval == 9004) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#dro-sublist").append(data);
          },
        });
      } else if ($boxval == 9003) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#droc-sublist").append(data); 
          },
        });
      } else if ($boxval == 9006) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#ready-sublist").append(data);
          },
        });
      }else if ($boxval == 9002) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#dro-sublist").append(data);
          },
        });
      }else if ($boxval == 9008) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#dis-sublist").append(data);
          },
        });
      }else if ($boxval == 9009) {
        param = {
          Action: "GetSubProcedureType",
          subProcTypeID: $boxval,
          deptID: deptID,
        };
        param = JSON.stringify(param);
        $.ajax({
          url: "/tatsystem/include/qrcodeGen.inc.php",
          type: "POST",
          data: { data: param },
          success: function (data) {
            //console.log(data);
            $("#dro-sublist").append(data);
          },
        });
      }
    } else {
      $box.prop("checked", false);
      $(row_item).remove();
      $(row_item2).remove();
      $(row_item3).remove();
    }
  });

  ///start of qr-scan jquery
  var pervious;
  //const html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
  const html5QrCode = new Html5Qrcode("reader");
  const config = { fps: 10, qrbox: { width: 250, height: 250 } };

  function Scan() {
    // If you want to prefer back camera
    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);
  }

  //exceed time limit
  function GetExceedProcess(qr, procID, subProcID) {
    param = {
      Action: "GetExceedProcess",
      qr: qr,
      procID: procID,
      subProcID: subProcID,
    };
    param = JSON.stringify(param);
    var result;
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      async: false,
      success: function (data) {
        console.log(data);
        $("#exceedProcess").html(JSON.parse(data)[0]?.TransactionID_FK);
        result = JSON.parse(data)[0]?.Exceed;
      },
    });
    return result;
  }

  function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    //let result = `Scan result: ${decodedText}`;
    let result = decodedText;
    let patID = result;
    //datetime now
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
    //+ " " + session;

    //dept id of user
    var id = document.getElementById("dept-value");
    var deptID = id.innerHTML;

    //username of logged in user
    var uid = document.getElementById("username-value");
    var uname = uid.innerHTML;

    //procedure type ID
    var pid = document.getElementById("passVal-proc");
    var pname = pid.innerHTML;

    //trasact type radio btn
    //let tranxtype = $("input[type='radio'].radioBtnClass:checked").val();

    //tranxtiming
    let tranxtiming = $(
      "input[type='radio'].radioBtnClassTranxTiming:checked"
    ).val();

    let procType = $(
      "input[type='checkbox'].checkboxBtnClassProcedure:checked"
    ).val();

    //tranxtiming
    let subprocType = $(
      "input[type='radio'].radioBtnClassSubProcedure:checked"
    ).val()
      ? $("input[type='radio'].radioBtnClassSubProcedure:checked").val()
      : 0;
    let proc = $("#procedure").find(":selected").val();

    let remarks = $("#txtremarks").val() ? $("#txtremarks").val() : "";

    //store patien qr in hidden span
    $("#qr-value").html(result);
    html5QrCode
      .stop()
      .then((ignore) => {
        // QR Code scanning is stopped.
        //window.reload();
        $("#qr-scan-modal").toggleClass("hidden flex");

        if (tranxtiming == "End") {
          if (GetExceedProcess(patID, procType, subprocType) == "YES") {
            $("#remarks-modal").toggleClass("flex hidden");
          } else {
            $("#remarks-modal").toggleClass("flex hidden");
            // InsertQrTat(
            //   patID,
            //   deptID,
            //   procType,
            //   subprocType,
            //   proc,
            //   dateTime,
            //   tranxtiming,
            //   remarks,
            //   uname,
            //   dateTime,
            //   pname
            // );
          }
        } else {
          InsertQrTat(
            patID,
            deptID,
            procType,
            subprocType,
            proc,
            dateTime,
            tranxtiming,
            remarks,
            uname,
            dateTime,
            pname
          );
        }
      })
      .catch((err) => {
        // Stop failed, handle it.
        console.log(err);
      });
    document.getElementById("reader").remove();
  }

  function onScanError(errorMessage) {
    // handle on error condition, with error message
    console.log(`Scan result: ${decodedText}`, decodedResult);
  }

  function InsertQrTat(
    patID,
    deptID,
    procTypeID,
    subprocTypeID,
    procedure,
    scanDate,
    tranxTiming,
    remarks,
    createdBy,
    createdDate
  ) {
    param = {
      Action: "InsertQrTat", 
      patID: patID,
      deptD: deptID,
      procTypeID: procTypeID,
      subprocTypeID: subprocTypeID,
      procedure: procedure,
      scanDate: scanDate,
      tranxTiming: tranxTiming,
      remarks: remarks,
      createdBy: createdBy,
      createdDate: createdDate,
    };
    param = JSON.stringify(param);
    $.ajax({
      type: "POST",
      url: "/tatsystem/qrcode.php",
      data: { data: param },
      //dataType:"json",
      success: function (data) {
        console.log("success: " + data);
        if (JSON.parse(data)[0].errormsg != "") {
          Swal.fire({
            text: JSON.parse(data)[0].errormsg,
            confirmButtonColor: "#3085d6",
            width: 300,
            height: 200,
          }).then(function () {
            location.reload();
          }); 
        }
        if (JSON.parse(data)[0].successmsg != "") {
          Swal.fire({
            text: JSON.parse(data)[0].successmsg,
            confirmButtonColor: "#3085d6",
            width: 300,
            height: 200,
          }).then(function () {
            location.reload();
          });
        }
      },
      error: function (data) {
        //console.log("error: " + data);
      },
    });
  }

  //update exceed tat
  function UpdateExceedTAT(tranxID, updatedBy, updatedDate) {
    param = {
      Action: "UpdateExceedTAT",
      tranxID: tranxID,
      updatedBy: updatedBy,
      updatedDate: updatedDate,
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        console.log(data);
      },
    });
  }

  //insert qr upon entring remarks
  $("#btn-submit-remarks").click(function (e) {
    e.preventDefault();

    //datetime now
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
    //+ " " + session;

    //dept id of user
    let patNum = document.getElementById("qr-value");
    let patID = patNum.innerHTML;

    //dept id of user
    var id = document.getElementById("dept-value");
    var deptID = id.innerHTML;

    //username of logged in user
    var uid = document.getElementById("username-value");
    var uname = uid.innerHTML;

    //procedure type ID
    var pid = document.getElementById("passVal-proc");
    var pname = pid.innerHTML;

    //trasact type radio btn
    //let tranxtype = $("input[type='radio'].radioBtnClass:checked").val();

    //tranxtiming
    let tranxtiming = $(
      "input[type='radio'].radioBtnClassTranxTiming:checked"
    ).val();

    let procType = $(
      "input[type='checkbox'].checkboxBtnClassProcedure:checked"
    ).val();
    let proc = $("#procedure").find(":selected").val();
    //console.log(procType);

    //tranxtiming
    let subprocType = $(
      "input[type='radio'].radioBtnClassSubProcedure:checked"
    ).val()
      ? $("input[type='radio'].radioBtnClassSubProcedure:checked").val() 
      : 0;

    let remarks = $("#txtremarks").val() ? $("#txtremarks").val() : "";

    //exceed process tranx ID
    //procedure type ID
    var tID = document.getElementById("exceedProcess");
    var tID_Fk = tID.innerHTML;
    //console.log(tID_Fk);

    if (remarks.trim().length < 1) {
      Swal.fire("Enter remarks to proceed!");
    } else {
      InsertQrTat(
        patID,
        deptID,
        procType,
        subprocType,
        proc,
        dateTime,
        tranxtiming,
        remarks,
        uname,
        dateTime,
        pname
      );
      UpdateExceedTAT(tID_Fk, uname, dateTime);
    }
  });

  //to enable scan function
  $(document).ready(function () {
    //checkbox checklist item
    $('input[type="checkbox"][name=procedureType]').on("change", function () {
      var procTypeID = $(this).val();
      console.log(procTypeID);
      if (procTypeID) {
        if (
          procTypeID == 9001 ||
          // procTypeID == 9002 || remove 2024-03-21
          //procTypeID == 9003 || remove 2024-09-11 9:06AM to enable patx assessment
          procTypeID == 9007 ||
          procTypeID == 9009 ||
          procTypeID == 9010
        ) {
          $("input[type=radio][name=transactTiming]").change(function () {
            if($('input[type="checkbox"][name=procedureType]').is(':checked')) //2024_02_27 10:41AM restrict user to enable qr scan when unchecked procedure
            {
              $("#qr-scan-modal").toggleClass("hidden flex");
              Scan();
            }else{

            }
          });
        }
        if (procTypeID == 9004 || procTypeID == 9006 || procTypeID == 9002 || procTypeID == 9008 || procTypeID == 9003) { //add finalized SOA 2025_05_21 10:36AM
          $(document).on(
            "click",
            "input[type=radio][name=subprocedureType]",
            function () {
              $("input[type=radio][name=transactTiming]").change(function () {
                  if($('input[type="checkbox"][name=procedureType]').is(':checked'))
                  {
                    $("#qr-scan-modal").toggleClass("hidden flex");
                    Scan();
                  }else{

                  }
              });
            }
          );
        }
      }
    });
  });

  function dropdown(proctypeid) {
    // if (proctypeid == 7) {
      param = {
        Action: "GetProcedureImaging",
        procTypeID: proctypeid,
      };
      param = JSON.stringify(param);
      $.ajax({
        type: "POST",
        url: "/tatsystem/include/qrcodeGen.inc.php",
        dataType: "json",
        data: { data: param },
        success: function (data) {
          // console.log(data);
          $('select[name="procedure"]').empty();
          $.each(data, function (key, value) {
            $('select[name="procedure"]').append(
              '<option value="' + key + '">' + value + "</option>"
            );
          });
          $('select[name="procedure"]')
            .prepend("<option value=''>--Select Procedure--</option>")
            .val("");
        },
      });
    // }
    // if (proctypeid == 8) {
    //   param = {
    //     Action: "GetProcedure",
    //     subname: "Laboratory Exam",
    //   };
    //   param = JSON.stringify(param);
    //   $.ajax({
    //     type: "POST",
    //     url: "/tatsystem/include/qrcodeGen.inc.php",
    //     dataType: "json",
    //     data: { data: param },
    //     success: function (data) {
    //       $('select[name="procedure"]').empty();
    //       $.each(data, function (key, value) {
    //         $('select[name="procedure"]').append(
    //           '<option value="' +
    //             value["itemcode"] +
    //             '">' +
    //             value["item"] +
    //             "</option>"
    //         );
    //       });
    //       $('select[name="procedure"]')
    //         .prepend("<option value=''>--Select Procedure--</option>")
    //         .val("");
    //       //console.log(data);
    //     },
    //   });
    // }
  }

  //get dr order id and show select dropdown for procedure
  //checkbox checklist item
  $(document).on(
    "change",
    'input[type="radio"][name=subprocedureType]',
    function () {
      let procTypeID = $(this).val();
      //console.log(procTypeID);
      if (procTypeID > 6 && procTypeID <= 8) {
        if ($("#select-procedure").hasClass("flex")) {
          $("#select-procedure").toggleClass("flex");
        } else {
          $("#select-procedure").toggleClass("flex hidden");
        }
        dropdown(procTypeID);
      }
    }
  );

  //time diff
  function CalculateTimeDiff(start_time, timeNow) {
    var diff = Math.abs(new Date(timeNow) - new Date(start_time));
    var seconds = Math.floor(diff / 1000); //ignore any left over units smaller than a second
    var minutes = Math.floor(seconds / 60);
    seconds = seconds % 60;
    timeSec = seconds > 9 ? seconds : "0" + seconds;
    var hours = Math.floor(minutes / 60);
    minutes = minutes % 60;
    timeMin = minutes > 9 ? minutes : "0" + minutes;

    let timediff = hours + ":" + timeMin + ":" + timeSec;
    return timediff;
  }

  //time add
  function CalculateTimeAdd(start_time, timeNow) {
    var diff = Math.abs(new Date(timeNow) + new Date(start_time));
    var seconds = Math.floor(diff / 1000); //ignore any left over units smaller than a second
    var minutes = Math.floor(seconds / 60);
    seconds = seconds % 60;
    timeSec = seconds > 9 ? seconds : "0" + seconds;
    var hours = Math.floor(minutes / 60);
    minutes = minutes % 60;
    timeMin = minutes > 9 ? minutes : "0" + minutes;

    let timediff = hours + ":" + timeMin + ":" + timeSec;
    return timediff;
  }

  //set yes if exceed time
  function Exceed(tranxID, createdBy, createdDate) {
    param = {
      Action: "Exceed",
      tranxID: tranxID,
      createdBy: createdBy,
      createdDate: createdDate,
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        console.log(data);
      },
    });
  }

  //get all transaction start and run calculate time function
  function GetAllTranxStart(deptID,userID) {
    // to get current time/ date.
    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    // to get the current hour
    var h = today.getHours();
    // to get the current minutes
    var m = today.getMinutes();
    //to get the current second
    var s = today.getSeconds();

    // //conditions for times behavior
    // if (h == 0) {
    //   h = 12;
    // }
    // if (h >= 12) {
    //   session = "PM";
    // }

    // if (h > 12) {
    //   h = h - 12;
    // }
    m = m < 10 ? (m = "0" + m) : m;
    s = s < 10 ? (s = "0" + s) : s;
    var time = h + ":" + m + ":" + s;
    var dateTimeNow = date + " " + time;

    param = {
      Action: "GetAllTranxStart",
      deptID: deptID,
      userID:userID
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        console.log(data);
        $.each(JSON.parse(data), function (key, value) {
          switch (value["ProcedureType"]) {
            case "Triage":
              let tresTMin1 = "0:03:00";
              let tresTMin2 = "0:03:59";
              let tresTMax = "0:05:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >= tresTMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresTMin2
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] +  ": 2 minutes left to end " +
                      value["ProcedureType"]
                      : "Patient - " + value["Patient"]  + ": 2 minutes left to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (CalculateTimeDiff(value["Start"], dateTimeNow) > tresTMax) {
                  Toastify({
                    text:
                    value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + value["ProcedureType"] + " process has reach its maximum time limit!"
                    : "Patient - " + value["Patient"]  +": " +value["ProcedureType"] + " process has reach its maximum time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                }
              } else {
              }
              break;
            case "Clerk":
              let tresRMin1 = "0:08:00";
              let tresRMin2 = "0:08:59";
              let tresRMax = "0:10:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >= tresRMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresRMin2
                ) {
                  Toastify({
                    text:
                    value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " +"2 minutes to end " + value["ProcedureType"]
                    : "Patient - " + value["Patient"]  + ": " + "2 minutes to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (CalculateTimeDiff(value["Start"], dateTimeNow) > tresRMax) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + value["ProcedureType"] + " process has reach its maximum time limit!" 
                      : "Patient - " + value["Patient"]  + ": " + value["ProcedureType"] + " process has reach its maximum time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                }
              } else {
              }
              break;
            case "Doctors Order":
              let tresDOMin1 = "0:25:00";
              let tresDOMin2 = "0:25:59";
              let tresDOMax = "0:30:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >=
                    tresDOMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresDOMin2
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + "5 minutes to end " + value["ProcedureType"]
                      : "Patient - " + value["Patient"]  + ": " + "5 minutes to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) > tresDOMax
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + value["ProcedureType"] + " process has reach its maximum time limit!"
                      : "Patient - " + value["Patient"]  + ": " + value["ProcedureType"] + " process has reach its maximum time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                }
              } else {
              }
              break;
            case "Carry Out":
              let tresDOCOMin1 = "1:00:00";
              let tresDOCOMin2 = "1:00:59";
              let tresDOCOMax = "1:30:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >=
                    tresDOCOMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresDOCOMin2
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + "30 minutes to end " + value["ProcedureType"]
                      : "Patient - " + value["Patient"]  + ": " + "30 minutes to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) > tresDOCOMax
                ) {
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                  console.log(value["Start"]);
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + value["ProcedureType"] + "-" + value["SubProcedureType"] + " exceeds its time limit!":
                       "Patient - " + value["Patient"]  + ": " + value["ProcedureType"] + "-" + value["SubProcedureType"] + " exceeds its time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                }
              } else {
              }
              break;
            case "Ready To Transfer":
              let tresRTFMin1 = "0:45:00";
              let tresRTFMin2 = "0:45:59";
              let tresRTFMax = "1:00:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >=
                    tresRTFMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresRTFMin2
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " + "15 minutes to end " + value["ProcedureType"]
                      : "Patient - " + value["Patient"]  + ": " + "15 minutes to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) > tresRTFMax
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] +": " + value["ProcedureType"] + " process has reach its maximum time limit!"
                      : "Patient - " + value["Patient"]  + ": " + value["ProcedureType"] + " process has reach its maximum time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                }
              } else {
              }
              break;
            case "Transfer To Room":
              let tresTTRMin1 = "0:10:00";
              let tresTTRMin2 = "0:10:59";
              let tresTTRMax = "0:15:00";
              if (value["End"] == null) {
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) >=
                    tresTTRMin1 &&
                  CalculateTimeDiff(value["Start"], dateTimeNow) <= tresTTRMin2
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] +": " +"5 minutes to end " +value["ProcedureType"]
                      : "Patient - " + value["Patient"]  +": " +"5 minutes to end " + value["ProcedureType"],
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastWarning",
                    style: {
                      background: "rgb(254, 249, 195)",
                      color: "rgb(161 98 7)",
                    },
                  }).showToast();
                }
                if (
                  CalculateTimeDiff(value["Start"], dateTimeNow) > tresTTRMax
                ) {
                  Toastify({
                    text:
                      value["Patient"] == null ? "Patient - " + value["PatientNumber"] +": " +value["ProcedureType"] +" process has reach its maximum time limit!"
                      : "Patient - " + value["Patient"]  +": " + value["ProcedureType"] + " process has reach its maximum time limit!",
                    position: "left",
                    duration: 3000,
                    close: true,
                    offset: {
                      x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                    className: "toastDanger",
                    style: {
                      background: "rgb(254 226 226)",
                      color: "rgb(239 68 68)",
                    },
                  }).showToast();
                  Exceed(
                    value["TransactionID"],
                    value["CreatedBy"],
                    dateTimeNow
                  );
                }
              } else {
              }
              break;
              case "Disposition":
                let tresDisMin1 = "0:10:00";
                let tresDisMin2 = "0:10:59";
                let tresDisMax = "0:15:00";
                if (value["End"] == null) {
                  if (
                    CalculateTimeDiff(value["Start"], dateTimeNow) >=
                    tresDisMin1 &&
                    CalculateTimeDiff(value["Start"], dateTimeNow) <= tresDisMin2
                  ) {
                    Toastify({
                      text:
                        value["Patient"] == null ? "Patient - " + value["PatientNumber"] + ": " +"5 minutes to end " + value["ProcedureType"]
                        : "Patient - " + value["Patient"]  + ": " + "5 minutes to end " + value["ProcedureType"],
                      position: "left",
                      duration: 3000,
                      close: true,
                      offset: {
                        x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                      },
                      className: "toastWarning",
                      style: {
                        background: "rgb(254, 249, 195)",
                        color: "rgb(161 98 7)",
                      },
                    }).showToast();
                  }
                  if (
                    CalculateTimeDiff(value["Start"], dateTimeNow) > tresDisMax
                  ) {
                    Toastify({
                      text:
                        value["Patient"] == null ? "Patient - " + value["PatientNumber"] +": " +value["ProcedureType"] +" process has reach its maximum time limit!"
                        : "Patient - " + value["Patient"]  +": " +value["ProcedureType"] +" process has reach its maximum time limit!",
                      position: "left",
                      duration: 3000,
                      close: true,
                      offset: {
                        x: 10, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 150, // vertical axis - can be a number or a string indicating unity. eg: '2em'
                      },
                      className: "toastDanger",
                      style: {
                        background: "rgb(254 226 226)",
                        color: "rgb(239 68 68)",
                      },
                    }).showToast();
                    Exceed(
                      value["TransactionID"],
                      value["CreatedBy"],
                      dateTimeNow
                    );
                  }
                } else {
                }
                break;
            default:
              break;
          }
        });
      },
    });
    setTimeout(GetAllTranxStart, 5000);
  }




  
  // let uname = document.getElementById("username-value");
  // let fullname = uname.innerHTML;
  let deptID = document.getElementById("dept-value");
  let dept = deptID.innerHTML;
  let userID = document.getElementById("username-value");
  let user = userID.innerHTML;
 GetAllTranxStart(dept,user);

  CountNotifs(dept,user);

  function CountNotifs(deptID,userID) {
    param = {
      Action: "CountNotifs",
      deptID: deptID,
      userID:userID
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        //console.log(data);
        $("#notif").html(JSON.parse(data)[0]?.CountNotifs);
      },
    });
    //setTimeout(CountNotifs, 1000);
  }

  //notification
  $("#btn-notif").click(function (e) {
    e.preventDefault();
    // let deptID = document.getElementById("dept-value");
    // let dept = deptID.innerHTML;
    $("#notif-modal").toggleClass("flex hidden");

    //call function get notif
    GetNotifications(dept,user);
  });

  $("#btn-close-notif").click(function (e) {
    e.preventDefault();
    $("#notif-modal").toggleClass("hidden flex"); 
    location.reload();
  });

  $(document).on("click", ".btn-auto-end", function (e) {
    e.preventDefault();

    //datetime now
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

    //qr number id of user
    let patNum = document.getElementById("qrCode");
    let patID = patNum.innerHTML;

    //patients name
    let patientName = document.getElementById("patientName");
    let patName = patientName.innerHTML;

    //dept id of user
    var id = document.getElementById("dept-value");
    var deptID = id.innerHTML;

    //username of logged in user
    var uid = document.getElementById("username-value");
    var uname = uid.innerHTML;

    //proceduretypeid
    var pid = document.getElementById("procType2");
    var prID = pid.innerHTML;

    //proceduretypename
    var prname = document.getElementById("procTypeName2");
    var prName = prname.innerHTML;

    //subproctypeid
    var sid = document.getElementById("subprocType2");
    var subprID = sid.innerHTML;


    //procedure
    var prid = document.getElementById("proc2");
    var procID = prid.innerHTML;

    //transactionID
    var trID = document.getElementById("transac2");
    var tranxID = trID.innerHTML;

    let remarks = dateTime + " - End of exceeded TAT: Patient " + patName + " - " + prName;

    Swal.fire({
      title: "Are you sure?",
      text: "You want to End this Procedure",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Save!",
    }).then((result) => {
      if (result.isConfirmed) {
        console.log(remarks);
        InsertQrTat(patID,deptID,prID,subprID,procID,dateTime,"End",remarks,uname,dateTime);
        UpdateExceedTAT(tranxID,uname,dateTime);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        //location.reload();
      }
    });
    //$("#notif-modal").toggleClass("hidden flex");
  });

  //get notifs
  function GetNotifications(deptID,UserID) {
    param = {
      Action: "GetNotifications",
      deptID: deptID,
      UserID:UserID
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        // console.log("succes: " + data);
        $.each(JSON.parse(data), function (key, value) {
          $("#notif-body").append(
            `
            <span class="hidden" id="qrCode">`+value["QRCode"]+`</span>
            <span class="hidden" id="patientName">`+value["Patient"]+`</span>
            <span class="hidden" id="procType2">`+value["ProcedureTypeID"] +`</span>
            <span class="hidden" id="procTypeName2">`+value["ProcedureType"] +`</span>
            <span class="hidden" id="subprocType2">`+value["SubProcedureTypeID"] +`</span>
            <span class="hidden" id="proc2">`+value["Procedure"] +`</span>
            <span class="hidden" id="transac2">`+value["TransactionID"] +`</span>
            <div class="bg-slate-100 border border-slate-200 rounded shadow-xl mt-2 mx-3 h-20">
              <span id="notif-time" class="xs:text-[10px] sm:text-[10px] md:text-[15px] font-bold">` +
              value["CreatedDate"] +
              `</span>
                <br>
                <span class="text-center xs:text-[10px] sm:text-[10px] md:text-[10px] text-black">` +
              "Patient " +
              value["Patient"] +
              " - " +
              value["ProcedureType"] +
              " has reach its maximum  time limit" +
              `</span>
              <br>
              <button type="button" id="btn-auto-end" class="btn-auto-end ml-3 w-10 h-5 my-3 border border-black rounded-md bg-blue-500 text-white">End</button>
            </div>
          `
          );
        });
      },
      error: function (data) {
        console.log("Error: " + data);
      },
    });
    //setTimeout(GetNotifications, 1000);
  }

});
