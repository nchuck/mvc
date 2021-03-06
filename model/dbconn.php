<?php
class DatabaseConnection {

    private $conn;
    private $user;
    private $pass;

    function __construct(){
        $this->conn = null;
        $this->user = 'libreria';
        $this->pass = 'libreria';
    }

    private function openConn(){
        $this->conn = new PDO('mysql:host=localhost;dbname=libros', $this->user, $this->pass);
        return $this->conn;
    }

    private function closeConn(){
        $this->conn = null;
    }

    /**
     * Calls a query and returns the object, also logs to ChromePHP logger
     *
     * @param $sentence
     * @return mixed
     */
    function raw($sentence){
        $this->openConn();
        $result = $this->conn->query($sentence);
        return $result;
    }

    function quote($var){
        return  "'".$var."'";
    }

    function quoteConcat($var){
        return $this->quote($var).',';
    }

    function query($sentence){
        $this->openConn();
        $result = $this->conn->query($sentence)->fetchAll();
        $this->closeConn();
        return $result;
    }

    function fetchRow($sentence){
        $this->openConn();
        $result = $this->conn->query($sentence)->fetch(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $result;
    }

    function singleton($sentence){
        $res = $this->openConn()->query($sentence)->fetchColumn(0);
        $this->closeConn();
        return $res;
    }

    function procedure($sentence, $parameters) {
        $conn = $this->openConn();
        $sentence = $conn->prepare($sentence);
        $sentence->execute($parameters);
        $this->closeConn();
    }


}