
export async function deleteConsumer(consumerId) {
  const param = new URLSearchParams();
  param.append("action", "delete");
  param.append("consumer_id", consumerId);

  const data = await fetch("/API/consumer.php", {
    method: 'POST',
    body: param
  })
    .then(response => response.json())
    .catch(err => console.error(err));
  
  return "status" in data && data["status"] === "ok";
}
