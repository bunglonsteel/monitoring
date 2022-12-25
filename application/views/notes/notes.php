<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">
        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua Catatan</h6>
                            <?php if($this->session->userdata('role_id') == 2) : ?>
                            <div class="card-action-wrap">
                                <a href="<?= base_url('notes/add_notes') ?>" class="btn btn-sm btn-primary me-2">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Catatan</span>
                                    </span>
                                </a>
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <?= $this->session->flashdata('message'); ?>
                            <div class="contact-list-view">
                                <table id="table-notes" class="table nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Catatan Client</th>
                                            <th>Catatan judul</th>
                                            <th>Catatan Kategori</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                            <th class="text-center">Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($notes as $note) :?>
                                            <tr class="fs-7">
                                                <td><?= $no++ ?>.</td>
                                                <td><?= $note['notes_client'] ?></td>
                                                <td><?= $note['notes_title'] ?></td>
                                                <td>
                                                    <span class="badge badge-soft-primary"><?= $note['notes_category_name'] ?></span>
                                                </td>
                                                <td>
                                                    <?php if( $note['notes_status'] == 'PUB') :?>
                                                        <span class="badge badge-soft-success">Diterbitkan</span>
                                                    <?php elseif($note['notes_status'] == 'DRF') :?>
                                                        <span class="badge badge-soft-info">Draf</span>
                                                    <?php else :?>
                                                        <span class="badge badge-soft-danger">Dinonaktifkan</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('notes/detail/') ?><?= $note['notes_id'] ?>" class="btn btn-sm btn-soft-dark flush-soft-hover">
                                                        <span class="fs-8">
                                                            <span class="icon me-1">
                                                                <span class="feather-icon">
                                                                    <i data-feather="eye"></i>
                                                                </span>
                                                            </span>
                                                            <span>Lihat</span>
                                                        </span>
                                                    </a>
                                                </td>
                                                <?php if($this->session->userdata('role_id') == 2) : ?>
                                                <td class="text-center">
                                                    <a href="<?= base_url('notes/edit_notes/') ?><?= $note['notes_id'] ?>" class="btn me-2 btn-icon btn-sm btn-soft-dark flush-soft-hover">
                                                        <span class="icon">
                                                            <span class="feather-icon">
                                                                <i data-feather="edit"></i>
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <button class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover btn-delete" type="button" data-id="<?= $note['notes_id'] ?>">
                                                        <span class="icon">
                                                            <span class="feather-icon">
                                                                <i data-feather="trash"></i>
                                                            </span>
                                                        </span>
                                                    </button>
                                                </td>
                                                <?php endif; ?>
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
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>

<!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {

        $('#table-notes').DataTable({
            // pageLength: 8,
            order: [3, 'asc'],
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

        $('#tambah-notes').submit(function (e) { 
            // console.log('fsdfs')
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
                        $('#errors').html(response.desc).show()
                        $('.csrf').val(response.csrfHash)
                    }
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
        })

        $(document).on('click','.btn-delete', function (e) { 
            e.preventDefault()
            const id = $(this).data('id')
            const url = `<?= base_url('notes/delete_notes/') ?>${id}`
            const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
            // console.log(url)
            Swal.fire({
                html:
                `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus catatan ini?</p>
                </div>`,
                customClass: {
                    content: 'p-3 text-center',
                    confirmButton: 'btn btn-danger fs-7',
                    actions: 'justify-content-center mt-1 p-0',
                    cancelButton:'btn btn-soft-dark fs-7 me-2'
                },
                width: 300,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tutup',
                reverseButtons:true,
                showCancelButton: true,
                buttonsStyling: false,
            }).then((r)=>{
                if(r.value){
                    $.ajax({
                        type: "POST",
                        url: url, 
                        data: {[csrfName] : csrfHash},
                        dataType: "json",  
                        cache: false,
                        success: function(response){
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
                }
            })
            return false;
        })

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