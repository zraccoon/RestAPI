<?php
class Page  {

    public static $title = "Please set your title!";

    static function header()   { ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>

        <!-- Basic Page Needs
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <meta charset="utf-8">
        <title><?php echo self::$title; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Mobile Specific Metas
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FONT
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

        <!-- CSS
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">

        <!-- Favicon
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <link rel="icon" type="image/png" href="images/favicon.png">

        </head>
        <body>

        <!-- Primary Page Layout
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        <div class="container">
            <div class="row">
            <div class="one-half column" style="margin-top: 25%">
                <h4><?php echo self::$title; ?></h4>
                <a href="index.php?view=user">User</a>&nbsp;&nbsp;&nbsp;
                <a href="index.php?view=playlist">PlayList</a>&nbsp;&nbsp;&nbsp;
                <a href="index.php?view=song">Song</a>&nbsp;&nbsp;&nbsp;
                <a href="index.php?view=artist">Artist</a>&nbsp;&nbsp;&nbsp;
    <?php }

    static function footer()   { ?>
            </div>
            </div>
        </div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            jQuery(document).ready(function($){
                $("#but_search_user"). click(function(){
                    var searchstr = $("#txt_user").val();
                    if(searchstr == "")
                        window.location.href =  'index.php?view=user';
                    else
                        window.location.href =  'index.php?view=user&action=search&key=' + searchstr;
                });
                $("#but_search_playlist"). click(function(){
                    var searchstr = $("#txt_playlist").val();
                    if(searchstr == "")
                        window.location.href =  'index.php?view=playlist';
                    else
                        window.location.href =  'index.php?view=playlist&action=search&key=' + searchstr;
                });
                $("#but_search_artist"). click(function(){
                    var searchstr = $("#txt_artist").val();
                    if(searchstr == "")
                        window.location.href =  'index.php?view=artist';
                    else
                        window.location.href =  'index.php?view=artist&action=search&key=' + searchstr;
                });
                $("#but_search_song"). click(function(){
                    var searchstr = $("#txt_song").val();
                    if(searchstr == "")
                        window.location.href =  'index.php?view=song';
                    else
                        window.location.href =  'index.php?view=song&action=search&key=' + searchstr;
                });
            });
        </script>
        <!-- End Document
        –––––––––––––––––––––––––––––––––––––––––––––––––– -->
        </body>
        </html>

    <?php }

