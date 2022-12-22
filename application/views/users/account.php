<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="hk-pg-body">
        <div class="container-xxl">
            <div class="profile-wrap">
                <div class="profile-img-wrap">
                    <img class="img-fluid rounded-5" src="<?= base_url() ?>public/image/background/profile-bg.jpg" alt="Image Description">
                </div>
                <div class="profile-intro">
                    <div class="card card-flush bg-transparent">
                        <div class="card-body mw-400p">
                            <div class="avatar avatar-xxl avatar-rounded position-relative mb-2">
                                <img src="<?= base_url() ?>public/image/users/<?= $employee['image_profile'] ?>" alt="user" class="avatar-img border border-4 border-white" style="background: #f9f9f9;">
                                <span class="badge badge-indicator badge-success badge-indicator-xl position-bottom-end-overflow-1 me-1"></span>
                            </div>
                            <h4><?= $employee['full_name'] ?>
                                <i class="bi-check-circle-fill fs-6 text-primary"></i>
                            </h4>
                            <p class="fs-7">
                                <?= $employee['bio'] ?>
                            </p>
                            <ul class="list-inline fs-7 mt-2 mb-0">
                                <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                                    <i class="bi bi-briefcase me-1"></i>
                                    <a href="javascript:void(0);"><?= $department['name_department'] ?></a>
                                </li>
                                <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                                    <i class="bi bi-envelope me-1"></i>
                                    <a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <form id="update-image" method="post" enctype="multipart/form-data">
                            <input id="image-upload" type="file" name="image_profile" class="dropify" />
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                            <button type="submit" class="btn btn-primary fs-7 mt-2 btn-block my-3">Ganti foto</button>
                        </form>
                    </div>

                    <div class="col-md-8">
                        <form id="update-informasi" action="<?= base_url() ?>account/update_information/<?= $employee['employee_id'] ?>" method="POST">
                            <div class="row g-2">
                                <div id="notif-information" style="display:none;"></div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Nama
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="user"></i>
                                                </span>
                                            </span>
                                            <input type="text" name="fullname" class="form-control" placeholder="Nama lengkap" value="<?= $employee['full_name'] ?>">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Email
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="mail"></i>
                                                </span>
                                            </span>
                                            <input disabled type="text" class="form-control" placeholder="Alamat email" value="<?= $user['email'] ?>">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">No. Kontak
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="phone"></i>
                                                </span>
                                            </span>
                                            <input type="text" name="contact" class="form-control" placeholder="No. telepon" value="<?= $employee['contact']?>">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jenis" class="fs-8 mb-1">Jenis Kelamin
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <select class="form-select" id="jenis" name="gender">
                                        <option value="0" hidden>Choose...</option>
                                        <option value="1" <?php if($employee['gender']==1) :?> selected <?php endif;?>>Laki-laki</option>
                                        <option value="2" <?php if($employee['gender']==2) :?> selected <?php endif;?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Tanggal lahir
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="calendar"></i>
                                                </span>
                                            </span>
                                            <input id="date-birth" class="form-control" type="text" name="birth" value="<?= $employee['birth_date'] ?>" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jenis" class="fs-8 mb-1">Pendidikan terakhir
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <select class="form-select" name="last_education">
                                        <option value="0" hidden>Choose...</option>
                                        <option value="SD"<?php if($employee['last_education']=='SD') :?> selected <?php endif;?>>SD</option>
                                        <option value="SMP"<?php if($employee['last_education']=='SMP') :?> selected <?php endif;?>>SMP</option>
                                        <option value="SMA"<?php if($employee['last_education']=='SMA') :?> selected <?php endif;?>>SMA/SMK</option>
                                        <option value="SARJANA"<?php if($employee['last_education']=='SARJANA') :?> selected <?php endif;?>>D1-S3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-8 mb-1">Alamat lengkap
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="address" rows="2"><?= $employee['address']?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-8 mb-1">Bio</label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="bio" rows="2"><?= $employee['bio']?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <input id="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                    <button type="submit" class="btn btn-primary fs-7 mt-2">Edit Informasi</button>
                                </div>
                            </div>
                        </form>
                            <div class="col-12">
                                <div class="separator"></div>
                            </div>
                        <form id="update-password" action="<?= base_url() ?>account/update_password/<?= $user['user_id'] ?>" method="POST">
                            <div class="row g-2">
                                <div id="notif-password" style="display:none;"></div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Password Lama
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="lock"></i>
                                                </span>
                                            </span>
                                            <input type="password" name="oldpassword" class="form-control" placeholder="Password lama">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Password Baru
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="key"></i>
                                                </span>
                                            </span>
                                            <input type="password" name="newpassword" class="form-control" placeholder="Password baru">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-8 mb-1">Ulangi Password Baru
                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-affix-wrapper">
                                            <span class="input-prefix">
                                                <span class="feather-icon">
                                                    <i data-feather="key"></i>
                                                </span>
                                            </span>
                                            <input type="password" name="repassword" class="form-control" placeholder="Ulangi password baru">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                    <button type="submit" class="btn btn-primary fs-7 mt-2">Ubah Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('layout/footer-copyright') ?>
</div>

<!-- Dropify JavaScript -->
<script src="<?= base_url() ?>public/assets/vendors/dropify/dist/js/dropify.min.js"></script>
<!-- Daterangepicker JS -->
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.js"></script>
<script>
    $('.dropify').dropify({
        messages: {
            'default': 'Upload foto',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
        },
    });

    $('#date-birth').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1970,
        maxYear: <?= date('Y') ?>,
        "cancelClass": "btn-soft-dark",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });



    $('#update-informasi').submit(function (e) { 
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
                    if (response.errors) {
                        $('#notif-information').html(response.desc).show()
                        $('#csrf').val(response.csrfhash)
                        $('#csrf').attr('name',response.csrfname)
                    }
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
            return false;
        })

    $('#update-password').submit(function (e) { 
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
                if (response.errors) {
                    $('#notif-password').html(response.desc).show()
                }
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
        return false;
    })

    $('#update-image').submit(function (e) { 
        e.preventDefault()
        const url = '<?= base_url() ?>account/update_image/<?= $employee['employee_id'] ?>';
        const formdata = new FormData(this);
        // console.log(formdata)
        $.ajax({
            type: "POST",
            url: url,
            data: formdata,
            dataType: "json",
            cache: false,
            processData: false,
            contentType: false,
            success: function(response){
                if (response.error) {
                    // console.log(response)
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
</script>