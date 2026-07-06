    </main>

    <!-- FOOTER -->
    <!-- <footer></footer> -->

    <!-- SCRIPTS -->
    <script src="<?= URL_BASE ?>assets/vendor/jquery/jquery-3.7.1.min.js"></script>
    <script src="<?= URL_BASE ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= URL_BASE ?>assets/js/script.js"></script>

    
    <script>
        $(document).ready(function() {
            $('.navbar-brand').on('click', function() {
                window.location.href = 'index.php';
            });
        });
    </script>
</body>

</html>