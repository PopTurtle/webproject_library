
export async function deleteBook(bookId) {
  const param = new URLSearchParams();
  param.append("action", "delete");
  param.append("book_id", bookId);

  const data = await fetch("/API/book.php", {
    method: 'POST',
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));
  
    console.log(data);
  return "status" in data && data["status"] === "ok";
}
