<?php

$hour = date("G", time());
$ucapan = '';

if ($hour>=0 && $hour<=11) {
    $ucapan = "Selamat Pagi";
} elseif ($hour >=12 && $hour<=14) {
    $ucapan = "Selamat Siang";
} elseif ($hour >=15 && $hour<=17) {
    $ucapan = "Selamat Sore"; 
} elseif ($hour >=17 && $hour<=18) {
    $ucapan = "Selamat Petang";
} elseif ($hour >=19 && $hour<=23) {
    $ucapan = "Selamat Malam";
}

$persen_hadir = floor(($total_hadir / $total_karyawan_aktif) * 100);
$persen_izin = floor(($total_izin / $total_karyawan_aktif) * 100);
$persen_sakit = floor(($total_sakit / $total_karyawan_aktif) * 100);

?>

<!-- Main Content -->
<div class="hk-pg-wrapper">
    <div class="container-xxl">

            <!-- Page Header -->
            <div class="hk-pg-header pg-header-wth-tab pt-5 mb-3" style="border-bottom: none;">
                <div class="row">
                    <div class="col">
                        <div class="d-flex">
                            <div class="d-flex flex-wrap justify-content-between flex-1">
                                <div class="mb-lg-0 mb-2 me-8">
                                    <h1 class="pg-title">Hallo👋, Administrator</h1>
                                    <p class="fs-7 mb-2">Selamat datang kembali dan <?=$ucapan ?> 😊</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
        <div class="hk-page-body">
            <div class="row mb-3">
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h6 class="text-xs text-primary mb-0">
                                        Kehadiran hari ini
                                    </h6>
                                    <div class="mb-0 fw-bold text-dark" style="font-size:2.3rem;"><?= $total_hadir ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="feather-icon">
                                        <i data-feather="clock" style="color: #eaeaea; font-size:45px;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h6 class="text-xs text-primary mb-0">
                                        Karyawan aktif
                                    </h6>
                                    <div class="mb-0 fw-bold text-dark" style="font-size:2.3rem;"><?= $total_karyawan_aktif ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="feather-icon">
                                        <i data-feather="user-check" style="color: #eaeaea; font-size:45px;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h6 class="text-xs text-primary mb-0">
                                        Karyawan keluar
                                    </h6>
                                    <div class="mb-0 fw-bold text-dark" style="font-size:2.3rem;"><?= $total_karyawan_keluar ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="feather-icon">
                                        <i data-feather="user-x" style="color: #eaeaea; font-size:45px;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card card-border h-100 pt-2 pb-0 mb-2">
                        <div class="card-body pt-3 pb-0">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h6 class="text-xs text-primary mb-0">
                                        Department
                                    </h6>
                                    <div class="mb-0 fw-bold text-dark" style="font-size:2.3rem;"><?= $total_department ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="feather-icon">
                                        <i data-feather="share-2" style="color: #eaeaea; font-size:45px;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-9 col-lg-8 col-md-7 mb-md-4 mb-3">
                    <div class="card card-border mb-0 h-100">
                        <div class="card-header card-header-action">
                            <h6>Grafik absensi
                                <span class="badge badge-soft-primary"><?= date('M Y') ?></span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="chart-absensi"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-lg-4 col-md-5 mb-md-4 mb-3">
                    <div class="card card-border mb-0  h-100">
                        <div class="card-header card-header-action">
                            <h6>Grafik kehadiran</h6>
                        </div>
                        <div class="card-body text-center">
                            <div id="radial_chart_2"></div>
                            <div class="d-flex justify-content-center mt-4">
                                <div class="mx-2">
                                    <span class="badge-status lh-1">
                                        <span class="badge badge-indicator badge-indicator-nobdr" style="background-color:#007D88;"></span>
                                        <span class="badge-label d-inline-block">Hadir</span>
                                    </span>
                                    <span class="d-block text-dark fs-5 fw-medium mb-0 mt-1"><?= $total_hadir ?></span>
                                </div>
                                <div class="mx-2">
                                    <span class="badge-status lh-1">
                                        <span class="badge badge-indicator badge-indicator-nobdr" style="background-color:#298DFF;"></span>
                                        <span class="badge-label">Izin</span>
                                    </span>
                                    <span class="d-block text-dark fs-5 fw-medium mb-0 mt-1"><?= $total_izin ?></span>
                                </div>
                                <div class="mx-2">
                                    <span class="badge-status lh-1">
                                        <span class="badge badge-indicator badge-indicator-nobdr" style="background-color:#f93542;"></span>
                                        <span class="badge-label">Sakit</span>
                                    </span>
                                    <span class="d-block text-dark fs-5 fw-medium mb-0 mt-1"><?= $total_sakit ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('layout/footer-copyright') ?>
    </div>
</div>


<!-- Apex JS -->
<script src="<?= base_url() ?>public/assets/vendors/apexcharts/dist/apexcharts.min.js"></script>
<script>
let options = {
	series: [
        {
            name: 'Hadir ',
            data: [<?php foreach($hadir as $h) :?> <?= $h ?>,<?php endforeach;?>]
        },
        {
            name: 'Izin ',
            data: [<?php foreach($izin as $i) :?> <?= $i ?>,<?php endforeach;?>]
        },
        {
            name: 'Sakit ',
            data: [<?php foreach($sakit as $s) :?> <?= $s ?>,<?php endforeach;?>]
        }
    ],
    xaxis: {
		type: 'categories',
        labels: {
            datetimeUTC: false,
            format: 'dd MMM'
        },
		categories: [<?php foreach($tgl as $d) :?> '<?= date('d M', strtotime($d)) ?>',<?php endforeach;?>],
	},
	chart: {
		height: 320,
		type: 'line',
        zoom: {
            enabled: false
        }
	},
	stroke: {
		width: 5,
		curve: 'smooth'
	},
	fill: {
		type: 'solid',
        colors: ['#1A73E8', '#B32824','#1A73E8']
	},
	markers: {
		size: 4,
		colors: ["rgba(0, 143, 251, 0.85)", "rgba(0, 227, 150, 0.85)", "rgba(254, 176, 25, 0.85)"],
		strokeColors: "#fff",
		strokeWidth: 1,
		hover: {
			size: 6,
		}
	},
    // colors: [colors.primary, colors.danger, colors.warning],
    // grid: {
    //     padding: {
    //         bottom: -4
    //     },
    //     borderColor: colors.gridBorder,
    //     xaxis: {
    //         lines: {
    //             show: true
    //         }
    //     }
    // },
    legend: {
        show: false,
    },
	yaxis: {
		min: 0,
		max: <?= $total_karyawan_aktif + 10 ?>,
		title: {
			text: 'Absensi harian',
		},
	}
};
var chartLine = new ApexCharts(document.querySelector("#chart-absensi"), options);
chartLine.render();

var optionsDonut = {
	series: [<?=$persen_hadir ?>, <?=$persen_izin ?>, <?=$persen_sakit ?>],
	stroke: {
		lineCap: 'round'
	},
	chart: {
		height: 255,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			hollow: {
				margin: 0,
				size: "30%",
			},
			dataLabels: {
				showOn: "always",
				name: {
					show: false,
				},
				value: {
					fontSize: "1.75rem",
					show: true,
					fontWeight: '500'
				}	,
				total: {
					show: true,
					formatter: function () {
						return [('%')];
					}
				}
			  }
		}
	},
	colors: ['#007D88','#298DFF','#f93542'],
	labels: ['Hadir', 'Izin', 'Sakit'],
};

var chartDonut = new ApexCharts(document.querySelector("#radial_chart_2"), optionsDonut);
chartDonut.render();
</script>