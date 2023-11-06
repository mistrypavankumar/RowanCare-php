document.addEventListener("DOMContentLoaded", function () {
  const menuBar = document.getElementById("idMenuBar");
  const mobileNavbar = document.getElementById("mobileNavbar");

  const toggleDrawer = () => {
    if (mobileNavbar.classList.contains("active")) {
      mobileNavbar.classList.remove("active");
      console.log(mobileNavbar);
    } else {
      mobileNavbar.classList.add("active");
    }
  };

  menuBar.addEventListener("click", toggleDrawer);

  // on page scroll change the navbar background color from transparent to solid color
  const headerNavbar = document.getElementById("headerNavbar");
  window.onscroll = function () {
    if (window.scrollY > 0) {
      headerNavbar.style.backgroundColor = "#ffffff";
    } else {
      headerNavbar.style.backgroundColor = "transparent";
    }
  };
});
