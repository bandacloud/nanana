<?php
include './head.php';
include './side-bar.php';
include './header.php';
?>

<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="single_element">
                    <div class="quick_activity">
                        <div class="row">
                            <div class="col-12">
                                <div class="quick_activity_wrap">
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/temperature.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="temp"></span> </h3>
                                            <p>&deg;C</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/humidity.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="hum"></span> </h3>
                                            <p>%</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/moisture.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="moisture"></span> </h3>
                                            <p>%</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/nitrogen.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="n"></span> </h3>
                                            <p>mg/kg</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/phosphorus.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="p"></span> </h3>
                                            <p>mg/kg</p>
                                        </div>
                                    </div>
                                    <div class="single_quick_activity d-flex">
                                        <div class="icon">
                                            <img src="img/potassium.png" alt>
                                        </div>
                                        <div class="count_content">
                                            <h3><span class="k"></span> </h3>
                                            <p>mg/kg</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-12">
                <div class="white_box mb_30 ">
                    <div class="box_header border_bottom_1px  ">
                        <div class="main-title">
                            <h3 class="mb_25">Pump State</h3>
                        </div>
                    </div>
                    <div class="form-check form-switch d-flex justify-content-center">
                        <input class="form-check-input" type="checkbox" id="pumpSwitch" name="darkmode" value="yes">
                        <label class="form-check-label" id="pumpStatus">off</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white_box card_height_50 mb_30">
                    <div class="box_header border_bottom_1px  ">
                        <div class="main-title">
                            <h3 class="mb_25">Charts</h3>
                        </div>
                    </div>
                    <canvas id="myChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white_box card_height_50 mb_30">
                    <div class="box_header border_bottom_1px  ">
                        <div class="main-title">
                            <h3 class="mb_25">NPK Values</h3>
                        </div>
                    </div>
                    <canvas id="myBarChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-12">
                <div class="QA_table mb_30">
                    <?php
                    $run = mysqli_query($conn, "SELECT * FROM `plants` WHERE `mode`=1") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($run);
                    $run2 = mysqli_query($conn, "SELECT * FROM `sensor_data` ORDER BY `sid` DESC LIMIT 1") or die(mysqli_error($conn));
                    $row2 = mysqli_fetch_array($run2);
                    ?>
                    <table class="table white_box">
                        <tr>
                            <th scope="col">Plant</th>
                            <td class="t_plant"></td>
                        </tr>
                        <tr>
                            <th scope="col">Temperature</th>
                            <td class="t_temp"></td>
                        </tr>
                        <tr>
                            <th scope="col">Humidity</th>
                            <td class="t_hum"></td>
                        </tr>
                        <tr>
                            <th scope="col">Moisture</th>
                            <td class="t_moisture"></td>
                        </tr>
                        <tr>
                            <th scope="col">Nitrogen</th>
                            <td class="t_n"></td>
                        </tr>
                        <tr>
                            <th scope="col">Phosphorus</th>
                            <td class="t_p"></td>
                        </tr>
                        <tr>
                            <th scope="col">Potassium</th>
                            <td class="t_k"></td>
                        </tr>
                    </table>
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
        var url = "./php/read_all.php";
        var url2 = "./php/read_plant_data.php";
        $.getJSON(url, function(data) {
            var moisture = data['pms'][(Object.keys(data['pms']).length) - 1]['moisture'];
            var n = data['pms'][(Object.keys(data['pms']).length) - 1]['n'];
            var p = data['pms'][(Object.keys(data['pms']).length) - 1]['p'];
            var k = data['pms'][(Object.keys(data['pms']).length) - 1]['k'];
            var temp = data['pms'][(Object.keys(data['pms']).length) - 1]['temp'];
            var hum = data['pms'][(Object.keys(data['pms']).length) - 1]['hum'];

            // Single Value Variable
            document.querySelector(".temp").innerHTML = temp;
            document.querySelector(".hum").innerHTML = hum;
            document.querySelector(".moisture").innerHTML = moisture;
            document.querySelector(".n").innerHTML = n;
            document.querySelector(".p").innerHTML = p;
            document.querySelector(".k").innerHTML = k;

            var temperature = [];
            var humidity = [];
            var stamp = [];

            for (var a = 0; a < 15; a++) {

                temperature[a] = data['pms'][(Object.keys(data['pms']).length) - (a + 1)]['temp'];
                humidity[a] = data['pms'][(Object.keys(data['pms']).length) - (a + 1)]['hum'];
                stamp[a] = data['pms'][(Object.keys(data['pms']).length) - (a + 1)]['stamp'];
            }

            /******************************* Bar Chart ******************************/
            // Sample data for nutrient levels
            var dataBar = {
                labels: ['Nitrogen', 'Phosphorus', 'Potassium'],
                datasets: [{
                    label: 'Nutrient Levels',
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(75, 192, 192)', 'rgb(255, 205, 86)'],
                    data: [n, p, k],
                }]
            };

            // Get the context of the canvas element
            var ctxBar = document.getElementById('myBarChart').getContext('2d');

            // Create a bar chart
            var myBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: dataBar,
                options: {
                    responsive: true,
                    animation: false,
                    scales: {
                        x: {
                            type: 'category',
                            labels: dataBar.labels,
                        },
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            /******************************************** Line Chart ***********************************************/
            var data = {
                labels: stamp.reverse(),
                datasets: [{
                    label: 'Temperature (°C)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: temperature.reverse(),
                    fill: false,
                }, {
                    label: 'Humidity (%)',
                    borderColor: 'rgb(75, 192, 192)',
                    data: humidity.reverse(),
                    fill: false,
                }]
            };

            // Get the context of the canvas element
            var ctx = document.getElementById('myChart').getContext('2d');

            // Create a line chart
            var myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    animation: false,
                    scales: {
                        x: {
                            type: 'category',
                            labels: data.labels,
                        },
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            $.getJSON(url2, function(data2) {
                var plant = data2['plant'][(Object.keys(data2['plant']).length) - 1]['plant'];
                var p_moisture = data2['plant'][(Object.keys(data2['plant']).length) - 1]['moisture'];
                var p_n = data2['plant'][(Object.keys(data2['plant']).length) - 1]['n'];
                var p_p = data2['plant'][(Object.keys(data2['plant']).length) - 1]['p'];
                var p_k = data2['plant'][(Object.keys(data2['plant']).length) - 1]['k'];
                var p_temp = data2['plant'][(Object.keys(data2['plant']).length) - 1]['temp'];
                var p_hum = data2['plant'][(Object.keys(data2['plant']).length) - 1]['hum'];

                //plant
                document.querySelector(".t_plant").innerHTML = plant;

                //temp
                if (temp > (1.2 * p_temp)) {
                    document.querySelector(".t_temp").innerHTML = "Too High";
                } else if (temp < (0.8 * p_temp)) {
                    document.querySelector(".t_temp").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_temp").innerHTML = "In range";
                }

                //hum
                if (hum > (1.2 * p_hum)) {
                    document.querySelector(".t_hum").innerHTML = "Too High";
                } else if (hum < (0.8 * p_hum)) {
                    document.querySelector(".t_hum").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_hum").innerHTML = "In range";
                }

                 //Moisture
                 if (moisture > (1.2 * p_moisture)) {
                    document.querySelector(".t_moisture").innerHTML = "Too High";
                } else if (moisture < (0.8 * p_moisture)) {
                    document.querySelector(".t_moisture").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_moisture").innerHTML = "In range";
                }

                //Nitrogen
                if (n > (1.2 * p_n)) {
                    document.querySelector(".t_n").innerHTML = "Too High";
                } else if (n < (0.8 * p_n)) {
                    document.querySelector(".t_n").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_n").innerHTML = "In range";
                }

                //Phosphorus
                if (p > (1.2 * p_p)) {
                    document.querySelector(".t_p").innerHTML = "Too High";
                } else if (p < (0.8 * p_p)) {
                    document.querySelector(".t_p").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_p").innerHTML = "In range";
                }

                //Pottasium
                if (p > (1.2 * p_k)) {
                    document.querySelector(".t_k").innerHTML = "Too High";
                } else if (k < (0.8 * p_k)) {
                    document.querySelector(".t_k").innerHTML = "Too Low";
                } else {
                    document.querySelector(".t_k").innerHTML = "In range";
                }
            });
        });
    }

    window.setInterval(function() {
        loadData();
    }, 500);
</script>
<script>
    // pump control
    //Controlling the pump
    let pumpSwitch = document.querySelector("#pumpSwitch");
    let pumpStatus = document.querySelector("#pumpStatus");

    //monitor if checkbox is clicked
    pumpSwitch.addEventListener("click", function() {
        //turn bulb on if the switch is on 
        if (pumpSwitch.checked) {
            // bulb.src = "../assets/img/on.png";
            // bulb.setAttribute("alt", "on");
            pumpStatus.innerHTML = "on";

            let url = "./php/update-pump.php?id=1&status=on";
            $.getJSON(url, function(data) {
                console.log(data);
            });

        } else {
            //turn bulb off if switch is off
            // bulb.src = "../assets/img/off.png";
            // bulb.setAttribute("alt", "off");
            pumpStatus.innerHTML = "off";

            let url = "./php/update-pump.php?id=1&status=off";
            $.getJSON(url, function(data) {
                console.log(data);
            });
        }
    });
</script>
<script>
    document.querySelector("#sidebar_menu .dashboard").classList.add("mm-active");
</script>