<?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
    <div id="toaster" class="<?php echo !empty($_SESSION['success_message']) ? "bg-green-500" : "bg-red-500"; ?>
 h-auto w-[350px] p-4 text-white rounded-lg fixed bottom-[-100px] right-2 z-[99999] transition-all duration-500">
        <h2 class="text-xl mb-2">
            <?php echo !empty($_SESSION['success_message']) ? "Success!" : "Error!"; ?>
        </h2>
        <p class="text-sm">
            <?php echo !empty($_SESSION['success_message']) ? $_SESSION['success_message'] : $_SESSION['error_message']; ?>
        </p>
    </div>
    <script>
        const toaster = document.getElementById("toaster");
        toaster.style.bottom = "12px";
        setTimeout(() => {
            toaster.style.bottom = "0";
            toaster.style.right = "-100%";
        }, 3000);
    </script>

    <?php unset($_SESSION['success_message']); ?>
    <?php unset($_SESSION['error_message']); ?>

<?php endif; ?>