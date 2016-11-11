<?php 
/*
##############################################
#     User registration app                  #
#                                            #
#	@@ -=::MATLLE::=-                        #
#	@ paso.175@gmail.com                     #
#	@ martial.babo@matlle.com                #
##############################################
*/


require_once 'includes/config.php';

class Database extends PDO { 
	
    protected $transactionCounter = 0; 
    static $_instance;

    public function __construct() {
        parent::__construct('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASSWORD);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // A singleton pattern
    public static function getInstance() {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function beginTransaction() { 
        if(!$this->transactionCounter++) 
            return parent::beginTransaction(); 
       return $this->transactionCounter >= 0; 
    } 

    public function commit() { 
       if(!--$this->transactionCounter) 
           return parent::commit(); 
       return $this->transactionCounter >= 0; 
    } 

    public function rollback() { 
        if($this->transactionCounter >= 0) { 
            $this->transactionCounter = 0; 
            return parent::rollback(); 
        } 
        $this->transactionCounter = 0; 
        return false; 
    } 


    public function select($sql, $array = array()) {

        $query = $this->prepare($sql);
        foreach($array as $key => $value) {
            if(is_int($value))
                $query->bindValue("$key", $value, \PDO::PARAM_INT);
            else
                $query->bindValue("$key", $value, \PDO::PARAM_STR);
        }

        $query->execute() or die(print_r($query->errorInfo()));
        $data = $query->fetchAll();
        $query->closeCursor();
        return $data;

    }


    public function insert($table, $data) {

        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)";


        $query = $this->prepare($sql);

        foreach($data as $key => $value) {
            if(is_int($value))
                $query->bindValue("$key", $value, PDO::PARAM_INT);
            else
                $query->bindValue("$key", $value, PDO::PARAM_STR);
        }
        
        $query->execute() or print_r($query->errorInfo());
        $query->closeCursor();

    }
    
     
    // Transaction on Inserting in table
    public function transaction($table_name, $data) {
        if(!$this->beginTransaction())
            return false;
        
        $this->insert($table_name, $data);
         
        if(!$this->commit()) {
            $this->rollback();
            return false;
        }  
        
        return true;
        
    }



} 
