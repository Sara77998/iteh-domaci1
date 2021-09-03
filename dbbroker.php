<?php

class DBBroker{
    private $mysqli;

    public function __construct(Mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }
    public function vratiSveZanrove()
    {
                $upit = "SELECT * FROM zanr";

                $rs = $this->mysqli->query($upit);
                $zanrovi = [];
            while ($red = $rs->fetch_object()) {
                $zanrovi[] = new Zanr($red->zanrID,$red->nazivZanra);
            }
            return $zanrovi;
    }
}
?>