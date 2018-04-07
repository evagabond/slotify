<?php include 'includes/header.php';

if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);
/* 
 * No need to create Artist object like we have created Album object in Line 10, because 
 * Artist object has already been created in Album.php-Line 38. Instead, replace the object 
 * creation in Line 16 with the class-method call in Line 17
 */
 // $artist = new Artist($con, $album['artist']); 
$artist = $album->getArtist();
?>

<div class="entityInfo">

    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>">             
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>   
    </div>

</div>

<div class="tracklistContainer">
    <ul class="tracklist">

        <?php
        $songIdArray = $album->getSongIds();

        $i = 1;
        foreach($songIdArray as $songId) {

            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();              
            
            echo "<li class='tracklistRow'>
                <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png'>
                    <span class='trackNumber'>$i</span>
                </div>

                <div class='trackInfo'>
                    <span class='trackName'>{$albumSong->getTitle()}</span>
                    <span class='artistName'>{$albumArtist->getName()}</span>              
                </div>

                <div class='trackOptions'>
                    <img class='optionButton' src='assets/images/icons/more.png'>
                </div>

                <div class='trackDuration'>
                    <span class='duration'>{$albumSong->getDuration()}</span>
                </div>
           </li>";

           $i++;

        }

        ?>
    
    </div>


</div>

          
<?php include 'includes/footer.php'; ?>