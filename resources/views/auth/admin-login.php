<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - RegiTrack</title>
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
                <a href="/adminlogin" class="admin-link" style="background: var(--highlight); color: var(--white);">Admin Login</a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="fa-solid fa-user-shield"></i>
                <h2>Admin Login</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/adminlogin">
                <div class="form-group">
                    <label for="name">Admin Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter admin name" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>
            
            <div class="back-link">
                <a href="/">← Back to Student Login</a>
            </div>
        </div>
    </div>
</body>
</html>
