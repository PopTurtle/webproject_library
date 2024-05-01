import { renewLoan } from "./utils/bookloan.js";
import { addStatusBefore, replaceElt } from "./utils/status.js";

document.addEventListener('DOMContentLoaded', () => {
  const btns = document.getElementsByClassName("renew-book");
  let dateEndObjects = document.getElementsByClassName("renew-date-end");
  const dateEndText = dateEndObjects.length > 0 ? dateEndObjects[0] : null;

  let lastMsgElt = null;
  for (const button of btns) {
    const bookId = button.dataset.bookId;
    button.addEventListener("click", async () => {
      if (confirm("Renouveler l'emprunt ?")) {
        if (await renewLoan(bookId)) {
          replaceElt(button, "L'emprunt a bien été renouvelé.");
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
