
async function bookLoan(bookId) {
  const param = new URLSearchParams();
  param.append("action", "add");
  param.append("book_id", bookId);

  fetch("/Api/cartitem.php", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: param
  })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(err => console.error(err));
}

document.addEventListener('DOMContentLoaded', () => {
  document
    .getElementById("loan-btn")
    .addEventListener("click", async () => {
      await bookLoan(22);
    });
});
