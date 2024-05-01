import { returnLoan } from "./utils/bookloan.js";
import { addStatusAfter, replaceElt } from "./utils/status.js";

document.addEventListener('DOMContentLoaded', () => {
  const btns = document.getElementsByClassName("return-book");
  for (const button of btns) {
    const bookId = button.dataset.bookId;
    button.addEventListener("click", async () => {
      if (confirm("Rendre le livre ?")) {
        if (await returnLoan(bookId)) {
          replaceElt(button, "Le livre a bien été rendu.");
        } else {
          addStatusAfter(button, "Une erreur s'est produite");
        }
      }
    });
  }
});
