<?php

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";
}

?>


<!-- Success Message -->
<div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
    <i class="fas fa-check-circle"></i>
    <span>Form is Submitted successfully!</span>
</div>

<script>
    // Success Message
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
</script>