<?php

//Config
require_once("inc/config.inc.php");
//Entities
require_once("inc/Entities/User.class.php");
require_once("inc/Entities/Playlist.class.php");
require_once("inc/Entities/Artist.class.php");
require_once("inc/Entities/Songs.class.php");

//Utility Classes
require_once("inc/Utility/RestClient.class.php");
require_once("inc/Utility/Page.class.php");



Page::$title = "PHP_FINAL_PROJECT";
Page::header();

$mode = "user";

if(!empty($_GET["view"]))
    $mode = $_GET["view"];

if (!empty($_POST)) {
    if($mode == "user") {
        switch($_POST['posting']){
        case 'add':
            RestClient::call("ADD_USER",$_POST);
        break; 
        case 'update':
            RestClient::call("EDIT_USER",$_POST);
        break;
        }
    }
    else if($mode == "playlist") {
        switch($_POST['posting']){
        case 'add':
            RestClient::call("ADD_PLAYLIST",$_POST);
        break; 
        case 'update':
            RestClient::call("EDIT_PLAYLIST",$_POST);
        break;
        }
    }
    else if($mode == "artist") {
        switch($_POST['posting']){
        case 'add':
            RestClient::call("ADD_ARTIST",$_POST);
        break; 
        case 'update':
            RestClient::call("EDIT_ARTIST",$_POST);
        break;
        }
    }
    else if($mode == "song") {
        switch($_POST['posting']){
        case 'add':
            RestClient::call("ADD_SONG",$_POST);
        break; 
        case 'update':
            RestClient::call("EDIT_SONG",$_POST);
        break;
        }
    }
    
}


if (!empty($_GET["action"]))  {
    if($mode == "user") {
        if ($_GET["action"] == "edit")    {
            //Make a REST call out to the WS

            $result = RestClient::call("GET_USER",array('UserID'=>$_GET['UserID']));
            $jUsers = json_decode($result);
            foreach ($jUsers as $u)  {
                $nu = new User();
        	    $nu->setUserID($u->UserID);
        	    $nu->setFirstName($u->FirstName);
                $nu->setLastName($u->LastName);
        	    $nu->setEmail($u->Email);
                page::editUserForm($nu);
            }
        }
        else if ($_GET["action"] == "delete")    {
            //Make a REST call out to the WS
            RestClient::call("DELETE_USER",array('UserID'=>$_GET['UserID']));
        }
    }
    else if($mode == "playlist") {
        if ($_GET["action"] == "edit")    {
            //Make a REST call out to the WS

            $result = RestClient::call("GET_PLAYLIST",array('PlaylistID'=>$_GET['PlaylistID']));
            $jPlaylists = json_decode($result);
            foreach ($jPlaylists as $p)  {
                $np = new Playlist();                
                $np->setPlaylistID($p->PlaylistID);
                $np->setPlaylistName($p->PlaylistName);
                $np->setUserID($p->UserID);
                page::editPlaylistForm($np);
            }
        }
        else if ($_GET["action"] == "delete")    {
            //Make a REST call out to the WS
            RestClient::call("DELETE_PLAYLIST",array('PlaylistID'=>$_GET['PlaylistID']));
        }
    }
    else if($mode == "artist") {
        if ($_GET["action"] == "edit")    {
            //Make a REST call out to the WS

            $result = RestClient::call("GET_ARTIST",array('ArtistID'=>$_GET['ArtistID']));
            $jArtists = json_decode($result);
            foreach ($jArtists as $p)  {
                $np = new Artist();                
                $np->setArtistID($p->ArtistID);
                $np->setArtistName($p->ArtistName);
                $np->setUserID($p->UserID);
                page::editArtistForm($np);
            }
        }
        else if ($_GET["action"] == "delete")    {
            //Make a REST call out to the WS
            RestClient::call("DELETE_ARTIST",array('ArtistID'=>$_GET['ArtistID']));
        }
    }
    else if($mode == "song") {
        if ($_GET["action"] == "edit")    {
            //Make a REST call out to the WS

            $result = RestClient::call("GET_SONG",array('SongID'=>$_GET['SongID']));
            $jSongs = json_decode($result);
            foreach ($jSongs as $s)  {
                $ns = new Song();
                $ns->setSongID($s->SongID);
                $ns->setPlaylistID($s->PlaylistID);
                $ns->setSongName($s->SongName);
                $ns->setArtist($s->Artist);
                $ns->setGenre($s->Genre);
                $ns->setYear($s->Year);
                $ns->setDuration($s->Duration);
                page::editSongForm($ns);
            }
        }
        else if ($_GET["action"] == "delete")    {
            //Make a REST call out to the WS
            RestClient::call("DELETE_SONG",array('SongID'=>$_GET['SongID']));
        }
    }
}

