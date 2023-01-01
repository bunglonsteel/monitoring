<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">
        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua Client</h6>
                            <div class="card-action-wrap">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-client">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Client</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                            <table id="table-notes-section" class="table nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Catatan Client</th>
                                        <th>Catatan Standar</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; foreach ($notes_client as $client) :?>
                                    <tr class="fs-7">
                                        <td><?= $no++ ?>.</td>
                                        <td><?= $client['notes_client'] ?></td>
                                        <td>
                                            <?php if($no % 2 == 0) : ?>
                                                <span class="badge badge-soft-primary"><?= $client['notes_standard'] ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-soft-warning"><?= $client['notes_standard'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn me-2 btn-icon btn-sm btn-soft-dark flush-soft-hover btn-edit" data-id="<?= $client['notes_client_id'] ?>" data-client="<?= $client['notes_client'] ?>" data-standar="<?= $client['notes_standard_id'] ?>">
                                                <span class="icon fs-8">
                                                    <i class="icon dripicons-pencil"></i>
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover btn-delete" data-id="<?= $client['notes_client_id'] ?>">
                                                <span class="icon fs-8">
                                                    <i class="icon dripicons-trash"></i>
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
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

<!-- Tambah -->
<div class="modal fade" id="modal-tambah-client" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Client</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambah-notes-client" class="form-floating" action="<?= base_url('notes/add_notes_client')?>" method="POST">
                <div class="modal-body">
                    <div id="errors" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="fs-8 mb-2">Nama catatan client
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <input type="text" name="notes_client" class="form-control" placeholder="Ketikan catatan client"></input>
                        </div>

                        <div class="col-6">
                            <label class="fs-8 mb-2">Catatan Standar
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <select class="form-select" name="notes_standard">
                                <option value="0" hidden>Choose..</option>
                                <?php foreach ($notes_standar as $standar) :?>
                                    <option value="<?= $standar['notes_standard_id'] ?>"><?= $standar['notes_standard'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="modal-footer p-2" style="border-top: none ;">
                        <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary fs-7">Tambah</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Client</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-notes-client" class="form-floating" action="<?= base_url('notes/edit_client')?>">
                <div class="modal-body">
                    <div id="errors-e" style="display: none;"></div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="fs-8 mb-2">Nama catatan client
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <input id="notes-client" type="text" name="notes_client" class="form-control" placeholder="Ketikan catatan client"></input>
                        </div>

                        <div class="col-6">
                            <label class="fs-8 mb-2">Catatan Standar
                                <span class="badge badge-danger mb-1 badge-indicator-processing badge-indicator"></span>
                            </label>
                            <select id="notes-standard" class="form-select" name="notes_standard">
                                <option value="0" hidden>Choose..</option>
                                <?php foreach ($notes_standar as $standar) :?>
                                    <option value="<?= $standar['notes_standard_id'] ?>"><?= $standar['notes_standard'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2" style="border-top: none ;">
                    <input id="client-id" type="hidden" name="client_id">
                    <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <button type="button" class="btn btn-soft-dark fs-7" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fs-7">Edit acara</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Data Table JS -->
<script src="<?= base_url()?>public/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url()?>public/assets/vendors/datatables.net-select/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function () {

        $('#table-notes-section').DataTable({
            // pageLength: 1,
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

        $('#tambah-notes-client').submit(function (e) { 
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

        $('#update-notes-client').submit(function(e){
            e.preventDefault()
            const url = $(this).attr('action')
            // console.log($(this).serialize())
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                dataType: "json",  
                cache: false,
                success: function(response){
                    if (response.success) {
                        sweatalert_confirm('success', response)
                    }
                    if (response.errors) {
                        $('#errors-e').html(response.desc).show()
                        $('.csrf').val(response.csrfHash)
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

        $(document).on('click', '.btn-edit', function(e){
            e.preventDefault()
            $('#modal-edit').modal('show')

            const clientId = $(this).data('id')
            const client = $(this).data('client')
            const standard = $(this).data('standar')
            // console.log(standard)

            
            $('#modal-edit #client-id').val(clientId)
            $('#modal-edit #notes-client').val(client)
            $('#modal-edit #notes-standard').val(standard).change()
            
        })

        $(document).on('click', '.btn-delete', function (e) { 
            e.preventDefault()
            const id = $(this).data('id')
            const url = `<?= base_url('notes/delete_notes_client/') ?>${id}`
            const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
            console.log(url)
            Swal.fire({
                html:
                `<div class="avatar avatar-icon avatar-soft-danger mb-3">
                    <span class="initial-wrap rounded-8">
                        <i class="icon dripicons-trash" style="line-height:0;"></i>
                    </span>
                </div>
                <div>
                    <h5 class="text-dark">Hapus</h5>
                    <p class="fs-7 mt-2">Anda yakin ingin menghapus bagian catatan ini?</p>
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