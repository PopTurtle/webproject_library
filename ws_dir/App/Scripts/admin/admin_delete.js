import { deleteBook } from "../utils/book.js"
import { deleteConsumer } from "../utils/consumer.js"
import { replaceElt } from "../utils/status.js";

function manageButton(button, action, actionArg, confirmMsg, successMsg) {
  button.addEventListener("click", async function delbtnClick() {
    if (!confirm(confirmMsg)) {
      return;
    }
    button.removeEventListener("click", delbtnClick);
    if (await action(actionArg)) {
      replaceElt(button, successMsg);
    } else {
      replaceElt(button, "Une erreur s'est produite lors de la suppression");
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const hasSearchResult = document.getElementsByClassName("result-container").length > 0;
  const deleteBtn = document.getElementById("del-btn");
  const bookId = deleteBtn.dataset.bookId;
  const consumerId = deleteBtn.dataset.consumerId;
  if (hasSearchResult && bookId !== undefined) {
    manageButton(deleteBtn, deleteBook, bookId, "Supprimer le livre ?", "Le livre a bien été supprimé");
  }
  if (hasSearchResult && consumerId !== undefined) {
    manageButton(deleteBtn, deleteConsumer, consumerId, "Supprimer l'utilisateur ?", "L'utilisateur a bien été supprimé");
  }
});
