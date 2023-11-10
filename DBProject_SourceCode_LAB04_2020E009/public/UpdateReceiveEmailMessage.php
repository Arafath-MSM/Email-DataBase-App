<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $ReceiveEmailMessageId = $_POST["ReceiveEmailMessageId"];
        $newTitle = $_POST["title"];
        $newDescription = $_POST["description"];

        $sql = "UPDATE ReceiveEmailMessage
                SET title = :title, description = :description
                WHERE ReceiveEmailMessageId = :ReceiveEmailMessageId";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':ReceiveEmailMessageId', $ReceiveEmailMessageId);
        $statement->bindValue(':title', $newTitle);
        $statement->bindValue(':description', $newDescription);

        $statement->execute();

        header("Location: ReadReceiveEmailMessage.php?ReceiveEmailMessageId=$ReceiveEmailMessageId");
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
s