<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>
        
        <div class="hk-page-body">
            <div class="row g-2 g-md-3">
                <div class="col-md-4">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="text-xs text-primary mb-0 d-inline-block me-2">
                                            Uang KAS
                                        </h6>
                                        <a id="action-add-kas" href="javascript:void(0)" class="badge badge-sm badge-primary">+ Tambah</a>
                                    </div>
                                    <div id="balance" class="mb-0 fw-bold text-dark" style="font-size:1.5rem;"></div>
                                </div>
                                <i class="ri-wallet-2-line" style="color: #eaeaea; font-size:40px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-xs text-primary mb-1">
                                        Pengeluaran Bulan Ini
                                    </h6>
                                    <div id="amount-month" class="mb-0 fw-bold text-dark" style="font-size:1.5rem;"></div>
                                </div>
                                <i class="ri-wallet-line" style="color: #eaeaea; font-size:40px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-xs text-primary mb-1">
                                        Pengeluaran Tahun Ini
                                    </h6>
                                    <div id="amount-year" class="mb-0 fw-bold text-dark" style="font-size:1.5rem;"></div>
                                </div>
                                <i class="ri-wallet-line" style="color: #eaeaea; font-size:40px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <div class="d-flex align-items-center">
                                <div class="input-group me-2">
                                    <span class="input-affix-wrapper">
                                        <span class="input-prefix">
                                            <span class="feather-icon">
                                                <i data-feather="filter"></i>
                                            </span>
                                        </span>
                                        <input type="text" name="filter" class="form-control" placeholder="Filter tanggal">
                                    </span>
                                </div>
                                <button id="btn-filter-reset" class="btn btn-icon btn-sm btn-soft-dark flush-soft-hover px-2" type="button" style="display: none">
                                    <span class="icon fs-8">
                                        <i class="icon dripicons-clockwise"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="card-action-wrap">
                                <button id="action-add" class="btn btn-sm btn-primary ms-3 py-2 py-md-1" data-bs-toggle="modal" data-bs-target="#modal">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="d-none d-md-block btn-text">Pengeluaran</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="contact-list-view">
                                <table id="table" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pengeluaran</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Catatan</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="modal-title" class="modal-title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form" class="form-floating">
                <div class="modal-body">
                    <div class="notif" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="expense-categories" class="fs-8 mb-1"> Pengeluaran
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <select id="expense-categories" name="expense_categories"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="fs-8 mb-1"> Jumlah
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="fs-7">
                                            Rp.
                                        </span>
                                    </span>
                                    <input id="amount" name="amount" type="number" class="form-control" placeholder="Jumlah" pattern="^[0-9]*$">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="date" class="fs-8 mb-1">Tanggal</label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input id="date" name="date" type="text" class="form-control date" placeholder="Tanggal">
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="fs-8 mb-1">Catatan</label>
                            <textarea class="form-control" name="note" rows="2" placeholder="Catatan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <div id="loading" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <input type="hidden" name="target">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="btn-save" type="submit" class="btn btn-primary fs-7"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-kas" tabindex="-1" role="dialog" aria-labelledby="modal" aria-modal="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah KAS</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-kas" class="form-floating">
                <div class="modal-body">
                    <div class="notif" style="display: none;"></div>
                    <label for="amount" class="fs-8 mb-1"> Jumlah
                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                    </label>
                    <div class="input-group">
                        <span class="input-affix-wrapper">
                            <span class="input-prefix">
                                <span class="fs-7">
                                    Rp.
                                </span>
                            </span>
                            <input id="amount" name="amount" type="number" class="form-control" placeholder="Jumlah" pattern="^[0-9]*$">
                        </span>
                    </div>
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="btn-save" type="submit" class="btn btn-primary fs-7">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script async src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/select2/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        const table      = $('#table')
        const modalTitle = $('#modal-title')
        const btnSave    = $('#btn-save')
        const notifAlert = $('.notif')
        const form       = $('#form');
        const formKas    = $('#form-kas');
        const filter     = $('input[name="filter"]');
        var saveAction;

        const modal     = new bootstrap.Modal(document.getElementById('modal'))
        const modalkas = new bootstrap.Modal(document.getElementById('modal-kas'))

        const formModal = (action, title = "", btnText = "Tambah") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            modal.show()
            form[0].reset()
            notifAlert.empty()
            $('input[name="amount"]').removeAttr('disabled')

            $('#expense-categories').select2().empty()
            ajaxSelect('#expense-categories', "<?= base_url('expenses/select_expense_cateogories') ?>", true)
        }

        const loadAfterAction = _ => {
            setTimeout(() => {
                modal.hide()
            }, 1000);

            setTimeout(() => {
                table.DataTable().ajax.reload();
            }, 1300);
        }

        table.DataTable({
            processing: true,
            scrollX: true,
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search",
                sLengthMenu: "_MENU_items",
                paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                    previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
                }
            },
            dom: '<"row align-items-center"<"col-6 col-md-6"l><"col-6 col-md-6"<"#grand-total.text-center text-lg-end">>>t<"row align-items-center"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            drawCallback: _ => {
                $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple pagination-sm');
                $('tbody tr').addClass('fs-7')
            },
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '<?= base_url() ?>expenses',
                type: 'POST',
                data: function(e) {
                    e.csrf_token = csrf.attr('content');
                    e.filter     = filter.val();
                },
                dataSrc: function(e) {
                    csrf.attr('content', e.csrf_hash)
                    $('#grand-total').html(`<span>Total Pengeluaran</span><h4 class="mb-0">${e.amount_filter}</h4>`)
                    $('#balance').html(e.balance)
                    if (e.balance.replace(/(Rp. )/,'').replaceAll('.','') < 0) {
                        $('#balance').removeClass('text-dark').addClass('text-danger')
                    } else {
                        $('#balance').removeClass('text-danger').addClass('text-dark')
                    }
                    $('#amount-month').html(e.expense_month)
                    $('#amount-year').html(e.expense_year)
                    return e.data
                }
            },
        });

        dateRangePicker()

        filter.daterangepicker({
            showDropdowns: true,
            maxDate: new Date(),
            maxYear: moment().year(),
            minYear: moment().subtract(1, "years").year(),
            locale: {
                format: 'DD MMM YYYY'
            },
            drops: "auto",
            ranges: {
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });
        filter.val('')
        filter.change(function(){
            $('#btn-filter-reset').show()
            table.DataTable().draw()
        })

        form.submit(function(e) {
            e.preventDefault();
            var url;
            if (saveAction == "add") {
                url = '<?= base_url('expenses/action/add') ?>'
            } else {
                url = '<?= base_url('expenses/action/update') ?>'
            }
            filter.val('')
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize() + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    if (response.success) {
                        loadAfterAction()
                    }
                }
            });
        });

        formKas.submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?= base_url('expenses/add_saldo') ?>',
                data: $(this).serialize() + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    setTimeout(() => {
                        modalkas.hide()
                    }, 1000);
                    setTimeout(() => {
                        table.DataTable().ajax.reload();
                    }, 1300);
                }
            });
        });

        $('#btn-filter-reset').click(function(e) {
            e.preventDefault();
            filter.val('')
            table.DataTable().ajax.reload();
            $(this).hide()
        });

        $('#action-add').click(function(e) {
            e.preventDefault();
            formModal('add', 'Tambah Pengeluaran')
        });

        $('#action-add-kas').click(function(e) {
            e.preventDefault();
            notifAlert.empty()
            formKas[0].reset()
            modalkas.show()
        });

        $('body').on('click', '.edit', function(e) {
            e.preventDefault();
            formModal('edit', 'Edit Pengaturan', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('expenses/get') ?>",
                data: {
                    id: $(this).data('id'),
                    type: "expenses",
                    csrf_token: csrf.attr('content'),
                },
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
                    if (response.success) {
                        $('input[name="target"]').val(response.data.expense_id)
                        $('input[name="amount"]').val(response.data.amount).attr('disabled','true')
                        $('input[name="date"]').val(response.data.date)

                        $('select[name="expense_categories"]').append(new Option(response.data.name, response.data.expense_categories_id, true, true)).trigger('change');
                        $('textarea[name="note"]').val(response.data.note)
                    }

                }
            }).done(() => {
                $('#loading').hide()
            });
        });

        $('body').on('click', '.delete', function(e) {
            e.preventDefault()

            Swal.fire({
                html: `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian pengeluaran ini?</p>
                </div>`,
                customClass: {
                    content: 'p-3 text-center',
                    confirmButton: 'btn btn-danger fs-7',
                    actions: 'justify-content-center mt-1 p-0',
                    cancelButton: 'btn btn-soft-dark fs-7 me-2'
                },
                width: 300,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tutup',
                reverseButtons: true,
                showCancelButton: true,
                buttonsStyling: false,
            }).then((r) => {
                if (r.value) {
                    $.ajax({
                        type: "POST",
                        url: `<?= base_url('expenses/delete') ?>`,
                        data: {
                            id: $(this).data('id'),
                            type: "expenses",
                            csrf_token: csrf.attr('content'),
                        },
                        dataType: "json",
                        success: function(response) {
                            notifAction(response)
                            loadAfterAction()
                        },
                        error: function(xhr, status, errorThrown) {
                            console.log(xhr.responseText)
                            console.log(status)
                            console.log(errorThrown)
                        }
                    });
                }
            })
            return false;
        })
    });
</script>