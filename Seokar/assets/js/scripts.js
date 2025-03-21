document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const navMenu = document.querySelector(".nav-menu");

    menuToggle.addEventListener("click", function () {
        navMenu.classList.toggle("active");
        this.setAttribute("aria-expanded", navMenu.classList.contains("active"));
    });

    function toggleDarkMode() {
        const currentTheme = document.documentElement.dataset.theme;
        const newTheme = currentTheme === "dark" ? "light" : "dark";
        document.documentElement.dataset.theme = newTheme;
        localStorage.setItem("theme", newTheme);
    }
});
