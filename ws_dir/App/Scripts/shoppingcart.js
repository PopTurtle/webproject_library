import { validateShoppingCart } from "./utils/shoppingcart.js"

document.addEventListener('DOMContentLoaded', () => {
  const validate = document.getElementById("validate-shopping-cart");
  validate.addEventListener("click", async () => {
    if (confirm("Valider l'emprunt du panier ?")) {
      console.log(await validateShoppingCart());
    }
  });
});
