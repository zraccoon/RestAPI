
<?php

class Playlist  {

    private $PlaylistID;
    private $PlaylistName;
    private $UserID;

    //Getters
    function getPlaylistID() : string   {
        return $this->PlaylistID;
    }

    function getPlaylistName() : string {
        return $this->PlaylistName;
    }

    function getUserID() : string     {
        return $this->UserID;
    }

    
    //Setters
    function setPlaylistID(string $newPlaylistID)   {
        $this->PlaylistID = $newPlaylistID;
    }

    function setPlaylistName(string $newPlaylistName)  {
        $this->PlaylistName = $newPlaylistName;
    }

    function setUserID(string $newUserID)   {
        $this->UserID = $newUserID;
    }
    

    //function addition serialize
    function jsonSerialize()    {

        // $vars = get_object_vars($this);
        // return $vars;

        //Make a standard class
        $obj = new StdClass;
        $obj->PlaylistID = $this->getPlaylistID();
        $obj->PlaylistName = $this->getPlaylistName();        
        $obj->UserID = $this->getUserID();

        //Return the standard class
        return $obj;
    }
}

?>