<?php

class ArtistMapper {

    //Place to store the PDO Agent
    private static $db;

    static function initialize(string $className)   {
        
        self::$db = new PDOAgent($className);

    }

    static function createArtist(Artist $newArtist) : int   {
        $sqlInsert = "INSERT INTO Artist (ArtistName, UserID) VALUES (:ArtistName, :UserID)";

        self::$db->query($sqlInsert);

        self::$db->bind(':ArtistName', $newArtist->getArtistName());        
        self::$db->bind(':UserID', $newArtist->getUserID());

        self::$db->execute();

        return self::$db->lastInsertId();

    }

    static function updateArtist(Artist $updateArtist) : bool   {
        try{
            $sqlupdate = "UPDATE Artist SET ArtistName=:ArtistName, UserID=:UserID WHERE ArtistID =:ArtistID";
            self::$db->query($sqlupdate);
            self::$db->bind(':ArtistID', $updateArtist->getArtistID());
            self::$db->bind(':ArtistName', $updateArtist->getArtistName());
            self::$db->bind(':UserID', $updateArtist->getUserID());
            self::$db->execute();
            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem updating playlist $ArtistID");
            }
        }catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;
    }

    static function getArtists() : Array {
        
        $selectAll = "SELECT * FROM Artist;";

        self::$db->query($selectAll);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function deleteArtist(string $ArtistID) : bool {
        $deleteSQLQuery = "DELETE FROM Artist WHERE ArtistID = :ArtistID;";

        try {

            self::$db->query($deleteSQLQuery);
            self::$db->bind(':ArtistID', $ArtistID);
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem deleting playlist $ArtistID");
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;

    }

    static function getEditArtist($ArtistID)  : Array  {
        
        $sqlSelect = "SELECT * FROM Artist WHERE ArtistID = :ArtistID";
        //Query
        self::$db->query($sqlSelect);
        //Bind
        self::$db->bind(':ArtistID', $ArtistID);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }

    static function getArtistWithKey($SearchKey)  : Array  {
        

        $sqlSelect = "SELECT * FROM Artist WHERE ArtistName LIKE '%$SearchKey%'";
        //Query
        self::$db->query($sqlSelect);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }
}

?>