<!-- Stylesheet Name -->
<?php $style = 'contact' ?>

<?php

// Mailer CLasses & Namespaces.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// My Email.
$target = "email@gmail.com";
// Email Password.
$pass = "mypassword";

// Import Autoloader.
require "autoloader.php";

// Import Mailer Autoloader
require "vendor/autoload.php";

// Import Output Card
require "tools/output_card.php";

// Object to keep value in input fields.
$inp_val = new ValueKeeper();

// Instantiate object to validate input.
$validator = new Validator;

// Instantiate input variables
$name = $subject = $email = $phone = $msg = "";

// Instantiate errors variables
$name_err = $subject_err = $email_err = $phone_err = $msg_err = "";


// Determine if request method is post.
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    // Name Validation.
    if (empty($_POST['full_name'])) {
        $name_err = "Name field is required.";
    } elseif (!$validator->validate($_POST['full_name'], "name")) {
        $name_err = "Please type a valid name.";
    } elseif (strlen($_POST['full_name']) < 8 ) {
        $name_err = "Enter your full name please.";
    } else {
        $name = $validator->clean_input($_POST['full_name']);
        // Get User's First Name To Use It In A Confirmation Message.
        $fname = ucfirst(explode(" ", $name)[0]);
    }

    // Subject Validation.
    $subject = $validator->clean_input($_POST['subject']);

    // Email Validation.
    if(empty($_POST['email'])) {
        $email_err = "Email field is required.";
    } elseif (!$validator->validate($_POST['email'])) {
        $email_err = "Please, enter a valid email";
    } else {
        $email = $validator->clean_input($_POST['email']);
    }
    
    // Phone Number Validation.
    if (!empty($_POST['phone'])) {
        if (!$validator->validate($_POST['phone'], "phone")) {
            $phone_err = "Sorry, invalid phone number.";
        } else {
            $phone = $validator->clean_input($_POST['phone']);
        }
    }

    // Message Validation.
    if(empty($_POST['msg']) || strlen($_POST['msg']) < 30) {
        $msg_err = "Message should be at least 30 letters.";
    } else {
        $msg = $_POST['msg'];
    }

    
    // Form Is Valid.
    if (!$name_err && !$email_err && !$phone_err && !$msg_err) {
        // Initialize Object From PhpMailer Library.
        $mail = new PHPMailer();

        //Server settings
        $mail->SMTPDebug = 0;                                       //Disable Debugging Output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $target;                                //SMTP username
        $mail->Password   = $pass;                                  //SMTP Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Content Settings
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($target);
        $mail->addReplyTo($email, "");

        $mail->Subject = $subject;
        $mailHeader = "<br>\n<br><h4>User Info:</h4> <br> Email: $email<br>Phone Number: $phone<br>Name: $name<br> <br> <br><h2>Message:</h2>";
        $mail->Body    =  $mailHeader . nl2br($msg);

        try {
            $mail->send();
            $output = card("Done!", "Thanks, $fname", "bg-success", "text-white", "Your Message Has Been Sent Successfully.");
            $_POST['full_name'] = $_POST['phone'] = $_POST['subject'] = $_POST['email'] = $_POST['msg'] = "";
        } catch (Exception $e) {
            $output = card("Error!", "Sorry, $fname", "bg-danger", "text-white", "An error occured while sending your message.");
            exit();
        }
    }
}

?>

<!-- Header -->
<?php include "include/header.php" ?>

<body>
    <!-- Navbar -->
    <?php include "include/nav.php" ?>

    <div class="container main-container">
        <div class="row mt-5 mb-3 heading">
            <h2> <span><img src="images/contacts/contact.png" width="25" height="25" alt="Contact Icon" class="head-icon mb-1"></span> Contact Me</h2>
        </div>


        <!-- Result -->
        <div class="result">
            <?= isset($output) ? $ouput : NULL?>
        </div>


        <!-- Contacts Form -->
        <div class="row form-container">
            <form class="row g-3 mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <!-- Full Name -->
                <div class="col-md-6 field">
                    <span class="field-icon"><img src="images/contacts/user.png" alt="User Icon" width="20" height="20"></span>
                    <label for="full_name" class="form-label">Full Name <span class="err">*</span></label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Your Name" value="<?= $inp_val->keepVals('full_name') ?>">
                    <p class='err'> <?= $name_err ?> </p>
                </div>      
                
                <!-- Subject -->
                <div class="col-md-6 field">
                    <span class="field-icon"><img src="images/contacts/subject.png" alt="User Icon" width="20" height="20"></span>
                    <label for="subject" class="form-label">Subject </label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="<?= $inp_val->keepVals('subject') ?>">
                </div>

                <!-- Email -->
                <div class="col-md-6 field">
                    <span class="field-icon"><img src="images/contacts/mail.png" alt="Email Icon" width="20" height="20"></span>
                    <label for="email" class="form-label">Email <span class="err">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="<?= $inp_val->keepVals('email') ?>">
                    <p class='err'> <?= $email_err ?> </p>
                </div>
                
                <!-- Phone Number -->
                <div class="col-md-6 field">
                    <span class="field-icon"><img src="images/contacts/phone.png" alt="Phone Icon" width="20" height="20"></span>
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?= $inp_val->keepVals('phone') ?>">
                    <p class='err'> <?= $phone_err ?> </p>
                </div>

                <!-- Message -->
                <div class="field">
                    <span class="field-icon"><img src="images/contacts/message.png" alt="Message Icon" width="20" height="20"></span>
                    <label for="msg" class="form-label">Message <span class="err">*</span></label>
                    <textarea class="form-control" id="msg" name="msg" rows="3" placeholder="Your Message"><?= $inp_val->keepVals('msg') ?></textarea>
                    <p class='err'> <?= $msg_err ?> </p>
                </div>

                <!-- Send Button -->
                <div class="col-12 submit">
                    <button type="submit" class="btn submit-btn btn-success">Send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php require "include/footer.php" ?>
</body>

</html>