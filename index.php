<?php
require 'Song.php'; // We Include the class Song from Song.php file

// Class Song is instanciated with a song's name as parameter 
$song = new Song('99 shooters sans alcool');
?>

<!-- Form is displayed -->
<p>Veuillez entrer un nombre entre 0 et 99 :</p>

<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
<!-- Name attribute (user input) will be used to "play" the differents couplets of the song...
... according to what the user has typed in when the form is submitted -->
  <input type="text" name="user_input">
  <input type="submit" name="submit" value="Afficher le couplet !">  
</form>


<?php 
// This is the main method of the class Song and the program runs according to its class's methods
$song->startSong();
?>
