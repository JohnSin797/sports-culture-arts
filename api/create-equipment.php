<?php
// Check if form is submitted
include('../../connection/dbase.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are not empty
    if (isset($_POST['equipment_type']) && !empty($_POST['equipment_type']) && isset($_POST['equipment_name']) && !empty($_POST['equipment_name'])) {
        // Get the form data
        $equipment_type = $_POST['equipment_type'];
        $equipment_name = $_POST['equipment_name'];

        // Connect to the database (adjust with your connection details)
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "your_database";

        // // Create a connection
        // $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($CON->connect_error) {
            die("Connection failed: " . $CON->connect_error);
        }

        // Prepare the SQL statement to insert data into the table
        $sql = "INSERT INTO equipment (equipment_type_id, equipment_name) VALUES (?, ?)";

        // Prepare the statement
        if ($stmt = $CON->prepare($sql)) {
            // Bind the parameters (equipment_type is an integer, name is a string)
            $stmt->bind_param("is", $equipment_type, $equipment_name);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New equipment added successfully!";
            } else {
                echo "Error: " . $stmt->error;
                header("Location: ../home/sports/create-sports-equipment-stock.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
                exit;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $CON->error;
            header("Location: ../home/sports/create-sports-equipment.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
            exit;
        }

        // Close the connection
        $CON->close();
        header("Location: ../home/sports/create-sports-equipment.php?resonseMessage=Data%20saved%20successfully");
        exit;
    } else {
        echo "Please fill in all fields.";
    }
}
?>
