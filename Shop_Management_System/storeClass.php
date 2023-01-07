<?php

    require_once("dbClass.php");
    require_once("shoeClass.php");

    class store{ 
        private $id;
        private $store_name;

		/*get's functions*/
        public function getId(){
            return $this->id;
        }
        
        public function getStoreName(){
            return $this->store_name;
        }
        
        public function setID($id){
            $this->id = $id;
        }
        
        public function setStoreName($store_name){
            $this->store_name = $store_name;
        }
  

        
        public function getInfoById($id){
            $conn = new dbClass();
            $conn->connect();
            
            $sql  = "SELECT * FROM `shoes`, `store` 
                    WHERE '$id'=`store`.`id`&&`store`.`id`=`shoes`.`id`";
            $result = $conn->getConnection()->query($sql);
            
            if($row = $result->fetchObject(__CLASS__)){
                echo "<b>".$row->getId().",&#160;&#160; &#160;&#160;&#160; &#160;&#160;&#160;".$row->model.", &#160;&#160;&#160;&#160;&#160; &#160;&#160;&#160;"
                    .$row->getStoreName().", &#160;&#160;&#160;&#160;&#160; &#160;&#160;&#160;".$row->price."</b><br>";
            }
            $conn->disconnect();
        }

       
        public function getAllInfo(){
            $conn = new dbClass();
            $conn->connect();

            $sql = "SELECT `shoes`.`id`, `shoes`.`model`, `shoes`.`price` ,
                  `store`.`store_name` 
                    FROM `shoes` INNER JOIN `store` ON `shoes`.`id`=`store`.`id`";
            $result = $conn->getConnection()->query($sql);
            
            while($row = $result->fetchObject(__CLASS__)){
                echo "<b>".$row->getId().", &#160;&#160;&#160;&#160;&#160; ".$row->model.", &#160;&#160;&#160;&#160;&#160;".
                    $row->getStoreName().", &#160;&#160;&#160;&#160;&#160; ".$row->price."</b><br>";
            }
            $conn->disconnect();
        }
        
        
        public function createFile(){
            $conn = new dbClass();
            $conn->connect();

            $f = fopen("shoes.txt","wb") or die("error to open file");

            if($f != false)
			{
                $sql = "SELECT `shoes`.`id`,`shoes`.`model`,`shoes`.`price` ,`store`.`store_name` 
                FROM `shoes` 
                INNER JOIN `store` ON `shoes`.`id`=`store`.`id`";
                $result = $conn->getConnection()->query($sql);
                
                fwrite($f," Id | ModeL | Store Name | Price\n\n");
        
                 while($row = $result->fetchObject(__CLASS__)){
                    fwrite($f,"  ".$row->getId().",  ".$row->model.",  ".$row->getStoreName().",  ".$row->price."\n");
                 }
                fclose($f);
            }
        $conn->disconnect();			
    }
	
        
        public function insert($id , $store_name){
            $conn = new dbClass();
            $conn->connect();
            
            $sql = "INSERT INTO `store` (`id`, `store_name`) VALUES ('$id', '$store_name')";
            
            $conn->getConnection()->exec($sql);
            
            $sql = "";
            $conn->disconnect();
        }
                
        public function myEcho(){
            echo "<pre>Id|Model|Store|Price</pre>";

        }
    }
?>
