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
				document.getElementById('alert-box').innerHTML =
				`<div class='alert alert-primary alert-dismissible fade show fixed-top' style='top: 3.3em' role='alert'>
				<strong>U heeft een product toegevoegd!</strong>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				</div>`
			}
		})
	return false;
};

if (document.getElementById('cart-col')) {

	document.querySelectorAll("a[href^=\"/cart\"]").forEach(x => {
		x.addEventListener("click", clickEvent(x.href));
	});

	document.querySelectorAll("form[action^=\"/cart\"]").forEach(x => {
		x.addEventListener("submit", clickEvent());
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