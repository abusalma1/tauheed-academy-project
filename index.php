<?php
include('./includes/header.php');

$statement = $connection->prepare('SELECT * FROM users');
$statement->execute();
$result = $statement->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

?>
<h2>Dashboard</h2>

<div>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>


<?php
include('./includes/footer.php')

?>