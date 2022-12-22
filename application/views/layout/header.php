<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>    
	<!-- Favicon -->
    <link rel="icon" href="<?=base_url() ?>public/image/default/<?= $settings['favicon'] ?>" type="image/x-icon">
	
	<!-- Daterangepicker CSS -->
    <link href="<?=base_url() ?>public/assets/vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    
    <link href="<?=base_url() ?>public/assets/vendors/summernote/summernote-lite.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url() ?>public/assets/vendors/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />

	<!-- Data Table CSS -->
    <link href="<?=base_url() ?>public/assets/vendors/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url() ?>public/assets/vendors/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url() ?>public/assets/vendors/dropify/dist/css/dropify.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url() ?>public/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
	<!-- CSS -->
    <link href="<?=base_url() ?>public/assets/dist/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>public/assets/dist/css/villainti.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>public/assets/dist/css/swalbootstrap-4.min.css" rel="stylesheet" type="text/css">
    <!-- Sweetalert JS -->
    <script async src="<?= base_url()?>public/assets/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?=base_url() ?>public/assets/vendors/jquery/dist/jquery.min.js"></script>

    <style>
        .clock-head {
            border: 1px solid #eaeaea;
            padding: 5px 8px 0 8px;
            border-radius: 5px;
        }
        .clock-head>.clock-head-date {
            font-size: 10px;
            font-weight: bolder;
        }
        .clock-head>.clock-head-hour {
            font-weight: bolder;
            color: #262a2e;
        }
        .btn.btn-sm>span:not(.badge):not(.sr-only):not(span[class^="spinner"]) .icon:not(:last-child) {
            margin-right: 0.2rem !important;
        }
        div.dataTables_wrapper div.dataTables_info {
            font-size: 14px;
        }
        .modal-header{
            padding: 0.8rem 1.2rem;
        }
        .form-control,
        .form-select{
			font-size: 0.9rem;
			line-height: 1.6;
		}
        .divider{
            display: inline;
            margin: 0 1rem 0 0.8rem;
            border-right: 1px solid #ededed;
        }
        .dropify-wrapper .dropify-message p{
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: 30px;
            transform: translate(-50%, -50%);
            font-size: 17px;
        }
        .dropify-wrapper .dropify-message span.file-icon{
            width: 100%;
        }
        .note-modal{
            position: absolute;
        }
        .note-modal-backdrop{
            z-index: 1040;
        }
        .note-modal-backdrop{
            position: relative;
        }
        .note-modal-footer{
            height: 60px;
        }
        .note-form-group{
            padding-bottom: 0;
        }
        .note-dropdown-item h1{
            font-size:2.22rem;
        }
        .note-editable p {
            font-family: Inter;
            font-size: 15px;
        }
        .image-calendar{
            width: 30px;
            height: 30px;
            object-fit: cover;
        }
        .calendarapp-wrap .calendarapp-content .fc .fc-daygrid-event{
            padding: 0.3rem 0.5rem;
        }
        .calendarapp-wrap .calendarapp-content .fc .fc-toolbar .fc-toolbar-chunk:nth-child(2) h2{
            text-align: center;
            margin-left: 15px;
        }
        .text-limit-1 {
            overflow: hidden!important;
            display: -webkit-box!important;
            -webkit-line-clamp: 1!important;
            -webkit-box-orient: vertical;
        }

        .select2-results__option[aria-selected],
        .select2-container--default .select2-selection--single .select2-selection__placeholder,
        .select2-results__option,
        .select2-selection__rendered{
            font-size: 14px;
        }

        .select2-search__field:focus-visible{
            border-color: #ededed;
        }

        .note-editor .dropdown-toggle::after{
            all: unset;
        }

        .note-editor .note-dropdown-menu{
            box-sizing: content-box;
        }

        .note-editor ul{
            list-style-type: disc;
        }

        .note-modal .note-group-image-url,
        .note-modal[aria-label="Help"] .note-modal-footer{
            display: none;
        }
        .note-modal .note-modal-content{
            border: none;
            border-radius: 8px;
        }
        .note-modal .note-modal-header{
            border: none;
            padding: 10px 10px 10px 20px;
        }
        .note-editor .note-toolbar{
            text-align: center;
        }
    </style>
</head>
<body>
<!-- Wrapper -->
	<div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">