</div>
		<!-- /Main Content -->
	</div>
    <!-- /Wrapper -->

    <!-- Bootstrap Core JS -->
    <script src="<?= base_url() ?>public/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FeatherIcons JS -->
    <script src="<?= base_url() ?>public/assets/dist/js/feather.min.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="<?= base_url() ?>public/assets/dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- Simplebar JS -->
    <script src="<?= base_url() ?>public/assets/vendors/simplebar/dist/simplebar.min.js"></script>

    <!-- Data Table JS -->
    <script src="<?= base_url() ?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>

    <!-- Init JS -->
    <script src="<?= base_url() ?>public/assets/dist/js/init.js"></script>
    <script src="<?= base_url() ?>public/assets/dist/js/chips-init.js"></script>
    <script>
        $(document).ready(function () {
            const date = new Date();
            const today = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']
            const month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
            ]

            $('.clock-head-date').html(
                `${today[date.getDay()]}, ${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()}`
            )
            setInterval(() => {
                const date = new Date();
                $('.clock-head-hour').text(
                    `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()} ${date.getHours() >= 12 ? 'PM' : 'AM'}`
                )
            }, 1000)

            <?php if ($this->session->userdata('role_id') == 1) : ?>
                const nameShort = function(){
                if ($('#name')) {
                        const fullname = '<?= $employee['full_name']?>';
                        const results = fullname.charAt(0)+fullname.charAt(fullname.length-1)
                        $('#name').html(results.toUpperCase())
                    }
                };
                nameShort();
            <?php endif; ?>
        });
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function(e) {
        if (e.ctrlKey && e.keyCode === 85) {
            return false;
            }
        };
    </script>
</body>
</html>