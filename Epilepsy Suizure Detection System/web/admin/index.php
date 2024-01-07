<?php
include './head.php';
include './sidebar.php';
include './page-container.php';
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row bg-white">
                <div class="col-xs-12 col-12">
                    <center>
                        <div id="chart_temp" class="chart"></div>
                    </center>
                </div>
            </div>


            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="white_box mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-body">
                        <center>
                            <i class="fa-10x fa fa-bell icon"></i>
                            <p class="message"></p>
                        </center>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Normal
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-danger"></i> Seizures
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row bg-white" style="margin-top:10px;">
                <div class="col-xs-12 col-12">
                    <center>
                        <div id="curve_chart"></div>
                    </center>
                </div>
            </div>
            <?php include './footer.php'; ?>
        </div>
    </div>
</div>
<?php include './scripts.php'; ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    //$(document).ready(function(){
    //-------------------------------------------------------------------------------------------------
    google.charts.load('current', {
        'packages': ['gauge']
    });
    google.charts.setOnLoadCallback(drawTemperatureChart);
    //-------------------------------------------------------------------------------------------------
    function drawTemperatureChart() {
        //guage starting values
        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temp', 0],
        ]);
        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
        var options = {
            width: 1000,
            height: 400,
            redFrom: 70,
            redTo: 100,
            yellowFrom: 40,
            yellowTo: 70,
            greenFrom: 00,
            greenTo: 40,
            minorTicks: 5
        };
        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
        var chart = new google.visualization.Gauge(document.getElementById('chart_temp'));
        chart.draw(data, options);
        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN


        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
        function refreshData() {
            $.ajax({
                url: '../php/get-temp.php',
                // use value from select element
                data: 'q=' + $("#users").val(),
                dataType: 'json',
                success: function(responseText) {
                    //______________________________________________________________
                    //console.log(responseText);
                    var var_temperature = parseFloat(responseText.temp).toFixed(2)
                    //console.log(var_temperature);
                    // use response from php for data table
                    //______________________________________________________________
                    //guage starting values
                    var data = google.visualization.arrayToDataTable([
                        ['Label', 'Value'],
                        ['Temp', eval(var_temperature)],
                    ]);
                    //______________________________________________________________
                    //var chart = new google.visualization.Gauge(document.getElementById('chart_temperature'));
                    chart.draw(data, options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown + ': ' + textStatus);
                }
            });
        }
        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
        //refreshData();

        setInterval(refreshData, 1000);
    }
    //-------------------------------------------------------------------------------------------------
</script>
<script>
    window.onload = function() {
        loadData();
    }

    function loadData() {

        var url = "../php/read_all.php";
        $.getJSON(url, function(data) {
            var icon = document.querySelector(".icon");
            var message = document.querySelector(".message");

            var stamp = [];
            var x = [];
            var y = [];
            var z = [];
            var angular = data['esds'][(Object.keys(data['esds']).length) - 1]['angular'];

            for (var a = 0; a < 8; a++) {
                x[a] = parseFloat(data['esds'][(Object.keys(data['esds']).length) - (a + 1)]['x']);
                y[a] = parseFloat(data['esds'][(Object.keys(data['esds']).length) - (a + 1)]['y']);
                z[a] = parseFloat(data['esds'][(Object.keys(data['esds']).length) - (a + 1)]['z']);
                stamp[a] = data['esds'][(Object.keys(data['esds']).length) - (a + 1)]['stamp'];
            }

            if (angular >= 4.2) {
                icon.style.color = "red";
                message.innerText = "Seizures";

                var url = "../php/sms.php";
                $.getJSON(url, function(data) {
                    console.log("Sending message")
                });
            } else {
                icon.style.color = "Green";
                message.innerText = "Normal";
            }

            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Time');
                data.addColumn('number', 'X');
                data.addColumn('number', 'Y');
                data.addColumn('number', 'Z');

                for (var i = 0; i < 8; i++) {
                    data.addRow([stamp[i], x[i], y[i], z[i]]);
                }

                var options = {
                    title: 'Seizure Frequency',
                    curveType: 'function',
                    legend: {
                        position: 'bottom'
                    },
                    width: 900,
                    height: 350
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
            }
        });
    }

    window.setInterval(function() {
        loadData();
    }, 500);
</script>
<script>
    document.querySelector('li.news').classList.add('active');
    document.querySelector('li.news-m').classList.add('active');
    document.querySelector('title').innerText = "ESDS - Dashboard";
</script>