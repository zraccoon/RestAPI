<?php
class SongsMapper {

    private static $db;

    static function initialize(string $className) {
        self::$db = new PDOAgent($className);
    }

    static function createSong(Song $newSong) : int {
        $sqlInsert = "INSERT INTO Songs (PlaylistID, SongName, Artist, Genre, Year, Duration) VALUES (:PlaylistID, :SongName, :Artist, :Genre, :Year, :Duration);";

        self::$db->query($sqlInsert);

        self::$db->bind(':PlaylistID', $newSong->getPlaylistID());
        self::$db->bind(':SongName', $newSong->getSongName());
        self::$db->bind(':Artist', $newSong->getArtist());
        self::$db->bind(':Genre', $newSong->getGenre());
        self::$db->bind(':Year', $newSong->getYear());
        self::$db->bind(':Duration', $newSong->getDuration());

        self::$db->execute();

        return self::$db->lastInsertId();
    }

    static function updateSong(Song $updateSong) : bool   {
        try{
            $sqlupdate = "UPDATE Songs SET PlaylistID=:PlaylistID, SongName=:SongName, Artist=:Artist, Genre=:Genre, Year=:Year, Duration=:Duration WHERE SongID =:SongID";
            self::$db->query($sqlupdate);
            self::$db->bind(':SongID', $updateSong->getSongID());
            self::$db->bind(':PlaylistID', $updateSong->getPlaylistID());
            self::$db->bind(':SongName', $updateSong->getSongName());
            self::$db->bind(':Artist', $updateSong->getArtist());
            self::$db->bind(':Genre', $updateSong->getGenre());
            self::$db->bind(':Year', $updateSong->getYear());
            self::$db->bind(':Duration', $updateSong->getDuration());

            self::$db->execute();
            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem updating song $SongID");
            }
        }catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;
    }

    static function getSongs() : Array {
        
        $selectAll = "SELECT * FROM Songs;";

        self::$db->query($selectAll);
        self::$db->execute();
        return self::$db->resultSet();
    }


    static function deleteSong(string $SongID) : bool {
        $deleteSQLQuery = "DELETE FROM Songs WHERE SongID = :SongID;";

        try {

            self::$db->query($deleteSQLQuery);
            self::$db->bind(':SongID', $SongID);
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("Problem deleting song $SongID");
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
            
        }

        return true;

    }

    static function getEditSong($SongID)  : Array  {
        
        $sqlSelect = "SELECT * FROM Songs WHERE SongID = :SongID";
        //Query
        self::$db->query($sqlSelect);
        //Bind
        self::$db->bind(':SongID', $SongID);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }

    static function getSongWithKey($SearchKey)  : Array  {
        

        $sqlSelect = "SELECT * FROM Songs WHERE SongName LIKE '%$SearchKey%' OR Artist LIKE '%$SearchKey%' OR Genre LIKE '%$SearchKey%' OR Year LIKE '%$SearchKey%'";
        //Query
        self::$db->query($sqlSelect);
        //Execute
        self::$db->execute();
        //Return
        return self::$db->resultSet();
    }


}
?>