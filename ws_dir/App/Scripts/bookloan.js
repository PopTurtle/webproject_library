
async function addCartItem(bookId) {
  const param = new URLSearchParams();
  param.append("action", "add");
  param.append("book_id", bookId);

  const data = await fetch("/Api/cartitem.php", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));

  return data;
}

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById("loan-btn");
  const bookId = btn.dataset.id;

  btn.addEventListener("click", async () => {
    await addCartItem(bookId);
  });
});
