
function showSuccessMessage() {
  const message = document.getElementById("successMessage");
  if (message) {
    message.classList.remove("hidden"); // show the message
    message.classList.add("flex"); // ensure it displays properly

    // Hide it after 5 seconds
    setTimeout(() => {
      message.classList.add("hidden");
      message.classList.remove("flex");
    }, 5000);
  }
}

