<?php
include './sidenav.php';
include './header.php';
?>
<div class="main_content_iner">
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="dashboard_header mb_15">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboard_header_title">
                                <h3>Charts</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-end">
                                <p>
                                    <a href="analytics.php">Analytics</a>
                                    <i class="fas fa-caret-right"></i> Charts
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-12 py-3">
                <div class="white_box mb_30">
                    <div class="box_header">
                        <div class="main-title">
                            <h3 class="mb_10">
                                Daily Records of Phase 1 Current
                            </h3>
                        </div>
                    </div>

                    <canvas id="temperature"></canvas>

                </div>
            </div>
            <div class="white_box mb_30">
                <div class="box_header">
                    <div class="main-title">
                        <h3 class="mb_10">
                            Daily Records of Phase 2 Current
                        </h3>
                    </div>
                </div>

                <canvas id="humidity"></canvas>

            </div>
        </div>
    </div>
</div>
</div>

<?php
include './footer.php';
include './scripts.php';
?>
<script>
    window.onload = function() {
        loadData();
    }

    function loadData() {
        var url = "../php/read_all.php";
        $.getJSON(url, function(data) {
            var c1=[];
            var c2=[];
            var stamp=[];
            
            for(var a=0; a<15; a++){
                
                c1[a]=data['tms'][(Object.keys(data['tms']).length) - (a+1)]['c1'];
                c2[a]=data['tms'][(Object.keys(data['tms']).length) - (a+1)]['c2'];
                stamp[a]=data['tms'][(Object.keys(data['tms']).length) - (a+1)]['stamp'];
            }

            const ctx = document.getElementById('temperature').getContext('2d');
            const chat1 = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: stamp.reverse(),
                    datasets: [{
                        label: 'Phase 1 Current',
                        data: c1.reverse(),
                        backgroundColor: [
                            'rgba(51, 153, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(51, 153, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const cty = document.getElementById('humidity').getContext('2d');
            const chat2 = new Chart(cty, {
                type: 'line',
                data: {
                    labels: stamp.reverse(),
                    datasets: [{
                        label: 'Phase 2 Current',
                        data: c2.reverse(),
                        backgroundColor: [
                            'rgba(51, 153, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(51, 153, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
    }

    window.setInterval(function() {
        loadData();
    }, 3000);

    document.querySelector("title").innerText = "TMS ~ Charts";
    document.querySelectorAll("nav #sidebar_menu li")[2].classList.add("mm-active");
</script>
<?php
include './end.php';
?>