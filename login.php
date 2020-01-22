<?php include 'header.php';
include 'MenuItem.php';
require_once('./model/WebsiteUser.php');
session_start();
if (isset($_SESSION['websiteUser'])) {
    if ($_SESSION['websiteUser']->isAuthenticated()) {
        session_write_close();
        header('Location:customerList.php');
    }
}

$missingFields = false;
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] == "" || $_POST['password'] == "") {
            $missingFields = true;
        } else {
            //All fields set, fields have a value
            $websiteUser = new WebsiteUser();
            if (!$websiteUser->hasDbError()) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $websiteUser->authenticate($username, $password);
                if ($websiteUser->isAuthenticated()) {
                    $websiteUser->updateLoginDate();
                    $_SESSION['websiteUser'] = $websiteUser;
                    $_SESSION['AdminId'] = $websiteUser->getAdminId();
                    $_SESSION['LastLogin'] = $websiteUser->getLastLogin();
                    header('Location:customerList.php?');
                }
            }
        }
    }
}

?>

<?php
    $wpBurger = new MenuItem("The WP Burger", "Freshly made all-beef patty served up with homefries", "$14");
    $wpKebob = new MenuItem("WP Kebobs", "Tender cuts of beef and chicken, served with your choice of side", "$17")
?>
        <?php
            //Missing username/password
            if ($missingFields) {
                echo '<h3 style="color:red;">Please enter both a username and a password</h3>';
            }
            
            //Authentication failed
            if (isset($websiteUser)) {
                if (!$websiteUser->isAuthenticated()) {
                    echo '<h3 style="color:red;">Login failed. Please try again.</h3>';
                }
            }
        ?>

            <div id="content"  class="clearfix">
                <form name="login" id="login" method='post' action="">
                   <div>
                        <span>Username</span> <input type="text" id='username' name='username'>
                   </div> 
                   <div>
                        <span>Password</span><input type="password" id='password' name='password'>
                   </div>
                   <div>
                        <input name="submit"  id='submit' type="submit">
                   </div>
                </form>
            </div><!-- End Content -->

<?php include 'footer.php';?>