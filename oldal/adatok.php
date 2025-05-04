<?php
session_start();
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

        if (!isset($_SESSION['username'])) {
         
            header("Location: bejelentkezes/login.php");
            exit(); 
        }
        
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($datum)) {
                $bekuldottDatum = $datum;

                $kezdoDatum = date('Y-m-d', strtotime('monday this week', strtotime($bekuldottDatum)));
                $vegsoDatum = date('Y-m-d', strtotime('sunday this week', strtotime($bekuldottDatum)));

                $sql = "SELECT * FROM cica WHERE chart_week BETWEEN '$kezdoDatum' AND '$vegsoDatum'";
                $result = $this->conn->query($sql);

                if ($result->num_rows > 0) {
                    $response = "<br><br><h3 class ='aaaa' >Az adatok a következő időszakra vonatkoznak: $kezdoDatum - $vegsoDatum</h3>";
                    $response .= "<div class='table-responsive' data-aos='fade-left' data-aos-duration='1300'>";
                    $response .= "<table class='table table-striped table-bordered'>";
                    $response .= "<thead class='thead-dark table-header' >";
                    $response .= "<tr><th>Pozíció</th><th>Cím</th><th>Előadó</th><th>Előző heti pozíció</th><th>Legjobb helyezés</th><th>Listán töltött hetek</th></tr>";
                    $response .= "</thead>";
                    $response .= "<tbody>";
                
                    while ($row = $result->fetch_assoc()) {
                    
                        $background_color = '';
                        if ($row['last_week'] == 0) {
                            $background_color = '#cfe7f7'; // Blue background
                        } elseif ($row['current_week'] > $row['last_week']) {
                            $background_color = '#ffb3ba'; // Red background
                        } elseif ($row['current_week'] < $row['last_week']) {
                            $background_color = '#bdecb6'; // Green background
                        }
                        
                        $response .= "<tr style='background-color: $background_color'>";
                        $response .= "<td>" . $row['current_week'] . "</td>";
                        $response .= "<td>" . $row['title'] . "</td>";
                        $response .= "<td>" . $row['performer'] . "</td>";
                        $response .= "<td>" . $row['last_week'] . "</td>";
                        $response .= "<td>" . $row['peak_pos'] . "</td>";
                        $response .= "<td>" . $row['wks_on_chart'] . "</td>";
                        $response .= "</tr>";
                    }
                    $response .= "</tbody>";
                    $response .= "</table>";
                    $response .= "</div>";
                    echo $response;
                } else {
                    echo "Nincs találat.";
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
