<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

        <?php $this->load->view('layout/breadcrumbs') ?>
        
        <div class="hk-page-body">
        <?php if($this->session->userdata('role_id') == 1) : ?>
            <div class="card card-border">
                <div class="card-header">
                    <h6>Silahkan klik bagian yang sudah dikerjakan</h6>
                </div>
                <div class="card-body">
                    <form class="row g-2">
                        <?php if($list_cleanliness):?>
                            <?php foreach($list_cleanliness as $list) : ?>
                                <div class="col-md-3">
                                    <input id="ca<?= $list['cleanliness_id'] ?>" type="checkbox" hidden value="<?= $list['cleanliness_id'] ?>">
                                    <label class="select-clean w-100" for="ca<?= $list['cleanliness_id'] ?>" style="cursor: pointer;">
                                        <div class="flex-row justify-content-between card card-border border-3 p-3 target">
                                            <h6 class="mb-0"><?= $list['cleanliness_name'] ?></h6>
                                            <span class="feather-icon d-none text-primary">
                                                <i data-feather="check-circle"></i>
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else :?>
                            <p class="text-center">Data kebersihan belum ada 😟 </p>
                        <?php endif;?>
                        <input class="csrf" type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    </form>
                </div>
            </div>
        <?php endif; ?>
            <div class="row mt-8">
                <div class="col-12">
                    <h5 class="text-center mb-5">Kebersihan hari ini <strong><?= count($check_progress) ?></strong> dari <strong>( <?= count($list_cleanliness) ?> )</strong></h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <?php if($this->session->userdata('role_id') == 2) : ?>
                                    <th>
                                        <input id="select-all" class="form-check-input" type="checkbox">
                                    </th>
                                <?php endif;?>
                                <th>Kebersihan</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <?php if($this->session->userdata('role_id') == 2) : ?>
                                    <th id="review">Beri Penilaian</th>
                                <?php endif;?>
                                </tr>
                            </thead>
                            <tbody class="fs-7">
                                <?php if($check_progress) : ?>
                                    <?php $no = 1;foreach($check_progress as $check) : ?>
                                        <tr class="<?php if($check['cleanliness_status'] != 'P') : ?> bg-light <?php endif; ?>">
                                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                                <th scope="row">
                                                    <input class="form-check-input select-row" type="checkbox" name="check[]" data-id="<?= $check['cleanliness_progress_id'] ?>" data-check="<?= $check['cleanliness_status'] ?>" <?php if($check['cleanliness_status'] != 'P') : ?>disabled checked style="background-color:#000;border-color:#000"<?php endif; ?>>
                                                </th>
                                            <?php endif;?>
                                            <td><?= $check['cleanliness_name'] ?></td>
                                            <td><?= $check['employee_name'] ?></td>
                                            <td><?= date('d M Y', strtotime($check['cleanliness_date'])) ?></td>
                                            <td>
                                                <?php if($check['cleanliness_status'] == 'P') : ?>
                                                    <span class="badge badge-soft-warning">
                                                        Sedang Ditinjau 🕒 
                                                    </span>
                                                <?php elseif($check['cleanliness_status'] == 'VG') : ?>
                                                    <span class="badge badge-soft-success">
                                                        Sangat Baik 👌
                                                    </span>
                                                <?php elseif($check['cleanliness_status'] == 'G') : ?>
                                                    <span class="badge badge-soft-primary">
                                                        Baik 👍
                                                    </span>
                                                <?php else : ?>
                                                    <span class="badge badge-soft-danger">
                                                        Tingkatkan Lagi ✊
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if($this->session->userdata('role_id') == 2) : ?>
                                            <td>
                                                <button class="btn btn-icon btn-sm btn-soft-success btn-evaluation" type="button" data-codestat="2" data-id="<?= $check['cleanliness_progress_id'] ?>" <?php if($check['cleanliness_status'] != 'P') : ?>disabled <?php endif; ?>>
                                                    <span class="icon">
                                                        <span class="feather-icon">
                                                            <i data-feather="check-circle"></i>
                                                        </span>
                                                    </span>
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-soft-light btn-evaluation" type="button" data-codestat="3" data-id="<?= $check['cleanliness_progress_id'] ?>" <?php if($check['cleanliness_status'] != 'P') : ?>disabled <?php endif; ?>>
                                                    <span class="icon">
                                                        <span class="feather-icon">
                                                            <i data-feather="plus-circle"></i>
                                                        </span>
                                                    </span>
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-soft-danger btn-evaluation" type="button" data-codestat="4" data-id="<?= $check['cleanliness_progress_id'] ?>" <?php if($check['cleanliness_status'] != 'P') : ?>disabled <?php endif; ?>>
                                                    <span class="icon">
                                                        <span class="feather-icon">
                                                            <i data-feather="minus-circle"></i>
                                                        </span>
                                                    </span>
                                                </button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Belum ada yang dikerjakan 😟 </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>
