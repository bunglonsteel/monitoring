<!-- Main Content -->
<div class="hk-pg-wrapper pb-0">
    <div class="hk-page-body">
        <div class="calendarapp-wrap">
            <div class="calendarapp-content" style="padding-left:0;">
                <div id="calendar" class="w-100"></div>
            </div>
        </div>
    </div>
        <?php $this->load->view('layout/footer-copyright') ?>
</div>


<script src="<?= base_url() ?>public/assets/vendors/fullcalendar/main.min.js"></script>
<script src="<?= base_url() ?>public/assets/vendors/moment/min/moment.min.js"></script>
<script>
    let curYear  = moment().format('YYYY')
    let curMonth = moment().format('MM');

    document.addEventListener('DOMContentLoaded', function() {
        let clTarget = document.getElementById('calendar')
        let calendar = new FullCalendar.Calendar(clTarget, {
            initialView: 'dayGridMonth',
            initialDate: curYear+'-'+curMonth+'-07',
            headerToolbar: {
                left: 'today prev',
                center: 'title',
                right: 'next'
            },
            themeSystem: 'bootstrap',
            height: 'parent',
            eventContent: function(arg) {
                if (arg.event.extendedProps.toHtml) {
                        return { html: arg.event.title }
                } 
            },
        });

        calendar.render();
        const year = '<?= date('Y') ?>'
        const birthEmployee = JSON.parse(`<?= $employee_list ?>`)
        const listCuti = JSON.parse(`<?= $cuti_list ?>`)
        const listEvents = JSON.parse(`<?= $event_list ?>`)

        birthEmployee.forEach(e => {
            calendar.addEvent({
                backgroundColor: 'rgb(132 74 255)',
                borderColor: 'rgb(132 74 255)',
                title: `<img data-bs-toggle="tooltip" data-bs-placement="right" title="🎂 Ulang tahun" class="image-calendar rounded-circle me-md-2 border border-2" src="<?= base_url() ?>public/image/users/${e.image_profile}" />
                                <span class="d-none d-md-block">${e.full_name}</span>`,
                start: `${year}${e.birth}`,
                extendedProps:{
                    toHtml: 'convert'
                }
            });
        });

        listEvents.forEach(e => {
            calendar.addEvent({
                backgroundColor: '#007D88',
                borderColor: '#007D88',
                title: `<i class="ri-plane-fill"></i>
                                <span class="d-none d-md-block">${e.event_title}</span>`,
                start: e.start_date,
                end: e.end_date,
                extendedProps:{
                    toHtml: 'convert'
                }
            });
        });

        listCuti.forEach(e => {
            if (e.cuti_type == 'CS' || e.cuti_type == 'CSS') {
                calendar.addEvent({
                    backgroundColor: 'rgb(255,74,74,1)',
                    borderColor: 'rgb(255,74,74,1)',
                    title: `
                                <img data-bs-toggle="tooltip" data-bs-placement="right" title="😷 Cuti Sakit" class="image-calendar rounded-circle me-md-2 border border-2" src="<?= base_url() ?>public/image/users/${e.image_profile}" />
                                <span class="d-none d-md-block">${e.full_name}</span>
                            `,
                    start: e.start_date,
                    end: e.end_date,
                    extendedProps:{
                        toHtml: 'convert'
                    }
                });
            } else if(e.cuti_type == 'CI'){
                calendar.addEvent({
                    backgroundColor: 'rgb(45,162,255,1)',
                    borderColor: 'rgb(45,162,255,1)',
                    title: `
                                <img data-bs-toggle="tooltip" data-bs-placement="right" title="✈️ Cuti Izin / Penting" class="image-calendar rounded-circle me-md-2 border border-2" src="<?= base_url() ?>public/image/users/${e.image_profile}" />
                                <span class="d-none d-md-block">${e.full_name}</span>
                    `,
                    start: e.start_date,
                    end: e.end_date,
                    extendedProps:{
                        toHtml: 'convert'
                    }
                });
            } else if(e.cuti_type == 'CT'){
                calendar.addEvent({
                    backgroundColor: 'rgb(255 134 74)',
                    borderColor: 'rgb(255 134 74)',
                    title: `
                        <img data-bs-toggle="tooltip" data-bs-placement="right" title="🚞 Cuti Tahunan" class="image-calendar rounded-circle me-md-2 border border-2" src="<?= base_url() ?>public/image/users/${e.image_profile}" />
                        <span class="d-none d-md-block">${e.full_name}</span>
                    `,
                    start: e.start_date,
                    end: e.end_date,
                    extendedProps:{
                        toHtml: 'convert'
                    }
                });
            }
        });
    });


    setTimeout(function(){
        $('.fc-today-button').addClass('fs-7');
        $('.fc-dayGridMonth-button,.fc-timeGridWeek-button,.fc-timeGridDay-button,.fc-listWeek-button')
        .removeClass('btn-primary')
        .addClass('btn-outline-light d-md-inline-block d-none');

        $('.fc-prev-button,.fc-next-button')
        .addClass('btn-icon btn-flush-dark btn-rounded flush-soft-hover')
        .find('.fa')
        .addClass('icon');

        $('.fc-toolbar-chunk:nth-child(3)').append('<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover hk-navbar-togglable" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Collapse"><span class="icon"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></span><span class="feather-icon d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span></span></a>');
        
        $('.fc-prev-button,.fc-next-button')
        .addClass('btn-icon btn-flush-dark btn-rounded flush-soft-hover')
        .find('.fa')
        .addClass('icon');
    },100);
</script>