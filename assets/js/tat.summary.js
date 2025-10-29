$(document).ready(function () {
 // $("#table-TAT").DataTable();
 new DataTable('#table-TAT',{
    scrollX: true,
    scrollY: '350px'
 })

  
  // //load data
  function Load() {
    param = {
      Action: "SearchTATSummary",
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "../include/transaction.inc.php",
      method: "POST",
      data: { data: param },
      success: function (data) {
        //console.log(data);
        $("#searchresult").html(data);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }

  Load();

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

  $("#btn-export-tat").click(function (e) {
    e.preventDefault();
    alert("This function has an on-going development. Sorry for the inconvenience.!");
    //$("#export-modal").toggleClass("flex hidden");
    // // let tableID = document.getElementById("table-TAT").innerHTML;
    // // let fileName = "Turn Around Time";
    // exportTableToExcel("table-TAT", "TAT Summary");
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

});
