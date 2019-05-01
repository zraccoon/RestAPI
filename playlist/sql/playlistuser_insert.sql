USE enjoydb;

INSERT into User(FirstName, LastName, Email)
    VALUES("Christian","Bale","balechristian@gmail.com"),
    ("Bradley","Cooper","bradcooper@aol.com"),
    ("Emma","Stone","emma.stone@yahoo.com"),
    ("Tom","Harper","harp007@gmail.com"),
    ("Lucy","James","jameslucy@rediff.com");


INSERT into Playlist (PlaylistName,UserID)
    VALUES("Coffee House", 2),
    ("Make me fade", 4),
    ("The colder days", 3),
    ("Whiskey in the woods", 5),
    ("Stress Reliever", 1),
    ("Summer of love", 3);


INSERT into Artist (ArtistName,UserID)
    VALUES("Artist1", 1),
    ("Artist2", 4),
    ("Artist3", 3);

INSERT into Songs (PlaylistID,SongName,Artist,genre,year,duration)
    VALUES(2, "Who Do You Love", "The Chainsmokers", "Electronic", 2019, "3:51" ),
    (1, "Better Now", "Post Malone", "Hip-Hop", 2018,"3:52"),
    (4, "I Mean It", "G Eazy", "Rap", 2014, "4:02"),
    (3, "God's Plan", "Drake","Hip-Hop", 2018, "5:56"),
    (5, "White Iversion", "Post Malone", "Rap", 2015, "4:32"),
    (4,"Chlorine", "Twenty One Pilots", "Electronic",2019,"3:55");