    static function listUsers($UserData)    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];

        echo '<p><h5>User</h5>
            <p><B>Total User Count - '. count($UserData) .'</B>
            <table class="u-full-width">
                <thead>
                    <tr>
                        <th colspan="3">Keyword : <input type="text" id="txt_user" name="txt_user" value="'. $key .'"></th>
                        <th><button id="but_search_user">Search User</button></th>
                        <th></th>
                    </tr>
                    <tr>            
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>            
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($UserData as $User)    {
            echo '  <tr>
    
            <td>'.$User->getFirstName().'</td>
            <td>'.$User->getLastName().'</td>
            <td>'.$User->getEmail().'</td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=user&action=delete&UserID='.$User->getUserID().'
            ">Delete</A></td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=user&action=edit&UserID='.$User->getUserID().'
            ">Edit</A></td>
            </tr>';
        }
        
        echo '</tbody>
        </table>';
  
    }

    static function addUserForm($d,$flag)   { ?>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"].'?view=user'; ?>">
        <div class="row">


            <div class="eight columns">
            
                <label for="title">First Name</label>
                <input class="u-full-width" type="text" placeholder="First Name" required value="<?php if($flag==1){} else echo $d[0]->FirstName?>" id="FirstName" name="FirstName">

                <label for="title">Last Name</label>
                <input class="u-full-width" type="text" placeholder="Last Name" required value="<?php if($flag==1){} else echo $d[0]->LastName?>" id="LastName" name="LastName">
    	    
                <label for="title">Email</label>
                <input class="u-full-width" type="text" placeholder="Email Address" required value="<?php if($flag==1){} else echo $d[0]->Email?>" id="Email" name="Email">
                 
      
                <input type="hidden" name="UserID" value="<?php if($flag==1){} else echo $d[0]->UserID?>">
                <input type="hidden" name="flag" value="<?php echo $flag ?>">

                <input type="hidden" name="posting" value="add">

                <input class="button-primary" type="submit" value="Submit">
            </div>
          

        </div>
        
        </form>

    <?php }

    static function editUserForm($data){ 
  
        $d = $data;
        /*foreach($data as $d) { */?>
      
        <h5> <?php echo "Edit User - " . $d->getUserID(); ?></h5>
        <form METHOD ="POST" ACTION = "<?php $_SERVER["PHP_SELF"].'?view=user' ?>">
          
          <div class="six columns">
            <input type="hidden" id="eUserID" name="eUserID" required value="<?php echo  $d->getUserID(); ?>">
            
            <label for="name">First Name</label>
            <input class="u-full-width" type="text"
             placeholder="First Name" id="eFirstName" name="eFirstName" required value="<?PHP echo $d->getFirstName(); ?>">
       
            <label for="name">Last Name</label>
            <input class="u-full-width" type="text"
             placeholder="Last Name" id="eLastName" name="eLastName" required value="<?PHP echo $d->getLastName(); ?>">
                 
            <input class="button-primary" type="submit" value="Submit">
          </div>
      
          <div class="six columns">
            <label for="address">Email</label>
            <input class="u-full-width" type="text" placeholder="Email Address" id="eEmail" name="eEmail" value="<?PHP echo $d->getEmail(); ?>">
            <input type="hidden" name="posting" value="update">      
          </div>
         
          <BR>
        </form> 
    <?php /*}*/
    }

    static function listPlaylists($PlaylistData)    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];

        echo '<p><h5>Playlist</h5>
            <p><B>Total Playlist Count - '. count($PlaylistData) .'</B>
            <table class="u-full-width">
                <thead>
                    <tr>
                        <th colspan="3">Keyword : <input type="text" id="txt_playlist" name="txt_playlist" value="'. $key .'"></th>
                        <th><button id="but_search_playlist">Search Playlist</button></th>
                        <th></th>
                    </tr>
                    <tr>            
                        <th>Playlist Name</th>
                        <th>UserID</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($PlaylistData as $Playlist)    {
            echo '  <tr>
    
            <td>'.$Playlist->getPlaylistName().'</td>
            <td>'.$Playlist->getUserID().'</td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=playlist&action=delete&PlaylistID='.$Playlist->getPlaylistID().'
            ">Delete</A></td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=playlist&action=edit&PlaylistID='.$Playlist->getPlaylistID().'
            ">Edit</A></td>
            </tr>';
        }
        
        echo '</tbody>
        </table>';
  
    }

    static function addPlaylistForm($d,$flag)   { ?>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"].'?view=playlist'; ?>">
        <div class="row">


            <div class="eight columns">
            
                <label for="title">Playlist Name</label>
                <input class="u-full-width" type="text" placeholder="Playlist Name" required value="<?php if($flag==1){} else echo $d[0]->PlaylistName?>" id="PlaylistName" name="PlaylistName">

                <label for="title">User ID</label>
                <input class="u-full-width" type="text" placeholder="User ID" required value="<?php if($flag==1){} else echo $d[0]->UserID?>" id="UserID" name="UserID">
                 
      
                <input type="hidden" name="PlaylistID" value="<?php if($flag==1){} else echo $d[0]->PlaylistID?>">
                <input type="hidden" name="flag" value="<?php echo $flag ?>">

                <input type="hidden" name="posting" value="add">

                <input class="button-primary" type="submit" value="Submit">
            </div>
          

        </div>
        
        </form>

    <?php }

    static function editPlaylistForm($data){ 
  
        $d = $data;
        /*foreach($data as $d) { */?>
      
        <h5> <?php echo "Edit Playlist - " . $d->getPlaylistID(); ?></h5>
        <form METHOD ="POST" ACTION = "<?php $_SERVER["PHP_SELF"].'?view=playlist' ?>">
          
          <div class="six columns">
            <input type="hidden" id="ePlaylistID" name="ePlaylistID" required value="<?php echo  $d->getPlaylistID(); ?>">
            
            <label for="name">Playlist Name</label>
            <input class="u-full-width" type="text" placeholder="Playlist Name" id="ePlaylistName" name="ePlaylistName" required value="<?PHP echo $d->getPlaylistName(); ?>">
       
            <label for="name">User ID</label>
            <input class="u-full-width" type="text" placeholder="User ID" id="eUserID" name="eUserID" required value="<?PHP echo $d->getUserID(); ?>">

          </div>
          <div class="six columns">
            <input class="button-primary" type="submit" value="Submit">
            <input type="hidden" name="posting" value="update">
          </div>

          <BR>
        </form> 
    <?php /*}*/
    }

    static function listArtists($ArtistData)    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];

        echo '<p><h5>Artist</h5>
            <p><B>Total Artist Count - '. count($ArtistData) .'</B>
            <table class="u-full-width">
                <thead>
                    <tr>
                        <th colspan="3">Keyword : <input type="text" id="txt_artist" name="txt_artist" value="'. $key .'"></th>
                        <th><button id="but_search_artist">Search Artist</button></th>
                        <th></th>
                    </tr>
                    <tr>            
                        <th>Artist Name</th>
                        <th>UserID</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($ArtistData as $Artist)    {
            echo '  <tr>
    
            <td>'.$Artist->getArtistName().'</td>
            <td>'.$Artist->getUserID().'</td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=artist&action=delete&ArtistID='.$Artist->getArtistID().'
            ">Delete</A></td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=artist&action=edit&ArtistID='.$Artist->getArtistID().'
            ">Edit</A></td>
            </tr>';
        }
        
        echo '</tbody>
        </table>';
  
    }

    static function addArtistForm($d,$flag)   { ?>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"].'?view=artist'; ?>">
        <div class="row">


            <div class="eight columns">
            
                <label for="title">Artist Name</label>
                <input class="u-full-width" type="text" placeholder="Artist Name" required value="<?php if($flag==1){} else echo $d[0]->ArtistName?>" id="ArtistName" name="ArtistName">

                <label for="title">User ID</label>
                <input class="u-full-width" type="text" placeholder="User ID" required value="<?php if($flag==1){} else echo $d[0]->UserID?>" id="UserID" name="UserID">
                 
      
                <input type="hidden" name="ArtistID" value="<?php if($flag==1){} else echo $d[0]->ArtistID?>">
                <input type="hidden" name="flag" value="<?php echo $flag ?>">

                <input type="hidden" name="posting" value="add">

                <input class="button-primary" type="submit" value="Submit">
            </div>
          

        </div>
        
        </form>

    <?php }

    static function editArtistForm($data){ 
  
        $d = $data;
        /*foreach($data as $d) { */?>
      
        <h5> <?php echo "Edit Artist - " . $d->getArtistID(); ?></h5>
        <form METHOD ="POST" ACTION = "<?php $_SERVER["PHP_SELF"].'?view=artist' ?>">
          
          <div class="six columns">
            <input type="hidden" id="eArtistID" name="eArtistID" value="<?php echo  $d->getArtistID(); ?>">
            
            <label for="name">Artist Name</label>
            <input class="u-full-width" type="text" placeholder="Artist Name" id="eArtistName" name="eArtistName" required value="<?PHP echo $d->getArtistName(); ?>">
       
            <label for="name">User ID</label>
            <input class="u-full-width" type="text" placeholder="User ID" id="eUserID" name="eUserID" required value="<?PHP echo $d->getUserID(); ?>">

          </div>
          <div class="six columns">
            <input class="button-primary" type="submit" value="Submit">
            <input type="hidden" name="posting" value="update">
          </div>

          <BR>
        </form> 
    <?php /*}*/
    }

    static function listSongs($SongData)    {
        $key = "";
        if (!empty($_GET["key"]))
            $key = $_GET["key"];

        echo '<p><h5>Song</h5>
            <p><B>Total Song Count - '. count($SongData) .'</B>
            <table class="u-full-width">
                <thead>
                    <tr>
                        <th colspan="3">Keyword : <input type="text" id="txt_song" name="txt_song" value="'. $key .'"></th>
                        <th><button id="but_search_song">Search Song</button></th>
                        <th></th>
                    </tr>
                    <tr>            
                        <th>Playlist ID</th>
                        <th>Song Name</th>
                        <th>Artist</th>            
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($SongData as $Song)    {
            echo '  <tr>
    
            <td>'.$Song->getPlaylistID().'</td>
            <td>'.$Song->getSongName().'</td>
            <td>'.$Song->getArtist().'</td>
            <td>'.$Song->getGenre().'</td>
            <td>'.$Song->getYear().'</td>
            <td>'.$Song->getDuration().'</td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=song&action=delete&SongID='.$Song->getSongID().'
            ">Delete</A></td>
            <td><A HREF="'.$_SERVER["PHP_SELF"].'?view=song&action=edit&SongID='.$Song->getSongID().'
            ">Edit</A></td>
            </tr>';
        }
        
        echo '</tbody>
        </table>';
  
    }

    static function addSongForm($d,$flag)   { ?>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"].'?view=song'; ?>">
        <div class="row">


            <div class="eight columns">
            
                <label for="title">Playlist ID</label>
                <input class="u-full-width" type="text" placeholder="Playlist ID" required value="<?php if($flag==1){} else echo $d[0]->PlaylistID?>" id="PlaylistID" name="PlaylistID">

                <label for="title">Song Name</label>
                <input class="u-full-width" type="text" placeholder="Song Name" required value="<?php if($flag==1){} else echo $d[0]->SongName?>" id="SongName" name="SongName">
            
                <label for="title">Artist</label>
                <input class="u-full-width" type="text" placeholder="Artist" required value="<?php if($flag==1){} else echo $d[0]->Artist?>" id="Artist" name="Artist">

                <label for="title">Genre</label>
                <input class="u-full-width" type="text" placeholder="Genre" required value="<?php if($flag==1){} else echo $d[0]->Genre?>" id="Genre" name="Genre">

                <label for="title">Year</label>
                <input class="u-full-width" type="text" placeholder="Year" required value="<?php if($flag==1){} else echo $d[0]->Year?>" id="Year" name="Year">

                <label for="title">Duration</label>
                <input class="u-full-width" type="text" placeholder="Duration" required value="<?php if($flag==1){} else echo $d[0]->Duration?>" id="Duration" name="Duration">
                 
      
                <input type="hidden" name="SongID" value="<?php if($flag==1){} else echo $d[0]->SongID?>">
                <input type="hidden" name="flag" value="<?php echo $flag ?>">

                <input type="hidden" name="posting" value="add">

                <input class="button-primary" type="submit" value="Submit">
            </div>
          

        </div>
        
        </form>

    <?php }

    static function editSongForm($data){ 
  
        $d = $data;
        /*foreach($data as $d) { */?>
      
        <h5> <?php echo "Edit Song - " . $d->getSongID(); ?></h5>
        <form METHOD ="POST" ACTION = "<?php $_SERVER["PHP_SELF"].'?view=song' ?>">
          
          <div class="six columns">
            <input type="hidden" id="eSongID" name="eSongID" value="<?php echo  $d->getSongID(); ?>">
            
            <label for="name">Playlist ID</label>
            <input class="u-full-width" type="text" placeholder="Playlist ID" id="ePlaylistID" name="ePlaylistID" required value="<?PHP echo $d->getPlaylistID(); ?>">
       
            <label for="name">Song Name</label>
            <input class="u-full-width" type="text" placeholder="Song Name" id="eSongName" name="eSongName" required value="<?PHP echo $d->getSongName(); ?>">

            <label for="name">Artist</label>
            <input class="u-full-width" type="text" placeholder="Artist" id="eArtist" name="eArtist" required value="<?PHP echo $d->getArtist(); ?>">
          </div>
      
          <div class="six columns">
            <label for="name">Genre</label>
            <input class="u-full-width" type="text" placeholder="Genre" id="eArtist" name="eGenre" required value="<?PHP echo $d->getGenre(); ?>">

            <label for="name">Year</label>
            <input class="u-full-width" type="text" placeholder="Year" id="eArtist" name="eYear" required value="<?PHP echo $d->getYear(); ?>">

            <label for="name">Duration</label>
            <input class="u-full-width" type="text" placeholder="Duration" id="eDuration" name="eDuration" required value="<?PHP echo $d->getDuration(); ?>">

            <input type="hidden" name="posting" value="update">      
          </div>

          <div class="six columns">
            <input class="button-primary" type="submit" value="Submit">
          </div>
         
          <BR>
        </form> 
    <?php /*}*/
    }
}
?>