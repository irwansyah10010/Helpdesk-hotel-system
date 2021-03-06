<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace engine\database\driver;

use engine\database\DatabaseSql;

class MysqlConnection extends DatabaseSql{
    
    function __construct() {
        $this->initial();
    }
    
    function getConnection() {
        $con="";
        
        try{
            
            $con = new \PDO($this->getDB().':host='.$this->getHost().';dbname='.$this->getDBName().';port='.$this->getPort(), $this->getUsername(), $this->getPassword());
            
            $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //$con->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);
            
        } catch (\PDOException $ex) {
            
            switch ($ex->getCode()){
                // case ketika server tidak tersedia
                case 2002:
                    echo '['.$this->getDB().':host='.$this->getHost().']'.' Server tidak tersedia';
                    break;
                // Database
                case 1049 :
                    echo '[Database = '.$this->getDBName().']'.' Nama database tidak tersedia ';
                    break;
                // Username
                case 1044 :
                    echo '[Username ='.$this->getUsername().']'.' Akses di tolak untuk Host @'.$this->getHost().'dengan nama database '.$this->getDBName();
                    break;
                // Password
                case 1045 :
                    echo '[Password ='.$this->getPassword().']'.' Akses di tolak untuk user '.$this->getUsername().'@'.$this->getHost().'(Gunakan Password: Iya)';
                    break;
                default:
                    break;
            }
            exit;
        }
        
        return $con;
    }
}
