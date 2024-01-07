var listen_link = "https://c14.radioboss.fm:8285/stream";
function ErrorNotify(err) {
  console.error(err);
}

$(function () {
  const mp_play = $("#miniplayer_play"),
    mp_stop = $("#miniplayer_stop"),
    mp = document.getElementById("miniplayer");
  let mp_error = false,
    mp_playing = false, //playing (or pending playing)
    mp_retry = false;

  //error handler for audio element
  function playerErrorHandler(e) {
    mp_error = true;
    mp_stop.click();
    ErrorNotify("Unable to play stream (1). Restart in 4 seconds.");
    mp_retry = setTimeout(function () {
      mp_play.click();
    }, 4000); //auto restart
  }

  function setPlayerErrorHandler() {
    removePlayerErrorHandler();
    mp.addEventListener("error", playerErrorHandler, true);
    mp.addEventListener("ended", playerErrorHandler, true);
  }

  function removePlayerErrorHandler() {
    mp.removeEventListener("error", playerErrorHandler, true);
    mp.removeEventListener("ended", playerErrorHandler, true);
  }

  mp_play.click(function () {
    if (mp_retry !== false) {
      clearTimeout(mp_retry);
      mp_retry = false;
    }
    if (mp_playing)
      //playing or pending playing
      return;
    mp_playing = true;
    //set error handler
    setPlayerErrorHandler();

    //set source
    const mp_src = mp.querySelector("source");
    mp_src.setAttribute("src", listen_link);
    mp.load();
    //start
    mp_error = false;
    const playpromise = mp.play();
    if (playpromise !== undefined) {
      playpromise.catch(function (error) {
        mp_error = true;
        if (mp_playing) ErrorNotify("Unable to play stream (2).");
        mp_playing = false;
        mp_stop.click();
      });
    }
    mp_play.removeClass("active");
    mp_stop.addClass("active");
  });

  mp_stop.click(function () {
    mp_playing = false;
    if (!mp_error) {
      const src = mp.querySelector("source");
      if (src !== null) {
        removePlayerErrorHandler();
        src.setAttribute("src", "");
        mp.load(); //load with empty source to stop the stream
      }
    }
    mp_play.addClass("active");
    mp_stop.removeClass("active");
  });
});
