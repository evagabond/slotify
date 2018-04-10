<?php

// Fetch songs to generate a random playlist
$songQuery = mysqli_query($con, 'SELECT id FROM songs ORDER BY RAND() LIMIT 10');

$resultArray = array();
    
while($row = mysqli_fetch_assoc($songQuery)) {
  //Pushing the song Ids into $resultArray
  array_push($resultArray, $row['id']);
}

// Converting PHP array ($resultArray) into JSON
$jsonArray = json_encode($resultArray);
?>

<script>
// To Check contents of $jsonArray object
// console.log(<?php //echo $jsonArray; ?> );

$(document).ready(function() {
  currentPlaylist = <?php echo $jsonArray; ?>;
  // audioElement object
  audioElement = new Audio();

  // currentPlaylist[0] set from Line 22
  setTrack(currentPlaylist[0], currentPlaylist, false); 
});

// trackID = currentPlaylist[0] from Line 26, which is the value of the first Song Id fetched from the DB
function setTrack(trackId, newPlaylist, play) {  

  // AJAX call to get song data from DB. songId is got from jsonArray[0] in Line 13, 26
  // jsonArray[0] is the value of the first Song ID fetched from the DB
  // function(data) is the result returned by the Ajax call, which is the JSON data
  $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

    // Converting JSON data into JS Object called track, so that JS can read it
    // If not JSON data isn't parsed JS won't be able to read it, resulting in an error
    var track = JSON.parse(data);
    // console.log(track);

    // Creating jQuery Object to output Track Title in Line 89
    $(".trackName span").text(track.title);

    // AJAX call to get Artist data from DB
    // track.artist is got from the Ajax call in Line 35
    // function(data) is the result returned by the Ajax call, which is the JSON data
    $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
      var artist = JSON.parse(data);
      //console.log(artist.name);
      // Creating jQuery Object to output Track Title in Line 93
      $(".artistName span").text(artist.name);
    });

     // AJAX call to get Album data from DB
     // track.album is got from the Ajax call in Line 35
    // function(data) is the result returned by the Ajax call, which is the JSON data 
    $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
      var album = JSON.parse(data);
      //console.log(album.title);
      //console.log(album.genre);
      $(".albumLink img").attr("src", album.artworkPath);      
    }); 

    // track.path is got from the Ajax call in Line 35
    // path refers to the column name in the songs table
    audioElement.setTrack(track);
    playSong();

  });

  if(play) {
    audioElement.play();
  }
}

function playSong() {
  if(audioElement.audio.currentTime === 0) {
    // console.log(audioElement);
    // AJAX call to UPDATE song play count in the songs table
    $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });   
  }
  
  $(".controlButton.play").hide();
  $(".controlButton.pause").show();
  audioElement.play();
}

function pauseSong() {
  $(".controlButton.play").show();
  $(".controlButton.pause").hide();
  audioElement.pause();
}
</script>
      
<div id="nowPlayingBarContainer">

  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
      <div class="content">
        <span class="albumLink">
          <img class="albumArtwork" src="" alt="Album cover">
        </span>

        <div class="trackInfo">

          <span class="trackName">
            <span></span>
          </span>

          <span class="artistName">
            <span></span>
          </span>

        </div>
      </div>
    </div>

    <div id="nowPlayingCenter">

      <div class="content playerControls">

        <div class="buttons">
          <button class="controlButton shuffle" title="Shuffle button">
            <img src="assets/images/icons/shuffle.png" alt="Shuffle">
          </button>

          <button class="controlButton previous" title="Previous button">
            <img src="assets/images/icons/previous.png" alt="Previous">
          </button>

          <button class="controlButton pause" title="Pause button" style="display:none;">
            <img src="assets/images/icons/pause.png" alt="Pause" onclick="pauseSong()">
          </button>

          <button class="controlButton play" title="Play button" onclick="playSong()">
            <img src="assets/images/icons/play.png" alt="Play">
          </button>

          <button class="controlButton next" title="Next button">
            <img src="assets/images/icons/next.png" alt="Next">
          </button>

          <button class="controlButton repeat" title="Repeat button">
            <img src="assets/images/icons/repeat.png" alt="Repeat">
          </button>

        </div>

        <div class="playbackBar">

          <span class="progressTime current">0.00</span>

          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>            
          </div>

          <span class="progressTime remaining">0.00</span>
        </div>
      </div>        
    </div>

      <div id="nowPlayingRight">

        <div class="volumeBar">

          <button class="controlButton volume" title="Volume button">
            <img src="assets/images/icons/volume.png" alt="Volume">
          </button>
          
          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div> 
                   
        </div>              
      </div>
  </div>
</div>
