<?php require "templates/header.php"; ?>

<h2>Edit ReceiveEmailMessage</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["ReceiveEmailMessageId"])) {
    try {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $ReceiveEmailMessageId = $_GET["ReceiveEmailMessageId"];

        $sql = "SELECT * FROM ReceiveEmailMessage WHERE ReceiveEmailMessageId = :ReceiveEmailMessageId";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':ReceiveEmailMessageId', $ReceiveEmailMessageId);
        $statement->execute();

        $row = $statement->fetch();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php if (isset($row) && $row) { ?>
    <form method="POST" action="UpdateReceiveEmailMessage.php">
        <input type="hidden" name="ReceiveEmailMessageId" value="<?php echo $row['ReceiveEmailMessageId']; ?>">

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>">

        <label for="description">Description</label>
        <textarea name="description" id="description"><?php echo $row['description']; ?></textarea>

        <input type="submit" name="submit" value="Update">
    </form>
<?php } else { ?>
    <blockquote>ReceiveEmailMessage not found.</blockquote>
<?php } ?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
