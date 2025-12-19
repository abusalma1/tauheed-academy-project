<!-- Error Message -->
<div id="errorMessage" class="hidden mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
    <i class="fas fa-exclamation-circle"></i>

    <span>Check the form & make sure all requirments are satisfied</span>
</div>

<script>
    // Error Message
    function showErrorMessage() {
        const message = document.getElementById("errorMessage");
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