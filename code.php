
<?php
    // Conexión a la base de datos
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "botellita";
    $conn = new mysqli($host, $user, $password, $db);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    function generateRoomCode() {
        // Generate a random room code using letters and numbers
        $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = "";
        for ($i = 0; $i < 5; $i++) {
          $code .= $possible[rand(0, strlen($possible) - 1)];
        }
        return $code;
    }
    function joinRoom() {
        $enteredCode = $_POST["room-code"];
        $sql = "SELECT codigo_sala FROM preguntas_y_retos WHERE codigo_sala = '$enteredCode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Room code is valid
            $row = $result->fetch_assoc();
            $roomCode = $row["codigo_sala"];
            if(count(players)<8){
            alert("Successfully joined room");
            // Do something to add player to the room
            }else{
              alert("Sala Llena")
            }
        } else {
            // Room code is invalid
            alert("Invalid Room code");
        }
        $conn->close();
    }
    // Recuperar los valores del formulario
    $truths = $_POST["truths"];
    $challenges = $_POST["challenges"];
    $roomCode = generateRoomCode();

    // Crear una consulta para insertar las preguntas y los retos en la base de datos
    $sql = "INSERT INTO preguntas_y_retos (verdades, retos, codigo_sala) VALUES ('$truths', '$challenges', '$roomCode')";

    // Ejecutar la consulta y verificar si se ha insertado correctamente
    if ($conn->query($sql) === TRUE) {
        echo "Las preguntas y los retos se han guardado correctamente.";
    } else {
        echo "Error al guardar las preguntas y los retos: " . $conn->error;
    }

    $conn->close();
?>