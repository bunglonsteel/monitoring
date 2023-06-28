<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">List cek item</h6>
                            <div class="card-action-wrap">

                                <button id="action-add" type="button" class="btn btn-sm btn-primary">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Cek item</span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table-task-categories" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="w-100">Nama Cek Item</th>
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
                            <div class="row g-2">
                                <div class="col-12">
                                    <label for="name_categories" class="fs-8 mb-1">Judul Item
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="layers"></i>
                                                </span>
                                            </span>
                                            <input id="name_categories" type="text" name="category" class="form-control" placeholder="Nama Item">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="select_category" class="fs-8 mb-1">Pilih Induk Item</label>
                                    <select id="select_category" name="parent_category"></select>
                                    <p class="mt-2 fs-8">Kosongkan jika ingin menjadikan cek item sebagai induk Item.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-2" style="border-top: none ;">
                            <div id="loading" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <input type="hidden" name="target" value="0">
                            <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                            <button id="btn-save" type="submit" class="btn btn-primary fs-7"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>


<script async src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    $(function () {
        const table = $('#table-task-categories')
        const modalTitle = $('#modal-title')
        const btnSave = $('#btn-save')
        const notifAlert = $('.notif')
        const form = $('#form');
        var saveAction;

        const modal = new bootstrap.Modal(document.getElementById('modal'))

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
                $('body').tooltip({
                    selector: '.text-wrap',
                });
            },
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '<?= base_url() ?>task/categories',
                type: 'POST',
                data: function(e) {
                    e.csrf_token = csrf.attr('content');
                },
                dataSrc: function(e) {
                    csrf.attr('content', e.csrf_hash)
                    return e.data
                }
            }
        });

        const formModal = (action, title = "", btnText = "") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            modal.show()
            form[0].reset()

            $('#select_category').select2().empty()
            ajaxSelect('#select_category', "<?= base_url('project/select_categories') ?>", true)
        }

        form.submit(function(e) {
            e.preventDefault();
            let url;
            if (saveAction == "add") {
                url = '<?= base_url('project/action_task_categories/add') ?>'
            } else {
                url = '<?= base_url('project/action_task_categories/update') ?>'
            }

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize() + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    if (response.success) {
                        setTimeout(() => {
                            modal.hide()
                        }, 1000);
                        setTimeout(() => {
                            table.DataTable().ajax.reload();
                        }, 1300);
                    }
                }
            });
        });

        $('#action-add').click(function(e) {
            e.preventDefault();
            formModal('add', 'Tambah Cek Item', "Tambah")
        });

        $('body').on('click', '.action-edit', function(e) {
            e.preventDefault();

            formModal('edit', 'Edit Cek Item', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_task_category') ?>",
                data: "id=" + $(this).data('id') + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
                    if (response.success) {
                        $('input[name="target"]').val(response.data.task_category_id)
                        $('input[name="category"]').val(response.data.category_name)
                        if (response.data.parent_id) {
                            $('#select_category').append(new Option(response.data.parent_name, response.data.parent_id)).trigger('change');
                        }
                    }

                }
            }).done(() => {
                $('#loading').hide()
            });
        });

        $('body').on('click', '.action-remove', function(e) {
            e.preventDefault()

            const id = $(this).data('id')
            const url = `<?= base_url('project/delete') ?>`

            Swal.fire({
                html: `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian kategori ini?</p>
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
                        url: url,
                        data: {
                            id: id,
                            type: "task_category",
                            csrf_token: csrf.attr('content'),
                        },
                        dataType: "json",
                        success: function(response) {
                            notifAction(response)
                            setTimeout(() => {
                                table.DataTable().ajax.reload();
                            }, 1300);
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