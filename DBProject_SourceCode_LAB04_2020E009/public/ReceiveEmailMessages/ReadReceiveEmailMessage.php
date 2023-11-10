<?php
if (isset($_GET['ReceiveEmailMessageId'])) {
    try {
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $ReceiveEmailMessageId = $_GET['ReceiveEmailMessageId'];

        $sql = "SELECT * FROM ReceiveEmailMessage WHERE ReceiveEmailMessageId = :ReceiveEmailMessageId";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':ReceiveEmailMessageId', $ReceiveEmailMessageId, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            require "templates/header.php";
?>

            <h2>Read ReceiveEmailMessage</h2>
            <table>
                <tr>
                    <th>ReceiveEmailMessageId</th>
                    <td><?php echo $result['ReceiveEmailMessageId']; ?></td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td><?php echo $result['title']; ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?php echo $result['description']; ?></td>
                </tr>
                <!-- Add more details as needed -->
            </table>
            <a href="ReceiveEmailMessageHome.php">Back to ReceiveEmailMessage Home</a>

<?php
            require "templates/footer.php";
        } else {
            echo "No ReceiveEmailMessage found with the provided ID.";
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
} else {
    echo "Invalid Request: ReceiveEmailMessageId not provided.";
}
?>
