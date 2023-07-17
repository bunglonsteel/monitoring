<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="card card-border h-100 mb-md-0">
                        <div class="card-header">
                            <h6 class="fs-7">Filter laporan</h6>
                        </div>
                        <div class="card-body">
                            <form id="filter-kebersihan" action="<?= base_url('cleanliness/get_laporan') ?>">
                                <div id="filter-bulan">
                                    <label for="jenis" class="fs-8 mb-1">Pilih Bulan
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <select id="select-month" class="form-select mb-2" name="filter_month">
                                        <option value="0" hidden>Choose...</option>
                                        <option value="01-<?= date('Y') ?>"<?php if(1 > date('n')) : ?> disabled <?php endif; ?>>Januari <?= date('Y') ?></option>
                                        <option value="02-<?= date('Y') ?>"<?php if(2 > date('n')) : ?> disabled <?php endif; ?>>Februari <?= date('Y') ?></option>
                                        <option value="03-<?= date('Y') ?>"<?php if(3 > date('n')) : ?> disabled <?php endif; ?>>Maret <?= date('Y') ?></option>
                                        <option value="04-<?= date('Y') ?>"<?php if(4 > date('n')) : ?> disabled <?php endif; ?>>April <?= date('Y') ?></option>
                                        <option value="05-<?= date('Y') ?>"<?php if(5 > date('n')) : ?> disabled <?php endif; ?>>Mei <?= date('Y') ?></option>
                                        <option value="06-<?= date('Y') ?>"<?php if(6 > date('n')) : ?> disabled <?php endif; ?>>Juni <?= date('Y') ?></option>
                                        <option value="07-<?= date('Y') ?>"<?php if(7 > date('n')) : ?> disabled <?php endif; ?>>Juli <?= date('Y') ?></option>
                                        <option value="08-<?= date('Y') ?>"<?php if(8 > date('n')) : ?> disabled <?php endif; ?>>Agustus <?= date('Y') ?></option>
                                        <option value="09-<?= date('Y') ?>"<?php if(9 > date('n')) : ?> disabled <?php endif; ?>>September <?= date('Y') ?></option>
                                        <option value="10-<?= date('Y') ?>"<?php if(10 > date('n')) : ?> disabled <?php endif; ?>>Oktober <?= date('Y') ?></option>
                                        <option value="11-<?= date('Y') ?>"<?php if(11 > date('n')) : ?> disabled <?php endif; ?>>November <?= date('Y') ?></option>
                                        <option value="12-<?= date('Y') ?>"<?php if(12 > date('n')) : ?> disabled <?php endif; ?>>Desember <?= date('Y') ?></option>
                                    </select>
                                </div>
                                <input id="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                <button class="btn btn-primary fs-7 btn-block" type="submit">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="filter"></i>
                                            </span>
                                        </span>
                                        <span>Filter</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row g-2">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Pekerjaan Selesai
                                            </h6>
                                            <div id="finished" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="check-circle" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Wajib dikerjakan
                                            </h6>
                                            <div id="job" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="clipboard" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Tidak mengerjakan
                                            </h6>
                                            <div id="not-doing" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="x-circle" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Belum di nilai
                                            </h6>
                                            <div id="not-yet-rated" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="info" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Sangat Baik
                                            </h6>
                                            <div id="very-good" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="check-circle" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Bagus
                                            </h6>
                                            <div id="good" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="check" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-0">
                                                Perlu ditingkatkan
                                            </h6>
                                            <div id="must-be-improved" class="mb-0 fw-bold text-dark" style="font-size:2.3rem;">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="bar-chart" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="card card-border h-100 pt-2 pb-0">
                                <div class="card-body pt-3 pb-0">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <h6 class="text-xs text-primary mb-3">
                                                Status Penilaian
                                            </h6>
                                            <div id="rating" class="mb-2 fw-bold text-dark">-</div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="feather-icon">
                                                <i data-feather="star" style="color: #eaeaea; font-size:45px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('submit','#filter-kebersihan', function(e){
            e.preventDefault()
            const url = $(this).attr('action')
            $.ajax({
                type: "POST",
                url: url, 
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.success) {
                        $('#finished').text(response.data.finished)
                        $('#job').text(response.data.jobs)
                        $('#not-doing').text(response.data.not_doing)
                        $('#not-yet-rated').text(response.data.not_yet_rated)
                        $('#very-good').text(response.data.very_good)
                        $('#good').text(response.data.good)
                        $('#must-be-improved').text(response.data.must_be_improved)

                        const res_p = response.data.rating
                        const penilaian = (res_p == 3) ? `<span class="badge badge-soft-success">Sangat Baik</span>` : ((res_p == 2) ? `<span class="badge badge-soft-primary">Baik</span>` : `<span class="badge badge-soft-danger">Kurang</span>`)
                        $('#rating').html(penilaian)
                        $('#csrf').val(response.csrfHash)
                    }
                    
                    if (response.error) {
                        sweatalert_confirm('danger', response)
                    }

                    if (response.errors) {
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

        function sweatalert_confirm(type, res){
            let icon;
            let classHeader;
            if (type == 'success') {
                icon = '😍';
                classHeader = 'avatar-soft-success'
            } else if(type == 'danger'){
                icon = '😣';
                classHeader = 'avatar-soft-danger'
            } else if(type == 'warning'){
                icon = '🧐';
                classHeader = 'avatar-soft-warning'
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