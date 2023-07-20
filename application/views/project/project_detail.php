<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">
        <?php $this->load->view('layout/breadcrumbs') ?>
        <div class="hk-page-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="card card-border p-3 fs-7 h-100">
                        <div class="d-flex flex-column gap-2 flex-md-row justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Infomasi Pekerjaan</h5>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge badge-soft-light fw-bold">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="play-circle"></i>
                                            </span>
                                        </span>
                                        <?= $project->start_date ? date('d M Y', strtotime($project->start_date)) : "-" ?>
                                    </span>
                                </span>
                                <span class="text-light">-</span>
                                <span class="badge badge-soft-danger fw-bold">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="stop-circle"></i>
                                            </span>
                                        </span>
                                        <?= $project->deadline ? date('d M Y', strtotime($project->deadline)) : "-" ?>
                                    </span>
                                </span>
                                <!-- <?php if($project->project_status == "finished") : ?>
                                    <span class=" badge badge-soft-success fw-bold">
                                        <span>
                                            <span class="icon">
                                                <span class="feather-icon">
                                                    <i data-feather="check"></i>
                                                </span>
                                            </span>
                                            Selesai
                                        </span>
                                    </span>
                                <?php endif; ?> -->
                            </div>
                        </div>
                        
                        <hr class="mt-0 mb-3">
                        <p class="mb-1"><span class="info-title">Nama Project</span> : <?= ucwords($project->project_name) ?></p>
                        <?php if($project->completed_on) : ?>
                        <div>
                            <span class="info-title">Tanggal Selesai</span> : 
                                <span class="d-inline-block badge badge-soft-light fw-bold mb-1">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="flag"></i>
                                            </span>
                                        </span>
                                        <?= $project->completed_on ? date('d M Y', strtotime($project->completed_on)) : "-" ?>
                                    </span>
                                </span>
                        </div>
                        <?php endif; ?>
                        <p class="mb-1"><span class="info-title">Status</span> : <strong><?= ucwords($project->project_status) ?></strong></p>
                        <p class="mb-1"><span class="info-title">Progress</span> : <strong><?= $project->completion_percent ?>%</strong></p>
                        <div class="mb-3"><span class="info-title">Team</span> : 
                                <span class="bg-light d-inline-block rounded-pill p-1 pe-3 mr-1 mb-1 fs-8">
                                    <div class="avatar avatar-rounded avatar-xxs">
                                        <img src="<?= base_url('public/image/users/'. $project->leader->image_profile) ?>" alt="<?= $project->leader->fullname ?>" class="avatar-img">
                                        <span class="badge position-bottom-end-overflow-1 fs-7">👑</span>
                                    </div>
                                    <?= $project->leader->fullname ?>
                                </span>
                                <?php if (count($project->team)) :?>
                                    <?php foreach($project->team as $t) : ?>
                                        <span class="bg-light d-inline-block rounded-pill p-1 pe-3 mr-1 mb-1 fs-8">
                                            <div class="avatar avatar-rounded avatar-xxs">
                                                <img src="<?= base_url('public/image/users/'. $t->image_profile) ?>" alt="<?= $t->fullname ?>" class="avatar-img">
                                            </div>
                                            <?= $t->fullname ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </div>
                        <div class="accordion accordion-card accordion-card-bold accordion-simple" id="description">
                            <div class="accordion-item mb-0">
                                <h6 class="accordion-header" id="simplecardshadowbold-headingThree">
                                    <button class="accordion-button collapsed fs-7" type="button" data-bs-toggle="collapse" data-bs-target="#desc" aria-expanded="false" aria-controls="simplecardshadowbold-collapseThree">
                                        Deskripsi / Catatan Project
                                    </button>
                                </h6>
                                <div id="desc" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#description">
                                    <div class="accordion-body">
                                        <?= $project->project_description ?$project->project_description : "-" ?>
                                    </div>
                                </div>
                            </div>
                        </div>
			
                    </div>
                </div>
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6>List Tugas</h6>
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
                            </div>
                        </div>

                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table-task" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Nama tugas</th>
                                            <th>Project</th>
                                            <th>Mulai</th>
                                            <th>Berakhir</th>
                                            <th>Status</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Review</th>
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
        <?php $this->load->view('project/modal-task') ?>
        <?php $this->load->view('project/drawer_task_detail') ?>
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>


<script src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>
<!-- Daterangepicker JS -->
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/select2/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        const table  = $('#table-task')
        const paramid = $(location).attr('href').split('/')
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
        $('#wrap-project')
            .empty()
            .css('margin', 0)
            .append(`
                <input class="form-control" type="text" name="project" value="<?= $project->project_id ?>" hidden>`
            )
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

                $(".status_task").select2({
                    placeholder: 'Choose...',
                    data: statusTask,
                    templateResult: formatSelectWithIndicator,
                    templateSelection: formatSelectWithIndicator,
                });
            },
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '<?= base_url() ?>project/task/'+ paramid.at(-1),
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

        $('body').on('change', '.status_task', function(e) {
            e.preventDefault();
            const id = $(this).closest('tr').find('.edit-task').data('id')
            const data = {
                id        : id,
                type      : "task",
                status    : $(this).val(),
                csrf_token: csrf.attr('content')
            }
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/update_status') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    setTimeout(() => {
                        table.DataTable().ajax.reload();
                    }, 1300);
                }
            })
        });

        $('body').on('click', '.review', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/review_task') ?>",
                data: {
                    id        : $(this).data('id'),
                    review    : $(this).data('value'),
                    csrf_token: csrf.attr('content')
                },
                dataType: "JSON",
                success: function(response) {
                    notifAction(response)
                    setTimeout(() => {
                        table.DataTable().ajax.reload();
                    }, 1300);
                }
            })
        });
    });
</script>