<?php

require_once('inc/config.inc.php');
require_once('inc/Utility/PDOAgent.class.php');

require_once('inc/Entities/User.class.php');
require_once('inc/Utility/UserMapper.class.php');
require_once('inc/Entities/Playlist.class.php');
require_once('inc/Utility/PlaylistMapper.class.php');
require_once('inc/Entities/Artist.class.php');
require_once('inc/Utility/ArtistMapper.class.php');
require_once('inc/Entities/Songs.class.php');
require_once('inc/Utility/SongsMapper.class.php');

UserMapper::initialize("User");
PlaylistMapper::initialize("Playlist");
ArtistMapper::initialize("Artist");
SongsMapper::initialize("Song");

//Pull the request data from the input stream
parse_str(file_get_contents('php://input'), $requestData);

switch($_SERVER["REQUEST_METHOD"])  {
    //Its  a GET request, time to read!
    case "GET_USER":
        if (isset($requestData['UserID']))  {

            $Users = UserMapper::getEditUser($requestData['UserID']);
            $serializedUsers = array();

            foreach ($Users as $User)   {
                $serializedUsers[] = $User->jsonSerialize();
            }

            header('Content-Type: application/json');
            echo json_encode($serializedUsers);

        } else {

            $Users = UserMapper::getUsers();
            $serializedUsers = array();

            foreach ($Users as $User)   {
                $serializedUsers[] = $User->jsonSerialize();
            }

            //Set the header
            header('Content-Type: application/json');
            //Return all the users!
            echo json_encode($serializedUsers);

        }
        break;

    case "SEARCH_USER":
        $Users = UserMapper::getUserWithKey($requestData['SearchKey']);
        $serializedUsers = array();

        foreach ($Users as $User)   {
            $serializedUsers[] = $User->jsonSerialize();
        }

        header('Content-Type: application/json');
        echo json_encode($serializedUsers);
        break;

    case "EDIT_USER":
        $nu = new User();
      
        $nu->setFirstName($requestData['eFirstName']);
        $nu->setLastName($requestData['eLastName']);
        $nu->setEmail($requestData['eEmail']);
        $nu->setUserID($requestData["eUserID"]);
                   
        //Update User
        $result = UserMapper::updateUser($nu);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
        break;

    case "ADD_USER":

        $nu = new User();
        $nu->setFirstName($requestData['FirstName']);
        $nu->setLastName($requestData['LastName']);
        $nu->setEmail($requestData['Email']);
        
        //Add User
        $result = UserMapper::createUser($nu);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "DELETE_USER":

        $result = UserMapper::deleteUser($requestData['UserID']);
        header('Content-Type: application/json');
        echo json_encode($result);
    break;

    case "GET_SONG":
        if (isset($requestData['SongID']))  {

            $Songs = SongsMapper::getEditSong($requestData['SongID']);
            $serializedSongs = array();

            foreach ($Songs as $Song)   {
                $serializedSongs[] = $Song->jsonSerialize();
            }

            header('Content-Type: application/json');
            echo json_encode($serializedSongs);

        } else {

            $Songs = SongsMapper::getSongs();
            $serializedSongs = array();

            foreach ($Songs as $Song)   {
                $serializedSongs[] = $Song->jsonSerialize();
            }

            //Set the header
            header('Content-Type: application/json');
            //Return all the users!
            echo json_encode($serializedSongs);

        }
        break;

    case "SEARCH_SONG":
        $Songs = SongsMapper::getSongWithKey($requestData['SearchKey']);
        $serializedSongs = array();

        foreach ($Songs as $Song)   {
            $serializedSongs[] = $Song->jsonSerialize();
        }

        header('Content-Type: application/json');
        echo json_encode($serializedSongs);
        break;

    case "EDIT_SONG":

        $ns = new Song();      
        $ns->setSongID($requestData['eSongID']);
        $ns->setPlaylistID($requestData['ePlaylistID']);
        $ns->setSongName($requestData['eSongName']);
        $ns->setArtist($requestData['eArtist']);
        $ns->setGenre($requestData['eGenre']);
        $ns->setYear($requestData["eYear"]);
        $ns->setDuration($requestData["eDuration"]);
                   
        //Update Song
        $result = SongsMapper::updateSong($ns);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
        break;

    case "ADD_SONG":

        $ns = new Song();
        $ns->setPlaylistID($requestData['PlaylistID']);
        $ns->setSongName($requestData['SongName']);
        $ns->setArtist($requestData['Artist']);
        $ns->setGenre($requestData['Genre']);
        $ns->setYear($requestData["Year"]);
        $ns->setDuration($requestData["Duration"]);
        
        //Add Song
        $result = SongsMapper::createSong($ns);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "DELETE_SONG":

        $result = SongsMapper::deleteSong($requestData['SongID']);
        header('Content-Type: application/json');
        echo json_encode($result);
    break;

    case "GET_PLAYLIST":
        if (isset($requestData['PlaylistID']))  {

            $Playlists = PlaylistMapper::getEditPlaylist($requestData['PlaylistID']);
            $serializedPlaylists = array();

            foreach ($Playlists as $Playlist)   {
                $serializedPlaylists[] = $Playlist->jsonSerialize();
            }

            header('Content-Type: application/json');
            echo json_encode($serializedPlaylists);

        } else {

            $Playlists = PlaylistMapper::getPlaylists();
            $serializedPlaylists = array();

            foreach ($Playlists as $Playlist)   {
                $serializedPlaylists[] = $Playlist->jsonSerialize();
            }

            //Set the header
            header('Content-Type: application/json');
            //Return all the users!
            echo json_encode($serializedPlaylists);

        }
        break;

    case "SEARCH_PLAYLIST":
        $Playlists = PlaylistMapper::getPlaylistWithKey($requestData['SearchKey']);
        $serializedPlaylists = array();

        foreach ($Playlists as $Playlist)   {
            $serializedPlaylists[] = $Playlist->jsonSerialize();
        }

        header('Content-Type: application/json');
        echo json_encode($serializedPlaylists);
        break;

    case "EDIT_PLAYLIST":
        $np = new Playlist();
      
        $np->setPlaylistName($requestData['ePlaylistName']);
        $np->setUserID($requestData['eUserID']);
        $np->setPlaylistID($requestData["ePlaylistID"]);
        
        //Update Playlist
        $result = PlaylistMapper::updatePlaylist($np);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "ADD_PLAYLIST":

        $np = new Playlist();
        $np->setPlaylistName($requestData['PlaylistName']);
        $np->setUserID($requestData['UserID']);
        
        //Add Playlist
        $result = PlaylistMapper::createPlaylist($np);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "DELETE_PLAYLIST":

        $result = PlaylistMapper::deletePlaylist($requestData['PlaylistID']);
        header('Content-Type: application/json');
        echo json_encode($result);
    break;

    case "GET_ARTIST":
        if (isset($requestData['ArtistID']))  {

            $Artists = ArtistMapper::getEditArtist($requestData['ArtistID']);
            $serializedArtists = array();

            foreach ($Artists as $Artist)   {
                $serializedArtists[] = $Artist->jsonSerialize();
            }

            header('Content-Type: application/json');
            echo json_encode($serializedArtists);

        } else {

            $Artists = ArtistMapper::getArtists();
            $serializedArtists = array();

            foreach ($Artists as $Artist)   {
                $serializedArtists[] = $Artist->jsonSerialize();
            }

            //Set the header
            header('Content-Type: application/json');
            //Return all the users!
            echo json_encode($serializedArtists);

        }
        break;

    case "SEARCH_ARTIST":
        $Artists = ArtistMapper::getArtistWithKey($requestData['SearchKey']);
        $serializedArtists = array();

        foreach ($Artists as $Artist)   {
            $serializedArtists[] = $Artist->jsonSerialize();
        }

        header('Content-Type: application/json');
        echo json_encode($serializedArtists);
        break;

    case "EDIT_ARTIST":
        $np = new Artist();
      
        $np->setArtistName($requestData['eArtistName']);
        $np->setUserID($requestData['eUserID']);
        $np->setArtistID($requestData["eArtistID"]);
        
        //Update Artist
        $result = ArtistMapper::updateArtist($np);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "ADD_ARTIST":

        $np = new Artist();
        $np->setArtistName($requestData['ArtistName']);
        $np->setUserID($requestData['UserID']);
        
        //Add Artist
        $result = ArtistMapper::createArtist($np);

        //REturn result
        header('Content-Type: application/json');
        //Return the result.
        echo json_encode($result);
    break;

    case "DELETE_ARTIST":

        $result = ArtistMapper::deleteArtist($requestData['ArtistID']);
        header('Content-Type: application/json');
        echo json_encode($result);
    break;

    default:
        echo json_encode(array("message" => "Voce fala HTTP?"));
    break;
    
}