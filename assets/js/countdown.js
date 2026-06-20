// Set the date and time for the countdown (format: year, month [0-11], day, hour, minute, second)
var countdownDate = new Date("Feb 24, 2023 23:59:00").getTime();

// Update the countdown every second
var countdownInterval = setInterval(function() {

  // Get the current date and time
  var now = new Date().getTime();

  // Calculate the time remaining until the countdown date
  var timeRemaining = countdownDate - now;

  // Calculate days, hours, minutes, and seconds remaining
  var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
  var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

  // Display the countdown in the HTML element with id="countdown"
  document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

  // If the countdown is over, display a message
  if (timeRemaining < 0) {
    clearInterval(countdownInterval);
    document.getElementById("countdown").innerHTML = "EXPIRED";
  }
}, 1000);