// function showTime() {
//   // to get current time/ date.
//   var date = new Date();
//   // to get the current hour
//   var h = date.getHours();
//   // to get the current minutes
//   var m = date.getMinutes();
//   //to get the current second
//   var s = date.getSeconds();
//   // AM, PM setting
//   var session = "AM";

//   //conditions for times behavior
//   if (h == 0) {
//     h = 12;
//   }
//   if (h >= 12) {
//     session = "PM";
//   }

//   if (h > 12) {
//     h = h - 12;
//   }
//   m = m < 10 ? (m = "0" + m) : m;
//   s = s < 10 ? (s = "0" + s) : s;

//   //putting time in one variable
//   let today = new Date()
//     .toLocaleDateString("default", {
//       month: "short",
//       day: "numeric",
//       year: "numeric",
//     })
//     .toUpperCase();
//   var time = h + ":" + m + ":" + s + " " + session;
//   //putting time in our div
//   $("#clock").html(today + " | " + time);
//   $("#clock1").html(today + " " + time);
//   //to change time in every seconds
//   setTimeout(showTime, 1000);
// }
// showTime();


let serverTimeOffset = 0;

function fetchServerTime() {
  fetch("servertime.php")
    .then(response => response.json())
    .then(data => {
      const serverTime = new Date(data.serverTime);
      const localTime = new Date();
      serverTimeOffset = serverTime - localTime; // Difference in ms
      showTime(); // Start the clock after sync
    });
}

function showTime() {
  const date = new Date(Date.now() + serverTimeOffset); // Adjusted time
  let h = date.getHours();
  let m = date.getMinutes();
  let s = date.getSeconds();
  let session = "AM";

  if (h == 0) {
    h = 12;
  } else if (h >= 12) {
    session = "PM";
    if (h > 12) h -= 12;
  }

  m = m < 10 ? "0" + m : m;
  s = s < 10 ? "0" + s : s;

  const today = date.toLocaleDateString("default", {
    month: "short",
    day: "numeric",
    year: "numeric",
  }).toUpperCase();

  const time = `${h}:${m}:${s} ${session}`;

  $("#clock").html(today + " | " + time);
  $("#clock1").html(today + " " + time);

  setTimeout(showTime, 1000);
}

fetchServerTime(); // Start here
