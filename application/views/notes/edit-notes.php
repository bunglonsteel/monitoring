<!-- Main Content -->
<div class="hk-pg-wrapper pb-0">
    <div class="hk-page-body py-0">
        <div class="blogapp-wrap">
            <div class="blogapp-content" style="padding-left: 0;">
                <div class="blogapp-detail-wrap">
                    <header class="blog-header">
                        <h5 class="mb-0">Tambah Bagian Catatan</h5>
                        <div class="blog-options-wrap">
                            <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover hk-navbar-togglable d-sm-inline-block d-none" 
                            href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Collapse">
                                <span class="btn-icon-wrap">
                                    <span class="feather-icon">
                                        <i data-feather="chevron-up"></i>
                                    </span>
                                    <span class="feather-icon d-none">
                                        <i data-feather="chevron-down"></i>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <!-- <div class="hk-sidebar-togglable"></div> -->
                    </header>

                    <div class="blog-body mt-3">
                        <div data-simplebar class="nicescroll-bar">
                            <div class="container-fluid">
                                <form action="<?= base_url('notes/edit_notes/') ?><?= $notes_edit['notes_id'] ?>" method="POST" class="p-md-2 pt-3 card card-border">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label for="notes_sub_title" class="fs-7 mb-1">Judul
                                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" name="notes_title" class="form-control" value="<?= $notes_edit['notes_title'] ?>" placeholder="Ketikan judul">
                                                    </div>
                                                    <?= form_error('notes_title', '<small class="invalid-feedback d-block fs-8">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="fs-7 mb-1">Pilih Untuk Client
                                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                    </label>
                                                    <select id="notes-client" class="form-select" name="notes_client">
                                                        <option value="0" hidden>Choose..</option>
                                                        <?php foreach ($notes_client as $client) :?>
                                                                <option value="<?= $client['notes_client_id'] ?>">
                                                                    <?= $client['notes_client'] ?>
                                                                </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= form_error('notes_client', '<small class="invalid-feedback d-block fs-8">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="fs-7 mb-1">Tipe Kategori
                                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                    </label>
                                                    <select id="notes-category" class="form-select" name="notes_category">
                                                        <option value="0" hidden>Choose..</option>
                                                        <?php foreach ($notes_category as $category) :?>
                                                            <option value="<?= $category['notes_category_id'] ?>">
                                                                <?= $category['notes_category_name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= form_error('notes_category', '<small class="invalid-feedback d-block fs-8">', '</small>'); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="fs-7 mb-1">Status
                                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                                                    </label>
                                                    <select id="notes-status" class="form-select" name="notes_status">
                                                        <option value="0" hidden>Choose..</option>
                                                        <option value="1">Simpan Draft</option>
                                                        <option value="2">Terbitkan</option>
                                                        <option value="3">Nonaktifkan</option>
                                                    </select>
                                                    <?= form_error('notes_status', '<small class="invalid-feedback d-block fs-8">', '</small>'); ?>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="fs-7 mb-1">Isi Catatan
                                                        <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span> |

                                                        <small>Max-upload Image 1Mb</small>
                                                    </label>
                                                    <textarea id="summernote" name="notes_content" ><?= $notes_edit['notes_content'] ?></textarea>
                                                </div>
                                                <input id="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                                                <div class="d-flex justify-content-between">
                                                    <a href="<?= base_url('notes') ?>" class="btn btn-soft-secondary fs-7" type="submit">
                                                        <span>
                                                            <span class="icon">
                                                                <span class="feather-icon">
                                                                    <i data-feather="arrow-left"></i>
                                                                </span>
                                                            </span>
                                                            <span class="btn-text">Kembali</span>
                                                        </span>
                                                    </a>
                                                    <div class="d-flex">
                                                        <button class="btn btn-primary fs-7" type="submit">
                                                            <span>
                                                                <span class="icon">
                                                                    <span class="feather-icon">
                                                                        <i data-feather="save"></i>
                                                                    </span>
                                                                </span>
                                                                <span class="btn-text">Update</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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

<script src="<?= base_url()?>public/assets/vendors/summernote/summernote-lite.js"></script>

<script>
    $(document).ready(function () {
        const notesClient = '<?= $notes_edit['notes_client_id'] ?>';
        const notesCat = '<?= $notes_edit['notes_category_id'] ?>';
        const notesStat = '<?= $notes_edit['notes_status'] ?>';

        if(notesClient != ''){
            $('#notes-client').val(notesClient).change()
        }
        if(notesCat != ''){
            $('#notes-category').val(notesCat).change()
        }

        if(notesStat == 'DRF'){
            $('#notes-status').val(1).change()
        } else if(notesStat == 'PUB'){
            $('#notes-status').val(2).change()
        } else {
            $('#notes-status').val(3).change()
        }

    });

    $('#summernote').summernote({
        placeholder: 'Ketikan catatan disini..',
        codeviewIframeFilter: true,
        disableDragAndDrop: true,
        height: 250,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['picture','link']],
            ['view', ['codeview','help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    $.upload(files[i]);
                }
            },
            onMediaDelete: function(target) {
                $.delete(target[0].src);
            }
        },
    });

    $.upload = function(file) {
        let data = new FormData();
        data.append('file', file, file.name);
        data.append($('#csrf').attr('name'), $('#csrf').val());

        for (var pair of data.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        // console.log(data.entries())
        $.ajax({
            method: 'POST',
            url: '<?= base_url('notes/upload_image_summernote') ?>',
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(res) {

                eval('var response='+res);

                if (response.error) {
                    Swal.fire({
                        html:
                        `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                            <span class="initial-wrap rounded-8">
                                😣
                            </span>
                        </div>
                        <div>
                            <h5 class="text-dark fw-bold">Gagal Upload</h5>
                            <p class="fs-7 mt-2">${response.data}</p>
                        </div>`,
                        customClass: {
                            content: 'p-3 text-center',
                            confirmButton: 'btn btn-primary fs-7',
                            actions: 'justify-content-center mt-1',
                        },
                        width: 300,
                        confirmButtonText: 'Ok, tutup',
                        buttonsStyling: false,
                    })
                    $('#csrf').val(response.csrfHash)
                }

                if (response.success) {
                    $('#summernote').summernote('insertImage', response.data);
                    $('#csrf').val(response.csrfHash)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };

    $.delete = function(src) {
        $.ajax({
            method: 'POST',
            url: '<?= base_url('notes/delete_image_summernote') ?>',
            cache: false,
            data: {src:src, [$('#csrf').attr('name')]:$('#csrf').val()},
            success: function(res) {
                eval('var response='+res);
                if (response.success) {
                    $('#csrf').val(response.csrfHash)
                }
            }
        });
    };

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
        })
    }
</script>