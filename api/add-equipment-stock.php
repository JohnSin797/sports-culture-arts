<?php
// Check if form is submitted
include('../connection/dbase.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are not empty
    if (isset($_POST['equipment_id']) && !empty($_POST['equipment_id']) && isset($_POST['quantity']) && !empty($_POST['quantity'])
        && isset($_POST['tblaccount_id']) && !empty($_POST['tblaccount_id'])
    ) {
        // Get the form data
        $tblaccount_id = $_POST['tblaccount_id'];
        $quantity = $_POST['quantity'];
        $equipment_id = $_POST['equipment_id'];
        $stats = 'stock';
        if ($CON->connect_error) {
            die("Connection failed: " . $CON->connect_error);
        }

        $sql = "INSERT INTO logs (equipment_id, tblaccount_id, quantity, stats) VALUES (?, ?, ?, ?)";
        $sql2 = "INSERT INTO stocks (equipment_id, stock) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE stock = stock + VALUES(stock)";

        // Prepare the SQL statement to insert data into the logs table
        if ($stmt = $CON->prepare($sql)) {
            // Bind the parameters (adjust types as needed: i=int, s=string)
            $stmt->bind_param("iiis", $equipment_id, $tblaccount_id, $quantity, $stats);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New log entry added successfully!";

                // Prepare the second statement for stocks table
                if ($stmt2 = $CON->prepare($sql2)) {
                    // Define stock_quantity and bind parameters
                    $stock_quantity = $quantity; // Example: using the same quantity from logs
                    $stmt2->bind_param("ii", $equipment_id, $stock_quantity);

                    // Execute the second statement
                    if ($stmt2->execute()) {
                        echo "Stock record updated successfully!";
                    } else {
                        echo "Error updating stocks: " . $stmt2->error;
                        header("Location: ../home/sports/add-equipment-stock.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
                        exit;
                    }

                    // Close the second statement
                    $stmt2->close();
                } else {
                    echo "Error preparing stocks statement: " . $CON->error;
                    header("Location: ../home/sports/add-equipment-stock.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
                    exit;
                }
            } else {
                echo "Error inserting into logs: " . $stmt->error;
                header("Location: ../home/sports/add-equipment-stock.php?resonseMessage=There%20is%20a%20problem%20during%20submission");
                exit;
            }

            // Close the first statement
            $stmt->close();
        } else {
            echo "Error preparing logs statement: " . $CON->error;
        }

        // Close the connection
        $CON->close();
        header("Location: ../home/sports/add-equipment-stock.php?resonseMessage=Data%20saved%20successfully");
        exit;
    } else {
        echo "Please fill in all fields.";
    }
}
?>
