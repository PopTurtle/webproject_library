
/**
 *  Tente d'ajouter un livre au panier de l'utilisateur
 *    actuellement connecté.
 *  @param {Number} bookId id du livre
 *  @returns {Boolean}
 */
export async function addBookToCart(bookId) {
  const param = new URLSearchParams();
  param.append("action", "add");
  param.append("book_id", bookId);

  const data = await fetch("/API/cartitem.php", {
    method: 'POST',
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));
  
    return "status" in data && data["status"] === "ok";
}

/**
 *  Tente de retirer le livre du panier de l'utilisateur
 *    actuellement connecté.
 *  @param {Number} bookId id du livre
 *  @returns {Boolean}
 */
export async function removeBookFromCart(bookId) {
  const param = new URLSearchParams();
  param.append("action", "remove");
  param.append("book_id", bookId);

  const data = await fetch("/API/cartitem.php", {
    method: 'POST',
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));

  return "status" in data && data["status"] === "ok";
}
