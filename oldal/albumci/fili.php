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

    $sql = "SELECT albumka.chart_weel, albumka.album, albumka.performer, MIN(albumka.peak_pos) as minci, MAX(albumka.time_on_chart) as maxci 
            FROM albumka 
            WHERE albumka.performer LIKE '%{$performer}%' AND albumka.chart_weel > '0000-00-00' AND albumka.peak_pos > 0 
            GROUP BY albumka.album 
            ORDER BY 4 ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response = '<br><br><h3>Találatok</h3>';
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
               
                $response .= "<td style='background-color: #FFF176;'>" . $row['chart_weel'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['album'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['performer'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['minci'] . "</td>";
                $response .= "<td style='background-color: #FFF176;'>" . $row['maxci'] . "</td>";
            } elseif ($peak_pos <= 10 && $peak_pos > 1) {
            
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['chart_weel'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['album'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['performer'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['minci'] . "</td>";
                $response .= "<td style='background-color: #B3E5FC;'>" . $row['maxci'] . "</td>";
            } else {
               
                $response .= "<td>" . $row['chart_weel'] . "</td>";
                $response .= "<td>" . $row['album'] . "</td>";
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
        echo "Nincs találat a előadóra.";
    }
}



if (isset($_POST['album_name'])) {
    $album_name = $_POST['album_name'];
   

    $sql_album = "SELECT albumka.chart_weel, albumka.position, albumka.album, albumka.performer, albumka.peak_pos, albumka.time_on_chart FROM albumka WHERE albumka.album LIKE '%{$album_name}%' GROUP BY 1 ORDER by 1
    ";

    $result_album = $conn->query($sql_album);

    if ($result_album->num_rows > 0) {
        $response_album = "<br><br><h3 class = 'aaaa'>Találatok:</h3>";
        $response_album .= "<div class='table-responsive' data-aos='fade-left' data-aos-duration='1300'>";
        $response_album .= "<table class='table table-striped table-bordered'>";
        $response_album .= "<thead class='thead-dark'>";
        $response_album .= "<tr><th>Jelenlegi hét</th><th>Helyezés</th><th>Album</th><th>Előadó</th><th>Legjobb hely</th><th>Hetek a listán</th></tr>";
        $response_album .= "</thead>";
        $response_album .= "<tbody>";

        while ($row_album = $result_album->fetch_assoc()) {
            $response_album .= "<tr>";
            $current_week = intval($row_album['position']);
         
            if ($current_week == 1) {
              
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['chart_weel'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $current_week . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['album'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['performer'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td style='background-color: #FFF176;'>" . $row_album['time_on_chart'] . "</td>";
            } elseif ($current_week > 1 && $current_week <= 10) {
              
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['chart_weel'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $current_week . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['album'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['performer'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td style='background-color: #B3E5FC;'>" . $row_album['time_on_chart'] . "</td>";
            } else {
        
                $response_album .= "<td>" . $row_album['chart_weel'] . "</td>";
                $response_album .= "<td>" . $current_week . "</td>";
                $response_album .= "<td>" . $row_album['album'] . "</td>";
                $response_album .= "<td>" . $row_album['performer'] . "</td>";
                $response_album .= "<td>" . $row_album['peak_pos'] . "</td>";
                $response_album .= "<td>" . $row_album['time_on_chart'] . "</td>";
            }

            $response_album .= "</tr>";
        }
        $response_album .= "</tbody>";
        $response_album .= "</table>";
        $response_album .= "</div>";
        echo $response_album;
    } else {
        echo "Nincs találat az albumra.";
    }
}


$conn->close();
?>
