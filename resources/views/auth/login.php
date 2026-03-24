<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegiTrack - Student Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="nav-logo">
                <i class="fa-solid fa-school"></i>
                RegiTrack
            </a>
            <div class="nav-user">
                <a href="/adminlogin" class="admin-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="fa-solid fa-user-graduate"></i>
                <h2>Student Login</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/">
                <div class="form-group">
                    <label for="stud_id">Student ID</label>
                    <input type="text" id="stud_id" name="stud_id" placeholder="XX-XXXX-XXXXXX" required>
                    <small class="hint">Format: XX-XXXX-XXXXXX (e.g., 04-2324-0437361)</small>
                </div>
                
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('stud_id').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 2) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 2) + '-' + value.slice(2);
                } else {
                    value = value.slice(0, 2) + '-' + value.slice(2, 6) + '-' + value.slice(6, 12);
                }
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
