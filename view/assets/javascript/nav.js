const navItems = document.querySelectorAll("#main-menu .nav-link");
navItems.forEach(x => {
    if(window.location.pathname.includes(x.pathname)) {
        navItems.forEach(x => x.parentElement.classList.remove("active"))
        x.parentElement.classList.add("active");
    }
});