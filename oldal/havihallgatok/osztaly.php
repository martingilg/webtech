<?php
    


session_start();


    
    
    
    class Utvonal {
        private $teljesURL;
        private $erkezettAdatok;

        public function __construct($URL) {
            $this->teljesURL = explode('/', $URL);
            $this->erkezettAdatok = json_decode(file_get_contents('php://input'), false);
        }

        public function utvonalVizsgalat() {
            switch (end($this->teljesURL)) {
                case 'havieloadok': {
                     $konyvtar = new Spotify();
                     echo $konyvtar->randomHall();
                     break;
                }

                case 'saveUserScore': {
                    $postData = $this->erkezettAdatok;
                    $userId = $_SESSION['userId'];
                    $score = $postData->score;
                    $this->saveUserScore($userId, $score);
                    break;
                }


                case 'highscore': {
                    $konyvtar = new Spotify();
                    echo $konyvtar->hajszkulmjuzikel();
                    break;
               }

               case 'ehesvagyok': {
               
                $postData = $this->erkezettAdatok;
                $userId = $_SESSION['userId'];
                
                
                $nev = isset($postData->nev) ? $postData->nev : null;
                $link = isset($postData->link) ? $postData->link : null;
                
                $this->kerelemBekuldi($userId, $nev, $link); 
                
                break;
            }
                
                default: {
                    echo "nem késő szakot váltani!";
                    break;
                }
            }
        }

        private function saveUserScore($userId, $score) {
            $spotify = new Spotify();
            $spotify->saveUserScore($userId, $score);
        }

        private function kerelemBekuldi($userId, $nev, $link) {
            $spotify = new Spotify();
            $spotify->kerelemBekuldi($userId, $nev, $link);
        }   

        
    }

    class Spotify {


        
        public function randomHall() {
            $sqlMuvelet = "SELECT eloado_adatok.helyezes, eloado_adatok.eloado, eloado_adatok.havihallgato, eloado_adatok.kep FROM eloado_adatok
            ORDER BY RAND()
            LIMIT 2;";
            $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
            return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
        }
    
        public function saveUserScore($userId, $score) {
            $sqlMuvelet = "INSERT INTO user_scores (user_id, score) VALUES ('$userId', '$score')";
            Adatbazis::adatModositas($sqlMuvelet);
        }
    
        public function hajszkulmjuzikel() {
            $sqlMuvelet = "SELECT DISTINCT users.username as 'felhi', MAX(user_scores.score) as 'legnagyobb', MAX(user_scores.timestamp) as 'ido' FROM users INNER JOIN user_scores on users.id = user_scores.user_id WHERE user_scores.score > 0 GROUP BY 1 ORDER BY 2 DESC;";
            $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
            return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
        }
    
        public function kerelemBekuldi($userId, $nev, $link) {
            $sqlMuvelet = "INSERT INTO javaslatok (user_id, nevecske, linkecske) VALUES ('$userId', '$nev', '$link')";
            Adatbazis::adatModositas($sqlMuvelet);
        }

        

        
    }

    class Adatbazis {
        private static $kiszolgalo = 'localhost';
        private static $felhasznalo = 'root';
        private static $jelszo = '';
        private static $tabla = 'zenek';
        private static $db;

        



        //adatok lekérése az adatbázisból
        public static function adatLekeres($muvelet) {
            self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);

            if (self::$db->connect_errno == 0) {
                $eredm = self::$db->query($muvelet);
                if (self::$db->errno == 0) {
                    if ($eredm->num_rows > 0) {
                        $adatok = $eredm->fetch_all(MYSQLI_ASSOC);
                    }
                    else {
                        $adatok = array('valasz' => 'Nincs találat');
                    }
                }
                else {
                    $adatok = self::$db->error;
                }
            }
            else {
                $adatok = self::$db->connect_error;
            }

            return $adatok;
        }

        public static function adatModositas($muvelet) {
            self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);

            if (self::$db->connect_errno == 0) {
                $eredm = self::$db->query($muvelet);
                if (self::$db->errno == 0) {
                    if (self::$db->affected_rows > 0) {
                        $adatok = array('valasz' => "Sikeres");
                    }
                    else {
                        $adatok = array('valasz' => 'Sikeretlen');
                    }
                }
                else {
                    $adatok = self::$db->error;
                }
            }
            else {
                $adatok = self::$db->connect_error;
            }

            return $adatok;
        }
    }

 
?>