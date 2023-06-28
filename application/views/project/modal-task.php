<div class="modal fade" id="modal-task" tabindex="-1" role="dialog" aria-labelledby="modal" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="title-task" class="modal-title">Tambah Tugas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-task" class="form-floating">
                <div class="modal-body">
                    <div class="notif" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="title_task" class="fs-8 mb-1">Judul tugas
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="layers"></i>
                                        </span>
                                    </span>
                                    <input id="title_task" type="text" name="title_task" class="form-control" placeholder="Judul tugas">
                                </span>
                            </div>
                        </div>
                        <div id="wrap-project" class="col-12">
                            <label for="select_project" class="fs-8 mb-1">Project <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                            <select id="select_project" name="project">
                                <option value="">Choose...</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="select_categories" class="fs-8 mb-1">Cek Item <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                            <select id="select_categories" name="categories[]" multiple>
                                <option value="">Choose...</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="status_task" class="fs-8 mb-1">Status tugas <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                            <select id="status_task" name="status_task">
                                <option value="">Choose...</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start-date" class="fs-8 mb-1">Tanggal Mulai</label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="start-date" name="start_date" type="text" class="form-control date" placeholder="Tanggal Mulai">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="due_date" class="fs-8 mb-1">Tanggal Berakhir</label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="due_date" name="due_date" type="text" class="form-control date" placeholder="Tanggal Berakhir">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="fs-8 mt-2"><b>Catatan</b> : Jika tanggal mulai dan tanggal berakhir kosong maka tanggal hari itu juga menjadi tanggal dan berakhirnya.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="desc-task" class="fs-8 mb-1">Deskripsi / Catatan tugas</label>
                            <textarea id="desc-task" class="form-control" name="desc_task" rows="2" placeholder="Deskripsi / Catatan tugas"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <div id="loading" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <input type="hidden" name="target">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="save_task" type="submit" class="btn btn-primary fs-7">Tambah tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Init for table
        var   table      = $('#table-task')
        const modalTitle = $('#title-task')
        const btnSave    = $('#save_task')
        const formTask   = $('#form-task');
        let saveActionTask;

        const modalTask  = new bootstrap.Modal(document.getElementById('modal-task'))
        const statusTask = [{
            id: 'doing',
            text: "Doing",
            class: "badge-info"
        },{
            id: 'partially finished',
            text: "Partially Finished",
            class: "badge-primary"
        },{
            id: 'completed',
            text: "Completed",
            class: "badge-success"
        }]

        const formModal = (action, title = "", btnText = "") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            $('#notif-task').empty()
            formTask[0].reset()
            $('#select_categories').select2().empty()
            modalTask.show()

            ajaxSelect('#select_project', "<?= base_url('project/select_project') ?>", true, '#modal-task')
            ajaxSelectWithGroup('#select_categories', "<?= base_url('project/select_task_categories') ?>", true, '#modal-task')
            $("#status_task").select2({
                placeholder: 'Choose...',
                data: statusTask,
                templateResult: formatSelectWithIndicator,
                templateSelection: formatSelectWithIndicator,
                dropdownParent: $('#modal-task')
            });
        }

        dateRangePicker()

        formTask.submit(function(e) {
            e.preventDefault();
            let url;
            if (saveAction == "add") {
                url = '<?= base_url('project/action_task/add') ?>'
            } else {
                url = '<?= base_url('project/action_task/update') ?>'
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
                            modalTask.hide()
                        }, 1000);
                        
                        if (table.length > 0) {
                            setTimeout(() => {
                                table.DataTable().ajax.reload();
                            }, 1300);
                        }
                    }
                }
            });
        });

        $('#action-task-add').click(function(e) {
            e.preventDefault();
            formModal('add', 'Tambah Tugas', "Tambah Tugas")
        });

        $('body').on('click', '.edit-task', function(e) {
            e.preventDefault();
            formModal('edit', 'Edit Tugas', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_task') ?>",
                data: "id=" + $(this).data('id') + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
                    console.log(response)
                    if (response.success) {
                        $('input[name="target"]').val(response.data.task_id)
                        $('input[name="title_task"]').val(response.data.task_title)
                        $('input[name="start_date"]').val(response.data.start_date)
                        $('input[name="due_date"]').val(response.data.due_date)

                        response.data.categories.forEach(v => {
                            $('#select_categories').append(new Option(v.name, v.id, true, true)).trigger('change');
                        });

                        if ($('#select_project').length > 0) {
                            $('#select_project').append(new Option(response.data.project_name, response.data.project_id, true, true)).trigger('change');
                        } else {
                            $('input[name="project"]').val(response.data.project_id)
                        }
                        $('select[name="status_task"]').val(response.data.status).trigger('change');
                        $('textarea[name="desc_task"]').val(response.data.task_description)
                    }

                }
            }).done(() => {
                $('#loading').hide()
            });
        });

        $('body').on('click', '.remove-task', function(e) {
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
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian tugas ini?</p>
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
                            type: "task",
                            csrf_token: csrf.attr('content'),
                        },
                        dataType: "json",
                        success: function(response) {
                            notifAction(response)
                            if (table.length > 0) {
                                setTimeout(() => {
                                    table.DataTable().ajax.reload();
                                }, 1300);
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
            return false;
        })
    });
</script>