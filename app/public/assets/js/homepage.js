document.addEventListener("DOMContentLoaded", () => {
    // Set your festival date/time (adjust as needed)
    const festivalDate = new Date("July 6, 2025 9:30:00").getTime();
  
    const timerInterval = setInterval(() => {
      const now = new Date().getTime();
      const distance = festivalDate - now;
  
      // If the countdown is finished
      if (distance < 0) {
        clearInterval(timerInterval);
        document.getElementById("countdown").textContent = "The festival has started!";
        document.getElementById("timer-labels").textContent = "";
        return;
      }
  
      // Calculate days, hours, minutes, seconds
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const minutes = Math.floor(
        (distance % (1000 * 60 * 60)) / (1000 * 60)
      );
      const seconds = Math.floor(
        (distance % (1000 * 60)) / 1000
      );
  
      // Update the DOM
      document.getElementById("days").textContent = days;
      document.getElementById("hours").textContent = hours;
      document.getElementById("minutes").textContent = minutes;
      document.getElementById("seconds").textContent = seconds;
    }, 1000);
  });
  