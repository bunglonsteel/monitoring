<div id="drawer_scope" class="hk-drawer drawer-small drawer-right">

</div>

<script>
    $(function() {

        const showDetail = response => {
            const target = $('#drawer_scope')
            let items = '';
            response.data.forEach(e => {
                items += `
                    <li class="timeline-item card card-border p-3">
                        ${e.status == "progress" ? '<span class="badge badge-soft-info mb-3">Doing</span>' : '<span class="badge badge-soft-success mb-3">Completed</span>'}
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="icon dripicons-clock" style="line-height:0"></span>
                            <span>${e.created_at}</span>
                        </div>
                        <p>${e.title}</p>
                    </li>
                `
            })
            const content = `<div class="drawer-header">
                    <div class="d-flex">
                        <div class="drawer-text">
                            <div class="icon dripicons-clock" style="line-height:0"></div>
                        </div>
                        <div id="loading-scope" class="spinner-border spinner-border-sm me-auto ms-3" role="status" style="display:none">
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
                            <h5 class="fw-bold mb-3">${response.scope}</h5>
                            <ul class="timeline fs-7">
                                ${items}
                            </ul>
                        </div>
                    </div>
                </div>`;
            target.html(content).addClass('drawer-toggle')
        }

        $('body').on('click', '.show-scope', function(e) {
            e.stopPropagation()
            const id = $(this).closest('label').data('id')
            const scopeName = $(this).closest('label').data('scope')
            $.ajax({
                type: "POST",
                url: "<?= base_url('project/get_task_sub') ?>",
                data: {
                    id: id,
                    csrf_token: csrf.attr('content')
                },
                dataType: "JSON",
                beforeSend: _ => {
                    $('#loading-scope').show()
                },
                success: function(response) {
                    csrf.attr('content', response.csrf_hash)
                    if (response.success) {
                        response.scope = scopeName
                        showDetail(response)
                    } else {
                        show_toast('warning', 'Peringatan 🙁', response.message)
                    }
                },
                error: function(xhr, status, errorThrown) {
                    console.log(xhr.responseText)
                    console.log(status)
                    console.log(errorThrown)
                }
            }).done(_ => {
                $('#loading-scope').hide()
            });
        });
    });
</script>