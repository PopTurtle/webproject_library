import { addBookToCart, removeBookFromCart } from "./shoppingcart.js";

let bookId;

let btnState;
let btnLoan;
let btnUnloan;

let btnStateDisplay;
let btnLoanDisplay;
let btnUnloanDisplay;

function hideBtnState() {
  btnState.style.display = "none";
}

function setBtnStateText(text) {
  btnState.innerHTML = text;
  btnState.style.display = btnStateDisplay;
}

function setButton(btn, requestAction, onSuccess, successStr, failStr) {
  btn.addEventListener("click", async function onClick() {
    btn.removeEventListener("click", onClick);
    if (await requestAction(bookId)) {
      setBtnStateText(successStr);
      btn.style.display = "none";
      onSuccess();
    } else {
      setBtnStateText(failStr);
    }
  });
}

function setButtonLoan() {
  btnLoan.style.display = btnLoanDisplay;
  setButton(
    btnLoan,
    addBookToCart,
    setButtonUnloan,
    "Ajouté avec succès !",
    "Une erreur s'est produite :("
  );
}

function setButtonUnloan() {
  btnUnloan.style.display = btnUnloanDisplay;
  setButton(
    btnUnloan,
    removeBookFromCart,
    setButtonLoan,
    "Retiré avec succès !",
    "Une erreur s'est produite :("
  );
}

/**
 *  Gère les boutons associés à l'emprunt dans la page d'un livre (Main)
 */
document.addEventListener('DOMContentLoaded', () => {
  const loanContainer = document.getElementById("loan-container");
  if (loanContainer === null) {
    return;
  }

  btnState = document.getElementById("btn-state");
  btnLoan = document.getElementById("btn-loan");
  btnUnloan = document.getElementById("btn-unloan")

  btnStateDisplay = btnState.style.display;
  btnLoanDisplay = btnLoan.style.display;
  btnUnloanDisplay = btnUnloan.style.display;

  hideBtnState();
  btnLoan.style.display = "none";
  btnUnloan.style.display = "none";

  bookId = loanContainer.dataset.bookId;

  const isLoan = loanContainer.dataset.isLoan;
  if (isLoan === "1") {
    setButtonLoan();
  } else {
    setButtonUnloan();
  }
});
