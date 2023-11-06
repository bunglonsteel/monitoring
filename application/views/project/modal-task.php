<div class="modal fade" id="modal-task" tabindex="-1" role="dialog" aria-labelledby="modal" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="title-task" class="modal-title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-task" class="form-floating">
                <div class="modal-body mh-600p">
                    <div class="notif" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="title_task" class="fs-8 mb-1">Judul
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="layers"></i>
                                        </span>
                                    </span>
                                    <input id="title_task" type="text" name="title_task" class="form-control" placeholder="Ketikan...">
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
                        <!-- <div class="col-12">
                            <label for="status_task" class="fs-8 mb-1">Status tugas <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                            <select id="status_task" name="status_task">
                                <option value="">Choose...</option>
                            </select>
                        </div> -->
                        <div class="col-12">
                            <label for="start-date" class="fs-8 mb-1">Tanggal</label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input id="start-date" name="start_date" type="text" class="form-control date" placeholder="Tanggal">
                                </span>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-6">
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
                            </div> -->
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="fs-8 me-3">Deskripsi / Catatan</label>
                                <div id="wrap-action-sub-task" class="divi flex-grow-1">
                                    <div class="divi-text">
                                        <button id="add-sub-task-item" type="button" class="btn pe-0 fs-7 text-primary fw-bold">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                                <span>Deskripsi</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- <textarea id="desc-task" class="form-control" name="desc_task" rows="2" placeholder="Deskripsi / Catatan tugas"></textarea> -->

                            <div id="sub-task-items" class="card card-border mb-0 p-3 mh-300p overflow-auto">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-sticky bottom-0 modal-footer p-2 bg-white" style="border-top: none ;z-index: 5;">
                    <div id="loading" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <input type="hidden" name="target">
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button id="save_task" type="submit" class="btn btn-primary fs-7"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Init for table
        const paramid = $(location).attr('href').split('/').at(-1)
        var table = $('#table-task')
        const modalTitle = $('#title-task')
        const btnSave = $('#save_task')
        const formTask = $('#form-task');
        let saveActionTask;

        const modalTask = new bootstrap.Modal(document.getElementById('modal-task'))
        const itemTaskStatus = [{
            id: 'progress',
            text: "Progress",
            class: "badge-info"
        }, {
            id: 'completed',
            text: "Completed",
            class: "badge-success"
        }]

        const templateScopes = state => {
            if (!state.id) {
                return state.text;
            }
            var result = $(
                `
                    <span class="flex-grow-1 text-limit-2">${state.text}</span>
                `
            );
            return result;
        }

        const descriptionItemField = (action, itemLength = 0, item = {}) => {

            if ($.isEmptyObject(item)) {
                var status = {
                    id: '',
                    text: 'Choose...'
                }
                var item = {
                    id: '',
                    title: ''
                }
            } else {
                var status = {
                    id: item.status,
                    text: item.status[0].toUpperCase() + item.status.slice(1)
                }
                var item = {
                    id: item.id,
                    title: item.title,
                    scope: item.scope_id,
                    scopeName: item.scope
                }
            }
            const lengthItem = $('.item-description').length
            const row = `
                    <div class="item-description row g-2">
                        <div class="col-12">
                            <label class="fs-8 mb-1"> Item
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <input type="text" name="item[${itemLength}][title]" class="form-control w-100" value="${item.title}" placeholder="Ketikan...">
                            <input type="hidden" name="item[${itemLength}][id]" value="${item.id}">
                        </div>
                        <div class="col-12 d-flex gap-2 align-items-end">
                            <div class="flex-grow-1" style="max-width:50%">
                                <label for="scope" class="fs-8 mb-1">Scope <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                                <select name="item[${itemLength}][scopes]">
                                    <option value="${item.scope}">${item.scopeName}</option>
                                </select>
                            </div>
                            <div class="flex-grow-1" style="max-width:50%">
                                <label for="status" class="fs-8 mb-1">Status <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                                <select name="item[${itemLength}][status]">
                                    <option value="${status.id}">${status.text}</option>
                                </select>
                            </div>
                            ${lengthItem > 0 && action == "add" ? `<button class="btn btn-icon remove-sub-task"  type="button">
                                <span>
                                    <i class="icon dripicons-cross text-danger"></i>
                                </span>
                            </button>` : ''}
                        </div>
                    </div>
            `

            $('#sub-task-items').append(row)
            $(`select[name='item[${itemLength}][status]'`).select2({
                placeholder: 'Choose...',
                data: itemTaskStatus,
                templateResult: formatSelectWithIndicator,
                templateSelection: formatSelectWithIndicator,
                dropdownParent: $('#modal-task')
            });

            $(`select[name='item[${itemLength}][scopes]'`).select2({
                placeholder: 'Choose...',
                templateResult: templateScopes,
                templateSelection: templateScopes,
                dropdownParent: $('#modal-task'),
                ajax: {
                    url: "<?= base_url('project/get_scopes') ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    delay: 300,
                    minimumInputLength: 4,
                    data: function(params) {
                        return {
                            id: paramid,
                            status: "yes",
                            search: params.term,
                            csrf_token: csrf.attr('content')
                        };
                    },
                    processResults: function(res) {
                        csrf.attr('content', res.csrf_hash)
                        return {
                            results: $.map(res.data, function(item) {
                                return {
                                    id: item.scope_id,
                                    text: item.scope
                                }
                            })
                        };
                    }
                }
            });
        }

        const formModal = (action, title = "", btnText = "") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            $('#notif-task, #sub-task-items').empty()
            formTask[0].reset()
            $('#select_categories').select2().empty()
            modalTask.show()

            ajaxSelect('#select_project', "<?= base_url('project/select_project') ?>", true, '#modal-task')
            ajaxSelectWithGroup('#select_categories', "<?= base_url('project/select_task_categories') ?>", true, '#modal-task')

            if (action == "add") {
                descriptionItemField(action)
                $('#wrap-action-sub-task').show()
            } else {
                $('#wrap-action-sub-task').hide()
            }
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

            const formData = new FormData();
            // const items_id = [];
            // const items = [];
            // const scopes = [];
            // const values = [];
            // const results = [];
            for (const data of $(this).serializeArray()) {

                // if (data.name == "item[]" && data.value != "") {
                //     items.push(data.value)
                // }
                // if (data.name == "status[]") {
                //     values.push(data.value)
                // }
                // if (data.name == "scopes[]") {
                //     scopes.push(data.value)
                // }
                // if (data.name == "item_id[]") {
                //     items_id.push(data.value)
                // }
                // if (data.name == 'item[]' | data.name == 'status[]' | data.name == "scope[]" | data.name == 'item_id[]') {
                //     continue;
                // }
                console.log(data)
                formData.append(data.name, data.value)
            }

            // items.forEach((title, i) => {
            //     results.push({
            //         id: items_id[i],
            //         item: encodeURIComponent(title),
            //         scope: scopes[i],
            //         value: values[i]
            //     })
            // });
            // const check = results.filter(v => v.value == '')
            // if (check.length > 0 || results.length == 0) {
            //     show_toast('danger', 'Mohon Maaf', 'Item wajib diisi / tidak boleh kosong.')
            // }
            formData.append('csrf_token', csrf.attr('content'))
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
            formModal('add', 'Tambah', "Tambah")
        });

        $('body').on('click', '.edit-task', function(e) {
            e.preventDefault();
            formModal('edit', 'Edit', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_task') ?>",
                data: "id=" + $(this).data('id') + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
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

                        if (response.data.items.length > 0) {
                            response.data.items.forEach((e, i) => {
                                descriptionItemField('edit', i, e)
                            })
                        } else {
                            $('#sub-task-items').empty().append(`
                                        <div class="card card-border mb-0">
                                            <div class="card-body">
                                                <p>Deskripsi tidak ada</p>
                                            </div>
                                        </div>`)
                        }
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

        $('#add-sub-task-item').click(function(e) {
            const itemLength = $('body .item-description').length
            descriptionItemField('add', itemLength)
        })

        $('body').on('click', '.remove-sub-task', function(e) {
            $(this).closest('.item-description').remove()
        })
    });
</script>