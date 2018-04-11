/*
* Audio player Script
*/

// currentPlaylist array value is got from nowPlayingBar.php-Line-22
var currentPlaylist = Array();
// Audio class is instantiated by audioElement-object at nowPlayingBar.php-Line-24
var audioElement;

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time - (minutes * 60);        
    var extraZero;    
    
    // check if seconds is less than zero and prefix it with 0 if any
    // eg: time of 3.4 will be output as 3:04
    var extraZero = (seconds < 10) ? "0" : '';

    return minutes + ":" + extraZero + seconds;
}

// Audio Object Constructor which is akin to a class in JS
function Audio() {

    this.currentlyPlaying;
    // Read more on audio element here: https://tinyurl.com/y76sl54x
    // this.audio is the property of the Audio class   
    this.audio = document.createElement('audio');

    // When the canplay event is triggered, the function performs its operation
    // canplay event checks whether this audio object is able to play a song
    // if yes, it will perfrom the action in Line-24
    // event-canplay was called on this Audio object
    this.audio.addEventListener("canplay", function() {
        // this in this.duration - refers to the audio object viz. this.audio
        // that's why you don't have to write this.audio.durartion
        // else if you wanted to output duraton from outside the audio object
        // you would have to write this.audio.duration, just like this.audio.src in Line 49
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    // track is the object containing all the songs data, viz the object property. See nowPlayingBar.php-Line-41
    // Property of Object track is obtained by parsing the JSON data
    this.setTrack = function(track) {
    // Assigning object track to property
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }


}
