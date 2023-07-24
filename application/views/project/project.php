<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">List project</h6>
                            <div class="card-action-wrap">

                                <button id="action-task-add" type="button" class="btn btn-sm btn-primary">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Tugas</span>
                                    </span>
                                </button>
                                <?php if($this->session->userdata('role_id') == 2) : ?>
                                    <button id="action-add" type="button" class="btn btn-sm btn-primary ms-2">
                                        <span>
                                            <span class="icon">
                                                <span class="feather-icon">
                                                    <i data-feather="plus"></i>
                                                </span>
                                            </span>
                                            <span class="btn-text">Project</span>
                                        </span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Nama project</th>
                                            <th>Team</th>
                                            <th>Deadline</th>
                                            <th>Progress</th>
                                            <th>Status</th>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 id="modal-title" class="modal-title"></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="form-project" class="form-floating">
                        <div class="modal-body">
                            <div class="notif" style="display: none;"></div>
                            <div class="row g-2">
                                <div class="col-12">
                                    <label for="title" class="fs-8 mb-1">Judul project
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="layers"></i>
                                                </span>
                                            </span>
                                            <input id="title" type="text" name="title" class="form-control" placeholder="Judul project">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="start-date" class="fs-8 mb-1">Tanggal Mulai
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
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
                                    <label for="deadline" class="fs-8 mb-1">Batas waktu / Deadline</label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="deadline" name="deadline" type="text" class="form-control date" placeholder="Deadline">
                                        </span>
                                    </div>
                                    <span class="fs-9">Kosongkan jika tidak ada batas waktu</small>
                                </div>
                                <div class="col-12">
                                    <label class="fs-8 mb-1">Leader Team <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span></label>
                                    <select id="select_leader" class="select" name="leader"></select>
                                </div>
                                <div class="col-12">
                                    <label class="fs-8 mb-1">Team</label>
                                    <select id="select_team" class="select" multiple name="team[]"></select>
                                </div>
                                <div id="progress-wrap" class="col-12 mb-0" style="display: none">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="fs-8 mb-1">Project terselesaikan : </label>
                                            <span id="progress-title" class="fs-8">0%</span>
                                            <input id="progress" name="progress" type="range" class="form-range mt-md-1" min="0" max="100" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-8 mb-1">Status</label>
                                            <select id="select_status" name="status"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="fs-8 mb-1">Deskripsi / Catatan Project</label>
                                    <textarea id="summernote" class="form-control" name="desc" rows="2" placeholder="Deskripsi / Catatan"></textarea>
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

        <?php $this->load->view('project/modal-task') ?>
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>


<script async src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/summernote/summernote-lite.js"></script>

