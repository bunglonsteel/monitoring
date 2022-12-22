<!-- Top Navbar -->
<nav class="hk-navbar navbar navbar-expand-xl navbar-light fixed-top">
    <div class="container-fluid">
        <!-- Start Nav -->
        <div class="nav-start-wrap">
            <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle d-xl-none">
                <span class="icon">
                    <span class="feather-icon">
                        <i data-feather="menu"></i>
                    </span>
                </span>
            </button>

            <div class="d-flex flex-column clock-head ms-2 ms-md-1 ms-lg-0">
                <span class="clock-head-date"></span>
                <span class="clock-head-hour">-</span>
            </div>
        </div>
        <!-- /Start Nav -->

        <!-- End Nav -->
        <div class="nav-end-wrap">
            <ul class="navbar-nav flex-row">
                <!-- <li class="nav-item">
                    <a href="email.html" class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover">
                        <span class="icon"><span class=" position-relative">
                                <span class="feather-icon"><i data-feather="inbox"></i></span><span
                                    class="badge badge-sm badge-soft-primary badge-sm badge-pill position-top-end-overflow-1">4</span></span></span></a>
                </li> -->
                <li class="nav-item">
                    <div class="dropdown ps-2">
                        <a class=" dropdown-toggle no-caret" href="#" role="button" data-bs-display="static"
                            data-bs-toggle="dropdown" data-dropdown-animation data-bs-auto-close="outside"
                            aria-expanded="false">
                            <div class="media-head me-2">
                                <?php if($this->session->userdata('role_id')==2) : ?>
                                <div class="avatar avatar-primary avatar-rounded" style="height:2.5rem; width:2.5rem;">
                                    <span class="initial-wrap fs-7">AR</span>
                                </div>
                                <?php else : ?>
                                <div class="avatar avatar-rounded avatar-xs">
                                    <img src="<?= base_url() ?>public/image/users/<?= $employee['image_profile']?>" alt="user" class="avatar-img">
                                </div>
                                <?php endif;?>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 15rem;">
                            <div class="p-2">
                                <div class="media">
                                    <div class="media-head me-2">
                                        <div class="avatar avatar-primary avatar-sm avatar-rounded">
                                            <?php if($this->session->userdata('role_id')== 2) : ?>
                                                <span class="initial-wrap">AR</span>
                                            <?php else : ?>
                                                <span id="name" class="initial-wrap"></span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                            <?php if($this->session->userdata('role_id')==2) : ?>
                                                <span class="d-block link-dark fw-medium">Administrator</span>
                                            <?php else : ?>
                                                <span class="d-block link-dark fw-medium"><?= $employee['full_name']?></span>
                                            <?php endif;?>
                                        <div class="fs-7"><?= $this->session->userdata('email')?></div>
                                        <!-- <a href="#" class="d-block fs-8 link-secondary"><u>Sign Out</u></a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                                <?php if($this->session->userdata('role_id')==2) : ?>
                                <a class="dropdown-item" href="<?= base_url('settings') ?>">Pengaturan</a>
                                <?php else : ?>
                                    <a class="dropdown-item" href="<?= base_url('account') ?>">Akun saya</a>
                                <?php endif;?>
                            <a class="dropdown-item" href="<?= base_url('absensi') ?>">Absensi</a>
                            <h6 class="dropdown-header">Ingin mengakhiri ?</h6>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <span class="dropdown-icon feather-icon">
                                    <i data-feather="log-out"></i>
                                </span>
                                <span>Sign out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /End Nav -->
    </div>
</nav>
<!-- /Top Navbar -->