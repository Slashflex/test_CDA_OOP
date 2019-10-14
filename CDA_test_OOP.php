<?php // Class Song is instanciated with a song's name as parameter 
$song = new Song('99 shooters sans alcool'); 
?>

<!-- Form is displayed -->
<p>Veuillez entrer un nombre entre 0 et 99 :</p>

<form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
<!-- Name attribute (user input) will be used to "play" the different couplets of the song...
... according to what the user has typed in when the form is submitted -->
  <input type="text" name="user_input">
  <input type="submit" name="submit" value="Afficher le couplet !">  
</form>

<?php
// This is the main method of the class Song and the program runs according to its class's methods
$song->startSong();

class Song
{
	// Assign values to variables
    public $value = null; // $value is set to NULL to prevent an error message once page's loaded
    public $high = 99; // $high equal 99 since the program trys to only accepts user input >= to 99
    public $low = 0; // $low equal 0 since the program trys to only accepts user input <= to 0

	// Sets the music name once as soon as the class Song is instantiated with a string as parameter (see line 2)
    public function __construct($songName)
    {
        echo 'Votre musique préférée : '.$songName." vient d'être chargée.\r\n";
    }

	/* Function used to protect from Cross Site Scripting (XSS) attack...
	... this method tests the user input with 3 existing PHP methods */
    public function test_input($user_input)
    {
        $user_input = trim($user_input); // Removes spaces at the beginning and end of the string
		$user_input = stripslashes($user_input); // Removes backslashes from a string
		$user_input = htmlspecialchars($user_input); // Converts special characters to HTML entities
    	return $user_input;
    }

    // Function to check the range of user input between minimum and maximum range
    public function numberRange($value, $high, $low)
    {
        // return false if user input is lower than parameter $low ($low will be equal to 0 when function numberRange will be called)
        if ($value < $low) return false;

        // return false if user input is greater than parameter $high ($high will be equal to 99 when function numberRange will be called)
        if ($value > $high) return false;
        // If the user input is greater than or equal to $low (0) and less than or equal to $high (99)...
        //... makes it a numeric value with a state of true
        if ($value >= $low && $value <= $high) return is_numeric($value);

        return true;
    }

	// Function used to decrement the user input by 1
    public function decrement($value)
    {
        return --$value;
    }

	// Main method controlling the "game"'s flow
    public function startSong()
    {
		// Determines whether a variable is declared
        if (isset($_POST['user_input'])) {
            // Assign the variable with 3 differents checks using PHP methods
            $value = $this->test_input($_POST['user_input']);

			// If the user input is between 99 and 0 
            if ($this->numberRange($value, $this->high, $this->low)) {
                if ($value == $this->low) {
                    /* If user input is equal to 0...
                    ... default couplet of the song is displayed when there's no more "shooters" left */
                    echo '<p>
							Plus de shooters sans alcool sur le mur, plus de shooters sans alcool. </br> 
							Vas au supermarché pour en acheter, 99 shooters sans alcool sur le mur.					
						  </p>';
                } elseif ($value == 1) {
                    // Else if user input is equal to 1, displays the first two words "shooter" as singular 
                    echo '<p>'.
							$value.' shooter sans alcool sur le mur, '.$value.' shooter sans alcool. </br>
							Bois en un et au suivant ! plus de shooters sans alcool sur le mur.
						  </p>';
                } elseif ($value == 2) {
					/* Else if user input is equal to 2, displays the first two words "shooters" as plural but the last word "shooter" as singular...
					... and calls the decrement method with user input as parameter */
                    echo '<p>'.
							$value.' shooters sans alcool sur le mur, '.$value.' shooters sans alcool. </br>
							Bois en un et au suivant ! '.$this->decrement($value).' shooter sans alcool sur le mur.
						  </p>';
                } else {
                    /* Default couplet when user input is greater than 2, displaying all words "shooters" as plural...
                      ... and calls the decrement function with the user input as a parameter */
                    echo '<p>'.
							$value.' shooters sans alcool sur le mur, '.$value.' shooters sans alcool. </br>
							Bois en un et au suivant ! '.$this->decrement($value).' shooters sans alcool sur le mur.
						  </p>';
                }
            } elseif (empty($value)) {
                echo '<p>
						Vous n\'avez indiquer aucune valeure ! </br> 
						Veuilllez recommencer.
					  </p>';
            } else {
				/* Displays a red text with the user input displayed and an error message when the user input is different from values ​​between 0 and 99...
				... e.g(happens when the user input is a string or >= 100 or <= 0) */
				echo '<p>
						<span style="color:red">' .$value. '</span> n\'est pas une valeure correcte ! </br> 
						Veuilllez n\'utiliser que des nombres entiers compris entre 0 et 99.
					  </p>';
            }
        }
    }
}
