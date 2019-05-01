
<?php

class Artist  {

    private $ArtistID;
    private $ArtistName;
    private $UserID;

    //Getters
    function getArtistID() : string   {
        return $this->ArtistID;
    }

    function getArtistName() : string {
        return $this->ArtistName;
    }

    function getUserID() : string     {
        return $this->UserID;
    }

    
    //Setters
    function setArtistID(string $newArtistID)   {
        $this->ArtistID = $newArtistID;
    }

    function setArtistName(string $newArtistName)  {
        $this->ArtistName = $newArtistName;
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
        $obj->ArtistID = $this->getArtistID();
        $obj->ArtistName = $this->getArtistName();        
        $obj->UserID = $this->getUserID();

        //Return the standard class
        return $obj;
    }
}

?>