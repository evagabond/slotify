/*
* Audio player Script
*/


// currentPlaylist array value is got from nowPlayingBar.php-Line-22
var currentPlaylist = Array();
// Audio class is instantiated by audioElement-object at nowPlayingBar.php-Line-24
var audioElement;

// Audio Object Constructor which is akin to a class in JS
function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    // track is the object containing all the songs data, viz the object property. See nowPlayingBar.php-Line-39
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
