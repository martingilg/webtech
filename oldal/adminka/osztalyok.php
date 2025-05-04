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
                case 'spotifyjavaslat': {
                    $konyvtar = new Adminos();
                    echo $konyvtar->javaslatMegtekintes();
                    break;
               }

               case 'nembiromtovabb': {
                $listacska = new Adminos(); 
                echo $listacska->deleteJavaslat($this->erkezettAdatok->idka);
 
                break;
            }

            case 'ne': {
              
                $postData = $this->erkezettAdatok;
            
     
                $helyezes = $postData->helyezes;
                $nevecskeje = $postData->nevecskeje;
                $havihallgatok = $postData->havihallgatok;
                $keplink = $postData->keplink;
            
             
                $listacska = new Adminos();
            
            
                echo $listacska->jajdejo($helyezes, $nevecskeje, $havihallgatok, $keplink);
                break;
            }


            case 'osszesfelho':
            {
                $konyvtar = new Adminos();
                echo $konyvtar->felhokLista();
                break;
            }

            case 'deletecica': {
                $listacska = new Adminos(); 
                
                echo $listacska->deletefelhi($this->erkezettAdatok->idfelhi);
 
                break;
            }

            case 'norbiupdate': {
                $postData = $this->erkezettAdatok;
    $idke = $postData->idke; 
    $ujnev = $postData->ujnev;
    $ujjeli = $postData->ujjelszo; 
    $adminos = new Adminos(); 
    echo $adminos->updateflehi($ujnev, $ujjeli, $idke); 
    break;
            }



            case 'hajszkoros':
                {
                    $konyvtar = new Adminos();
                    echo $konyvtar->hajszkorlista();
                    break;
                }


                case 'deletehs': {
                    $listacska = new Adminos(); 
                    
                    echo $listacska->deletefelhi($this->erkezettAdatok->idhs);
     
                    break;
                }
            
                
                default: {
                    echo "nem késő szakot váltani!";
                    break;
                }
            }
        }

       
        
    }

    class Adminos {


        public function javaslatMegtekintes() {
            $sqlMuvelet = "SELECT users.username, javaslatok.id, javaslatok.nevecske, javaslatok.linkecske from javaslatok INNER JOIN users ON users.id = javaslatok.user_id";
            $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
            return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
        }
       
        public function deleteJavaslat($idka) {
            $sqlMuvelet = "DELETE FROM javaslatok WHERE id = '{$idka}'";
            return json_encode(Adatbazis::adatModositas($sqlMuvelet), JSON_UNESCAPED_UNICODE);
        }

        public function jajdejo($helyezes, $nevecskeje, $havihallgatok, $keplink) {

            $sqlMuvelet = "INSERT INTO `eloado_adatok` (`helyezes`, `eloado`, `havihallgato`, `kep`) VALUES ('{$helyezes}', '{$nevecskeje}', '{$havihallgatok}', '{$keplink}');";
        Adatbazis::adatModositas($sqlMuvelet);
        }

        public function felhokLista() {

            $sqlMuvelet = "SELECT users.id, users.username from users WHERE users.is_admin = 0 order by 1;";
            $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
            return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
        }


        public function deletefelhi($idfelhi) {

            

            $sqlMuvelet = "DELETE FROM users WHERE id = '{$idfelhi}'";
            return json_encode(Adatbazis::adatModositas($sqlMuvelet), JSON_UNESCAPED_UNICODE);
        }

        

        public function updateflehi($ujnev, $ujjeli, $idke) {
     
            $hashedPassword = password_hash($ujjeli, PASSWORD_DEFAULT);
        
          
            $sqlMuvelet = "UPDATE users
                SET username = '{$ujnev}', password = '{$hashedPassword}'
                WHERE id = {$idke}";
            
            return json_encode(Adatbazis::adatModositas($sqlMuvelet), JSON_UNESCAPED_UNICODE);
        }

        public function hajszkorlista() {

            $sqlMuvelet = "SELECT DISTINCT users.id, users.username as 'felhi', MAX(user_scores.score) as 'legnagyobb', MAX(user_scores.timestamp) as 'ido' FROM users INNER JOIN user_scores on users.id = user_scores.user_id GROUP BY 1 ORDER BY 2 DESC;";
            $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
            return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
        }

        public function deletehajszkor($idhs) {
            $sqlMuvelet = "UPDATE user_scores
            SET score = 0
            WHERE user_id = {$idhs};";
            return json_encode(Adatbazis::adatModositas($sqlMuvelet), JSON_UNESCAPED_UNICODE);
        }
        
        

        
    }

    class Adatbazis {
        private static $kiszolgalo = 'localhost';
        private static $felhasznalo = 'root';
        private static $jelszo = '';
        private static $tabla = 'zenek';
        private static $db;

        



      
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