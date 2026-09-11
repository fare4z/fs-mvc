    <footer class="footer bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024 - <?php echo date("Y"); ?> Student Portal. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

         <?php if (isset($_SESSION['flash_msg'])) : ?>
        <script>
            Swal.fire({
                title: "<?php echo $_SESSION['flash_msg']['msg'];?>",
                icon: "<?php echo $_SESSION['flash_msg']['type'];?>",
                timer: 2000
            });
        </script>

    <?php unset($_SESSION['flash_msg']);
    endif; ?>


    </body>

    </html>