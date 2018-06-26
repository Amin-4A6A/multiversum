import $ from "jquery";

const clickEvent = url => e => {
	e.preventDefault();

	if(!url && e.target.action) {

		let urlArray = [];
		for(let i = 0; i < e.target.length; i++) {
			urlArray.push(`${e.target[i].name}=${e.target[i].value}`)
		}

		url = e.target.action + "?" + urlArray.join("&");

	}

	fetch(url, { credentials: "same-origin" })
		.then(res => {
			if(res.status == 200) {
				updateCart();
			}
		})
	return false;
};

const showAlert = e => {
	$("#alert-box").addClass("show");
	setTimeout(() => {
		$("#alert-box").removeClass("show");
	}, 4000);
};

if (document.getElementById('cart-col')) {

	document.querySelectorAll("a[href^=\"/cart\"]").forEach(x => {
		x.addEventListener("click", clickEvent(x.href));
		x.addEventListener("click", showAlert);
	});

	document.querySelectorAll("form[action^=\"/cart\"]").forEach(x => {
		x.addEventListener("submit", clickEvent());
		x.addEventListener("submit", showAlert);
	});

	updateCart();
}

function updateCart() {
	fetch("/cart/cart", { credentials: "same-origin" })
		.then(res => res.text())
		.then(res => {
			document.getElementById('cart-col').innerHTML = res;
			
			addBindings();
		});
}

function addBindings() {

	document.querySelectorAll("#cart-col a[href^=\"/cart\"]").forEach(x => {
		x.addEventListener("click", clickEvent(x.href));
	});

	document.querySelectorAll("#cart-col form[action^=\"/cart\"]").forEach(x => {
		x.addEventListener("submit", clickEvent());
	});

}