<div id="drawer_push" class="hk-drawer drawer-small drawer-right">

</div>

<script>
    $(function () {

        const showDetail = response => {
            const target = $('#drawer_push')
            let categories = ''
            response.categories.forEach(e => {
                categories += `<span class="badge badge-soft-light">${e.name}</span>`
            });

            const review = response.verify_completed == "yes" ? "👍" : response.verify_completed == "no" ? "💪" : '<span class="badge badge-soft-warning">Menunggu...</span>';

            const content = `<div class="drawer-header">
                    <div class="d-flex">
                        <div class="drawer-text">
                            <div class="icon dripicons-checklist" style="line-height:0"></div>
                        </div>
                        <div id="loading" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="drawer-close btn-close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="drawer-body">
                    <div data-simplebar class="nicescroll-bar">
                        <div class="drawer-content-wrap">
                            <h5 class="fw-bold">${response.task_title}</h5>
                            <div class="body-information">
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Item Cek
                                    </span>
                                    <div class="d-flex gap-1 flex-wrap mt-1">
                                        ${categories}
                                    </div>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Tanggal Mulai
                                    </span>
                                    <p class="fs-7">${response.start_date}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Tanggal Berakhir
                                    </span>
                                    <p class="fs-7">${response.due_date}</p>
                                </div>
                                <div class="my-2">
                                    <span class="fs-8 text-primary fw-bold">
                                        Status Tugas
                                    </span>
                                    <p class="fs-7 text-capitalize">${response.status}</p>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Dibuat Oleh
                                    </span>
                                    <div class="mt-1">
                                        <span class="bg-light d-inline-block rounded-pill p-1 pe-3 mr-1 fs-8">
                                            <div class="avatar avatar-rounded avatar-xxs">
                                                <img src="<?= base_url('public/image/users/') ?>${response.image_profile}" class="avatar-img">
                                            </div>
                                            ${response.full_name}
                                        </span>
                                    </div>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Review
                                    </span>
                                    <div>
                                        ${review}
                                    </div>
                                </div>
                                <div class="my-2"> 
                                    <span class="fs-8 text-primary fw-bold">
                                        Deskripsi tugas
                                    </span>
                                    <p class="fs-7">${response.task_description}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            target.html(content).show()
        }

        $('body').on('click', '.show-detail', function(e){
            $.ajax({
                type: "POST",
                url : "<?= base_url('project/get_task') ?>",
                data: {
                    id : $(this).data('id'),
                    csrf_token : csrf.attr('content')
                },
                dataType: "JSON",
                beforeSend : _ => {
                    $('#loading').show()
                },
                success: function(response){
                    csrf.attr('content', response.csrf_hash)
                    showDetail(response.data)
                },
                error : function(xhr, status, errorThrown){
                    console.log(xhr.responseText)
                    console.log(status)
                    console.log(errorThrown)
                }
            }).done( _ => {
                $('#loading').hide()
            });
        });
    });
</script>