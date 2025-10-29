$(function () {
//DataTable
$("#patient-dataTable").DataTable();
$("#table-patient").DataTable();

  $(document).ready(function () {
    $(".btn-print-patx").click(function (e) {
      e.preventDefault();
      //print
      var printContents = document.getElementById("print-table-div").innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
      location.reload();
    });
  });

  //all data display
  function DisplayPatientListAll() {
    param = {
      Action: "DisplayPatientListAll",
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/patient.inc.php",
      type: "POST",
      data: { data: param },
      success: function (data) {
        //console.log(data);
        $("#result-table-pat").html(data);
      },
    });
  }
  DisplayPatientListAll();

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


  //export function of report
  $("#btn-export-tat").click(function (e) {
    e.preventDefault();
    $("#export-modal").toggleClass("flex hidden");
  });
  
    $("#btn-cancel-export").click(function (e){
      e.preventDefault();
      $("#export-modal").toggleClass("hidden flex");
    });


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
});
