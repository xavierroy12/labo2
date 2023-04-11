console.log('Input value has changed!');
const idCells = document.querySelectorAll("td:first-child");
const quantiteInputs = document.querySelectorAll("input[type='number']");
const priceCells = document.querySelectorAll("td:nth-child(4)");
const totalCells = document.querySelectorAll("td:nth-child(5)");
let totall = 0;
console.log(quantiteInputs );
for (let i = 0; i < quantiteInputs.length; i++) {
    quantiteInputs[i].addEventListener("input", () => {

      const quantite = parseInt(quantiteInputs[i].value);
      const price = parseFloat(priceCells[i].textContent);
      const total = quantite * price;
      totalCells[i].textContent = total.toFixed(2);
      const totalRow = document.querySelector("tr:last-child td:last-child");
      totalRow.textContent = calculateTotal().toFixed(2);
    });
  }
  
  function calculateTotal() {
    const totalCells = document.querySelectorAll("td:nth-child(5)");
    let total = 0;
    for (let i = 0; i < totalCells.length; i++) {
      total += parseFloat(totalCells[i].textContent);
    }
    totall = total;
    return total;
  }




function orderToJson() {
   //for each quantity input, get the id and the value if the value is > 0
   // return it as a json object
    let order = {};
    let orderItems = [];
    let quantiteInputs = document.querySelectorAll("input[type='number']");
    for (let i = 0; i < quantiteInputs.length; i++) {
        if (quantiteInputs[i].value > 0) {
            let orderItem = {};
            orderItem.id = idCells[i].textContent;
            orderItem.quantity = quantiteInputs[i].value;
            orderItem.total = totall;
            orderItems.push(orderItem);
        }
    }
    order.orderItems = orderItems;
    return order;
    
}

function paypalAjax(sendUrl, sendBody) {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();

        xhr.open("post", sendUrl);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = () => resolve(JSON.parse(xhr.responseText));
        xhr.onerror = () => reject(xhr.statusText);
        xhr.send(JSON.stringify(sendBody));
    });
}

paypal.Buttons({
    createOrder: function() {
        return paypalAjax("./paypal", orderToJson()).then(
            function(promiseResponse) {
                console.log("Transaction #" + promiseResponse.id + " initiated");
                return promiseResponse.id;
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(transactionDetails) {
                console.log("Transaction completed by " + transactionDetails.payer.name.given_name);
            });
        }
    }).render("#paypal-button-container");
