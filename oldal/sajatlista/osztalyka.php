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
            case 'lista': {
                $postData = $this->erkezettAdatok;
                $userId = $_SESSION['userId']; 
                $list = $postData->list;
                $listname = $postData->listname; 
                $listacska = new Listacska(); 
                $listacska->linzertinto($userId, $list, $listname); 
                break;
            }

            case 'osszesAdat': {
                $konyvtar = new Listacska();
                echo $konyvtar->osszerLista($_SESSION['userId']);
                break;
           }
           case 'megjelnoites': {
            $postData = json_decode(file_get_contents('php://input')); 
            $lisid = isset($postData->lisid) ? $postData->lisid : null; 
            if ($lisid !== null) {
                $konyvtar = new Listacska();
                echo $konyvtar->lekredii($lisid); 
            } else {
                echo json_encode(array('error' => 'No lisid provided'), JSON_UNESCAPED_UNICODE);
            }
            break;
        }

        case 'jajtorlom': {
            $listacska = new Listacska(); 
            
            echo $listacska->jajtorlom($this->erkezettAdatok->lisid);

            break;
        }


            
            default: {
                echo "nem késő szakot váltani!";
                break;
            }
        }
    }
}

class Listacska {
    public function linzertinto($userId, $list, $listname) {
        $serializedList = serialize($list);
        
        $sqlMuvelet = "INSERT INTO user_list (user_id, list, listname) VALUES ('$userId', '$serializedList', '$listname');";
        Adatbazis::adatModositas($sqlMuvelet);
    }

    public function osszerLista($userId) { 
        $sqlMuvelet = "select id, listname, list from user_list WHERE user_list.user_id = {$userId};";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        
       
        foreach ($sqlEredmeny as &$row) {
            $row['list'] = unserialize($row['list']);
        }

        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function lekredii($lisid) { 
        $sqlMuvelet = "SELECT user_list.list, user_list.created_at FROM user_list WHERE user_list.id = {$lisid};";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        
        
        if (!empty($sqlEredmeny)) {
           
            $response = $sqlEredmeny[0];
    
            $list = unserialize($response['list']);
    
        
            $response['list'] = $list;
    
          
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
        
            return json_encode(array('error' => 'No data found'), JSON_UNESCAPED_UNICODE);
        }
    }

    public function jajtorlom($lisid) {
    
        $sqlMuvelet = " DELETE FROM user_list WHERE id = {$lisid};";
            return json_encode(Adatbazis::adatModositas($sqlMuvelet), JSON_UNESCAPED_UNICODE);
    }
    
   
    
}



    class Adatbazis {
        private static $kiszolgalo = 'localhost';
        private static $felhasznalo = 'root';
        private static $jelszo = '';
        private static $tabla = 'zenek';
        private static $db;

        



        //nem birom tovabb segitseg
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