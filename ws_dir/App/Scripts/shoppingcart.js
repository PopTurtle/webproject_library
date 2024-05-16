import { validateShoppingCart } from "./utils/shoppingcart.js"
import { replaceElt } from "./utils/status.js";

document.addEventListener('DOMContentLoaded', () => {
  const validate = document.getElementById("validate-shopping-cart");
  if (validate === null) {
    return;
  }
  validate.addEventListener("click", async function onClick() {
    if (!confirm("Valider l'emprunt du panier ?")) {
      return;
    }
    validate.removeEventListener("click", onClick)
    if (await validateShoppingCart()) {
      replaceElt(validate, "L'emprunt a été validé avec succès !");
    } else {
      replaceElt(validate, "Une erreur est survenue.");
    }
  });
});
