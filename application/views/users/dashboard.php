<?php

$hour = date("G", time());
$ucapan = '';

if ($hour>=0 && $hour<=11) {
    $ucapan = "Selamat Pagi";
} elseif ($hour >=12 && $hour<=14) {
    $ucapan = "Selamat Siang";
} elseif ($hour >=15 && $hour<=17) {
    $ucapan = "Selamat Sore"; 
} elseif ($hour >=17 && $hour<=18) {
    $ucapan = "Selamat Petang";
} elseif ($hour >=19 && $hour<=23) {
    $ucapan = "Selamat Malam";
}

$disable = $check_absen ? 'disabled' : '';

?>

<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

            <!-- Page Header -->
            <div class="hk-pg-header pg-header-wth-tab pt-5 mb-3" style="border-bottom: none;">
                <div class="row">
                    <div class="col">
                        <div class="d-flex">
                            <div class="d-flex flex-wrap justify-content-between flex-1">
                                <div class="mb-lg-0 mb-2 me-8">
                                    <h1 class="pg-title">Hallo👋, <?=$employee['full_name'] ?></h1>
                                    <p class="fs-7 mb-2">Selamat datang kembali dan <?=$ucapan ?> 😊</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="card card-border h-100 pt-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="text-xs fw-bold text-primary mb-0">
                                        Absensi hari ini
                                    </h5>
                                    <p class="fs-7 mb-3">Silahkan lakukan absensi hari ini.</p>
                                </div>
                                <div class="col-auto">
                                    <i class="icon dripicons-calendar me-4" style="color: #eaeaea; font-size:45px;"></i>
                                </div>
                                <div class="col-12">
                                    <div class="d-block position-relative">
                                        <button <?=$disable ?> type="button" data-employeeid="<?= $employee['employee_id'] ?>" data-kehadiran="1" class="btn btn-sm btn-primary btn-animated mb-1 btn-absen">
                                            <span>
                                                <span class="icon me-1">
                                                    <span class="feather-icon" style="margin-top: 1px;">
                                                        <i data-feather="arrow-up-circle"></i>
                                                    </span>
                                                </span>
                                                Masuk
                                            </span>
                                        </button>
                                        <div class="divider"></div>
                                        <button 
                                            <?php if($check_absen != null && $check_absen['presence'] != 1 || $check_absen != null && $check_absen['clock_out']) :?> <?=$disable ?> <?php endif;?>
                                        type="button" data-employeeid="<?= $employee['employee_id'] ?>" class="btn btn-sm btn-soft-dark mb-1 btn-checkout">
                                            <span>
                                                <span class="icon me-1">
                                                    <span class="feather-icon" style="margin-top: 1px;">
                                                        <i data-feather="arrow-down-circle"></i>
                                                    </span>
                                                </span>
                                                Keluar
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 mb-2">
                        <div class="card-body pt-3 pb-md-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <small>Total per bulan</small>
                                    <h5 class="text-xs fw-bold text-primary mb-0">
                                        Izin
                                    </h5>
                                    <div class="h1 mb-0 fw-bold text-gray-800"><?=$total_izin ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="icon dripicons-direction me-4" style="color: #eaeaea; font-size:45px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 mb-2">
                        <div class="card-body pt-3 pb-md-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <small>Total per bulan</small>
                                    <h5 class="text-xs fw-bold text-primary mb-0">
                                        Sakit
                                    </h5>
                                    <div class="h1 mb-0 fw-bold text-gray-800"><?=$total_sakit ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="icon dripicons-graph-line me-4" style="color: #eaeaea; font-size:45px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Alasan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <input id="input-reason" type="text" class="form-control" id="floatingInputValue" name="reason">
                    <label for="floatingInputValue" >Tambah alasan <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i></label>
                </div>
            </div>
            <div class="modal-footer p-2" style="border-top: none ;">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                <button id="reason" type="button" class="btn btn-primary fs-7 btn-absen" data-employeeid="<?= $employee['employee_id'] ?>" data-kehadiran="1">Kirim</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.btn-sakit-izin').click(function(e){
            $('#reason').data('kehadiran', $(this).data('id'))
        })

        $('.btn-absen').click(function(e){
            e.preventDefault()
            const csrfName   = "<?= $this->security->get_csrf_token_name()?>";
            const csrfHash   = "<?=$this->security->get_csrf_hash()?>";
            const employeeId = $(this).data('employeeid');
            const codeKeh    = $(this).data('kehadiran');
            const url        = `<?= base_url('absensi/check_in/') ?>${employeeId}/${codeKeh}`;
            // console.log(codeKeh)

            $.ajax({
                type: "POST",
                url: url, 
                data: {[csrfName]: csrfHash},
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.error) {
                        sweatalert_confirm('danger', response)
                    }
                    if (response.success) {
                        sweatalert_confirm('success', response)
                    }
                    if (response.warning) {
                        sweatalert_confirm('warning', response)
                    }
                },
                error : function(xhr, status, errorThrown){
                    console.log(xhr.responseText)
                }
            });
            return false;
        });

        $('.btn-checkout').click(function(e){
            e.preventDefault()
            const csrfName   = "<?= $this->security->get_csrf_token_name()?>";
            const csrfHash   = "<?=$this->security->get_csrf_hash()?>";
            const employeeId = $(this).data('employeeid');
            const url        = `<?= base_url('absensi/check_out/') ?>${employeeId}`;

            $.ajax({
                type: "POST",
                url: url, 
                data: {[csrfName]: csrfHash},
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.error) {
                        sweatalert_confirm('danger', response)
                    }
                    if (response.success) {
                        sweatalert_confirm('success', response)
                    }
                    if (response.warning) {
                        sweatalert_confirm('warning', response)
                    }
                },
                error : function(xhr, status, errorThrown){
                    console.log(xhr.responseText)
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
                    <h5 class="text-dark fw-bold">${res.title}</h5>
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