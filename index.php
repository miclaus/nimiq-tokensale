<?php
# nimiq-tokensale (http://www.quarx.io/nimiq)
# author: iosif miclaus
# version: 0.5.0

// constants
define('REFRESH_SECONDS', 20);

// ...
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Nimiq Token Sale Live Progress</title>

  <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"
  ></script>

  <!-- <link href="css/reset.css" rel="stylesheet"> -->
  <link href="css/main.css" rel="stylesheet">

  <style>
    html, body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
      font-size: 16px;
      margin: 0;
    }
    .hint {
      font-size: 0.8rem;
    }
    #tokensale {
      position: absolute;
      z-index: 99;
      padding: 1rem;
    }
  </style>
</head>
<body>
  <div id="tokensale">
    <h1>Nimiq Token Sale Live Progress</h1>
    <p id="token-sale-progress-value">loading ...</p>
    <div class="hint">
      <span id="refreshing-progress">refresh in <?php echo REFRESH_SECONDS ?> seconds</span>
      <span>(<a href=".">refresh now</a>)</span>
    </div>
    <p class="hint">
      <a href="https://etherscan.io/address/0xcfb98637bcae43c13323eaa1731ced2b716962fd">see more</a>
    </p>
  </div>
  <div id="gamecontainer">
     <div id="gamescreen">
        <div id="sky" class="animated">
           <div id="flyarea">
              <div id="ceiling" class="animated"></div>
              <!-- This is the flying and pipe area container -->
              <div id="player" class="bird animated"></div>

              <div id="bigscore"></div>

              <div id="splash"></div>

              <div id="scoreboard">
                 <div id="medal"></div>
                 <div id="currentscore"></div>
                 <div id="highscore"></div>
                 <div id="replay"><img src="assets/replay.png" alt="replay"></div>
              </div>

              <!-- Pipes go here! -->
           </div>
        </div>
        <div id="land" class="animated"><div id="debug"></div></div>
     </div>
  </div>
  <div id="footer">
    <a href="http://www.dotgears.com/">original game/concept/art by dong nguyen</a>
    <a href="http://nebezb.com/">recreated by nebez briefkani</a>
    <a href="http://github.com/nebez/floppybird/">view github project</a>
  </div>
  <div class="boundingbox" id="playerbox"></div>
  <div class="boundingbox" id="pipebox"></div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.transit.min.js"></script>
  <script src="js/buzz.min.js"></script>
  <script src="js/main.js"></script>

  <script>
    $(document).ready(function() {
      // NOTE: Please check on your own whether this address is legit or nah !
      var nimiq_addr = '0xcfb98637bcae43C13323EAa1731cED2B716962fD';
      var api_call = 'https://api.etherscan.io/api?module=account&action=balance&address=' + nimiq_addr;

      make_api_call();

      var curr_refresh_seconds = <?php echo REFRESH_SECONDS ?>;
      setInterval(function() {
        if ( curr_refresh_seconds > 0 ) {
          var seconds = 'seconds';
          if ( curr_refresh_seconds === 1 ) { seconds = 'second' }

          $('#refreshing-progress').html('refresh in ' + curr_refresh_seconds + ' ' + seconds);
        }
        else {
          $('#refreshing-progress').html('refreshing ...');
          make_api_call();
          curr_refresh_seconds = <?php echo REFRESH_SECONDS ?>;
        }

        curr_refresh_seconds--;
      }, 1000);

      function make_api_call() {
        $.get(api_call, function(data) {
          if ( typeof data === 'object'
            && typeof data.result === 'string'
            && data.result.trim() !== ''
          ) {
            var eth = data.result.trim();
            var rlvnt_eth = eth.slice(0, 5);
            var rest_eth = eth.slice(5).slice(0, 5);
            var curr_eth = Number(rlvnt_eth + '.' + rest_eth);
            var curr_percent = curr_eth * 100 / 60000;

            $('#token-sale-progress-value').html(
              curr_eth.toString() + ' / 60000 Ether (~' + curr_percent.toFixed(2) + '%)'
            );
          }
        });
      }
    });
  </script>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-101835084-1', 'auto');
    ga('send', 'pageview');
  </script>
</body>
</html>
