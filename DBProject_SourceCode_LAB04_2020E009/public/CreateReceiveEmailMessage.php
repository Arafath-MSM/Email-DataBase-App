<?php
require "templates/header.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        // Process and insert data into the ReceiveEmailMessage table
        $title = $_POST['title'];
        $description = $_POST['description'];
        $createEmailMessages = $_POST['createEmailMessage'];

        // Insert data into the ReceiveEmailMessage table
        $sql = "INSERT INTO ReceiveEmailMessage (title, description) VALUES (:title, :description)";
        $statement = $connection->prepare($sql);
        $statement->execute(['title' => $title, 'description' => $description]);

        // Get the newly inserted ReceiveEmailMessage ID
        $newlyInsertedReceiveEmailMessageId = $connection->lastInsertId();

        // Insert relationship data into another table (replace RelationshipTable with your actual table name)
        if (!empty($createEmailMessages)) {
            foreach ($createEmailMessages as $messageId) {
                $sql = "INSERT INTO RelationshipTable (receiveEmailMessageId, emailMessageId) VALUES (:receiveEmailMessageId, :emailMessageId)";
                $statement = $connection->prepare($sql);
                $statement->execute(['receiveEmailMessageId' => $newlyInsertedReceiveEmailMessageId, 'emailMessageId' => $messageId]);
            }
        }

        // Redirect to a success page or display a success message
        header("Location: success.php");
        exit;
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    // Query to retrieve a list of CreateEmailMessage entries
    $sql = "SELECT EmailMessageId, name FROM CreateEmailMessage";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $createEmailMessages = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Create ReceiveEmailMessage</h2>

<form method="post">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" required></textarea>

    <label for="createEmailMessage">Link to CreateEmailMessage</label>
    <select name="createEmailMessage[]" id="createEmailMessage" multiple>
        <?php foreach ($createEmailMessages as $message) { ?>
            <option value="<?php echo $message['EmailMessageId']; ?>"><?php echo $message['name']; ?></option>
        <?php } ?>
    </select>

    <input type="submit" name="submit" value="Create ReceiveEmailMessage">
</form>

<?php if (isset($_POST['submit'])) { ?>
    <blockquote>ReceiveEmailMessage successfully created.</blockquote>
<?php } ?>


<a href="ReceiveEmailMessageHome.php">Back to ReceiveEmailMessage Home</a>

<?php require "templates/footer.php"; ?>
