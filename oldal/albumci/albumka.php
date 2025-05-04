<?php

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function fetchData($datum) {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($datum)) {
                $bekuldottDatum = $datum;

                $kezdoDatum = date('Y-m-d', strtotime('monday this week', strtotime($bekuldottDatum)));
                $vegsoDatum = date('Y-m-d', strtotime('sunday this week', strtotime($bekuldottDatum)));

                $sql = "SELECT * FROM albumka WHERE chart_weel BETWEEN '$kezdoDatum' AND '$vegsoDatum'";
                $result = $this->conn->query($sql);

                if ($result->num_rows > 0) {
                    $response = "<br><br><h3 class ='aaaa'>Az adatok a következő időszakra vonatkoznak: $kezdoDatum - $vegsoDatum</h3>";
                    $response .= "<div class='table-responsive' data-aos='fade-left' data-aos-duration='1300'>";
                    $response .= "<table class='table table-striped'>";
                    $response .= "<thead class='thead-dark'>";
                    $response .= "<tr><th>Pozíció</th><th>Cím</th><th>Előadó</th><th>Előző heti pozíció</th><th>Legjobb helyezés</th><th>Listán töltött hetek</th></tr>";
                    $response .= "</thead>";
                    $response .= "<tbody>";

                    while ($row = $result->fetch_assoc()) {
                        $response .= "<tr>";

                        if ($row['lastweek'] == 0) {
                            $response .= "<tr class='table-info'>"; 
                        } elseif ($row['chart_weel'] > $row['lastweek']) {
                            $response .= "<tr class='table-danger'>"; 
                        } elseif ($row['chart_weel'] < $row['lastweek']) {
                            $response .= "<tr class='table-success'>"; 
                        } else {
                            $response .= "<tr>";
                        }

                        $response .= "<td>" . $row['position'] . "</td>";
                        $response .= "<td>" . $row['album'] . "</td>";
                        $response .= "<td>" . $row['performer'] . "</td>";
                        $response .= "<td>" . $row['lastweek'] . "</td>";
                        $response .= "<td>" . $row['peak_pos'] . "</td>";
                        $response .= "<td>" . $row['time_on_chart'] . "</td>";
                        $response .= "</tr>";
                    }
                    $response .= "</tbody>";
                    $response .= "</table>";
                    $response .= "</div>";
                    echo $response;
                } else {
                    echo "Nincs találat a megadott dátumhoz.";
                }
            } else {
                echo "Kérlek, add meg a kívánt dátumot!";
            }
        }

        $this->conn->close();
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenek";

$dbConnection = new DatabaseConnection($servername, $username, $password, $dbname);
$dbConnection->fetchData($_POST['datum']);
?>
