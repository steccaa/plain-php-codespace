<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatrice PHP con SQLite3</title>
</head>
<body>
    <h1>Calcolatrice con Memorizzazione</h1>
    <form method="post">
        <input type="number" step="any" name="num1" placeholder="Primo numero" required>
        <input type="number" step="any" name="num2" placeholder="Secondo numero" required>
        <select name="operation" required>
            <option value="add">Addizione</option>
            <option value="subtract">Sottrazione</option>
            <option value="multiply">Moltiplicazione</option>
            <option value="divide">Divisione</option>
        </select>
        <button type="submit" name="calculate">Calcola</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operation = $_POST['operation'];
        $result = null;
        $operationText = "";

        if (is_numeric($num1) && is_numeric($num2)) {
            switch ($operation) {
                case "add":
                    $result = $num1 + $num2;
                    $operationText = "Addizione";
                    break;
                case "subtract":
                    $result = $num1 - $num2;
                    $operationText = "Sottrazione";
                    break;
                case "multiply":
                    $result = $num1 * $num2;
                    $operationText = "Moltiplicazione";
                    break;
                case "divide":
                    if ($num2 != 0) {
                        $result = $num1 / $num2;
                        $operationText = "Divisione";
                    } else {
                        echo "<h2>Errore: Divisione per zero non consentita.</h2>";
                        exit();
                    }
                    break;
                default:
                    echo "<h2>Operazione non valida.</h2>";
                    exit();
            }

            echo "<h2>Risultato: $result</h2>";

            // Connessione al database SQLite3
            $db = new SQLite3('db.sqlite');

            // Inserimento diretto dei dati nel database
            $query = "INSERT INTO calcoli (num1, num2, operazione, risultato) 
                      VALUES ($num1, $num2, '$operationText', $result)";
            $db->exec($query);

            echo "<h3>Calcolo salvato nel database.</h3>";

            // Chiudi la connessione al database
            $db->close();
        } else {
            echo "<h2>Errore: Inserisci numeri validi.</h2>";
        }
    }
    ?>
</body>
</html>




