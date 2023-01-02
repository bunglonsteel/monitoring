<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Kehadiran hari ini
                                <span class="badge badge-sm badge-light ms-1"><?= count($absensi) ?></span>
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
                                            <span class="btn-text">Absen Manual</span>
                                        </span>
                                    </button>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                            <table id="table-absensi" class="table nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Nama karyawan</th>
                                        <th>Department / bagian</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <?php if($this->session->userdata('role_id') == 2) : ?>
                                        <th>Total Jam</th>
                                        <?php endif; ?>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($absensi as $absen) :?>
                                        <tr class="fs-7">
                                            <td>
                                                <div class="media align-items-center">
                                                    <div class="media-head me-2">
                                                        <div class="avatar avatar-xs avatar-rounded">
                                                            <img src="<?= base_url()?>public/image/users/<?= $absen['image_profile'] ?>" alt="user" class="avatar-img">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-high-em"><?= $absen['full_name'] ?></div> 
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $absen['name_department'] ?></td>
                                            <td>
                                                <?php if($absen['clock_in'] == null) : ?>
                                                    -
                                                <?php else:?>
                                                    <span class="badge badge-soft-success">
                                                        <?= date('H:i', strtotime($absen['clock_in'])) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($absen['clock_out'] == null) : ?>
                                                    -
                                                <?php else:?>
                                                    <span class="badge badge-soft-danger">
                                                        <?= date('H:i', strtotime($absen['clock_out'])) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                            <td>
                                                <?php if($absen['total_hour'] == null) : ?>
                                                    -
                                                <?php else:?>
                                                    <?= $absen['total_hour'] ?>
                                                <?php endif; ?>
                                            </td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if($absen['presence'] == 1 ): ?>
                                                    <span class="badge badge-soft-success">
                                                        <span>
                                                            <span class="icon fs-8">
                                                                <i class="icon dripicons-graph-line"></i>
                                                            </span>
                                                            Masuk
                                                        </span>
                                                    </span>
                                                <?php elseif($absen['presence'] == 2): ?>
                                                    <span class="badge badge-soft-info">
                                                        <span>
                                                            <span class="icon fs-8">
                                                                <i class="icon dripicons-direction"></i>
                                                            </span>
                                                            Izin
                                                        </span>
                                                    </span>
                                                <?php else :?>
                                                    <span class="badge badge-soft-danger">
                                                        <span>
                                                            <span class="icon fs-8">
                                                                <i class="icon dripicons-pulse"></i>
                                                            </span>
                                                            Sakit
                                                        </span>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
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
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Absensi Manual</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="absensi" class="form-floating" action="<?= base_url('absensi/check_in_manual')?>">
                <div class="modal-body">
                    <div id="errors" style="display: none;"></div>

                    <ul class="nav nav-justified nav-light nav-tabs nav-segmented-tabs fs-7">
                        <li class="nav-item">
                            <a class="nav-link active tab-absensi" data-bs-toggle="tab" href="#tab_masuk">
                                <span class="nav-link-text">Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab-absensi" data-bs-toggle="tab" href="#tab_keluar">
                                <span class="nav-link-text">Keluar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab_masuk">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="fs-8 mb-1">Pilih Karyawan
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <select id="select-in" class="form-select" name="select_name">
                                        <option value="0" hidden>Choose...</option>
                                        <?php foreach($list_employee as $employee) :?>
                                            <option value="<?= $employee['employee_id'] ?>" ><?= $employee['full_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="fs-8 mb-1">Tanggal & Jam Masuk
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="clock-in" type="text" name="clock_in" class="form-control date">
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_keluar">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="fs-8 mb-1">Pilih Karyawan
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <select id="select-out" class="form-select">
                                        <option value="0" hidden>Choose...</option>
                                        <?php foreach($list_employee as $employee) :?>
                                            <option value="<?= $employee['employee_id'] ?>" ><?= $employee['full_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="fs-8 mb-1">Tanggal & Jam Keluar
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="clock-out" type="text" class="form-control date">
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <input id="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fs-7">Absen Karyawan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

    <!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>
<!-- Daterangepicker JS -->
<script src="<?= base_url()?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>

<script>
    $(document).ready( function () {
        $('#table-absensi').DataTable({
            // pageLength: 1,
            // order: [1, 'desc'],
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
    });

</script>

<?php if($this->session->userdata('role_id') == 2) : ?>
<script>
    $(document).ready(function () {
        $('.date').daterangepicker({
            timePicker: true,
            timePicker24Hour:true,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: <?= date('Y', strtotime('-1 year')) ?>,
            maxYear: <?= date('Y', strtotime('+1 year')) ?>,
            "cancelClass": "btn-soft-dark",
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });

        $(document).on('click', '.tab-absensi', function(e){
            if ($(this).attr('href') == '#tab_masuk') {
                $('#select-out').removeAttr('name')
                $('#clock-out').removeAttr('name')

                $('#select-in').attr('name','select_name')
                $('#clock-in').attr('name', 'clock_in')
                $('form#absensi').attr('action', '<?= base_url('absensi/check_in_manual') ?>')
            } else {
                $('#select-in').removeAttr('name')
                $('#clock-in').removeAttr('name')
                
                $('form#absensi').attr('action', '<?= base_url('absensi/check_out_manual') ?>')
                $('#select-out').attr('name','select_name')
                $('#clock-out').attr('name', 'clock_out')
            }
        })

        $(document).on('submit','#absensi',function (e) { 
            e.preventDefault();
            const url = $(this).attr('action')
            let data = $(this).serialize();
            console.log(data)
            
            $.ajax({
                type: "POST",
                url: url, 
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.errors) {
                        $('#errors').html(response.desc).show()
                        $('#csrf').val(response.csrfhash)
                    }
                    if (response.success) {
                        sweatalert_confirm('success', response)
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
        });

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
    });
</script>
<?php endif; ?>