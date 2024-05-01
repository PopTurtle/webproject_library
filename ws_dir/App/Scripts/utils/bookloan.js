
export async function returnLoan(bookId) {
  const param = new URLSearchParams();
  param.append("action", "return");
  param.append("book_id", bookId);

  const data = await fetch("/API/bookloan.php", {
    method: 'POST',
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));
  
  return "status" in data && data["status"] === "ok";
}

export async function renewLoan(bookId) {
  return false;
}
