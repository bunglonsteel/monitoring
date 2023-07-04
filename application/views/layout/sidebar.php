<!-- Vertical Nav -->
<div class="hk-menu">
    <!-- Brand -->
    <div class="menu-header">
        <span>
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img class="brand-img img-fluid rounded" src="<?= base_url() ?>public/image/default/<?= $settings['logo'] ?>" alt="brand" style="max-height: 35px;" />
                <img class="brand-img img-fluid" src="<?= base_url() ?>public/image/default/<?= $settings['logo_text'] ?>" alt="brand" style="max-height: 15px;" />
            </a>
            <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
                <span class="icon">
                    <span class="svg-icon fs-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="10" y1="12" x2="20" y2="12"></line>
                            <line x1="10" y1="12" x2="14" y2="16"></line>
                            <line x1="10" y1="12" x2="14" y2="8"></line>
                            <line x1="4" y1="4" x2="4" y2="20"></line>
                        </svg>
                    </span>
                </span>
            </button>
        </span>
    </div>
    <!-- /Brand -->

    <!-- Main Menu -->
    <div data-simplebar class="nicescroll-bar">
        <div class="menu-content-wrap">
            <div class="menu-group">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item <?php if ($this->uri->segment(1) == 'dashboard') : ?> active <?php endif; ?>">
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="4" rx="1" />
                                        <rect x="4" y="12" width="6" height="8" rx="1" />
                                        <line x1="14" y1="12" x2="20" y2="12" />
                                        <line x1="14" y1="16" x2="20" y2="16" />
                                        <line x1="14" y1="20" x2="20" y2="20" />
                                    </svg>
                                </span>
                            </span>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($this->uri->segment(1) == 'calendar') : ?> active <?php endif; ?>">
                        <a class="nav-link" href="<?= base_url('calendar') ?>">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i class="form-icon" data-feather="calendar"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Kalendar</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu-gap"></div>
            <div class="menu-group">
                <div class="nav-header">
                    <span>Aktivitas</span>
                </div>
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#absensi">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i class="form-icon" data-feather="clock"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Kehadiran</span>
                        </a>
                        <ul id="absensi" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'absensi') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('absensi') ?>">
                                            <span class="nav-link-text">Kehadiran / absensi</span>
                                        </a>
                                    </li>
                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'laporan') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('laporan') ?>">
                                                <span class="nav-link-text">Laporan Absensi</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#karyawan">
                                <span class="nav-icon-wrap">
                                    <span class="feather-icon">
                                        <i class="form-icon" data-feather="users"></i>
                                    </span>
                                </span>
                                <span class="nav-link-text">Karyawan</span>
                            </a>
                            <ul id="karyawan" class="nav flex-column collapse  nav-children">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'employee') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('employee') ?>">
                                                <span class="nav-link-text">Semua Karyawan</span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'department') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('department') ?>">
                                                <span class="nav-link-text">Department</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#jobs">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i class="form-icon" data-feather="layers"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Pekerjaan</span>
                        </a>
                        <ul id="jobs" class="nav flex-column collapse nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'project') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('project') ?>">
                                            <span class="nav-link-text">Pekerjaan</span>
                                        </a>
                                    </li>
                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'tasks') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('tasks') ?>">
                                            <span class="nav-link-text">Tugas</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'task-categories') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('task-categories') ?>">
                                            <span class="nav-link-text">Tugas Kategori</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item <?php if ($this->uri->segment(1) == 'cuti') : ?> active <?php endif; ?>">
                        <a class="nav-link" href="<?= base_url('cuti') ?>">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i data-feather="send"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Cuti</span>
                            <?php if ($this->session->userdata('role_id') == 2) : ?>
                                <span class="badge badge-primary ms-auto"><?= $count_pending ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cleanliness">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i class="form-icon" data-feather="trash"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Kebersihan</span>
                        </a>
                        <ul id="cleanliness" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'cleanliness-progress') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('cleanliness-progress') ?>">
                                            <span class="nav-link-text">Progress Kebersihan</span>
                                        </a>
                                    </li>
                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'cleanliness') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('cleanliness') ?>">
                                                <span class="nav-link-text">Semua Kebersihan</span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'laporan-kebersihan') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('laporan-kebersihan') ?>">
                                                <span class="nav-link-text">Laporan Kebersihan</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#expenses">
                                <span class="nav-icon-wrap">
                                    <span class="feather-icon">
                                        <i class="form-icon" data-feather="credit-card"></i>
                                    </span>
                                </span>
                                <span class="nav-link-text">Pengeluaran</span>
                            </a>
                            <ul id="expenses" class="nav flex-column collapse  nav-children">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'expenses') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('expenses') ?>">
                                                <span class="nav-link-text">Pengeluaran</span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'expenses-category') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('expenses-category') ?>">
                                                <span class="nav-link-text">Kategori</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="menu-gap"></div>
            <div class="menu-group">
                <div class="nav-header">
                    <span>Lainnya</span>
                </div>
                <ul class="navbar-nav flex-column">
                    <li class="nav-item <?php if ($this->uri->segment(1) == 'events') : ?> active <?php endif; ?>">
                        <a class="nav-link" href="<?= base_url('events') ?>">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i data-feather="image"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Acara</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#catatan">
                            <span class="nav-icon-wrap">
                                <span class="feather-icon">
                                    <i class="form-icon" data-feather="clipboard"></i>
                                </span>
                            </span>
                            <span class="nav-link-text">Catatan</span>
                        </a>
                        <ul id="catatan" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item <?php if ($this->uri->segment(1) == 'notes') : ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?= base_url('notes') ?>">
                                            <span class="nav-link-text">Standar pekerjaan</span>
                                        </a>
                                    </li>
                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'client') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('client') ?>">
                                                <span class="nav-link-text">Catatan Client</span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'notes-standard') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('notes-standard') ?>">
                                                <span class="nav-link-text">Catatan Standard</span>
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if ($this->uri->segment(1) == 'notes-category') : ?> active <?php endif; ?>">
                                            <a class="nav-link" href="<?= base_url('notes-category') ?>">
                                                <span class="nav-link-text">Catatan Kategori</span>
                                            </a>
                                        </li>

                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="menu-gap"></div>
            <div class="menu-group">
                <div class="nav-header">
                    <span>Pengaturan</span>
                </div>
                <ul class="navbar-nav flex-column">
                    <li class="nav-item <?php if ($this->uri->segment(1) == 'settings' || $this->uri->segment(1) == 'account') : ?> active <?php endif; ?>">
                        <a class="nav-link" href="
                        <?php if ($this->session->userdata('role_id') == 2) : ?>
                                <?= base_url('settings') ?>">
                        <?php else : ?>
                            <?= base_url('account') ?>">
                        <?php endif; ?>
                        <span class="nav-icon-wrap">
                            <span class="feather-icon">
                                <i data-feather="settings"></i>
                            </span>
                        </span>
                        <span class="nav-link-text">Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- <div class="callout card card-flush bg-orange-light-5 text-center mt-5 w-220p mx-auto">
                <div class="card-body">
                    <h5 class="h5">Absen hari ini</h5>
                    <p class="p-sm card-text">Anda sudah melakukan absen pada tanggal</p>
                    <a href="https://nubra-ui.hencework.com/" target="_blank"
                        class="btn btn-primary btn-block">12.00 Am</a>
                </div>
            </div> -->
        </div>
    </div>
    <!-- /Main Menu -->
</div>
<div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
<!-- /Vertical Nav -->