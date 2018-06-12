import $ from "jquery";

toggleIgnoreInputs();
document.querySelectorAll("input[name=\"afleveradres\"]").forEach(x => {
    x.addEventListener("click", e => {

        if(e.target.value === "boven") {
            $("#bezorgadres-container").collapse("hide");
            toggleIgnoreInputs();
        } else {
            $("#bezorgadres-container").collapse("show");
            toggleIgnoreInputs();
        }
    });
});


function toggleIgnoreInputs() {
    document.querySelectorAll("#bezorgadres-container input, #bezorgadres-container textarea").forEach(x => {
        if(x.getAttribute("disabled")) {
            x.removeAttribute("disabled");
        } else {
            x.setAttribute("disabled", true);
        }
    });
}