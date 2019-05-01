<?php

class PlaylistMapper {

    //Place to store the PDO Agent
    private static $db;

    static function initialize(string $className)   {
        
        self::$db = new PDOAgent($className);

    }

    static function createPlaylist(Playlist $newPlaylist) : int   {
        $sqlInsert = "INSERT INTO Playlist (PlaylistName, UserID) VALUES (:PlaylistName, :UserID)";

        self::$db->query($sqlInsert);

        self::$db->bind(':PlaylistName', $newPlaylist->getPlaylistName());        
        self::$db->bind(':UserID', $newPlaylist->getUserID());

        self::$db->execute();

        return self::$db->lastInsertId();

    }

    static function updatePlaylist(Playlist $updatePlaylist) : bool   {
        try{
            $sqlupdate = "UPDATE Playlist SET PlaylistName=:PlaylistName, UserID=:UserID WHERE PlaylistID =:PlaylistID";
            self::$db->query($sqlupdate);
            self::$db->bind(':PlaylistID', $updatePlaylist->getPlaylistID());
            self::$db->bind(':PlaylistName', $updatePlaylist->getPlaylistName());
            self::$db->bind(':UserID', $updatePlaylist->getUserID());
            self::$db->execute();
            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem updating playlist $PlaylistID");
            }
        }catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;
    }

    static function getPlaylists() : Array {
        
        $selectAll = "SELECT * FROM Playlist;";

        self::$db->query($selectAll);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function deletePlaylist(string $PlaylistID) : bool {
        $deleteSQLQuery = "DELETE FROM Playlist WHERE PlaylistID = :PlaylistID;";

        try {

            self::$db->query($deleteSQLQuery);
            self::$db->bind(':PlaylistID', $PlaylistID);
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem deleting playlist $PlaylistID");
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;

    }

    static function getEditPlaylist($PlaylistID)  : Array  {
        
        $sqlSelect = "SELECT * FROM Playlist WHERE PlaylistID = :PlaylistID";
        //Query
        self::$db->query($sqlSelect);
        //Bind
        self::$db->bind(':PlaylistID', $PlaylistID);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }

    static function getPlaylistWithKey($SearchKey)  : Array  {
        

        $sqlSelect = "SELECT * FROM Playlist WHERE PlaylistName LIKE '%$SearchKey%'";
        //Query
        self::$db->query($sqlSelect);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }
}

?>