<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>
        
        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua list kebersihan</h6>
                            <div class="card-action-wrap">
                                <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#modal">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Kebersihan</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                            <table id="table-cleanliness" class="table nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama kebersihan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($list_cleanliness as $clean) : ?>
                                        <tr class="fs-7">
                                            <td><?= $no++ ?>.</td>
                                            <td><?= $clean['cleanliness_name'] ?></td>
                                            <td class="text-center">
                                                <button class="btn me-2 btn-icon btn-sm btn-soft-dark flush-soft-hover btn-edit" type="button" data-id="<?= $clean['cleanliness_id'] ?>" data-name="<?= $clean['cleanliness_name'] ?>" data-bs-toggle="modal" data-bs-target="#modal-edit">
                                                    <span class="icon">
                                                        <i class="icon dripicons-pencil"></i>
                                                    </span>
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover btn-delete" type="button" data-id="<?= $clean['cleanliness_id'] ?>">
                                                    <span class="icon">
                                                        <span class="icon">
                                                            <i class="icon dripicons-trash"></i>
                                                        </span>
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
            
        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Kebersihan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error-add" style="display: none;"></div>
                <form id="tambah-kebersihan" class="form-floating" action="<?= base_url('cleanliness/add_cleanliness')?>">
                        <input type="text" class="form-control" name="cleanliness_name">
                        <label >Nama kebersihan <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i></label>
                    </div>
                    <div class="modal-footer p-2" style="border-top: none ;">
                        <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary fs-7">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Kebersihan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error-edit" style="display: none;"></div>
                <form id="edit-kebersihan" class="form-floating">
                        <input type="text" class="form-control" id="cleanliness-name" name="cleanliness_name">
                        <label >Nama kebersihan <i class="badge badge-danger badge-indicator badge-indicator-processing mb-2"></i></label>
                    </div>
                    <div class="modal-footer p-2" style="border-top: none ;">
                        <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary fs-7">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function () {
        $('#table-cleanliness').DataTable({
            pageLength: 5,
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

        $(document).on('click','.btn-edit', function(e){
            e.preventDefault()
            const id = $(this).data('id')
            const name = $(this).data('name')
            $('#edit-kebersihan').attr('action', `<?= base_url('cleanliness/edit_cleanliness/') ?>${id}`)
            $('#cleanliness-name').val(name)
            return false;
        })

        $(document).on('click','.btn-delete', function(e){
            e.preventDefault()
            const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
            const target = $(this).data('id')

            Swal.fire({
                html:
                `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian ini?</p>
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
                        url: '<?= base_url('cleanliness/delete_cleanliness/') ?>' + target, 
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

        $('#tambah-kebersihan').submit(function (e) { 
            e.preventDefault()
            const url = $(this).attr('action');

            $.ajax({
                type: "POST",
                url: url, 
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.error) {
                        $('#error-add').html(response.desc).show()
                        $('.csrf').val(response.csrfHash)
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

        $('#edit-kebersihan').submit(function (e) { 
            e.preventDefault()
            const url = $(this).attr('action');

            $.ajax({
                type: "POST",
                url: url, 
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.errors) {
                        $('#error-edit').html(response.desc).show()
                        $('.csrf').val(response.csrfHash)
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

