document.addEventListener("DOMContentLoaded", function () {
  const menuBar = document.getElementById("idMenuBar");
  const mobileNavbar = document.getElementById("mobileNavbar");

  menuBar.addEventListener("click", function () {
    if (mobileNavbar.classList.contains("active")) {
      mobileNavbar.classList.remove("active");
    } else {
      mobileNavbar.classList.add("active");
    }
  });
});
