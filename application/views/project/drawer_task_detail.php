<div id="drawer_push" class="hk-drawer drawer-small drawer-right">

</div>

<script>
    $(function() {

        const showDetail = response => {
            const target = $('#drawer_push')
            let categories = ''
            response.categories.forEach(e => {
                categories += `<span class="badge badge-soft-light">${e.name}</span>`
            });

            const review = response.verify_completed == "yes" ? "👍" : response.verify_completed == "no" ? "💪" : '<span class="badge badge-soft-warning">Menunggu...</span>';
            let items = '';
            response.items.forEach(e => {
                items += `
                    <div class="card card-border ${e.status == "progress" ? 'border-info' : 'border-success'}">
                        <div class="card-body p-3">
                            <div class="mb-1">
                            ${e.status == "progress" ? '<span class="badge badge-soft-info">Doing</span>' : '<span class="badge badge-soft-success">Completed</span>'}
                            </div>
                            <p class="fw-bold text-dark mb-2">${e.title}</p>
                            <span class="fs-8">Scope : ${e.scope}</span>
                        </div>
                    </div>
                `
            })
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
                                        Tanggal
                                    </span>
                                    <p class="fs-7">${response.start_date}</p>
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
                                    <span class="d-inline-block fs-8 text-primary fw-bold mb-1">
                                        Review
                                    </span>
                                    <div>
                                        ${review}
                                    </div>
                                </div>
                                <div class="my-2"> 
                                    <span class="d-inline-block fs-8 text-primary fw-bold mb-2">
                                        Deskripsi tugas
                                    </span>
                                    <div class="fs-7">
                                        ${items}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            target.html(content).show()
        }

        $('body').on('click', '.show-detail', function(e) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_task') ?>",
                data: {
                    id: $(this).data('id'),
                    csrf_token: csrf.attr('content')
                },
                dataType: "JSON",
                beforeSend: _ => {
                    $('#loading').show()
                },
                success: function(response) {
                    csrf.attr('content', response.csrf_hash)
                    showDetail(response.data)
                },
                error: function(xhr, status, errorThrown) {
                    console.log(xhr.responseText)
                    console.log(status)
                    console.log(errorThrown)
                }
            }).done(_ => {
                $('#loading').hide()
            });
        });
    });
</script>