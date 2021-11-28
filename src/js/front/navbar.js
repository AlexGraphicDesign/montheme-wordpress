export function toggleMenu() {
    const button = document.querySelector(".header-burger");
    const navbar = document.querySelector(".header-nav");
    const body = document.querySelector(".body");

    button.addEventListener("click", () => {
        navbar.classList.toggle('open');
        body.classList.toggle('overflow-y-hidden');
    });
}