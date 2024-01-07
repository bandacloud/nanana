function loadData() {
  var url = "../php/read-gate-data.php";
  $.getJSON(url, function (data) {
    var data = data;

    var status = data["gate"][0]["status"];
    var mode = data["gate"][0]["mode"];
    var direction = data["gate"][0]["direction"];

    // console.log("gate status:", status);
    // console.log("switch mode:", mode);

    //Controlling the gate
    let gateSwitch = document.querySelector("#gateSwitch");
    let modeSwitch = document.querySelector("#modeSwitch");
    var directionSwitch = document.querySelector("#directionSwitch");
    let gate = document.querySelector(".gate");

    if (status == "opened" && mode == "manual") {
      gateSwitch.checked = true; //programmatically check the switch
      modeSwitch.checked = true; //programmatically check the switch

      gate.src = "../img/gate-opened.png";
      gate.setAttribute("alt", "opened");

      //monitor if checkbox is clicked
      gateSwitch.addEventListener("click", function () {
        //turn gate on if the switch is on
        if (gateSwitch.checked) {
          gate.src = "../img/gate-opened.png";
          gate.setAttribute("alt", "opened");
          console.log("Gate Manually Opened");

          let url = "../php/update-gate.php?id=1&status=opened";
          $.getJSON(url, function (data) {
            console.log(data);
          });
        } else {
          //turn gate off if switch is off
          gate.src = "../img/gate-closed.png";
          gate.setAttribute("alt", "closed");
          console.log("Gate Manually Closed");

          let url = "../php/update-gate.php?id=1&status=closed";
          $.getJSON(url, function (data) {
            console.log(data);
          });
        }
      });
    } else if (status == "closed" && mode == "manual") {
      gateSwitch.checked = false; //programmatically check the switch
      modeSwitch.checked = true; //programmatically check the switch

      gate.src = "../img/gate-closed.png";
      gate.setAttribute("alt", "closed");

      //monitor if checkbox is clicked
      gateSwitch.addEventListener("click", function () {
        //turn gate on if the switch is on
        if (gateSwitch.checked) {
          gate.src = "../img/gate-opened.png";
          gate.setAttribute("alt", "opened");
          console.log("Gate Opened");

          let url = "../php/update-gate.php?id=1&status=opened";
          $.getJSON(url, function (data) {
            console.log(data);
          });
        } else {
          //turn gate off if switch is off
          gate.src = "../img/gate-closed.png";
          gate.setAttribute("alt", "closed");
          console.log("Gate Closed");

          let url = "../php/update-gate.php?id=1&status=closed";
          $.getJSON(url, function (data) {
            console.log(data);
          });
        }
      });
    } else if (status == "opened" && mode == "auto") {
      gateSwitch.checked = true; //programmatically check the switch
      modeSwitch.checked = false; //programmatically check the switch

      gate.src = "../img/gate-opened.png";
      gate.setAttribute("alt", "opened");
      console.log("Gate Automatically Opened");
    } else if (status == "closed" && mode == "auto") {
      gateSwitch.checked = false; //programmatically uncheck the switch
      modeSwitch.checked = false; //programmatically uncheck the switch

      gate.src = "../img/gate-closed.png";
      gate.setAttribute("alt", "closed");
      console.log("Gate Automatically Closed");
    }

    if(direction == "ltr"){
      directionSwitch.checked = true; //programmatically uncheck the switch
      console.log("Direction changed to Left to Right");
    } else {
      directionSwitch.checked = false; //programmatically uncheck the switch
      console.log("Direction changed to Right to Left");
    }

    //monitor if checkbox is clicked
    modeSwitch.addEventListener("click", function () {
      //turn bulb on if the switch is on
      if (modeSwitch.checked) {
        let url = "../php/update-mode.php?id=1&mode=manual";
        $.getJSON(url, function (data) {
          console.log(data);
        });
      } else {
        let url = "../php/update-mode.php?id=1&mode=auto";
        $.getJSON(url, function (data) {
          console.log(data);
        });
      }
    });

    //monitor if checkbox is clicked
    directionSwitch.addEventListener("click", function () {
      //turn bulb on if the switch is on
      if (directionSwitch.checked) {
        let url = "../php/update-mode.php?id=1&direction=ltr";
        $.getJSON(url, function (data) {
          console.log(data);
        });
      } else {
        let url = "../php/update-mode.php?id=1&direction=rtl";
        $.getJSON(url, function (data) {
          console.log(data);
        });
      }
    });
  });
}

window.setInterval(function () {
  loadData();
}, 500);