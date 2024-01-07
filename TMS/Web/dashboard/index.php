<?php
include './sidenav.php';
include './header.php';
?>
<div class="main_content_iner dht">
  <div class="container-fluid p-0 sm_padding_15px">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="dashboard_header mb_15">
          <div class="row">
            <div class="col-lg-6">
              <div class="dashboard_header_title">
                <h3>Home</h3>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="dashboard_breadcam text-end">
                <p>
                  <a href="index.php">Dashboard</a>
                  <i class="fas fa-caret-right"></i> Home
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 transformer">
        <center><img src="./img/transformer.png" alt="TRANSFORMER"></center>
      </div>
      <!-- RED PHASE -->
      <div class="col-12 phase text-danger">RED PHASE</div>
      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/high-voltage.png" alt=" Voltage">
              </div>
              <div class="col-6" id="v1"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/current.png" alt="Current">
              </div>
              <div class="col-6" id="c1"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/resistor.jpg" alt="Resistor">
              </div>
              <div class="col-6" id="r1"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- END RED PHASE -->

      <!-- YELLOW PHASE -->
      <div class="col-12 phase text-warning">YELLOW PHASE</div>
      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/high-voltage.png" alt=" Voltage">
              </div>
              <div class="col-6" id="v2">230 V</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/current.png" alt="Current">
              </div>
              <div class="col-6" id="c2"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/resistor.jpg" alt="Resistor">
              </div>
              <div class="col-6" id="r2"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- END YELLOW PHASE -->

      <!--BLUE  PHASE -->
      <div class="col-12 phase text-info">BLUE PHASE</div>
      <div class="col-xl-4 col-md-6 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/high-voltage.png" alt=" Voltage">
              </div>
              <div class="col-6" id="v3"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/current.png" alt="Current">
              </div>
              <div class="col-6" id="c3"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 mb-3">
        <div class="white_box QA_section icons">
          <div class="box_header m-0">
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-6">
                <img src="./img/resistor.jpg" alt="Resistor">
              </div>
              <div class="col-6" id="r3"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- END BLUE PHASE -->

      <div class="col-lg-12">
        <div class="white_box mb_30">
          <div class="box_header ">
            <div class="main-title">
              <h3 class="mb-0"></h3>
            </div>
          </div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">TIme</th>
                <th scope="col">Voltage 1</th>
                <th scope="col">Current 1</th>
                <th scope="col">Voltage 2</th>
                <th scope="col">Current 2</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $run = mysqli_query($conn, "SELECT * FROM `sensor_data` ORDER BY `sid` DESC LIMIT 5") or die(mysqli_error($conn));
              while ($row = mysqli_fetch_array($run)) {
              ?>
                <tr>
                  <th scope="row"><?php echo date('H:i:s',$row['stamp']); ?></th>
                  <td><?php echo $row['v1']; ?> V</td>
                  <td><?php echo $row['c1']; ?> A</td>
                  <td><?php echo $row['v2']; ?> V</td>
                  <td><?php echo $row['c2']; ?> A</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
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
    var url = "../php/read_all.php";
    $.getJSON(url, function(data) {
      var v1 = data['tms'][(Object.keys(data['tms']).length) - 1]['v1'];
      var v2 = data['tms'][(Object.keys(data['tms']).length) - 1]['v2'];
      var v3 = data['tms'][(Object.keys(data['tms']).length) - 1]['v3'];

      var c1 = data['tms'][(Object.keys(data['tms']).length) - 1]['c1'];
      var c2 = data['tms'][(Object.keys(data['tms']).length) - 1]['c2'];
      var c3 = data['tms'][(Object.keys(data['tms']).length) - 1]['c3'];

      document.querySelector("#v1").innerHTML = '  ' + v1 + ' V';
      document.querySelector("#v2").innerHTML = '  ' + v2 + ' V';
      document.querySelector("#v3").innerHTML = '  ' + v3 + ' V';

      document.querySelector("#c1").innerHTML = '  ' + c1 + ' A';
      document.querySelector("#c2").innerHTML = '  ' + c2 + ' A';
      document.querySelector("#c3").innerHTML = '  ' + v3 + ' A';

      document.querySelector("#r1").innerHTML = '  ' + (v1/c1).toFixed(2) + ' &#8486';
      document.querySelector("#r2").innerHTML = '  ' + (v2/c2).toFixed(2) + ' &#8486';
      document.querySelector("#r3").innerHTML = '  ' + (v3/c3).toFixed(2) + ' &#8486';

    });
  }

  window.setInterval(function() {
    loadData();
  }, 500);

  document.querySelector("title").innerText = "TMS ~ Home";
  document.querySelectorAll("nav #sidebar_menu li")[0].classList.add("mm-active");
</script>
<?php
include './end.php';
?>