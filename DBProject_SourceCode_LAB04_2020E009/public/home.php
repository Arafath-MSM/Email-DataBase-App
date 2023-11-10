<?php
try {
    require "../config.php"; // Include your database configuration
    require "../common.php"; // Include any common functions

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM CreateEmailMessage ORDER BY createdDateTime DESC LIMIT 3";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
    // Initialize $result as an empty array to avoid "Undefined variable" warning
    $result = [];
}
?>

<?php require "templates/header.php"; ?>

<h2>Last 3 Created Entries</h2>

<?php
if ($result && $statement->rowCount() > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>EmailMessageId</th>
                <th>Name</th>
                <th>loginID</th>
                <th>password</th>
                <th>threats</th>
                <th>createdDateTime</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo escape($row["EmailMessageId"]); ?></td>
                    <td><?php echo escape($row["name"]); ?></td>
                    <td><?php echo escape($row["loginID"]); ?></td>
                    <td><?php echo escape($row["password"]); ?></td>
                    <td><?php echo escape($row["threats"]); ?></td>
                    <td><?php echo escape($row["createdDateTime"]); ?></td>
                    <td><?php echo escape($row["date"]); ?></td>
                    <td>
                        <a href="viewRecord.php?recordId=<?php echo escape($row["EmailMessageId"]); ?>">View</a>
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
