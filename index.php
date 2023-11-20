<?php
// Verbindung zur Datenbank herstellen
$conn = new mysqli("localhost", "root", "", "fahrzeugverwaltung");

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

 // Aktion ausführen
 if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'fahrzeugliste':
            // Alle Autos aus der Datenbank abfragen
            $sql = "SELECT * FROM fahrzeug";
            $stmt = $conn->query($sql);

            // Die Autos in einer Tabelle ausgeben
            echo "<table>";
            echo "<tr><th>Kennzeichen</th><th>Marke</th><th>Modell</th><th>Kilometerstand</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr>";
                echo "<td>{$row['kennzeichen']}</td>";
                echo "<td>{$row['marke']}</td>";
                echo "<td>{$row['modell']}</td>";
                echo "<td>{$row['kilometerstand']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            break;
        case 'suche':
            // Suchanfrage abfragen bei suchfeld
            $suchbegriff = $_POST['suchbegriff'];

            // SQL-Abfrage für die Suche
            $sql = "SELECT * FROM fahrzeug WHERE kennzeichen = '$suchbegriff'";
            $stmt = $conn->query($sql);

            // Die Ergebnisse der Suche ausgeben
            if ($stmt->num_rows > 0) {
                echo "Das Auto wurde gefunden!";
            } else {
                echo "Das Auto ist nicht in der Datenbank.";
            }
            break;
        case 'drucken':
            // Meldung ausgeben
            echo "Ihre Fahrzeugliste wird gedruckt.";
            break;
    }
}

// Aktion ausführen
if (isset($_POST['submit'])) {
    // Daten aus dem Formular abrufen
    $kennzeichen = $_POST['kennzeichen'];
    $marke = $_POST['marke'];
    $modell = $_POST['modell'];
    $kilometerstand = $_POST['kilometerstand'];

    // Daten prüfen
    if (empty($kennzeichen) || empty($marke) || empty($modell) || empty($kilometerstand)) {
        echo "Bitte füllen Sie alle Felder aus.";
        return;
    }
        // Prüfen, ob das Fahrzeug bereits in der Datenbank vorhanden ist
        $sql = "SELECT * FROM fahrzeug WHERE kennzeichen = '$kennzeichen'";
        $stmt = $conn->query($sql);
        if ($stmt->num_rows > 0) {
            echo "Das Fahrzeug ist bereits in der Datenbank vorhanden.";
            return;
        }

        // SQL-Abfrage zum Einfügen des Fahrzeugs in die Datenbank
        $sql = "INSERT INTO fahrzeug (kennzeichen, marke, modell, kilometerstand) VALUES ('$kennzeichen', '$marke', '$modell', '$kilometerstand')";

        // Abfrage ausführen
        $result = $conn->query($sql);

        // Erfolg oder Fehlermeldung ausgeben
        if ($result) {
            echo "Sie haben das Auto erfolgreich angelegt!";
        } else {
            echo "Beim Anlegen des Fahrzeugs ist ein Fehler aufgetreten.";
        }
    }

    
// Datenbankverbindung schließen
$conn->close();
?>
