<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions

// Check if a ReceiveEmailMessage ID is provided in the URL
if (isset($_GET['id'])) {
    $receiveEmailMessageId = $_GET['id'];

    try {
        // Establish a database connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Fetch existing data of the ReceiveEmailMessage entity
        $selectSql = "SELECT * FROM ReceiveEmailMessage WHERE ReceiveEmailMessageId = :id";
        $selectStatement = $connection->prepare($selectSql);
        $selectStatement->bindParam(':id', $receiveEmailMessageId, PDO::PARAM_INT);
        $selectStatement->execute();
        $receiveEmailMessage = $selectStatement->fetch(PDO::FETCH_ASSOC);

        if (!$receiveEmailMessage) {
            echo "ReceiveEmailMessage not found.";
            exit;
        }

        // Handle form submission
        if (isset($_POST['submit'])) {
            // Start a database transaction
            $connection->beginTransaction();

            try {
                // Update the attributes of the ReceiveEmailMessage entity
                $title = $_POST['title'];

                $description = $_POST['description'];

                $updateSql = "UPDATE ReceiveEmailMessage SET title = :title, description = :description WHERE ReceiveEmailMessageId = :id";
                $updateStatement = $connection->prepare($updateSql);
                $updateStatement->bindParam(':title', $title, PDO::PARAM_STR);
                $updateStatement->bindParam(':description', $description, PDO::PARAM_STR);
                $updateStatement->bindParam(':id', $receiveEmailMessageId, PDO::PARAM_INT);
                $updateStatement->execute();

                // Update the relationship table (CreateEmailMessage_ReceiveEmailMessage)
                // You need to implement this part based on your logic

                // Commit the transaction
                $connection->commit();

                echo "ReceiveEmailMessage updated successfully.";
            } catch (PDOException $error) {
                // Rollback the transaction on error and display an error message
                $connection->rollback();
                echo "Error: " . $error->getMessage();
            }
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
} else {
    echo "Invalid Request: ReceiveEmailMessageId not provided.";
}
?>

<!-- HTML form for updating ReceiveEmailMessage attributes -->
<h2>Edit ReceiveEmailMessage</h2>
<form method="post">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?php echo $receiveEmailMessage['title']; ?>">
    <label for="description">Description</label>
    <input type="text" name="description" id="description" value="<?php echo $receiveEmailMessage['description']; ?>">
    <input type="submit" name="submit" value="Update">
</form>
