$(document).ready(function () {
  //Data Table 
 // $('#table-patient-history').DataTable();
 new DataTable('#table-patient-history',{
  scrollX: false,
  scrollY: '350px'
})

  function LoadAllData() {
    param = {
      Action: "LoadAllData", 
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "../include/transaction.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        $("#result-table").html(data);
        //console.log(data);
      },
    });
  }
  LoadAllData();
  //export to excel function
  function exportTableToExcel(tableID, filename = "") {
    let downloadLink;
    let dataType = "application/vnd.ms-excel";
    let tableSelect = document.getElementById(tableID);
    let tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");

    //format date
    var today = new Date();
    var date =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate();
    var time =
      today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var formatted = date;

    // Specify file name
    filename = filename
      ? filename + "-" + formatted + ".xls"
      : "excel_data.xls";
    // Create download link element
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if (navigator.msSaveOrOpenBlob) {
      let blob = new Blob(["\ufeff", tableHTML], {
        type: dataType,
      });
      navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      // Create a link to the file
      downloadLink.href = "data:" + dataType + ", " + tableHTML;
      // Setting the file name
      downloadLink.download = filename;
      //triggering the function
      downloadLink.click();
    }
  }

  //show notification

  $("#btn-notif").click(function (e) {
    e.preventDefault();
    $("#notif-modal").toggleClass("flex hidden");
  });

  $("#btn-close-notif").click(function (e) {
    e.preventDefault();
    location.reload();
  });


  // modal for export

  $("#btn-export-tat").click(function (e) {
    e.preventDefault();
    $("#export-modal").toggleClass("flex hidden");
    //exportTableToExcel("patient-all-data", "Patient History");
  });

  $("#btn-cancel-export").click(function (e){
    e.preventDefault();
    $("#export-modal").toggleClass("hidden flex");
  });


  //submit date
  $("#btn-submit-date").click(function (e){
    e.preventDefault();

    let from = $("#date_from").val();
    let to = $("#date_to").val();
    let reportname = $("#rpttitle").text();
    let com = $(this).data("com");
    let report = $(this).data("report");
    let url = "/tatsystem/reportgenerator.php?from=" + from + "&to=" + to + "&reportname=" + reportname + "&com=" + com + "&report" + report;
    window.open(url, "__blank");
  });


  //get notifs
  function GetNotifications(deptID) {
    param = {
      Action: "GetNotifications",
      deptID: deptID,
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
              <div class="bg-slate-100 border border-slate-200 rounded shadow-xl mt-2 mx-3 h-32">
                <span id="notif-time" class="text-[16px] font-bold">` +
              value["CreatedDate"] +
              `</span>
                  <br>
                  <span class="text-center text-[16px] text-black">` +
              "Patient " +
              value["QRCode"] +
              " - " +
              value["ProcedureType"] +
              " has reach its maximum  time limit" +
              `</span>
              </div>
            `
          );
        });
      },
      error: function (data) {
        console.log("Error: " + data);
      },
    });
  }

  function CountNotifs(deptID) {
    param = {
      Action: "CountNotifs",
      deptID: deptID,
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/qrcodeGen.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        //console.log(data);
        $("#notif-count").html(JSON.parse(data)[0]?.CountNotifs);
      },
    });
    setTimeout(CountNotifs, 1000);
  }

  let deptID = document.getElementById("dept-value");
  let dept = deptID.innerHTML;

  //GetNotifications(dept);
  //CountNotifs(dept);
});
