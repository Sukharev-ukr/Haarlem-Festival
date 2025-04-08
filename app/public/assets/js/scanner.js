const reader = new Html5Qrcode("reader");

function showMessage(message, type) {
  const box = document.getElementById("statusMessage");
  box.textContent = message;
  box.className = `status-${type}`;
  box.style.display = "block";
}

function startScanner() {
  reader.start(
    { facingMode: "environment" }, // Use back camera
    {
      fps: 10,
      qrbox: { width: 250, height: 250 },
    },
    onScanSuccess,
    (error) => {
      console.warn("Scanning error:", error);
    }
  );
}

function stopScanner() {
  reader.stop().catch((err) => console.error("Stop error", err));
}

function onScanSuccess(decodedText) {
  stopScanner();

  fetch("/api/tickets/scan", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ticketID: decodedText }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        showMessage(data.message, "success");
      } else if (data.message.includes("already")) {
        showMessage(data.message, "warning");
      } else {
        showMessage(data.message, "error");
      }

      // Restart scanner after 3 seconds
      setTimeout(() => {
        document.getElementById("statusMessage").style.display = "none";
        startScanner();
      }, 3000);
    })
    .catch((error) => {
      console.error("Fetch error:", error);
      showMessage("Failed to scan. Try again.", "error");
      setTimeout(() => {
        document.getElementById("statusMessage").style.display = "none";
        startScanner();
      }, 3000);
    });
}

// Start on load
startScanner();
