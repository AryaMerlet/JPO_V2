<?php 

class Database{
    public static function getPDO(){
        $host = '127.0.0.1';
        $db = 'site_actualite';
        $user = 'root';
        $pass = '';
        $port = '3306';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        $pdo = new PDO($dsn, $user, $pass);
        return $pdo;
    }

    public static function query($sql, $params=[]) {
        $pdo = self::getPDO();
        $temp = $pdo->prepare($sql);
        
        foreach ($params as $param => $value) {
            $temp->bindParam($param, $value);
        }
        $temp->execute();
        
        return $temp->fetchAll(PDO::FETCH_ASSOC);
    } 
}
 

