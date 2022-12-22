<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">
        <?php $this->load->view('layout/breadcrumbs') ?>

        <div class="hk-page-body">
            <div class="row">
                <div class="col-md-12 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6 id="tambah">Semua Catatan Bagian</h6>
                            <div class="card-action-wrap">
                                <a href="<?= base_url('notes/add_notes_section') ?>" class="btn btn-sm btn-primary">
                                    <span>
                                        <span class="icon">
                                            <span class="feather-icon">
                                                <i data-feather="plus"></i>
                                            </span>
                                        </span>
                                        <span class="btn-text">Bagian Catatan</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-3 pt-4">
                            <div class="contact-list-view">
                            <table id="table-notes-section" class="table nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Induk Catatan</th>
                                        <th>Bagian judul catatan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <?php $no = 1; foreach ($notes_section as $section) :?>
                                    <tr class="fs-7">
                                        <td>
                                            <span class="badge badge-soft-primary"><?= date('M Y', strtotime($section['notes_section_date'])) ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small>
                                                    <?php if($section['notes_category'] == 'GR') :?>
                                                        <span class="text-violet">General</span>
                                                    <?php elseif($section['notes_category'] == 'JR') : ?>
                                                        <span class="text-warning">Junior St</span>
                                                    <?php else : ?>
                                                        <span class="text-primary">Superior St</span>
                                                    <?php endif;?>
                                                </small>
                                                <small>( <?= $section['notes_loc'] ?> ) - <?= $section['notes_title'] ?></small>
                                            </div>
                                        </td>
                                        <td><?= $section['notes_section_title'] ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('notes/edit_notes_section') ?>" class="btn me-2 btn-icon btn-sm btn-soft-dark flush-soft-hover btn-edit">
                                                <span class="icon">
                                                    <span class="feather-icon">
                                                        <i data-feather="edit"></i>
                                                    </span>
                                                </span>
                                            </a>
                                            <button type="button" class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover btn-delete" data-id="<?= $section['notes_section_id'] ?>">
                                                <span class="icon">
                                                    <span class="feather-icon">
                                                        <i data-feather="trash"></i>
                                                    </span>
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

        $('.btn-delete').click(function (e) { 
            e.preventDefault()
            const id = $(this).data('id')
            const url = `<?= base_url('notes/delete_notes_section/') ?>${id}`
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