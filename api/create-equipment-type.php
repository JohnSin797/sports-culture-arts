<?php
// Check if form is submitted
include('../connection/dbase.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are not empty
    if (isset($_POST['name']) && !empty($_POST['name']) && isset($_FILES['type_image']) && !empty($_FILES['type_image'])) {
        // Get the form data
        $name = $_POST['name'];
        $image_file = $_POST['type_image'];
        $targetDir = 'storage/images/'; // Ensure the trailing slash here
        $uploadOk = 1;

        // Extract the file extension and generate a unique filename
        $imageFileType = strtolower(pathinfo($_FILES['type_image']['name'], PATHINFO_EXTENSION));
        $uniqueFilename = time() . '_' . uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $uniqueFilename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["type_image"]["tmp_name"], '../'.$targetFile)) {
            echo "The file has been uploaded successfully as: " . htmlspecialchars($uniqueFilename) . "<br>";
        } else {
            // Handle errors and redirect with a response message
            echo "Sorry, there was an error uploading your file.<br>";
            header("Location: ../home/sports/create-equipment-type.php?responseMessage=Upload%20failed");
            exit;
        }
        if ($CON->connect_error) {
            die("Connection failed: " . $CON->connect_error);
            header("Location: ../home/sports/create-equipment-type.php?resonseMessage=Connection%20failed");
            exit;
        }

        // Prepare the SQL statement to insert data into the table
        $sql = "INSERT INTO equipment_type (name, type_image) VALUES (?, ?)";

        // Prepare the statement
        if ($stmt = $CON->prepare($sql)) {
            // Bind the parameters (equipment_type is an integer, name is a string)
            $stmt->bind_param("ss", $name, $targetFile);

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
