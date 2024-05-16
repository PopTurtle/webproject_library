import { returnLoan } from "./utils/bookloan.js";
import { addStatusBefore, replaceElt } from "./utils/status.js";

document.addEventListener('DOMContentLoaded', () => {
  const btns = document.getElementsByClassName("return-book");
  for (const button of btns) {
    const bookId = button.dataset.bookId;
    let lastMsgElt = null
    button.addEventListener("click", async () => {
      if (confirm("Rendre le livre ?")) {
        if (await returnLoan(bookId)) {
          replaceElt(button, "Le livre a bien été rendu.");
        } else {
          if (lastMsgElt !== null) {
            lastMsgElt.remove();
          }
          lastMsgElt = addStatusBefore(button, "Une erreur s'est produite");
        }
      }
    });
  }
});
