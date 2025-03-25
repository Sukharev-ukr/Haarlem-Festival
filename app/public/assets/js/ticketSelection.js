document.addEventListener("DOMContentLoaded", () => {
  const incrementButtons = document.querySelectorAll(".increment");
  const decrementButtons = document.querySelectorAll(".decrement");
  const totalPriceElement = document.getElementById("total-price");
  let totalPrice = 0;

  incrementButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const index = button.getAttribute("data-index");
      const ticketCountElement = document.getElementById(
        `ticket-count-${index}`
      );
      const ticketTotalElement = document.getElementById(
        `ticket-total-${index}`
      );
      const ticketContainer = button.closest(".ticket-type");
      const ticketPrice = parseFloat(
        ticketContainer.getAttribute("data-price")
      );

      let count = parseInt(ticketCountElement.innerText);
      count++;
      ticketCountElement.innerText = count;

      const ticketTotal = ticketPrice * count;
      ticketTotalElement.innerText = `€${ticketTotal.toFixed(2)}`;

      updateTotalPrice();
    });
  });

  decrementButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const index = button.getAttribute("data-index");
      const ticketCountElement = document.getElementById(
        `ticket-count-${index}`
      );
      const ticketTotalElement = document.getElementById(
        `ticket-total-${index}`
      );
      const ticketContainer = button.closest(".ticket-type");
      const ticketPrice = parseFloat(
        ticketContainer.getAttribute("data-price")
      );

      let count = parseInt(ticketCountElement.innerText);
      if (count > 0) {
        count--;
        ticketCountElement.innerText = count;

        const ticketTotal = ticketPrice * count;
        ticketTotalElement.innerText = `€${ticketTotal.toFixed(2)}`;

        updateTotalPrice();
      }
    });
  });

  function updateTotalPrice() {
    let newTotalPrice = 0;
    document.querySelectorAll(".ticket-type").forEach((ticketContainer) => {
      const ticketTotalElement = ticketContainer.querySelector(".ticket-total");
      const ticketTotal =
        parseFloat(ticketTotalElement.innerText.replace("€", "")) || 0;
      newTotalPrice += ticketTotal;
    });
    totalPrice = newTotalPrice;
    totalPriceElement.innerText = `€${totalPrice.toFixed(2)}`;
  }
});

/////////////////////////////////////////////////////////////////////////////Check Out

//ticketSelection.js - Updated for Auth Handling

document.addEventListener("DOMContentLoaded", () => {
  const addToCartBtn = document.getElementById("add-to-cart-btn");
  const buyNowBtn = document.getElementById("buy-now-btn");

  const danceID = new URLSearchParams(window.location.search).get("danceID");

  /** ✨ Add to Cart Handler */
  addToCartBtn.addEventListener("click", () => {
    const tickets = [];
    document.querySelectorAll(".ticket-type").forEach((ticketContainer) => {
      const ticketTypeId = ticketContainer.getAttribute("data-type-id");
      const price = parseFloat(ticketContainer.getAttribute("data-price"));
      const quantity = parseInt(
        ticketContainer.querySelector(".ticket-count").innerText
      );

      if (quantity > 0) {
        tickets.push({
          ticketTypeId,
          quantity,
          price,
        });
      }
    });

    if (tickets.length > 0) {
      const payload = { danceID, tickets };
      console.log("📤 Sending data:", payload);

      fetch("/api/addToCart", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
      })
        .then(async (response) => {
          if (!response.ok) {
            if (response.status === 401) {
              alert("⚠️ You need to log in to add tickets to the cart.");
              //window.location.href = "/user/login";
              return;
            }

            const errorText = await response.text();
            throw new Error(`Unexpected error: ${errorText}`);
          }

          return response.json();
        })
        .then((data) => {
          if (data?.status === "success") {
            alert("✅ Tickets added to cart successfully!");
          } else {
            alert("❌ Failed to add tickets to cart.");
          }
        })
        .catch((error) => console.error("❌ Error:", error));
    } else {
      alert("⚠️ Please select at least one ticket.");
    }
  });

  /** ✨ Buy Now Handler 
  buyNowBtn.addEventListener("click", () => {
    window.location.href = "/checkout";
  });*/
});
