document.addEventListener("DOMContentLoaded", function() {
  // Select all input fields and error message
  const inputs = document.querySelectorAll("input");
  const errorMessage = document.getElementById("error-message");

  // Add event listener to clear error message when user starts typing
  inputs.forEach(input => {
      input.addEventListener("focus", function() {
          if (errorMessage) {
              errorMessage.style.display = "none"; // Hide error message when user focuses on input
          }
      });
  });
});