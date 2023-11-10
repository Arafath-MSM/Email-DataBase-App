<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    try {
        require "../config.php"; // Include your database configuration
        require "../common.php"; // Include any common functions

        // Create a PDO connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Start a transaction
        $connection->beginTransaction();

        // Step 1: Insert new entity (CreateMail)
        $createMailName = $_POST["createMailName"]; // Adjust field name accordingly

        // Prepare and execute the insert query
        $sqlInsertCreateMail = "INSERT INTO CreateMail (name) VALUES (:createMailName)";
        $stmtInsertCreateMail = $connection->prepare($sqlInsertCreateMail);
        $stmtInsertCreateMail->bindParam(":createMailName", $createMailName, PDO::PARAM_STR);
        $stmtInsertCreateMail->execute();

        // Get the last inserted ID
        $createMailId = $connection->lastInsertId();

        // Step 2: Update the relationship table (e.g., CreateMail_RecieveMail)
        $receiveMailId = $_POST["receiveMailId"]; // Assuming you have a select field for choosing RecieveMail

        // Prepare and execute the update query
        $sqlUpdateRelationship = "UPDATE CreateMail_RecieveMail SET CreateMailId = :createMailId WHERE RecieveMailId = :receiveMailId";
        $stmtUpdateRelationship = $connection->prepare($sqlUpdateRelationship);
        $stmtUpdateRelationship->bindParam(":createMailId", $createMailId, PDO::PARAM_INT);
        $stmtUpdateRelationship->bindParam(":receiveMailId", $receiveMailId, PDO::PARAM_INT);
        $stmtUpdateRelationship->execute();

        // Commit the transaction if everything was successful
        $connection->commit();

        echo "New entity created and relationship updated successfully.";
    } catch (PDOException $error) {
        // Roll back the transaction if any query fails
        $connection->rollback();
        echo "Error: " . $error->getMessage();
    }
}
?>

<!-- HTML form for creating a new entity and updating the relationship -->
<form method="post">
    <label for="createMailName">CreateMail Name</label>
    <input type="text" id="createMailName" name="createMailName" required>

    <label for="receiveMailId">RecieveMail</label>
    <select id="receiveMailId" name="receiveMailId" required>
        <!-- Populate this select field with RecieveMail options -->
        <option value="1">RecieveMail 1</option>
        <option value="2">RecieveMail 2</option>
        <!-- Add more options as needed -->
    </select>

    <input type="submit" name="submit" value="Submit">
</form>
