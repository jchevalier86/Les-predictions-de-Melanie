function toggleMenu() {
  const navbar = document.querySelector(".navbar");
  navbar.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.getElementById("bropbtn");

  menuItems.forEach(function (menuItem) {
    menuItem.addEventListener("click", function () {
      const dropbtn = this.getElementById("dropbtn");
      if (dropbtn.style.display === "block") {
        dropbtn.style.display = "none";
      } else {
        dropbtn.style.display = "block";
      }
    });
  });
});
