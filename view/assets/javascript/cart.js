if(document.getElementById('cart-col')) {
  fetch("/betaal/cart",{credentials: "same-origin"})
    .then(res => res.text())
    .then(res => {
      document.getElementById('cart-col').innerHTML = res;
    });
}
