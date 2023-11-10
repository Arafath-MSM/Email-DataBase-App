<?php

/**
 * Use an HTML form to create a new entry in the
 * EmailMessage table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "EmailMessageId" => $_POST['EmailMessageId'],
            "name" => $_POST['name'],
            "loginID"     => $_POST['loginID'],
            "password"     => $_POST['password'],
            "threats"  => $_POST['threats'],
            "createdDateTime"  => $_POST['createdDateTime'],
            "Date"  => $_POST['Date']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "CreateEmailMessage",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['name']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<form method="post">
        <label for="EmailMessageId">EmailMessageId</label>
        <input type="text" name="EmailMessageId" id="EmailMessageId">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="loginID">login ID</label>
        <input type="text" name="loginID" id="loginID">
        <label for="password">password</label>
        <input type="text" name="password" id="password">
        <label for="threats">threats</label>
        <input type="text" name="threats" id="threats">
         <label for="createdDateTime">createdDate Time</label>
         <input type="text" name="createdDateTime" id="createdDateTime">
          <label for="Date">Date</label>
          <input type="text" name="Date" id="Date">
        <input type="submit" name="submit" value="Submit">
    </form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
