$(document).ready(function () {
  $("#btn-submit").click(function () {
    var input = $("#search").val();
    var id = document.getElementById("page-item-count");
    var userid = id.innerHTML;
    let searchFilter = $("#filterColumn").find(":selected").val();
    Load(searchFilter, input, userid);
  });

  //load data
  function Load(searchFilter, searchVal, pageVal) {
    param = {
      Action: "SearchTATSummary",
      pageVal: pageVal,
      searchVal: searchVal,
      searchFilter: searchFilter,
    };
    param = JSON.stringify(param);
    $.ajax({
      url: "/tatsystem/include/transaction.inc.php",
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

  Load("", "", 1);
  $(document).on("click", ".page-item", function () {
    let page = $(this).attr("id");
    var input = $("#search").val();
    let searchFilter = $("#filterColumn").find(":selected").val();
    //alert(page);
    if (searchFilter == "") {
      searchFilter = "";
    } else {
      searchFilter = searchFilter;
    }
    Load(searchFilter, input, page);
  });

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
    // let tableID = document.getElementById("table-TAT").innerHTML;
    // let fileName = "Turn Around Time";
    exportTableToExcel("table-TAT", "TAT Summary");
  });

  // // //test sound
  // // function playSound(test) {
  // //   const audio = new Audio(url);
  // //   audio.play();
  // // }

  // $("#test-btn-sound").click(function (e) {
  //   e.preventDefault();
  //   //alert("https://www.youtube.com/watch?v=kJvl7GjjkI0");
  //   // playSound("https://www.youtube.com/watch?v=kJvl7GjjkI0");
  //   document.getElementById("test-audio").play();
  // });
});
