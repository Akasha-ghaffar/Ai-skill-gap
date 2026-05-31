<?php
include('db.php');

$message = "";
$message_type = "";

if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
       
        $update_query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
        if ($conn->query($update_query) === TRUE) {
            $message = "Password updated successfully! You can now login.";
            $message_type = "success";
        } else {
            $message = "Error updating password.";
            $message_type = "danger";
        }
    } else {
        $message = "Email address not found.";
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Skill Gap AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdf6fb; font-family: 'Segoe UI', sans-serif; }
        .reset-card {
            margin-top: 100px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .btn-custom {
            background-color: #ff9a9e;
            border: none;
            color: white;
            border-radius: 25px;
            font-weight: 600;
        }
        .btn-custom:hover { background-color: #f6416c; color: white; }
        .form-control { border-radius: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card reset-card p-4">
                <h3 class="text-center mb-4" style="color: #6a11cb;">Reset Password</h3>
                
                <?php if($message != ""): ?>
                    <div class="alert alert-<?php echo $message_type; ?> text-center">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="forgot_password.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your registered email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="reset_password" class="btn btn-custom py-2">Update Password</button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none" style="color: #8ec5fc;">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>