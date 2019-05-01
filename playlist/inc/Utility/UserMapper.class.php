<?php

class UserMapper {

    //Place to store the PDO Agent
    private static $db;

    static function initialize(string $className)   {
        
        self::$db = new PDOAgent($className);

    }

    // +----------+------------------+------+-----+---------+----------------+
    //| Field    | Type             | Null | Key | Default | Extra          |
    //+----------+------------------+------+-----+---------+----------------+
    //| UserID   | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    //| FirstName| varchar(50)      | NO   |     | NULL    |                |
    //| LastName | varchar(50)      | NO   |     | NULL    |                |
    //| Email    | varchar(50)      | NO   |     | NULL    |                |
    //+----------+------------------+------+-----+---------+----------------+
    //4 rows in set (0.00 sec)
    

    static function createUser(User $newUser) : int   {
        $sqlInsert = "INSERT INTO User (FirstName, LastName, Email) VALUES (:FirstName, :LastName, :Email)";

        self::$db->query($sqlInsert);

        self::$db->bind(':FirstName', $newUser->getFirstName());        
        self::$db->bind(':LastName', $newUser->getLastName());
        self::$db->bind(':Email', $newUser->getEmail());

        self::$db->execute();

        return self::$db->lastInsertId();

    }

    static function updateUser(User $updateUser) : bool   {
        try{
            $sqlupdate = "UPDATE User SET FirstName=:FirstName, LastName=:LastName, Email=:Email WHERE UserID =:UserID";
            self::$db->query($sqlupdate);
            self::$db->bind(':UserID', $updateUser->getUserID());
            self::$db->bind(':FirstName', $updateUser->getFirstName());
            self::$db->bind(':LastName', $updateUser->getLastName());
            self::$db->bind(':Email', $updateUser->getEmail());
            self::$db->execute();
            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem updating user $UserID");
            }
        }catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;
    }

    static function getUsers() : Array {
        
        $selectAll = "SELECT * FROM User;";

        self::$db->query($selectAll);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function deleteUser(string $UserID) : bool {
        $deleteSQLQuery = "DELETE FROM User WHERE UserID = :UserID;";

        try {

            self::$db->query($deleteSQLQuery);
            self::$db->bind(':UserID', $UserID);
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem deleting user $UserID");
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;

    }

    static function getEditUser($UserID)  : Array  {
        
        $sqlSelect = "SELECT * FROM User WHERE UserID = :UserID";
        //Query
        self::$db->query($sqlSelect);
        //Bind
        self::$db->bind(':UserID', $UserID);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }

    static function getUserWithKey($SearchKey)  : Array  {
        

        $sqlSelect = "SELECT * FROM User WHERE FirstName LIKE '%$SearchKey%' OR LastName LIKE '%$SearchKey%' OR Email LIKE '%$SearchKey%'";
        //Query
        self::$db->query($sqlSelect);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }

    /*static function getEditUser($UserID)  : Array  {
        
        $sqlSelect = "SELECT * FROM User WHERE UserID = :UserID";
        //Query
        self::$db->query($sqlSelect);
        //Bind
        self::$db->bind(':UserID', $UserID);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->singleResult();
    }*/

}

?>