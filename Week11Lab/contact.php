<?php include 'header.php';

require_once('./model/customer.php');
require_once('./dao/customerDAO.php');
require_once('./function.php');
require_once('./PasswordHash.php');

$customerName = '';
$phoneNumber = '';
$emailAddress = '';
$referrall = '';

$submitedSuccessful = false;

$custDAO = new CustomerDAO;

$isItPost = $_SERVER['REQUEST_METHOD'] == 'POST';
$checkForm = true;

$hash = new PasswordHash(2, "dasdas");

if ($isItPost) {
    $customerName = trim($_POST['customerName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $emailAddress = (trim($_POST['emailAddress']));
    $referrall = $_POST['referral'];

    $emailDup = $custDAO->checkDuplicatedEmail($emailAddress);

    $emailValid = validateEmail($emailAddress);

    $phoneValid = validatePhone($phoneNumber);

    if (!empty($customerName) && $phoneValid && !$emailDup && $emailValid && !empty($referrall)) {
        $newCust = new Customer($customerName, $phoneNumber, $hash->HashPassword($emailAddress), $referrall);

        $submitedSuccessful = $custDAO->addCustomer($newCust);

        //UPLOADING FILE
        $target_dir = "files/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<?php



?>
            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" enctype="multipart/form-data"
                    action="" >
                    <!-- newsletterSignup.php -->
                    <?php if (!$submitedSuccessful) {
    ?>
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" value="<?php echo $customerName ?>" id="customerName" size='40'>
                                <span style="color: red">
                                    <?php
                                    if ($isItPost && empty($customerName)) {
                                        echo "This can't be emplty";
                                    } ?>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" value="<?php echo $phoneNumber ?>" id="phoneNumber" size='40'>
                                <span style="color: red">
                                    <?php
                                    if ($isItPost && empty($phoneNumber)) {
                                        echo "This can't be emplty";
                                    } elseif ($isItPost && !$phoneValid) {
                                        echo "Phone number must be 10 digits";
                                    } ?>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" value="<?php echo $emailAddress ?>" id="emailAddress" size='40'>
                                <span style="color: red">
                                    <?php
                                    if ($isItPost && empty($emailAddress)) {
                                        echo "This can't be emplty";
                                    } elseif ($isItPost && $emailDup) {
                                        echo "This email is existed";
                                    } elseif ($isItPost && !$emailValid) {
                                        echo "This email is valid format";
                                    } ?>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper
                                    <input type="radio" name="referral" id="referralNewspaper" value="newspaper" <?php echo $referrall == 'newspaper' ? 'checked' : '' ?> >
                                    Radio
                                    <input type="radio" name='referral' id='referralRadio' value='radio' <?php echo $referrall == 'radio' ? 'checked' : '' ?>>
                                    TV
                                    <input type='radio' name='referral' id='referralTV' value='TV' <?php echo $referrall == 'TV' ? 'checked' : '' ?>>
                                    Other
                                    <input type='radio' name='referral' id='referralOther' value='other' <?php echo $referrall == 'other' ? 'checked' : '' ?>>
                                    <span style="color: red">
                                    <?php
                                    if ($isItPost && empty($referrall)) {
                                        echo "This can't be emplty";
                                    } ?>
                                </span>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;
                                <input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>

                    <?php
} elseif ($isItPost && $submitedSuccessful) {
                                        echo "<div> You're successfully submited</div>";
                                    } ?>
                        
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->
<?php include 'footer.php'; ?>