import { deleteBook } from "../utils/book.js"
import { replaceElt } from "../utils/status.js";

function manageDeleteButton(button, bookId) {
  button.addEventListener("click", async function delbtnClick () {
    if (!confirm("Supprimer le livre ?")) {
      return;
    }
    button.removeEventListener("click", delbtnClick);
    if (await deleteBook(bookId)) {
      replaceElt(button, "Le livre a bien été supprimé");
    } else {
      replaceElt(button, "Une erreur s'est produite lors de la suppression");
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const hasSearchResult = document.getElementsByClassName("result-container").length > 0;
  const deleteBtn = document.getElementById("del-btn");
  const bookId = deleteBtn.dataset.bookId;
  manageDeleteButton(deleteBtn, bookId);
});
