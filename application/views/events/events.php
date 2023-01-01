<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua Acara
                                <span class="badge badge-sm badge-light ms-1"></span>
                            </h6>
                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                <div class="card-action-wrap">
                                    <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#modal">
                                        <span>
                                            <span class="icon">
                                                <span class="feather-icon">
                                                    <i data-feather="plus"></i>
                                                </span>
                                            </span>
                                            <span class="btn-text">Acara</span>
                                        </span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                            <table id="table-events" class="table nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Judul acara</th>
                                        <th>Tempat Acara</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Status Acara</th>
                                        <th>Deskripsi</th>
                                        <?php if($this->session->userdata('role_id') == 2) : ?>
                                        <th class="text-center">Action</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($events as $event) : ?>
                                        <tr class="fs-7">
                                            <td><?= $event['event_title'] ?></td>
                                            <td><?= $event['event_location'] ?></td>
                                            <td>
                                                <span class="badge badge-soft-primary"><?= date('d M Y', strtotime($event['start_date'])) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-danger"><?= date('d M Y', strtotime($event['end_date'])) ?></span>
                                            </td>
                                            <td>
                                                <?php if( date('Y-m-d') < $event['start_date']) :?>
                                                    <span class="badge badge-soft-success">Acara Mendatang</span>
                                                <?php elseif(date('Y-m-d') >= $event['start_date'] &&  date('Y-m-d') < $event['end_date'] ) :?>
                                                    <span class="badge badge-soft-warning">Sedang berlangsung</span>
                                                <?php else : ?>
                                                    <span class="badge badge-soft-danger">Acara berakhir</span>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-soft-dark show-description" data-desc="<?= $event['event_description'] ?>" data-bs-toggle="modal" data-bs-target="#modal-show" type="button">
                                                    <span class="fs-8">
                                                        <span class="icon fs-8">
                                                            <i class="icon dripicons-preview"></i>
                                                        </span>
                                                        <span>Lihat</span>
                                                    </span>
                                                </button>
                                            </td>
                                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                            <td class="text-center">
                                                <button class="btn btn-icon btn-sm btn-soft-dark edit-event" data-eventid="<?= $event['event_id'] ?>" data-eventtitle="<?= $event['event_title'] ?>" data-location="<?= $event['event_location'] ?>" data-start="<?= $event['start_date'] ?>" data-end="<?= $event['end_date'] ?>" data-desc="<?= $event['event_description'] ?>" data-bs-toggle="modal" data-bs-target="#modal-edit" type="button">
                                                    <span class="icon fs-8">
                                                        <i class="icon dripicons-pencil"></i>
                                                    </span>
                                                </button>
                                                <button class="btn me-3 btn-icon btn-sm btn-soft-danger flush-soft-hover btn-delete" type="button" data-id="<?= $event['event_id'] ?>">
                                                    <span class="icon fs-8">
                                                        <i class="icon dripicons-trash"></i>
                                                    </span>
                                                </button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
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
<?php if($this->session->userdata('role_id') == 2) : ?>
<!-- Tambah -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Acara</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-event" class="form-floating" action="<?= base_url('events/add_events')?>">
                <div class="modal-body">
                    <div id="errors" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="fs-8 mb-1">Judul Acara 
                                <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i>
                            </label>
                            <input type="text" class="form-control" name="event_title" placeholder="Ketikan judul acara">
                        </div>
                        <div class="col-md-6">
                            <label class="fs-8 mb-1">Tempat Acara
                                <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i>
                            </label>
                            <input type="text" class="form-control" name="event_location" placeholder="Ketikan tempat acara">
                        </div>
                        <div class="col-6">
                            <label for="end-date" class="fs-8 mb-1">Mulai Acara
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="start_date" class="form-control date">
                                </span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="start-date" class="fs-8 mb-1">Berakhir Acara
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="end_date" class="form-control date">
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="fs-8 mb-1">Deskripsi (opt)</label>
                            <textarea class="form-control" name="event_description" rows="2" placeholder="Deskripsi tambahan"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fs-7">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Acara</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-event" class="form-floating" action="<?= base_url('events/edit_events')?>">
                <div class="modal-body">
                    <div id="errors-e" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="fs-8 mb-1">Judul Acara 
                                <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i>
                            </label>
                            <input id="event-title" type="text" class="form-control" name="event_title" placeholder="Ketikan judul acara">
                        </div>
                        <div class="col-md-6">
                            <label class="fs-8 mb-1">Tempat Acara
                                <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i>
                            </label>
                            <input id="event-location" type="text" class="form-control" name="event_location" placeholder="Ketikan tempat acara">
                        </div>
                        <div class="col-6">
                            <label for="end-date" class="fs-8 mb-1">Mulai Acara
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input id="start-date" type="text" name="start_date" class="form-control date">
                                </span>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="start-date" class="fs-8 mb-1">Berakhir Acara
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </span>
                                    <input id="end-date" type="text" name="end_date" class="form-control date">
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="fs-8 mb-1">Deskripsi (opt)</label>
                            <textarea id="event-description" class="form-control" name="event_description" rows="2" placeholder="Deskripsi tambahan"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <input id="event-id" type="hidden" name="event_id">
                    <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fs-7">Edit acara</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Modal Show Description -->
<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Deskripsi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="description" class="fs-7"></p>
            </div>
            <div class="modal-footer p-2" style="border-top: none ;">
                <button type="button" class="btn btn-primary fs-7" data-bs-dismiss="modal">Ok, Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>
<!-- Daterangepicker JS -->
<script src="<?= base_url()?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>

