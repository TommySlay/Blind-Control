<?php
    include_once('rolete_db.php');

    $result = getAllOutputs();
    $html_buttons = null;
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row["state"] == "1"){
                $button_checked = "checked";
            }
            else {
                $button_checked = "";
            }
            $html_buttons .= '<h3>' . $row["name"] .' - GPIO ' . $row["gpio"] .' - STATE ' . $row["state"] .' - id ' . $row["id"] . '</h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' . $button_checked . '><span class="slider"></span></label>';
        }
    }
?>

<!DOCTYPE HTML>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="esp-style.css">
        <title>ESP32 LED GPIO2 Control</title>
    </head>
<body>
    <h2>ESP32 LED GPIO2 Control</h2>
    <?php echo $html_buttons; ?>

    <br><br>

    <script>
        function updateOutput(element) {
            var xhr = new XMLHttpRequest();
            if(element.checked){
                xhr.open("GET", "rolete_actions.php?action=output_update&id="+element.id+"&state=1", true);
            }
            else {
                xhr.open("GET", "rolete_actions.php?action=output_update&id="+element.id+"&state=0", true);
            }
            xhr.send();
        }
    </script>
</body>
</html>
