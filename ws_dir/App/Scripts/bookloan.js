
async function addCartItem(bookId) {
  const param = new URLSearchParams();
  param.append("action", "add");
  param.append("book_id", bookId);

  const data = await fetch("/API/cartitem.php", {
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

async function removeCartItem(bookId) {
  const param = new URLSearchParams();
  param.append("action", "remove");
  param.append("book_id", bookId);

  const data = await fetch("/API/cartitem.php", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));

  console.log(data);
  return data;
}

function manageButtonLoan(btn) {
  const bookId = btn.dataset.id;
  btn.addEventListener("click", async function addClick () {
    btn.removeEventListener("click", addClick);
    const res = await addCartItem(bookId);
    if ("status" in res && res["status"] === "ok") {
      btn.innerHTML = "Ajouté avec succès!";
    } else {
      btn.innerHTML = "Une erreur s'est produite :(";
    }
  });
}

function manageButtonUnloan(btn) {
  const bookId = btn.dataset.id;
  btn.addEventListener("click", async function removeClick() {
    btn.removeEventListener("click", removeClick);
    const res = await removeCartItem(bookId);
    if ("status" in res && res["status"] === "ok") {
      btn.innerHTML = "Retiré avec succès !";
    } else {
      btn.innerHTML = "Une erreur s'est produite :(";
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const btnLoan = document.getElementById("btn-loan");
  if (btnLoan !== null) {
    manageButtonLoan(btnLoan);
  }

  const btnUnloan = document.getElementById("btn-unloan");
  if (btnUnloan !== null) {
    manageButtonUnloan(btnUnloan);
  }
});
