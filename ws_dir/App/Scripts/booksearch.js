import { addBookToCart, removeBookFromCart } from "./utils/shoppingcart.js";

function manageContainer(container) {
  const loanBtn = container.getElementsByClassName("btn-loan")[0];  
  const unloanBtn = container.getElementsByClassName("btn-unloan")[0];

  if (loanBtn !== undefined && unloanBtn !== undefined) {
    const isInCart = container.dataset.isInCart == 1;
    const bookId = container.dataset.bookId;
    let hadError = false;
    const loanBtnDisplay = loanBtn.style.display;
    const unloanBtnDisplay = unloanBtn.style.display;

    (isInCart ? loanBtn : unloanBtn).style.display = "none";

    const action = (btn1, btn2, btn2Display, func) => {
      if (hadError) {
        return;
      }
      if (func(bookId)) {
        btn1.style.display = "none";
        btn2.style.display = btn2Display;
      } else {
        hadError = true;
        btn1.innerHTML = "Erreur !";
      }
    };

    loanBtn.addEventListener("click", () => action(loanBtn, unloanBtn, unloanBtnDisplay, addBookToCart));
    unloanBtn.addEventListener("click", () => action(unloanBtn, loanBtn, loanBtnDisplay, removeBookFromCart));
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const containers = document.getElementsByClassName("btn-container");
  for (let i = 0; i < containers.length; ++i) {
    manageContainer(containers[i]);
  }
});
