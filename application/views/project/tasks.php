<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Summary project</h6>
                        </div>

                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table-task" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Daily Worker</th>
                                            <th>Tanggal</th>
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


<script async src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    $(function() {
        const table = $('#table-task')
        const statusTask = [{
            id: 'progress',
            text: "Progress",
            class: "badge-info"
        }, {
            id: 'partially finished',
            text: "Partially Finished",
            class: "badge-primary"
        }, {
            id: 'completed',
            text: "Completed",
            class: "badge-success"
        }]

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
                url: '<?= base_url() ?>project/task',
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
                id: id,
                type: "task",
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
                    id: $(this).data('id'),
                    review: $(this).data('value'),
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