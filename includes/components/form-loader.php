<div id="loader" class="flex space-x-2 justify-center items-center mt-4 hidden">
    <div class="w-3 h-3 bg-blue-900 rounded-full animate-upDown"></div>
    <div class="w-3 h-3 bg-blue-900 rounded-full animate-upDown" style="animation-delay: 0.1s;"></div>
    <div class="w-3 h-3 bg-blue-900 rounded-full animate-upDown" style="animation-delay: 0.2s;"></div>
    <div class="w-3 h-3 bg-blue-900 rounded-full animate-upDown" style="animation-delay: 0.3s;"></div>
</div>

<script>
    function showLoader() {
        const loader = document.getElementById('loader');
        loader.classList.remove('hidden');
        loader.classList.add('flex'); // Show loader

        // Optional: Disable submit button if one exists
        const form = loader.closest("form"); // Get closest form if loader is inside one
        if (form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }
</script>