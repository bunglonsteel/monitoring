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
    $(document).ready(function() {
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
            const nameShort = function() {
                if ($('#name')) {
                    const fullname = '<?= $employee['full_name'] ?>';
                    const results = fullname.charAt(0) + fullname.charAt(fullname.length - 1)
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
    var dateRangePicker = _ => {
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: <?= date('Y', strtotime('-1 year')) ?>,
            maxYear: <?= date('Y', strtotime('+1 year')) ?>,
            cancelClass: "btn-soft-dark",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    }

    var ajaxSelect = (selector, url, isHaveParent = false, selectorParent = "#modal") => {
        const config = {
            placeholder: 'Choose...',
            ajax: {
                url: url,
                type: 'POST',
                dataType: 'JSON',
                delay: 300,
                minimumInputLength: 4,
                data: function(params) {
                    return {
                        search: params.term,
                        csrf_token: csrf.attr('content')
                    };
                },
                processResults: function(res) {
                    csrf.attr('content', res.csrf_hash)
                    return {
                        results: $.map(res.data, function(item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    };
                }
            }
        }

        if (isHaveParent) {
            config.dropdownParent = $(selectorParent);
        }
        $(selector).select2(config);
    }
    var ajaxSelectWithGroup = (selector, url, isHaveParent = false, selectorParent = "#modal") => {
        const config = {
            placeholder: 'Choose...',
            ajax: {
                url: url,
                type: 'POST',
                dataType: 'JSON',
                delay: 300,
                minimumInputLength: 4,
                data: function(params) {
                    return {
                        search: params.term,
                        csrf_token: csrf.attr('content')
                    };
                },
                processResults: function(res) {
                    csrf.attr('content', res.csrf_hash)
                    const parent = res.data.filter(v => v.parent_id == null)
                    let result = []

                    $.each(parent, (i, v) => {
                        const child = res.data.filter(vr => v.id == vr.parent_id)

                        v.text = v.name
                        v.children = child.map(v => ({id:v.id, text:v.name}))

                        result.push(v)
                    });
                    return {results: result}

                }
            }
        }

        if (isHaveParent) {
            config.dropdownParent = $(selectorParent);
        }
        $(selector).select2(config);
    }

    var formatSelectWithIndicator = state => {
        if (!state.id) {
            return state.text;
        }
        var result = $(
            `
                <div class="d-flex align-items-center">
                    <i class="badge ${state.class} badge-indicator badge-indicator-lg me-1 flex-shrink-0"></i>
                    <span class="flex-grow-1">${state.text}</span>
                </div>
            `
        );
        return result;
    }

    var show_toast = (type, title, description) => {
        const typeClass = (type == "success") ? "alert-success" : ((type == "warning") ? "alert-warning" : "alert-danger")
        setTimeout(function() {
            $('.alert.alert-dismissible .close').addClass('btn-close').removeClass('close');
        }, 100);
        $.notify({
            title: `<b>${title}</b>`,
            message: `<p class="fs-7">${description}</p>`,
        }, {
            z_index: 1056,
            type: `dismissible ${typeClass}`,
            placement: {
                from: "top",
                align: "center"
            },
        });
    }

    const notifAction = response => {
        csrf.attr('content', response.csrf_hash)
        if (response.errors) {
            $('.notif').html(response.message).show()
        }

        if (response.error) {
            show_toast('danger', 'Mohon maaf 😣', response.message)
        }

        if (response.warning) {
            show_toast('warning', 'Peringatan 🙁', response.message)
        }

        if (response.success) {
            show_toast('success', 'Berhasil 😍', response.message)
        }
    }
</script>
</body>
</html>