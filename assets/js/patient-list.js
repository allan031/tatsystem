// $(document).ready(function () {
//   function LoadWithPagination(searchFilter, searchVal, pageVal) {
//     param = {
//       Action: "SearchPat",
//       pageVal: pageVal,
//       searchVal: searchVal,
//       searchFilter: searchFilter,
//     };
//     param = JSON.stringify(param);
//     $.ajax({
//       url: "/tatsystem/include/patient.inc.php",
//       method: "POST",
//       data: { data: param },
//       success: function (data) {
//         console.log(data);
//         $("#searchresult-patx-lists").html(data);
//       },
//       error: function (error) {
//         console.log(error);
//       },
//     });
//   }
//   LoadWithPagination("", "", 1);

//   $(document).on("click", ".page-item", function () {
//     let page = $(this).attr("id");
//     var input = $("#patx-search").val();
//     let searchFilter = $("#filterColumn").find(":selected").val();
//     //alert(page);
//     if (searchFilter == "") {
//       searchFilter = "";
//     } else {
//       searchFilter = searchFilter;
//     }
//     LoadWithPagination(searchFilter, input, page);
//   });

//   //btn search
//   $("#btn-submit-patx").click(function () {
//     var input = $("#patx-search").val();
//     var id = document.getElementById("page-item-count");
//     var userid = id.innerHTML;
//     let searchFilter = $("#filterColumn").find(":selected").val();
//     LoadWithPagination(searchFilter, input, userid);
//   });
// });
