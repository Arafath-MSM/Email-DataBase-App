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

if (isset($_POST['submit'])) {
    try {
        $updatedRecord = [
            "name" => $_POST['name'],
            "loginID" => $_POST['loginID'],
            "password" => $_POST['password'],
            "threats" => $_POST['threats'],
            // ... (include other fields)
        ];

        $sql = "UPDATE EmailMessage SET
                name = :name,
                loginID = :loginID,
                password = :password,
                threats = :threats
                WHERE EmailMessageId = :recordId";

        $connection->prepare($sql)->execute(array_merge($updatedRecord, ['recordId' => $recordId]));

        header("Location: home.php");
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php if ($record) { ?>
    <h2>Edit Record</h2>

    <form method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape($record["name"]); ?>"><br>

        <label for="loginID">Login ID</label>
        <input type="text" name="loginID" id="loginID" value="<?php echo escape($record["loginID"]); ?>"><br>

        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="<?php echo escape($record["password"]); ?>"><br>

        <label for="threats">Threats</label>
        <input type="text" name="threats" id="threats" value="<?php echo escape($record["threats"]); ?>"><br>

        <!-- ... (include other fields) ... -->

        <input type="submit" name="submit" value="Save">
    </form>

    <a href="viewRecord.php?recordId=<?php echo escape($record["EmailMessageId"]); ?>">View</a>
    <a href="home.php">Back to list</a>
<?php } else { ?>
    <blockquote>No record found.</blockquote>
<?php } ?>

<?php require "templates/footer.php"; ?>
