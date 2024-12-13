<?php

session_start();

$start = filter_input(INPUT_GET, "start", FILTER_VALIDATE_BOOLEAN);
$guess = filter_input(INPUT_GET, "guess", FILTER_VALIDATE_INT);

if ($start === true) {
    $nombreADeviner = rand(1, 100);
    $_SESSION['nombreADeviner'] = $nombreADeviner;
    echo donneBaseHTML(donneBoutonStop().''.donneFormJeu(null));
} else if ($guess !== null) {
    $nombreADeviner = $_SESSION['nombreADeviner'];
    if ($nombreADeviner == $guess) {
        echo donneBaseHTML('<div>Gagné !</div>'.donneBoutonStart('Recommencer'));
    } else {
        $message = $guess < $nombreADeviner ? "Plus" : "Moins";
        echo donneBaseHTML(donneBoutonStop().donneFormJeu($message));
    }
} else {
    echo donneBaseHTML(donneBoutonStart('Démarrer'));
}

function donneBoutonStart($label) {
    return '
        <form method="GET" action="./plusmoins.php">
            <input type="hidden" name="start" value="true">
            <button type="submit">'.$label.'</button>
        </form>
    ';
}

function donneBoutonStop() {
    return '
        <form method="GET" action="./plusmoins.php">
            <button type="submit">Stopper le jeu</button>
        </form>
    ';
}

function donneBaseHTML($body) {
    return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PlusMoins PHP</title>
        </head>
        <body>
            '.$body.'
        </body>
        </html>
    ';
}

function donneFormJeu($message) {
    $divMessage = $message ? '<div>'.$message.'</div><br>' : null;
    return '
        <form method="GET" action="./plusmoins.php">
            '.($divMessage ? $divMessage : '').'
            <label for="inputGuess">Devinez un nombre :</label>
            <br>
            <input type="number" id="inputGuess" name="guess" required>
            <br>
            <button type="submit">Deviner</button>
        </form>
    ';
}