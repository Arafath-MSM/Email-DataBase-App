<?php
if (isset($_GET['recordId'])) {
    try {
        require "../config.php"; // Include your database configuration
        require "../common.php"; // Include any common functions

        $connection = new PDO($dsn, $username, $password, $options);

        $recordId = $_GET['recordId'];
        $sql = "SELECT * FROM CreateEmailMessage WHERE EmailMessageId = :recordId";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':recordId', $recordId, PDO::PARAM_INT);
        $statement->execute();

        $record = $statement->fetch();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php if ($record) { ?>
    <h2>Record Details</h2>

    <table>
        <!-- ... (previous code) ... -->
    </table>

    <a href="editRecord.php?recordId=<?php echo escape($record["EmailMessageId"]); ?>">Edit</a><br>
    <a href="home.php">Back to list</a>
<?php } else { ?>
    <blockquote>No record found.</blockquote>
<?php } ?>

<?php require "templates/footer.php"; ?>
