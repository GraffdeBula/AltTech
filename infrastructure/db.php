<?php

class db{    
    //имя подключения к рабочей базе
    const DB_NAME='firebird:dbname=192.168.154.252:client1;charset=win1251;';    
    //логин и пароль к БД
    protected $dblogin;
    protected $dbpass;

    protected $conn; //подключение к бд
    protected static $instance; //свойство для хранения экземпляра класса

    private function __construct($login='superad',$pass='adm$0906'){ //закрываем конструктор для доступа снаружи
        $this->dblogin='superad';
        $this->dbpass='adm$%0106';
        $this->conn = new \PDO(self::DB_NAME, $this->dblogin, $this->dbpass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public function getInstance($login='',$pass=''){ //метод создания экземпляра класса		       
        if (is_null(self::$instance)) {
            self::$instance = new db($login,$pass); //здесь вызывается конструктор с двумя параметрами                
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
    
    public function query_select2($sql,$params=[]) {//вызов запроса к БД c параметрами        
        $query=$this->getConnection()->prepare($sql); 
        $params=self::towin($params);
        $query->execute($params);
                
        return $query;//->execute($params);                         
    }
        
    public function fetch_all($sql) {//разбор нескольких строк
        try{
            $result=$this->query_select($sql);
            return self::toutf($result->fetchAll(\PDO::FETCH_OBJ)); //каждая строка таблицы возвращается в виде объекта, а все образуют массив
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }                
    }
    
    public function fetch_all2($sql,$params=[]) {//разбор нескольких строк
        try{
            $result=$this->query_select2($sql,$params);
            return self::toutf($result->fetchAll(\PDO::FETCH_OBJ)); //каждая строка таблицы возвращается в виде объекта, а все образуют массив
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }                
    }
        
    public function fetch_one($sql) {//разбор одной строки
            try{
                $result=$this->query_select($sql);
                return self::toutf($result->fetch(\PDO::FETCH_OBJ)); //строка возвращается в виде объекта
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
    }
    
    public function fetch_one2($sql,$params=[]) {//разбор одной строки
            try{
                $result=$this->query_select2($sql,$params);
                return self::toutf($result->fetch(\PDO::FETCH_OBJ)); //строка возвращается в виде объекта
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
    }
        
    public function toutf($myobj){//метод получает объект для преобразования его текстовых свойств из win1251 в utf                     
        if (!$myobj==NULL){
            foreach ($myobj as $key => $var){//разбираем объект на свойства
                if (is_object($var)){ //если свойство тоже объект (или метод получил массив объектов из fetch_all), то рекурсия
                    self::toutf($var);
                }
                if (is_string($var)){

                    $myobj->$key=iconv('windows-1251','UTF-8',$var);
                }                
            }
        }

        return $myobj;
    }
        
    public function towin($myobj){//из utf в win
        $myobj1=[];
        foreach ($myobj as $key => $var){//разбираем объект на свойства
            if (is_object($var)){ //если свойство тоже объект (или метод получил массив объектов из fetch_all), то рекурсия                
                self::towin($var);                
            }
            if (is_array($var)){ //если свойство тоже объект (или метод получил массив объектов из fetch_all), то рекурсия                
                self::towin($var);
            }
            if (is_string($var)){                       
                $myobj1[$key]=iconv('UTF-8','windows-1251',$var);                
            }                
        }  
        return $myobj1;
    }
    
    
    //методы для передачи данных в таблицы
    public function query_insert($sql, $params){
        //подготовка запроса       
        $query = $this->getConnection()->prepare($sql);
        // выполнение запроса                
        $params1=self::towin($params);
        foreach ($params1 as $param) {
            $query->execute($param);
        }
        $query->closeCursor(); // Закрываем курсор
    }
    
    public function queryInsertOne($sql, $params){
        //подготовка запроса       
        $query = $this->getConnection()->prepare($sql);
        // выполнение запроса                
        $params1=self::towin($params);        
        $query->execute($params1);//Передаём массив на выполнение одного запроса Insert        
        $query->closeCursor(); // Закрываем курсор
    }
    
    //методы для изменения данных
    public function query_update($sql,$params) {
        $query = $this->getConnection()->prepare($sql);
        #var_dump($params);
        #echo("<br>");
        $params=self::towin($params);
        #var_dump($params);
        #echo("<br>");
        #echo($sql);
        #exit();
        $query->execute($params);
        $query->closeCursor(); // Закрываем курсор                 
    }
    //методы для удаления данных
    public function query_delete($sql) {
        $query = $this->getConnection()->prepare($sql);
        $query->execute();
        $query->closeCursor(); // Закрываем курсор                 
    }
    
    public function query_delete2($sql,$param) {
        $query = $this->getConnection()->prepare($sql);
        $query->execute($param);
        $query->closeCursor(); // Закрываем курсор                 
    }
}


	