<script async src="<?= base_url('public/assets/') ?>dist/js/bootstrap-notify.min.js"></script>

<?php 
$result = [];

foreach($check_progress as $check){
    array_push($result, $check['cleanliness_id']);
}
?>
<?php if($this->session->userdata('role_id') == 1) : ?>
<script>
    $(document).ready(function () {
        const check = [<?= '"'.implode('","', $result).'"' ?>];
        const selected = function(){

            $('input[type="checkbox"]').each((i, e) => {
                if (e.value == check.find(v => v == e.value)) {

                    $(`#${e.id}`).next().removeAttr('style')
                    $(`#${e.id}`).next().find('.target').addClass('border-primary result')
                    $(`#${e.id}`).next().find('.feather-icon').removeClass('d-none')
                    e.remove()
                }
            })

            $('.select-clean').click(function(e){
                e.preventDefault()
                if (!$(this).find('.target').hasClass('result')) {
                    $(this).find('.target').toggleClass('border-primary')
                    $(this).find('.feather-icon').toggleClass('d-none')

                    const clenalinessId = $(`#${$(this).attr('for')}`).val()
                    const url = '<?= base_url('cleanliness/add_progress') ?>';
                    const csrf_name = $('.csrf').attr('name')
                    const csrf_hash = $('.csrf').val()

                    $.ajax({
                        type: "POST",
                        url: url, 
                        data: {id : clenalinessId, employee: '<?= $employee['employee_id'] ?>', [csrf_name]: csrf_hash},
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
        }
        selected();
    });
</script>
<?php endif; ?>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-evaluation', function(e){
            const cpid = $(this).data('id')
            const codeStat = $(this).data('codestat')
            const url = `<?= base_url('cleanliness/rating/') ?>${cpid}/${codeStat}`
            const csrfName = '<?= $this->security->get_csrf_token_name()?>'
            const csrfHash = '<?= $this->security->get_csrf_hash()?>'
            console.log(codeStat, cpid)
            $.ajax({
                type: "POST",
                url: url,
                data: {[csrfName]:csrfHash},
                dataType: "json",  
                cache: false,
                success: function(response){
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
    var total_check_boxes;
    var total_checked_boxes;
    var check = []

    const actionReview = _ => {
		if (total_checked_boxes > 0) {
            $('#review').html(`
                <div class="mt-1">
                    <button class="btn btn-icon btn-sm btn-soft-success btn-evaluations" type="button" data-codestat="2">
                        <span class="icon">
                            <span class="feather-icon">
                                <i data-feather="check-circle"></i>
                            </span>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-sm btn-soft-light btn-evaluations" type="button" data-codestat="3">
                        <span class="icon">
                            <span class="feather-icon">
                                <i data-feather="plus-circle"></i>
                            </span>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-sm btn-soft-danger btn-evaluations" type="button" data-codestat="4">
                        <span class="icon">
                            <span class="feather-icon">
                                <i data-feather="minus-circle"></i>
                            </span>
                        </span>
                    </button>
                </div>
            `)
            feather.replace()
            const filterPending = $(".select-row:checked").map((i, v) => v.dataset.check == "P" ? v.dataset.id : '')
            check = [...filterPending] ;

        } else {
            $('#review').html('Beri penilaian')
        }
    }

    $(".select-row").on("change", function () {
        total_check_boxes   = $(".select-row").length;
        total_checked_boxes = $(".select-row:checked").length;

		if (total_check_boxes === total_checked_boxes) {
			$("#select-all").prop("checked", true);
		}
		else {
			$("#select-all").prop("checked", false);
		}

        if ($(this).closest('tr').hasClass('bg-light')) {
            $(this).closest('tr').removeClass('bg-light')
        } else {
            $(this).closest('tr').addClass('bg-light')
        }
        actionReview()
	});

    $('#select-all').on('click', function(e){

        if ($(this).is(':checked')) {
            $('.select-row').prop('checked', true)
            $('tbody tr').addClass('bg-light')
        } else {
            $('tbody tr').removeClass('bg-light')
            $('.select-row').prop('checked', false)
        }

        total_checked_boxes = $(".select-row:checked").length;
        actionReview()
    })

    $('body').on('click', '.btn-evaluations', function(e){

        const url         = "<?= base_url('cleanliness/ratings')?>"
        const codeStat    = $(this).data('codestat')
        const cleanliness = check.filter((v) => v)

        if (cleanliness.length > 0) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    cleanliness : cleanliness,
                    rating : codeStat,
                    csrf_token : csrf.attr('content')
                },
                dataType: "json",  
                cache: false,
                success: function(response){
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
        } else {
            show_toast('warning', 'Warning', 'Kebersihan telah diberi penilaian semua.')
        }
        return false;
    })

    });
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
</script>