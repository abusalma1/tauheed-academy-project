document.querySelectorAll(".dropdown-btn").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.stopPropagation(); // prevent bubbling

    const menu = btn.nextElementSibling;

    // Close other open dropdowns
    document.querySelectorAll(".dropdown-menu").forEach((m) => {
      if (m !== menu) m.classList.add("hidden");
    });

    // Toggle this one
    menu.classList.toggle("hidden");
  });
});

// Close dropdowns if clicking outside
document.addEventListener("click", () => {
  document
    .querySelectorAll(".dropdown-menu")
    .forEach((m) => m.classList.add("hidden"));
});

//  Mobile Menu Script
document.querySelectorAll(".mobile-dropdown-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    let dropdown = btn.nextElementSibling;
    dropdown.classList.toggle("hidden");
  });
});

const mobileMenuBtn = document.getElementById("mobile-menu-btn");
const mobileMenu = document.getElementById("mobile-menu");

mobileMenuBtn.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
});
