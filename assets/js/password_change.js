$(function () {
  let ispasswordchange = $("#ispasswordchange-hidden").text();

  if (ispasswordchange === "0") {
    $("#password-change-modal").toggleClass("hidden flex");
  } else {
    $("#password-change-modal").toggleClass("flex");
  }
});
