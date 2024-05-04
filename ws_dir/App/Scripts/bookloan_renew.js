import { renewLoan } from "./utils/bookloan.js";
import { addStatusBefore, replaceElt } from "./utils/status.js";

error("NOT WORKING ! TO FIX");

document.addEventListener('DOMContentLoaded', () => {
  const containers = document.getElementsByClassName("book-container");

  for (const container of containers) {
    const button = container.getElementsByClassName("renew-book")[0];
    const dateEndObject = container.getElementsByClassName("loan-end-date")[0];
    let lastMsgElt = null;
    button.addEventListener("click", async () => {
      const bookId = button.dataset.bookId;
      if (confirm("Renouveler l'emprunt ?")) {
        if (await renewLoan(bookId)) {
          replaceElt(button, "L'emprunt a bien été renouvelé.");
          if (dateEndObject !== undefined) {
            dateEndObject.classList.add("renewed");
          }
          if (dateEndText !== null) {
            dateEndText.innerHTML = "Nouvelle date ?";
          }
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
