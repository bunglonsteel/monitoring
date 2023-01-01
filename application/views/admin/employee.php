<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua Karyawan
                                <span class="badge badge-sm badge-light ms-1"><?= count($list_employee)?></span>
                            </h6>
                            <div class="card-action-wrap">
                                <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#modal">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Karyawan</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                                <table id="table-karyawan" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Department / bagian</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Gabung</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list_employee as $emp) :?>
                                        <tr class="fs-7">
                                            <td>
                                                <div class="media align-items-center">
                                                    <div class="media-head me-2">
                                                        <div class="avatar avatar-xs avatar-rounded">
                                                            <img src="<?= base_url()?>public/image/users/<?= $emp['image_profile'] ?>" alt="user" class="avatar-img">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-high-em"><?= $emp['full_name'] ?></div> 
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                            <!-- <select class="form-control select2">
                                                <option>Select</option>
                                            </select> -->
                                                <!-- <button type="button" class="btn fs-8 btn-soft-dark"> -->
                                                <?= $emp['name_department'] ?> 
                                                    <!-- <span class="badge badge-sm badge-light">
                                                        <span class="feather-icon">
                                                            <i data-feather="edit-3"></i>
                                                        </span>
                                                    </span>
                                                </button> -->
                                            </td>
                                            <td>
                                                <?php if($emp['gender'] == 1) :?>
                                                    <span class="badge badge-soft-success">
                                                    👨‍🦰 Laki-laki
                                                    </span>
                                                <?php else : ?>
                                                    <span class="badge badge-soft-warning">
                                                    👱‍♀️ Perempuan
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d M Y', strtotime($emp['join_date'])) ?></td>
                                            <td>
                                                <div class="dropdown me-1">
                                                    <?php if($emp['is_active'] == 1) :?>
                                                        <span class="badge badge-soft-success dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" style="cursor: pointer;">
                                                            Aktif
                                                        </span>
                                                    <?php else : ?>
                                                        <span class="badge badge-soft-danger dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" style="cursor: pointer;">
                                                            Nonaktif
                                                        </span>
                                                    <?php endif; ?>
                                                    <div role="menu" class="dropdown-menu" style="padding: 0;min-width:0; background:transparent;">
                                                        <?php if($emp['is_active'] == 1) :?>
                                                            <span class="badge badge-soft-danger btn-activation" style="cursor: pointer; border:1px solid;" data-active="0" data-userid="<?= $emp['user_id'] ?>">
                                                                Nonaktifkan
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="badge badge-soft-success btn-activation" style="cursor: pointer; border:1px solid;" data-active="1" data-userid="<?= $emp['user_id'] ?>">
                                                                Aktifkan
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button data-employee="<?= $emp['employee_id'] ?>" class="btn btn-sm btn-soft-dark flush-soft-hover mx-auto drawer-toggle-link show-profile" data-target="#drawer_push"  data-drawer="push-normal" type="button">
                                                    <span class="fs-8">
                                                        <span class="icon fs-8">
                                                            <i class="icon dripicons-preview"></i>
                                                        </span>
                                                        <span>Lihat</span>
                                                    </span>
                                                </button>
                                            </td>
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

        
        <div id="drawer_push" class="hk-drawer drawer-small drawer-right"></div>
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Karyawan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambah-karyawan" class="form-floating" action="<?= base_url('employee/add_employee')?>" method="POST">
                <div class="modal-body">
                    <div id="error-notif" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="fullname" class="fs-8 mb-1">Nama
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="user"></i>
                                        </span>
                                    </span>
                                    <input id="fullname" type="text" name="fullname" class="form-control" placeholder="Nama lengkap">
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="email" class="fs-8 mb-1">Email
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="mail"></i>
                                        </span>
                                    </span>
                                    <input id="email" type="email" name="email" class="form-control" placeholder="Alamat email">
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="department" class="fs-8 mb-1">Department / Bagian
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <select class="form-select" id="department" name="department">
                                <option value="0" hidden>Choose...</option>
                                <?php foreach ($department as $bagian) :?>
                                    <option value="<?= $bagian['department_id'] ?>"><?= $bagian['name_department'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-6">
                            <label for="jenis" class="fs-8 mb-1">Jenis Kelamin
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <select class="form-select" id="jenis" name="gender">
                                <option value="0" hidden>Choose...</option>
                                <option value="1">Laki-laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                        <div class="separator separator-light mb-1"></div>
                        <div class="col-6">
                            <label for="newpassword" class="fs-8 mb-1">Password
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="lock"></i>
                                        </span>
                                    </span>
                                    <input id="newpassword" type="password" name="newpassword" class="form-control" placeholder="Password">
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="repassword" class="fs-8 mb-1">Ulangi password
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-affix-wrapper">
                                    <span class="input-prefix">
                                        <span class="feather-icon">
                                            <i data-feather="key"></i>
                                        </span>
                                    </span>
                                    <input id="repassword" type="password" name="repassword" class="form-control" placeholder="Ulangi password">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="modal-footer p-2" style="border-top: none ;">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary fs-7">Tambah</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>
<!-- Sweetalert JS -->
<script src="<?= base_url()?>public/assets/vendors/sweetalert2/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function () {

        $('#table-karyawan').DataTable({
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

        $('#tambah-karyawan').submit(function (e) { 
            e.preventDefault()
            const url = $(this).attr('action')
            $.ajax({
                type: "POST",
                url: url, 
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.errors) {
                        $('#error-notif').html(response.desc).show()
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
            return false;
        })

        const csrfName = '<?= $this->security->get_csrf_token_name()?>'
        let csrfHash = '<?= $this->security->get_csrf_hash()?>'
        $(document).on('click', '.show-profile', function(e){
            const employeeId = $(this).data('employee');
            const url = '<?= base_url('employee/show_profile/') ?>'+employeeId;

            $.ajax({
                type: "POST",
                url: url, 
                data: {[csrfName] : csrfHash},
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response) {
                        csrfHash = response.csrf_hash
                        showprofile(response);
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

        $(document).on('click', '.btn-activation', function(e){
            const userId = $(this).data('userid');
            const is_active = $(this).data('active');
            const url = '<?= base_url('employee/activation/') ?>'+userId+'/'+is_active;
            const csrfName = '<?= $this->security->get_csrf_token_name()?>'
            const csrfHash = '<?= $this->security->get_csrf_hash()?>'
            // console.log(url)
            $.ajax({
                type: "POST",
                url: url, 
                data: {[csrfName] : csrfHash},
                dataType: "json",  
                cache: false,
                success: function(response){
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

        $(document).on('submit', '#update-pass', function(e){
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

        function showprofile(res){
            const gender = (res.desc.gender == 1) ? 'Laki-laki' : 'Perempuan';
            const month = ['Januari', 'Februari','Maret','April', 'Mei','Juni','Juli','Agustus','September', 'Oktober', 'November', 'Desember']
            const birth = new Date(res.desc.birth_date);
            const join = new Date(res.desc.join_date);
            const isActive = res.desc.is_active == 1 ? 'badge-success' : 'badge-danger';
            const address = res.desc.address != null ? res.desc.address : '-';
            const contact = res.desc.contact != '' ? res.desc.contact : '-';
            const education = res.desc.last_education != '' ? res.desc.last_education : '-';
            const child = 
            `
                <div class="drawer-header">
                    <div class="drawer-text">Informasi Karyawan</div>
                    <button type="button" class="drawer-close btn-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="drawer-body">
                    <div data-simplebar class="nicescroll-bar">
                        <div class="drawer-content-wrap">
                            <div class="card card-border bg-primary text-white">
                                <div class="card-body">
                                    <div class="avatar avatar-md avatar-rounded">
                                        <img src="<?= base_url() ?>public/image/users/${res.desc.image_profile}" alt="user" class="avatar-img border border-4 border-white" style="background: #f9f9f9;">
                                        <span class="badge badge-indicator ${isActive} badge-indicator-lg position-bottom-end-overflow-1 me-1"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="header-information mb-3">
                                <h5 class="mb-0">${res.desc.full_name}</h5>
                                <small><i class="bi bi-briefcase me-1"></i> ${res.desc.name_department}</small>
                            </div>
                            <div class="body-information">
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Email
                                    </span>
                                    <p class="fs-7">${res.desc.email}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        No. Kontak
                                    </span>
                                    <p class="fs-7">${contact}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Jenis Kelamin
                                    </span>
                                    <p class="fs-7">${gender}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Tanggal lahir
                                    </span>
                                    <p class="fs-7">${birth.getDate()} ${month[birth.getMonth()]} ${birth.getFullYear()}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Pendidikan terakhir
                                    </span>
                                    <p class="fs-7">${education}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Tanggal bergabung
                                    </span>
                                    <p class="fs-7">${join.getDate()} ${month[join.getMonth()]} ${join.getFullYear()}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Alamat
                                    </span>
                                    <p class="fs-7">${address}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="drawer-footer">
                    <form id="update-pass" class="d-flex" action="<?= base_url('employee') ?>/update_pass/${res.desc.user_id}" method="POST">
                        <span class="input-affix-wrapper me-1">
                            <span class="input-prefix">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Password baru">
                        </span>
                        <input type="hidden" name="${res.csrf_name}" value="${res.csrf_hash}" />
                        <button type="submit" class="btn btn-primary fs-7">Ubah</button>
                    </form>
                </div>
            `

            $('#drawer_push').html(child)
        }

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