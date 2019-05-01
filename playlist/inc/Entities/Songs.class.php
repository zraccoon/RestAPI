<?php

class Song {

    private $SongID;
    private $PlaylistID;
    private $SongName;
    private $Artist;
    private $Genre;
    private $Year;
    private $Duration;


    function getSongID() : string {
        return $this->SongID;
    }

    function getPlaylistID() : string {
        return $this->PlaylistID;
    }

    function getSongName() : string {
        return $this->SongName;
    }

    function getArtist() : string {
        return $this->Artist;
    }

    function getGenre() : string {
        return $this->Genre;
    }

    function getYear() : string {
        return $this->Year;
    }

    function getDuration() : string {
        return $this->Duration;
    }

    function setSongID(string $newSongID) {
        return $this->SongID = $newSongID;
    }

    function setPlaylistID(string $newPlaylistID) {
        return $this->PlaylistID = $newPlaylistID;
    }

    function setSongName(string $newSongName) {
        return $this->SongName = $newSongName;
    }

    function setArtist(string $newArtist) {
        return $this->Artist = $newArtist;
    }

    function setGenre(string $newGenre) {
        return $this->Genre = $newGenre;
    }

    function setYear(string $newYear) {
        return $this->Year = $newYear;
    }

    function setDuration(String $newDuration) {
        return $this->Duration = $newDuration;
    }

    //function addition serialize
    function jsonSerialize()    {

        // $vars = get_object_vars($this);
        // return $vars;

        //Make a standard class
        $obj = new StdClass;
        $obj->SongID = $this->getSongID();
        $obj->PlaylistID = $this->getPlaylistID();
        $obj->SongName = $this->getSongName();
        $obj->Artist = $this->getArtist();
        $obj->Genre = $this->getGenre();
        $obj->Year = $this->getYear();
        $obj->Duration = $this->getDuration();

        //Return the standard class
        return $obj;
    }


}
?>