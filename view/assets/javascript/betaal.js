import $ from "jquery";

document.querySelectorAll("input[name=\"afleveradres\"]").forEach(x => {
    x.addEventListener("click", e => {

        if(e.target.value === "boven") {
            $("#bezorgadres-container").collapse("hide");
        } else {
            $("#bezorgadres-container").collapse("show");
        }
    });
});