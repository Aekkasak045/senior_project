const header = document.querySelector(".header"),
  searchIcon = document.querySelector("#searchIcon"),
  OpenBtn = document.querySelector(".OpenBtn"),
  CloseBtn = document.querySelector(".CloseBtn");

searchIcon.addEventListener("click", () => {
  header.classList.toggle("openSearch");
  header.classList.remove("openNav");
  if (header.classList.contains("openSearch")) {
    return searchIcon.classList.replace("fa-search", "fa-times");
  }
  searchIcon.classList.replace("fa-times", "fa-search");
});

OpenBtn.addEventListener("click", () => {
  header.classList.add("openNav");
  header.classList.remove("openSearch");
  searchIcon.classList.replace("fa-times", "fa-search");
});
CloseBtn.addEventListener("click", () => {
  header.classList.remove("openNav");
});

// $(function () {
//   $(".toggle").on("click", function () {
//     if ($(".item").hasClass("active")) {
//       $(".item").removeClass("active");
//       $(this).find("a").html("<i class='fa fa-bars'></i>");
//     } else {
//       $(".item").addClass("active");
//       $(this).find("a").html("<i class='fa fa-times'></i>");
//     }
//   });
// });
