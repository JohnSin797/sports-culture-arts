<?php
// Check if form is submitted
include('../connection/dbase.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are not empty
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        // Get the form data
        $name = $_POST['name'];
        if ($CON->connect_error) {
            die("Connection failed: " . $CON->connect_error);
            header("Location: ../home/sports/create-equipment-type.php?resonseMessage=Connection%20failed");
            exit;
        }

        // Prepare the SQL statement to insert data into the table
        $sql = "INSERT INTO equipment_type (name) VALUES (?)";

        // Prepare the statement
        if ($stmt = $CON->prepare($sql)) {
            // Bind the parameters (equipment_type is an integer, name is a string)
            $stmt->bind_param("s", $name);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New equipment type added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $CON->error;
            header("Location: ../home/sports/create-equipment-type.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
            exit;
        }

        // Close the connection
        $CON->close();
        header("Location: ../home/sports/create-equipment-type.php?resonseMessage=Data%20saved%20successfully");
        exit;
    } else {
        echo "Please fill in all fields.";
    }
}
?>
