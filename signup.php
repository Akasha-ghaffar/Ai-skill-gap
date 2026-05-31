<?php
include('db.php'); 

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $message_type = "error";
    } else {
       
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($result) > 0) {
            $message = "This email is already registered. Try logging in!";
            $message_type = "error";
        } else {
            // 3. Hash password and insert into database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

            if (mysqli_query($conn, $sql)) {
                $message = "Account created successfully! Redirecting to login...";
                $message_type = "success";
               
                header("refresh:2;url=login.php");
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Skill Gap - Sign Up</title>
    <style>
        :root {
            --primary-blue: #2563eb;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            --error-red: #ef4444;
            --success-green: #10b981;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-gradient);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #fff;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 380px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        h2 { text-align: center; margin-bottom: 10px; font-weight: 400; }
        p.subtitle { text-align: center; color: #94a3b8; font-size: 0.9rem; margin-bottom: 25px; }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            text-align: center;
        }
        .error { background: rgba(239, 68, 68, 0.2); border: 1px solid var(--error-red); color: #fca5a5; }
        .success { background: rgba(16, 185, 129, 0.2); border: 1px solid var(--success-green); color: #a7f3d0; }

        .input-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-size: 0.85rem; color: #cbd5e1; }
        
        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 13px;
            background: var(--primary-blue);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .footer-link a { color: var(--primary-blue); text-decoration: none; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Join AI Skill Gap</h2>
        <p class="subtitle">Start your journey today</p>

        <?php if($message !== ""): ?>
            <div class="alert <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="signup.php" method="POST">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="example@email.com" required>
            </div>
            <div class="input-group">
                <label>Create Password</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>
            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Repeat password" required>
            </div>
            <button type="submit">Create Account</button>
        </form>
        
        <div class="footer-link">
            Already have an account? <a href="login.php">Log In</a>
        </div>
    </div>

</body>
</html>