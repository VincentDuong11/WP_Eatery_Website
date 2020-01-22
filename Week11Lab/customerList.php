<?php include 'header.php';
require_once('./dao/customerDAO.php');

$custDB = new CustomerDAO();
require_once('./model/WebsiteUser.php');
session_start();
session_regenerate_id(false);
// echo session_id();

if (isset($_SESSION['websiteUser'])) {
    if (!$_SESSION['websiteUser']->isAuthenticated()) {
        header('Location:login.php');
    }
} else {
    header('Location:login.php');
}
echo "Admin ID: " .  $_SESSION['AdminId'];
echo "<br>";
echo "Last Login: " . $_SESSION['LastLogin'];
?>  
            <div id="content" class="clearfix">
                <h1>Customer list!</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Reference</th>
                </tr>
                <?php
                    $list = $custDB->getAllCustomer();

                    while ($cust = mysqli_fetch_assoc($list)) {
                        ?>
                        <tr>
                            <td><?php echo $cust['customerName'] ?></td>
                            <td><?php echo $cust['phoneNumber'] ?></td>
                            <td><?php echo $cust['emailAddress']?></td>
                            <td><?php echo $cust['referrer']?></td>
                        </tr>
                   <?php
                    }
                ?>
            </table>
            <a href="logout.php">Logout!</a>
            </div><!-- End Content -->
<?php include 'footer.php';?>