<?php if (isset($_SESSION['failure'])): ?>
    <div id="failureAlert"
        class="fixed top-18 left-1/2 transform -translate-x-1/2 mt-4 px-6 py-3 bg-red-600 text-white rounded-full shadow-lg opacity-0 translate-y-[-100%] transition-all duration-500 ease-in-out z-[9999]">
        <?= htmlspecialchars($_SESSION['failure']); ?>
    </div>
    <?php unset($_SESSION['failure']); ?>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const failureAlert = document.getElementById("failureAlert");
        if (failureAlert) {
            // Slide in
            setTimeout(() => {
                failureAlert.classList.remove("opacity-0", "translate-y-[-100%]");
                failureAlert.classList.add("opacity-100", "translate-y-0");
            }, 100);

            // Auto hide after 3 seconds
            setTimeout(() => {
                failureAlert.classList.remove("opacity-100", "translate-y-0");
                failureAlert.classList.add("opacity-0", "translate-y-[-100%]");
            }, 3000);
        }
    });
</script>