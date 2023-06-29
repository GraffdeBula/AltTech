<?php

class db0{       
    const DB_NAME='firebird:dbname=192.168.154.252:client1;charset=win1251;';
    protected $dblogin;
    protected $dbpass;

    protected $conn; //подключение к бд
    protected static $instance; //свойство для хранения экземпляра класса

    private function __construct(){ //закрываем конструктор для доступа снаружи
        $this->dblogin='webchecker';
        $this->dbpass='afpc$0909';
        $this->conn = new \PDO(self::DB_NAME, $this->dblogin, $this->dbpass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public function getInstance(){ //метод создания экземпляра класса		
        if (is_null(self::$instance)) {
            self::$instance = new db0(); //здесь вызывается конструктор с двумя параметрами                
        }
        
        return self::$instance;
    }

    public function getConnection(){ //метод создания подключения к БД (как свойства объекта БД)		
        try{
            $conn = new \PDO(self::DB_NAME, $this->dblogin, $this->dbpass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            return $conn;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }  
    }
           
    public function query_select($sql) {//вызов запроса к БД
        return $this->getConnection()->query($sql);                         
    }
        
    public function fetch_one($sql) {//разбор одной строки
            try{
                $result=$this->query_select($sql);
                return $result->fetch(\PDO::FETCH_OBJ); //строка возвращается в виде объекта
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
    }     
    
}


	