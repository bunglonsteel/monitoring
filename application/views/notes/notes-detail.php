<!-- Main Content -->
<div class="hk-pg-wrapper pb-0">
    <div class="hk-pg-body py-0">
        <div class="blogapp-wrap">
            <nav class="blogapp-sidebar">
                <div data-simplebar class="nicescroll-bar">
                    <div class="menu-content-wrap">
                        <div class="nav-header">
                            <span>Index section</span>
                        </div>
                        <div class="menu-group">
                            <ul id="index-section" class="nav nav-light navbar-nav flex-column pt-1">

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="blogapp-content">
                <div class="blogapp-detail-wrap">
                    <header class="blog-header">
                        <div class="d-flex align-items-center">
                            <a class="blogapp-title link-dark" href="#">
                                <h5 class="mb-0"><?= $notes_content['notes_title'] ?></h5>
                            </a>
                        </div>
                        <div class="blog-options-wrap">
                            <button type="button" class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover hk-navbar-togglable d-sm-inline-block d-none" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Collapse">
                                <span class="icon">
                                    <span class="feather-icon"><i data-feather="chevron-up"></i></span>
                                    <span class="feather-icon d-none"><i data-feather="chevron-down"></i></span>
                                </span>
                            </button>
                        </div>
                        <div class="hk-sidebar-togglable"></div>
                    </header>
                    <div class="blog-body">
                        <div data-simplebar class="nicescroll-bar">
                            <div class="row g-0">
                                <div class="col-12 pt-2">
                                    <?= $notes_content['notes_content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click','a[href^="#"]', function(e){
        $('.blogapp-wrap').removeClass('blogapp-sidebar-toggle')
        $('.hk-sidebar-togglable').removeClass('active')
    });

    $('.blog-body img').css({'width':'100%'})
    $('.blog-body h2').css({'padding-top':'15px'})

    $('.blog-body h2').each((i, e) => {
        // console.log(e.innerText)
        $('#index-section').append(
            `<li class="nav-item fs-7">
                <a class="nav-link pb-2 pt-0" href="#${e.id}">
                    <span class="nav-link-text text-limit-2">- ${e.innerText} </span>
                </a>
            </li>`
        )
    })

</script>
