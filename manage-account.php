<?php
include('admin-sidebar.php');
    // Assuming you have a database connection in $mysqli
    $mysqli = require __DIR__ . "/database.php";


    // Fetch a list of customers from the database
    $result = $mysqli->query("SELECT id, name, email, is_blocked FROM user WHERE user_type = 'customer'");
?>
    <div class="content-container">
        <table border="1" cellspacing="0" cellpadding="10" class="viewTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['is_blocked'] ? 'Blocked' : 'Active' ?></td>
        <td>
            <?php if ($row['is_blocked']): ?>
                <!-- Unblock Form -->
                <form action="unblock-customer.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <input type="submit" value="Unblock">
                </form>
            <?php else: ?>
                <!-- Block Form -->
                <form action="block-customer.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <input type="submit" value="Block">
                </form>
            <?php endif; ?>

            <!-- Delete Form -->
            <form class="delete-form" action="delete-customer.php" method="post">
                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                <input type="submit" value="Delete">
            </form>
        </td>
    </tr>
<?php endwhile; ?>


    </table>
    </div>

<?php $mysqli->close(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage-Accounts</title>

    <style>
        body{
            margin: 0;
            background-color: white;
            color: #40596b;
            
        }
        .content-container {
            position: absolute;
            margin-left: 620px;
            margin-top: 300px;
        }

        .viewTable {
            border-collapse: collapse;
        }

        .text1{
                margin-top: 0px;
                margin-left: 590px;
                position: absolute;
                padding: 10px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
                font-size: 60px;
                background-color: white;
                box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
                color: #f89819;
            }

        #manageaccounts{
            background-color: #f4f4f4;
            font-weight: 600;
        }

        
    </style>
</head>
<body>
    <h1 class="text1" >MANAGE ACCOUNTS</h1>
</body>
</html>