if($mode == "user") {
    $result = array();

    if (!empty($_GET["action"]) && $_GET["action"] == "search")
    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];
        //Search users with key
        $result = RestClient::call("SEARCH_USER", array('SearchKey'=>$key));
    }
    else
        //Get all users
        $result = RestClient::call("GET_USER",array());

    //De-serialize the result of the Rest call.
    $jUsers = json_decode($result);

    //Store them in a new array as proper "User" objects
    $Users = array();

    foreach ($jUsers as $u)  {
        //Assemble a new user class
        $nu = new User();
        $nu->setUserID($u->UserID);
        $nu->setFirstName($u->FirstName);
        $nu->setLastName($u->LastName);
        $nu->setEmail($u->Email);
        
        //append the new user
        $Users[] = $nu;
    }

    Page::listUsers($Users);
    Page::addUserForm($result,1);
}
else if($mode == "playlist") {
    $result = array();

    if (!empty($_GET["action"]) && $_GET["action"] == "search")
    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];
        //Search playlists with key
        $result = RestClient::call("SEARCH_PLAYLIST", array('SearchKey'=>$key));
    }
    else
        //Get all playlists
        $result = RestClient::call("GET_PLAYLIST",array());

    //De-serialize the result of the Rest call.
    $jPlaylists = json_decode($result);

    //Store them in a new array as proper "Playlist" objects
    $Playlists = array();

    foreach ($jPlaylists as $p)  {
        //Assemble a new playlist class
        $np = new Playlist();
        
        $np->setPlaylistID($p->PlaylistID);
        $np->setPlaylistName($p->PlaylistName);
        $np->setUserID($p->UserID);
        
        //append the new playlist
        $Playlists[] = $np;
    }

    Page::listPlaylists($Playlists);
    Page::addPlaylistForm($result,1);
}
else if($mode == "artist") {
    $result = array();

    if (!empty($_GET["action"]) && $_GET["action"] == "search")
    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];
        //Search artists with key
        $result = RestClient::call("SEARCH_ARTIST", array('SearchKey'=>$key));
    }
    else
        //Get all artists
        $result = RestClient::call("GET_ARTIST",array());

    //De-serialize the result of the Rest call.
    $jArtists = json_decode($result);

    //Store them in a new array as proper "Artist" objects
    $Artists = array();

    foreach ($jArtists as $p)  {
        //Assemble a new artist class
        $np = new Artist();
        
        $np->setArtistID($p->ArtistID);
        $np->setArtistName($p->ArtistName);
        $np->setUserID($p->UserID);
        
        //append the new artist
        $Artists[] = $np;
    }

    Page::listArtists($Artists);
    Page::addArtistForm($result,1);
}
else if($mode == "song") {
    $result = array();

    if (!empty($_GET["action"]) && $_GET["action"] == "search")
    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];
        //Search users with key
        $result = RestClient::call("SEARCH_SONG", array('SearchKey'=>$key));
    }
    else
        //Get all users
        $result = RestClient::call("GET_SONG",array());

    //De-serialize the result of the Rest call.
    $jSongs = json_decode($result);

    //Store them in a new array as proper "User" objects
    $Songs = array();

    foreach ($jSongs as $s)  {
        //Assemble a new user class
        $ns = new Song();
        $ns->setSongID($s->SongID);
        $ns->setPlaylistID($s->PlaylistID);
        $ns->setSongName($s->SongName);
        $ns->setArtist($s->Artist);
        $ns->setGenre($s->Genre);
        $ns->setYear($s->Year);
        $ns->setDuration($s->Duration);

        //append the new song
        $Songs[] = $ns;
    }

    Page::listSongs($Songs);
    Page::addSongForm($result,1);
}

Page::footer();
