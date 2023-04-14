// menu burger responsive

const navbarMenu = document.querySelector(".navbar-menu");
const navbarToggle = document.querySelector(".navbar-toggle");

navbarToggle.addEventListener("click", function (e) {
    navbarMenu.classList.toggle("active");
});
