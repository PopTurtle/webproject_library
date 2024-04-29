import { addBookToCart, removeBookFromCart } from "./shoppingcart.js";

function manageButtonLoan(btn) {
  const bookId = btn.dataset.id;
  btn.addEventListener("click", function addClick () {
    btn.removeEventListener("click", addClick);
    if (addBookToCart(bookId)) {
      btn.innerHTML = "Ajouté avec succès!";
    } else {
      btn.innerHTML = "Une erreur s'est produite :(";
    }
  });
}

function manageButtonUnloan(btn) {
  const bookId = btn.dataset.id;
  btn.addEventListener("click", function removeClick() {
    btn.removeEventListener("click", removeClick);
    if (removeBookFromCart(bookId)) {
      btn.innerHTML = "Retiré avec succès !";
    } else {
      btn.innerHTML = "Une erreur s'est produite :(";
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const btnLoan = document.getElementById("btn-loan");
  if (btnLoan !== null) {
    manageButtonLoan(btnLoan);
  }

  const btnUnloan = document.getElementById("btn-unloan");
  if (btnUnloan !== null) {
    manageButtonUnloan(btnUnloan);
  }
});
