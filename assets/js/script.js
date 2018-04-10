// Value to currentPlaylist var is passed from nowPlayingBar.php-Line-22
var currentPlaylist = Array();
// Audio class is instantiated by AudioElement-object at nowPlayingBar.php-Line-23
var audioElement;

// Audio Object Constructor which is akin to a class in JS
function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.setTrack = function(src) {
        this.audio.src = src;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }
}
