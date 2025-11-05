<?php if (isset($_SESSION['success'])): ?>
    <div id="successAlert"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg opacity-0 translate-y-[-100%] transition-all duration-500 ease-in-out z-50">
        <?= htmlspecialchars($_SESSION['success']); ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const successAlert = document.getElementById("successAlert");
        if (successAlert) {
            // Slide in
            setTimeout(() => {
                successAlert.classList.remove("opacity-0", "translate-y-[-100%]");
                successAlert.classList.add("opacity-100", "translate-y-0");
            }, 100);

            // Auto hide after 4 seconds
            setTimeout(() => {
                successAlert.classList.remove("opacity-100", "translate-y-0");
                successAlert.classList.add("opacity-0", "translate-y-[-100%]");
            }, 4000);
        }
    });
</script>