<script>
    $('.date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: <?= date('Y', strtotime('-1 year')) ?>,
        maxYear: <?= date('Y', strtotime('+1 year')) ?>,
        "cancelClass": "btn-soft-dark",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('#table-events').DataTable({
        // pageLength: 1,
        order: [1, 'ASC'],
        scrollX:  true,
        language: { search: "",
            searchPlaceholder: "Search",
            sLengthMenu: "_MENU_items",
            paginate: {
                next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple pagination-sm');
        }
    });

    $(document).on('click', '.edit-event', function(e){
        e.preventDefault()
        const eventid = $(this).data('eventid')
        const eventtitle = $(this).data('eventtitle')
        const location = $(this).data('location')
        const startDate = $(this).data('start')
        const endDate = $(this).data('end')
        const desc = $(this).data('desc')

        $('#modal-edit #event-id').val(eventid)
        $('#modal-edit #event-title').val(eventtitle)
        $('#modal-edit #event-location').val(location)
        $('#modal-edit #start-date').val(startDate)
        $('#modal-edit #end-date').val(endDate)
        $('#modal-edit #event-description').html(desc)
        
        $('#start-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            startDate: startDate,
            minYear: <?= date('Y', strtotime('-1 year')) ?>,
            maxYear: <?= date('Y', strtotime('+1 year')) ?>,
            "cancelClass": "btn-soft-dark",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $('#end-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            startDate: endDate,
            minYear: <?= date('Y', strtotime('-1 year')) ?>,
            maxYear: <?= date('Y', strtotime('+1 year')) ?>,
            "cancelClass": "btn-soft-dark",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    })

    $(document).on('click', '.show-description', function(e){
        e.preventDefault()
        const desc = $(this).data('desc')
        $('#modal-show .modal-body #description').html(desc)
        
    })

    $(document).on('submit', '#add-event', function(e){
        e.preventDefault()
        const url = $(this).attr('action');
        // console.log(url)
        $.ajax({
            type: "POST",
            url: url, 
            data: $(this).serialize(),
            dataType: "json",  
            cache: false,
            success: function(response){
                if (response.success) {
                    sweatalert_confirm('success', response)
                }

                if (response.errors) {
                    $('#errors').html(response.desc).show()
                    $('.csrf').val(response.csrfHash)
                }

                if (response.error) {
                    sweatalert_confirm('danger', response)
                }

                if (response.warning) {
                    sweatalert_confirm('warning', response)
                }
            },
            error : function(xhr, status, errorThrown){
                console.log(xhr.responseText)
                console.log(status)
                console.log(errorThrown)
            }
        });
        return false;
    });

    $(document).on('submit', '#edit-event', function(e){
        e.preventDefault()
        const url = $(this).attr('action')
        // console.log(url)
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            dataType: "json",  
            cache: false,
            success: function(response){
                if (response.success) {
                    sweatalert_confirm('success', response)
                }
                if (response.errors) {
                    $('#errors-e').html(response.desc).show()
                    $('.csrf').val(response.csrfHash)
                }

                if (response.error) {
                    sweatalert_confirm('danger', response)
                }
            },
            error : function(xhr, status, errorThrown){
                console.log(xhr.responseText)
                console.log(status)
                console.log(errorThrown)
            }
        });
        return false;
    })

    $(document).on('click','.btn-delete', function(e){
        e.preventDefault()
        const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
        const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        const target = $(this).data('id')

        Swal.fire({
            html:
            `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                <span class="initial-wrap rounded-8">
                    <i class="icon dripicons-trash" style="line-height:0;"></i>
                </span>
            </div>
            <div>
                <h5 class="text-dark">Hapus</h5>
                <p class="fs-7 mt-2">Anda yakin ingin menghapus ini?</p>
            </div>`,
            customClass: {
                content: 'p-3 text-center',
                confirmButton: 'btn btn-danger fs-7',
                actions: 'justify-content-center mt-1 p-0',
                cancelButton:'btn btn-soft-dark fs-7 me-2'
            },
            width: 300,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Tutup',
            reverseButtons:true,
            showCancelButton: true,
            buttonsStyling: false,
        }).then((r)=>{
            if(r.value){
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('events/delete_events/') ?>' + target, 
                    data: {[csrfName] : csrfHash},
                    dataType: "json",  
                    cache: false,
                    success: function(response){
                        if (response.error) {
                            sweatalert_confirm('danger', response)
                        }
                        if (response.success) {
                            sweatalert_confirm('success', response)
                        }
                    },
                    error : function(xhr, status, errorThrown){
                        console.log(xhr.responseText)
                        console.log(status)
                        console.log(errorThrown)
                    }
                });
            }
        })
        return false;
    })

    function sweatalert_confirm(type, res){
            let icon;
            let classHeader;
            if (type == 'success') {
                icon = '😍';
                classHeader = 'avatar-soft-success';
            } else if(type == 'danger'){
                icon = '😣';
                classHeader = 'avatar-soft-danger';
            } else if(type == 'warning'){
                icon = '🧐';
                classHeader = 'avatar-soft-warning';
            }

            Swal.fire({
                html:
                `<div class="avatar avatar-icon ${classHeader}  mb-3">
                    <span class="initial-wrap rounded-8">
                        ${icon}
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">${res.title}</h5>
                    <p class="fs-7 mt-2">${res.desc}</p>
                </div>`,
                customClass: {
                    content: 'p-3 text-center',
                    confirmButton: 'btn btn-primary fs-7',
                    actions: 'justify-content-center mt-1',
                },
                width: 300,
                confirmButtonText: res.buttontext,
                buttonsStyling: false,
            }).then((r) => {
                setTimeout(() => {
                    location.reload()
                }, 10);
            })
        }
</script>
