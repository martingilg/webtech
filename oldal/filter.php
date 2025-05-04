<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenek";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['performer'])) {
    $performer = $_POST['performer'];

    $sql = "SELECT cica.chart_week, cica.title, cica.performer, MIN(cica.peak_pos) as minci, MAX(cica.wks_on_chart) as maxci FROM cica WHERE cica.performer LIKE '%{$performer}%' AND cica.chart_week > '0000-00-00' GROUP BY cica.title ORDER BY 4 ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response = '<h3>Eredmény:</h3>';
        $response .= "<div class='table-responsive' data-aos='fade-left' data-aos-duration='1300'>";
        $response .= "<table class='table table-striped table-bordered'>";
        $response .= "<thead class='thead-dark'>";
        $response .= "<tr><th>Legjobb hét</th><th>Cím</th><th>Előadó(k)</th><th>Legjobb helyezés</th><th>Listán töltött hetek</th></tr>";
        $response .= "</thead>";
        $response .= "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $peak_pos = intval($row['minci']); 

            $response .= "<tr>";

            
            if ($peak_pos == 1) {
           
                $response .= "<td style='background-color: #FFF176;'>" . $row['chart_week'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['title'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['performer'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['minci'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['maxci'] . "</td>";
            } elseif ($peak_pos > 1 && $peak_pos <= 10) {
            
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['chart_week'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['title'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['performer'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['minci'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['maxci'] . "</td>";
            } else {
    
                $response .= "<td>" . $row['chart_week'] . "</td>";
                $response .= "<td>" . $row['title'] . "</td>";
                $response .= "<td>" . $row['performer'] . "</td>";
                $response .= "<td>" . $row['minci'] . "</td>";
                $response .= "<td>" . $row['maxci'] . "</td>";
            }

            $response .= "</tr>";
        }
        $response .= "</tbody>";
        $response .= "</table>";
        $response .= "</div>";
        echo $response;
    } else {
        echo "Nincs találat.";
    }
}

if (isset($_POST['song_keres'])) {
    $song_keres = $_POST['song_keres'];

    $sql_szam = "SELECT cica.chart_week, cica.current_week, cica.peak_pos, cica.title, cica.performer, cica.wks_on_chart FROM cica WHERE cica.title LIKE '%{$song_keres}%' AND cica.chart_week > '0000-00-00' GROUP BY 1 ORDER BY 1 ASC";

    $szamosmamos = $conn->query($sql_szam);

    if ($szamosmamos->num_rows > 0) {
        $response_album = '<h3>Eredmény:</h3>';
        $response_album .= "<div class='table-responsive' data-aos='fade-left' data-aos-duration='1300'>";
        $response_album .= "<table class='table table-striped table-bordered'>";
        $response_album .= "<thead class='thead-dark'>";
        $response_album .= "<tr><th>Hét</th><th>Hely</th><th>Szám</th><th>Előadó(k)</th><th>Csúcs</th><th>Listán töltött hetek</th></tr>";
        $response_album .= "</thead>";
        $response_album .= "<tbody>";

        while ($row_album = $szamosmamos->fetch_assoc()) {
            $response_album .= "<tr>";
            $current_week = intval($row_album['current_week']);
        
            if ($current_week == 1) {
              
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['chart_week'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $current_week . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['title'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['performer'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['wks_on_chart'] . "</td>";
            } elseif ($current_week > 1 && $current_week <= 10) {
          
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['chart_week'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $current_week . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['title'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['performer'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['wks_on_chart'] . "</td>";
            } else {
              
                $response_album .= "<td>" . $row_album['chart_week'] . "</td>";
                $response_album .= "<td>" . $current_week . "</td>";
                $response_album .= "<td>" . $row_album['title'] . "</td>";
                $response_album .= "<td>" . $row_album['performer'] . "</td>";
                $response_album .= "<td>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td>" . $row_album['wks_on_chart'] . "</td>";
            }

            $response_album .= "</tr>";
        }
        $response_album .= "</tbody>";
        $response_album .= "</table>";
        $response_album .= "</div>";
        echo $response_album;
    } else {
        echo "Nincs találat a zenére.";
    }
}

$conn->close();
?>
