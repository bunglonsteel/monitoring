<div class="modal fade" id="modal-scope" tabindex="-1" role="dialog" aria-labelledby="modal" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="title-scope" class="modal-title">Tambah</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-scope" class="form-floating">
                <div class="modal-body mh-600p">
                    <div class="notif" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="scope" class="fs-8 mb-1">Scopes
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <textarea id="scope" class="form-control mb-2" name="scope" rows="4" placeholder="Ketikan..."></textarea>
                            <p class="fs-8"><strong>Catatan</strong> : Gunakan tanda | (pipe) sebagai pemisah antara scope.</p>
                        </div>
                    </div>
                </div>
                <div class="position-sticky bottom-0 modal-footer p-2 bg-white" style="border-top: none ;z-index: 5;">
                    <div id="loading-scope-form" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <input id="target-scope" type="hidden" name="target">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="save-scope" type="submit" class="btn btn-primary fs-7"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        const paramid = $(location).attr('href').split('/').at(-1)
        const listScope = $('#scopes')
        const modalTitle = $('#title-scope')
        const btnSave = $('#save-scope')
        const formScope = $('#form-scope');
        let saveAction;

        const modalScope = new bootstrap.Modal(document.getElementById('modal-scope'))

        const formModal = (action, title = "", btnText = "") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            $('.notif').empty()
            formScope[0].reset()
            modalScope.show()
        }

        const renderScopes = response => {
            if (response.data) {
                response.data.forEach((scope, i) => {
                    listScope
                        .append(`
                        <div class="col-md-4">
                            <input id="ca1" type="checkbox" hidden value="1">
                            <label class="w-100 h-100 status-scope" for="c-a1" style="cursor: pointer;" data-id="${scope.scope_id}" data-status="${scope.status}" data-scope="${scope.scope}">
                                <div class="h-100 card card-border mb-0 ${scope.status == 1 ? 'border-primary' : ''} border-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center gap-1 mb-1">
                                        <span class="d-inline-block"><strong class="text-primary">Scope</strong> : </span>
                                        <div>
                                            <button class="btn btn-xs btn-icon btn-soft-dark edit-scope feather-icon">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <button class="btn btn-xs btn-icon btn-soft-danger delete-scope feather-icon">
                                                <i data-feather="trash"></i>
                                            </button>
                                            <button class="btn btn-xs btn-icon btn-soft-dark show-scope feather-icon drawer-toggle-link" data-target="#drawer_scope" data-drawer="push-normal">
                                                <i data-feather="eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 text-limit-2">${scope.scope}</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        `)
                });
                feather.replace()
            } else {
                listScope
                    .append(`
                    <div class="col">
                        <div class="card card-border">
                            <div class="card-body p-3">
                                Scope belum ada
                            </div>
                        </div>
                    </div>
                    `)
            }
        }

        const scopes = () => {
            const url = "<?= base_url('project/get_scopes/') ?>" + paramid
            $('#loading-scopes').show()
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + paramid + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr('content', response.csrf_hash)
                    listScope.empty()
                    renderScopes(response)
                }
            }).done(() => {
                $('#loading-scopes').hide()
            })
        }

        $('#scope-view').click(function(e) {
            if (listScope.children().length == 0) {
                scopes()
            }
        })

        formScope.submit(function(e) {
            e.preventDefault();
            let url;
            if (saveAction == "add") {
                url = '<?= base_url('project/action_scope_project/add') ?>'
            } else {
                url = '<?= base_url('project/action_scope_project/update') ?>'
            }

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize() + "&project=" + paramid + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)

                    if (response.success) {
                        setTimeout(() => {
                            modalScope.hide()
                        }, 1000);
                        setTimeout(() => {
                            scopes()
                        }, 1300);
                    }
                }
            });
        });

        $('#action-scope-add').click(function(e) {
            formModal('add', 'Tambah', 'Tambah')
        })

        $('body').on('click', '.edit-scope', function(e) {
            e.stopPropagation();
            formModal('Edit', 'Edit', 'Simpan')
            const url = "<?= base_url('project/get_scope') ?>";
            const id = $(this).closest('label').data('id')
            $('#loading-scope-form').show()
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + id + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr('content', response.csrf_hash)
                    $('textarea[name="scope"]').val(response.data.scope)
                    $('#target-scope').val(response.data.scope_id)
                }
            }).done(() => {
                $('#loading-scope-form').hide()
            })
        })

        $('body').on('click', '.status-scope', function(e) {
            const url = "<?= base_url('project/update_status') ?>";
            const id = $(this).closest('label').data('id');
            const status = $(this).closest('label').data('status') == 1 ? 0 : 1;

            Swal.fire({
                html: `<div class="avatar avatar-icon ${status == 0 ? 'avatar-soft-warning' : 'avatar-soft-success'} mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon ${status == 0 ? 'dripicons-information' : 'dripicons-checkmark'}" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">${status == 0 ? 'Scope Selesai' : 'Tandai Selesai'}</h5>
                    <p class="fs-7 mt-2">${status == 0 ? 'Anda yakin ingin mengubah ke belum selesai?' : 'Anda yakin scope project ini sudah selesai?'}</p>
                </div>`,
                customClass: {
                    content: 'p-3 text-center',
                    confirmButton: 'btn btn-primary fs-7',
                    actions: 'justify-content-center mt-1 p-0',
                    cancelButton: 'btn btn-soft-dark fs-7 me-2'
                },
                width: 300,
                confirmButtonText: `${status == 0 ? 'Ya, Ubah' : 'Ya, Selesai'}`,
                cancelButtonText: 'Tutup',
                reverseButtons: true,
                showCancelButton: true,
                buttonsStyling: false,
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            id: id,
                            type: "scope",
                            status: status,
                            csrf_token: csrf.attr('content'),
                        },
                        dataType: "json",
                        success: function(response) {
                            notifAction(response)
                            if (response.success) {
                                scopes()
                            }
                        },
                        error: function(xhr, status, errorThrown) {
                            console.log(xhr.responseText)
                            console.log(status)
                            console.log(errorThrown)
                        }
                    });
                }
            })
        })

        $('body').on('click', '.delete-scope', function(e) {
            e.stopPropagation()
            const url = "<?= base_url('project/delete') ?>";
            const id = $(this).closest('label').data('id');
            const status = $(this).closest('label').data('status') == 1 ? 0 : 1;

            Swal.fire({
                html: `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus scope of work ini?</p>
                </div>`,
                customClass: {
                    content: 'p-3 text-center',
                    confirmButton: 'btn btn-primary fs-7',
                    actions: 'justify-content-center mt-1 p-0',
                    cancelButton: 'btn btn-soft-dark fs-7 me-2'
                },
                width: 300,
                confirmButtonText: `Ya, Hapus`,
                cancelButtonText: 'Tutup',
                reverseButtons: true,
                showCancelButton: true,
                buttonsStyling: false,
            }).then((e) => {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            id: id,
                            type: "scope",
                            status: status,
                            csrf_token: csrf.attr('content'),
                        },
                        dataType: "json",
                        success: function(response) {
                            notifAction(response)
                            if (response.success) {
                                scopes()
                            }
                        },
                        error: function(xhr, status, errorThrown) {
                            console.log(xhr.responseText)
                            console.log(status)
                            console.log(errorThrown)
                        }
                    });
                }
            })
        })

    });
</script>