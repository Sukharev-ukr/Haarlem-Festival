document.addEventListener("DOMContentLoaded", () => {
  fetch("/api/cart")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        renderCartItems(data.data);
      }
    });

  function renderCartItems(items) {
    const container = document.getElementById("cart-items");
    let total = 0;
    items.forEach((item) => {
      total += parseFloat(item.itemPrice);
      const itemElement = `
                <div class="cart-item shadow rounded mb-3 p-2 text-white">
                    <div>${
                      item.danceEvent || item.restaurantName || "History Tour"
                    }</div>
                    <div>€${item.itemPrice}</div>
                    <button class="btn btn-danger remove-btn" data-id="${
                      item.orderItemID
                    }">Remove</button>
                </div>`;
      container.innerHTML += itemElement;
    });
    document.getElementById("total-price").innerText = `€${total.toFixed(2)}`;
  }

  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("remove-btn")) {
      const orderItemId = e.target.getAttribute("data-id");
      fetch("/api/cart/remove", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ orderItemId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            location.reload();
          } else {
            alert("Failed to remove item.");
          }
        });
    }
  });
});
