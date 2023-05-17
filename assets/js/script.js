// menu burger responsive

const navbarMenu = document.querySelector(".navbar-menu");
const navbarToggle = document.querySelector(".navbar-toggle");

navbarToggle.addEventListener("click", function (e) {
  navbarMenu.classList.toggle("active");
});


// let searchInput = document.querySelector("#searchInput");
// let searchBtn = document.querySelector("#searchBtn");
// searchBtn.disabled = true;
// searchInput.addEventListener("input", stateHandle);
// function stateHandle() {
//   if (searchInput.value === "" || searchInput.value === " ") {
//     searchBtn.disabled = true;
//   } else {
//     searchBtn.disabled = false;
//   }
// }