<script>
    $(function() {
        const modalTitle = $('#modal-title')
        const btnSave = $('#btn-save')
        const notifAlert = $('.notif')
        const table = $('#table');
        const form = $('#form-project');
        var saveAction;

        const modal = new bootstrap.Modal(document.getElementById('modal'))

        var status = [
        {
            id: 'in progress',
            text: "In Progress",
            class: "badge-info"
        },{
            id: 'approval',
            text: "Approval",
            class: "badge-warning"
        },{
            id: 'fabrication',
            text: "Fabrication",
            class: "badge-primary"
        },{
            id: 'finished',
            text: "Finished",
            class: "badge-success",
        }]

        <?php if($this->session->userdata('role_id') == 2) : ?>
            status.push({
                    id: 'not started',
                    text: "Not Started",
                    class: "badge-secondary"
                })
        <?php endif; ?>

        // const taskPriority = [{
        //     id: 'low',
        //     text: "Low",
        //     class: "badge-primary"
        // }, {
        //     id: 'medium',
        //     text: "Medium",
        //     class: "badge-warning"
        // }, {
        //     id: 'high',
        //     text: "High",
        //     class: "badge-danger"
        // }]
        $('#progress').on('input', function() {
            $('#progress-title').text($(this).val() + "%")
        });

        const formModal = (action, title = "", btnText = "") => {
            saveAction = action
            modalTitle.text(title)
            btnSave.text(btnText)
            modal.show()
            form[0].reset()

            $('#select_leader, #select_team').select2().empty()
            <?php if($this->session->userdata('role_id') == 2) : ?>
                ajaxSelect('#select_leader', "<?= base_url('project/select_employee') ?>", true)
            <?php endif; ?>
            ajaxSelect('#select_team', "<?= base_url('project/select_employee') ?>", true)


            if (action == "add") {
                $('#progress-wrap').hide()
            } else {
                $('#progress').removeAttr('disabled')
                $('#progress-wrap').show()
            }
        }

        const selectStatus = (selector, isHaveParent = false) => {
            const config = {
                placeholder: 'Choose...',
                data: status,
                templateResult: formatSelectWithIndicator,
                templateSelection: formatSelectWithIndicator,
            }

            if (isHaveParent) {
                config.dropdownParent = $('#modal')
            }

            $(selector).select2(config);
        }

        const loadAfterAction = _ => {
            setTimeout(() => {
                modal.hide()
            }, 1000);

            setTimeout(() => {
                table.DataTable().ajax.reload();
            }, 1300);
        }

        dateRangePicker()

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
                selectStatus('.select_status')
                $('body').tooltip({
                    selector: '.avatar',
                });
            },
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '<?= base_url() ?>project',
                type: 'POST',
                data: function(e) {
                    e.csrf_token = csrf.attr('content');
                },
                dataSrc: function(e) {
                    csrf.attr('content', e.csrf_hash)
                    return e.data
                }
            },
            columnDefs: [{
                target: 5,
                orderable: false,
            }]
        });

        form.submit(function(e) {
            e.preventDefault();
            var url;
            if (saveAction == "add") {
                url = '<?= base_url('project/action/add') ?>'
            } else {
                url = '<?= base_url('project/action/update') ?>'
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
            formModal('add', 'Tambah Project', "Tambah Project")
        });

        $('body').on('change', '.select_status', function(e) {
            e.preventDefault();
            selectStatus('#select_status', true)
            const id = $(this).closest('tr').find('button').data('id')
            const data = {
                id: id,
                type: "project",
                status: $(this).val(),
                csrf_token: csrf.attr('content')
            }

            $.ajax({
                type: "POST",
                url: "<?= base_url('project/update_status') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                }
            })
        });

        $('#summernote').summernote({
            placeholder: 'Ketikan catatan disini..',
            codeviewIframeFilter: true,
            disableDragAndDrop: true,
            height: 90,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen','codeview']]
            ]
        });

        $('body').on('click', '.action-edit', function(e) {
            e.preventDefault();

            selectStatus('#select_status', true)
            formModal('edit', 'Edit Project', "Simpan")
            $('#loading').show()
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_project') ?>",
                data: "id=" + $(this).data('id') + "&csrf_token=" + csrf.attr('content'),
                dataType: "JSON",
                success: function(response) {
                    csrf.attr("content", response.csrf_hash)
                    if (response.success) {
                        $('input[name="target"]').val(response.data.project_id)
                        $('input[name="title"]').val(response.data.project_name)
                        $('input[name="start_date"]').val(response.data.start_date)
                        $('input[name="deadline"]').val(response.data.deadline)
                        $('#select_leader').append(new Option(response.data.leader.fullname, response.data.leader.user_id)).trigger('change');
                        response.data.team.forEach(v => {
                            $('#select_team').append(new Option(v.fullname, v.user_id, true, true)).trigger('change');
                        });
                        $('#select_status').val(response.data.project_status).trigger('change');
                        $('#progress-title').html(response.data.completion_percent + "%")
                        $('input[name="progress"]').val(response.data.completion_percent)
                        $('#summernote').summernote('code', response.data.project_description);
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
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian project ini?</p>
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
                            type: "project",
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