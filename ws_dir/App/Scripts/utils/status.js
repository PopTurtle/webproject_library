
export function replaceElt(elt, statusMsg) {
  const msg = document.createElement("p");
  msg.innerHTML = statusMsg;
  elt.parentNode.insertBefore(msg, elt);
  elt.remove();
}
