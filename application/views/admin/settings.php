<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4 col-md-3">
                            <ul class="nav flex-column nav-light nav-pills nav-vertical">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#situs">
                                        <span class="nav-link-text">Pengaturan Web</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#logo">
                                        <span class="nav-link-text">Logo</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#akun">
                                        <span class="nav-link-text">Akun</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-8 col-md-9">
                            <div id="notif" style="display: none ;"></div>
                            <div class="tab-content mt-0">
                                <div class="tab-pane fade show active" id="situs">
                                    <form id="update-site" action="<?= base_url() ?>settings/update_site" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="fs-8 mb-1">Nama situs
                                                    <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-affix-wrapper">
                                                        <span class="input-prefix">
                                                            <span class="feather-icon">
                                                                <i data-feather="user"></i>
                                                            </span>
                                                        </span>
                                                        <input type="text" name="site_name" class="form-control" placeholder="Masukan nama situs" value="<?= $settings['site_name'] ?>">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="fs-8 mb-1">Judul situs
                                                    <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-affix-wrapper">
                                                        <span class="input-prefix">
                                                            <span class="feather-icon">
                                                                <i data-feather="user"></i>
                                                            </span>
                                                        </span>
                                                        <input type="text" name="site_title" class="form-control" placeholder="Masukan judul" value="<?= $settings['site_title'] ?>">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="fs-8 mb-1">Deskripsi situs
                                                    <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                </label>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="description" rows="3"><?= $settings['description'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                                <button type="submit" class="btn btn-primary fs-7 mt-2 my-3">Update Pengaturan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="logo">
                                    <form id="update-image" action="<?= base_url() ?>settings/update_logo" method="POST">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="file" name="logo" class="dropify" data-default-file="<?= base_url() ?>public/image/default/<?= $settings['logo'] ?>" />
                                                <small>Max upload 1Mb 600x600</small>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" name="logo_text" class="dropify" data-default-file="<?= base_url() ?>public/image/default/<?= $settings['logo_text'] ?>" />
                                                <small>Max upload 1Mb 600x70</small>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" name="favicon" class="dropify" data-default-file="<?= base_url() ?>public/image/default/<?= $settings['favicon'] ?>" />
                                                <small>Max upload 1Mb 600x600</small>
                                            </div>
                                            <div class="col-12 text-end">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                                <button type="submit" class="btn btn-primary fs-7 mt-2 my-3">Update Logo</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="akun">
                                    <form class="update-akun" action="<?= base_url() ?>settings/update_akun/email/<?= $user['user_id'] ?>" method="POST">
                                        <div class="row" style="align-items: flex-end;">
                                            <div class="col-md-8 col-lg-10">
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
                                                        <input type="email" name="email" class="form-control" placeholder="Alamat email" value="<?= $user['email'] ?>">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col text-end">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                                <button type="submit" class="btn btn-primary fs-7 mt-2 my-3 my-md-0">Update email</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="separator"></div>
                                    <form class="update-akun" action="<?= base_url() ?>settings/update_akun/password/<?= $user['user_id'] ?>" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="fs-8 mb-1">Password Baru
                                                    <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-affix-wrapper">
                                                        <span class="input-prefix">
                                                            <span class="feather-icon">
                                                                <i data-feather="lock"></i>
                                                            </span>
                                                        </span>
                                                        <input type="password" name="newpassword" class="form-control" placeholder="Password baru">
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="fs-8 mb-1">Ulangi Password
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
                                                <button type="submit" class="btn btn-primary fs-7 mt-2 my-3">Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>

<!-- Dropify JavaScript -->
<script src="<?= base_url() ?>public/assets/vendors/dropify/dist/js/dropify.min.js"></script>

<script>
        $('.dropify').dropify({
            messages: {
                'default': 'Upload foto',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Ooops, something wrong happended.'
            },
        });

        $('#update-site').submit(function (e) { 
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
                        $('#notif').html(response.desc).show()
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

        $('.update-akun').submit(function (e) { 
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
                        $('#notif').html(response.desc).show()
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
                        $('#notif').html(response.desc).show()
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
        const url = '<?= base_url() ?>settings/update_logo';
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