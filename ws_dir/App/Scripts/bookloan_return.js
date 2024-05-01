import { returnLoan } from "./utils/bookloan.js";
import { replaceElt } from "./utils/status.js";

document.addEventListener('DOMContentLoaded', () => {
  const btns = document.getElementsByClassName("return-book");
  for (const button of btns) {
    const bookId = button.dataset.bookId;
    button.addEventListener("click", async () => {
      // if (confirm("Rendre le livre ?")) {
      //   console.log(await returnLoan(bookId));
      // }
      replaceElt(button, "MESSAGE DE REMPLACEMENT");
    });
  }
});
