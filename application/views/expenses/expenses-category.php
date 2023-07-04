<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>
        
        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6>Semua kategori</h6>
                            <div class="card-action-wrap">
                                <button id="action-add" class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#modal">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Kategori</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori Pengeluaran</th>
                                            <th>Deskripsi</th>
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
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
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
                    <label for="category" class="fs-8 mb-1"> Kategori
                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                    </label>
                    <div class="input-group mb-2">
                        <span class="input-affix-wrapper">
                            <span class="input-prefix">
                                <span class="feather-icon">
                                    <i data-feather="grid"></i>
                                </span>
                            </span>
                            <input id="category" type="text" name="category" class="form-control" placeholder="Nama Kategori">
                        </span>
                    </div>

                    <label for="category" class="fs-8 mb-1"> Deskripsi</label>
                    <textarea class="form-control" name="description" rows="2" placeholder="Deskripsi"></textarea>
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <input type="hidden" name="target">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="btn-save" type="submit" class="btn btn-primary fs-7"></button>
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
        var saveAction;

        const modal     = new bootstrap.Modal(document.getElementById('modal'))

        const formModal = (action, title = "", btnText = "Tambah") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            modal.show()
            form[0].reset()
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
            drawCallback: _ => {
                $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple pagination-sm');
                $('tbody tr').addClass('fs-7')
            },
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '<?= base_url() ?>expenses-category',
                type: 'POST',
                data: function(e) {
                    e.csrf_token = csrf.attr('content');
                },
                dataSrc: function(e) {
                    csrf.attr('content', e.csrf_hash)
                    return e.data
                }
            },
        });

        form.submit(function(e) {
            e.preventDefault();
            var url;
            if (saveAction == "add") {
                url = '<?= base_url('expenses/action_cat/add') ?>'
            } else {
                url = '<?= base_url('expenses/action_cat/update') ?>'
            }

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize() + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    loadAfterAction()
                }
            });
        });

        $('#action-add').click(function(e) {
            e.preventDefault();
            formModal('add', 'Tambah Kategori Pengeluaran')
        });

        $('body').on('click', '.edit', function(e) {
            e.preventDefault();
            formModal('edit', 'Edit Kategori Pengeluaran', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('expenses/get') ?>",
                data: {
                    id: $(this).data('id'),
                    type: "expense_categories",
                    csrf_token: csrf.attr('content'),
                },
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
                    console.log(response)
                    if (response.success) {
                        $('input[name="target"]').val(response.data.expense_categories_id)
                        $('input[name="category"]').val(response.data.name)
                        $('textarea[name="description"]').val(response.data.description)
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
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus kategori pengeluaran ini?</p>
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
                            type: "expense_categories",
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