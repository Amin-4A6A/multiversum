document.querySelectorAll(".remove-image-button").forEach(x => {

    x.addEventListener("click", e => {

        e.preventDefault();

        fetch(x.href, { credentials: "same-origin" })
            .then(res => {
                if(res.status == 200) {
                    x.parentElement.parentElement.remove();
                }
            })

        return false;
    });

});

if(document.querySelector("#customFile")) {
    document.querySelector("#customFile").addEventListener("change", e => {
        if(e.target.files.length == 1) {
            e.target.labels[0].innerHTML = e.target.files[0].name;
        } else {
            e.target.labels[0].innerHTML = "U heeft " + e.target.files.length + " bestanden geupload";
        }
    });
}