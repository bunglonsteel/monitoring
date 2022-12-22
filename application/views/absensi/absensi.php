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
                                                            <span class="icon">
                                                                <span class="feather-icon">
                                                                    <i data-feather="zap"></i>
                                                                </span>
                                                            </span>
                                                            Masuk
                                                        </span>
                                                    </span>
                                                <?php elseif($absen['presence'] == 2): ?>
                                                    <span class="badge badge-soft-info">
                                                        <span>
                                                            <span class="icon">
                                                                <span class="feather-icon">
                                                                    <i data-feather="send"></i>
                                                                </span>
                                                            </span>
                                                            Izin
                                                        </span>
                                                    </span>
                                                <?php else :?>
                                                    <span class="badge badge-soft-danger">
                                                        <span>
                                                            <span class="icon">
                                                                <span class="feather-icon">
                                                                    <i data-feather="activity"></i>
                                                                </span>
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

    <!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>

<script>
    $(document).ready( function () {
        var targetElem = $('#table-absensi');
        var targetDt = targetElem.DataTable({
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