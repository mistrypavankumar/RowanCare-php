$(document).ready(function () {
  let timestamp = new Date().getTime();
  let randomeNum = Math.floor(Math.random() * 1000);
  let orderId = `order_${timestamp}_${randomeNum}`;

  $("#orderId").attr("value", orderId);
});
