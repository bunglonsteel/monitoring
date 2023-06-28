<!-- Page Header -->
<div class="hk-pg-header pg-header-wth-tab pt-5 mb-3" style="border-bottom: none;">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $slug ?></li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="d-flex flex-wrap justify-content-between flex-1">
                    <div class="mb-lg-0 mb-2 me-8">
                        <h1 class="pg-title"><?= ucwords($judul) ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Header -->