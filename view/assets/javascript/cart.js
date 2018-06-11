fetch("/betaal/cart")
  .then(res => res.text())
  .then(res => {
    document.getElementById('cart-col').innerHTML = res;
  });
