<?php

class db2{
    //имя и путь к БД
    //имя подключения к рабочей базе
           
    //логин и пароль к БД
    protected $dblogin;
    protected $dbpass;

    protected $conn; //подключение к бд
    protected static $instance; //свойство для хранения экземпляра класса

    private function __construct(){ //закрываем конструктор для доступа снаружи
        $this->dblogin='dbadmin';
        $this->dbpass='dev$%2501';       
        $this->conn = new \PDO(DB_NAME_MAIN, $this->dblogin, $this->dbpass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public function getInstance($login='',$pass=''){ //метод создания экземпляра класса		       
        if (is_null(self::$instance)) {
            self::$instance = new db2($login,$pass); //здесь вызывается конструктор с двумя параметрами                
        }
        
        return self::$instance;
    }

    public function getConnection(){ //метод создания подключения к БД (как свойства объекта БД)		
        try{
            $conn = new \PDO(DB_NAME_MAIN, $this->dblogin, $this->dbpass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
            return $conn;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }  
    }
    
    
    public function lastContCode($TblName){
        $MaxId=$this->FetchOne('SELECT MAX(ContCode) as MaxId FROM '.$TblName,[])->MAXID;
        return $this->FetchOne('SELECT * FROM '.$TblName.' WHERE ContCode=?',[$MaxId]);
    }
    
    public function Query($sql,$params=[]) {//вызов запроса к БД c параметрами        
        try {
            $query=$this->getConnection()->prepare($sql);                     
        } catch (\PDOException $e) {            
            new MyCheck($e,$sql,2);
        }
        
        try {
            $query->execute($params);            
        } catch (\PDOException $e) {
            new MyCheck([$e,$sql,$params],1);
        }                
        return $query;                         
    }
    
    public function FetchOne($sql='',$params=[]) {//разбор одной строки
        try{
            $result=$this->Query($sql,$params);
            return $result->fetch(\PDO::FETCH_OBJ); //строка возвращается в виде объекта
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function FetchAll($sql,$params=[]) {//разбор нескольких строк
        try{
            $result=$this->Query($sql,$params);
            return $result->fetchAll(\PDO::FETCH_OBJ); //каждая строка таблицы возвращается в виде объекта, а все образуют массив
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }                
    }          
        
}


	