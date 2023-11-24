document.addEventListener("DOMContentLoaded", (event) => {
  // start script for book-appointment.php

  const h1_current_date = document.getElementById("currentDate");
  const p_current_day = document.getElementById("currentDay");

  const days = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thusday",
    "Friday",
    "Saturday",
  ];
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  let today = new Date();
  console.log(today);
  let day = today.getDay();
  let date = today.getDate();
  let month = today.getMonth();
  let year = today.getFullYear();

  h1_current_date.innerHTML = `${date} ${months[month]}, ${year}`;
  p_current_day.innerHTML = `${days[day]}`;

  //=== end script for book-appointment.php
});
