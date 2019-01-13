<?php
if (isset($_GET['ajax'])) {
    session_start();
    $handle = fopen('tmp/sendMail.log', 'r');
    if (isset($_SESSION['offset'])) {
        echo "offset: ".$_SESSION['offset']."<br>";
        $data = stream_get_contents($handle, -1, $_SESSION['offset']);
        echo nl2br($data);
        $_SESSION['offset'] = ftell($handle);
    } else {
        fseek($handle, 0, SEEK_END);
        $_SESSION['offset'] = ftell($handle);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-timing.js"></script> <!-- Составная tail.php -->
    <script>
  $(function() {
    $.repeat(1000, function() {
      $.get('sendMailProcess.php?ajax', function(data) {
        $('#tail').append(data);
      });
    });
  });
    </script>
</head>
<body>
  <div id="tail">Starting up...<br></div>

<!--  <div class="container">
    <h2>Процесс отправки сообщений</h2>
    <p>Отправлено писем:</p>
    <div class="progress">
      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
        40%
      </div>
    </div>
  </div>-->
</body>
</html>