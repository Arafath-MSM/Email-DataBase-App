<?php require "templates/header.php"; ?>

<ul>
    <li><a href="CreateReceiveEmailMessage.php"><strong>Create ReceiveEmailMessage</strong></a> - Create a new ReceiveEmailMessage</li>
    <li><a href="ReadReceiveEmailMessage.php"><strong>Read ReceiveEmailMessage</strong></a> - Read details of ReceiveEmailMessages</li>
    <li><a href="EditReceiveEmailMessage.php"><strong>Edit ReceiveEmailMessage</strong></a> - Edit details of ReceiveEmailMessages</li>
    <li><a href="UpdateReceiveEmailMessage.php"><strong>Update ReceiveEmailMessage</strong></a> - Update details of ReceiveEmailMessages</li>
</ul>

<h2>ReceiveEmailMessage Home</h2>

<h3>Last Received ReceiveEmailMessages</h3>

<?php
try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM ReceiveEmailMessage ORDER BY CreatedDate DESC LIMIT 5"; // Adjust the LIMIT as needed
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if ($result && $statement->rowCount() > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>ReceiveEmailMessageId</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["ReceiveEmailMessageId"]); ?></td>
                <td><?php echo escape($row["title"]); ?></td>
                <td><?php echo escape($row["description"]); ?></td>
                <td><?php echo escape($row["CreatedDate"]); ?></td>
                <td>
                    <a href="ReadReceiveEmailMessage.php?ReceiveEmailMessageId=<?php echo escape($row["ReceiveEmailMessageId"]); ?>">View</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <blockquote>No results found.</blockquote>
<?php } ?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
