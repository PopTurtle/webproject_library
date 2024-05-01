
function msgElement(msg) {
  let elt = document.createElement("p");
  elt.innerHTML = msg;
  return elt;
}

function insertBefore(newElt, oldElt) {
  oldElt.parentNode.insertBefore(newElt, oldElt);
}

export function replaceElt(elt, statusMsg) {
  const msg = msgElement(statusMsg);
  insertBefore(msg, elt);
  elt.remove();
  return msg;
}

export function addStatusBefore(elt, statusMsg) {
  const msg = msgElement(statusMsg);
  insertBefore(msg, elt)
  return msg;
}
