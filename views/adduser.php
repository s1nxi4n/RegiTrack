<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - RegiTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/adminhome" class="nav-logo">
                <i class="fa-solid fa-school"></i>
                RegiTrack
            </a>
            <div class="nav-links">
                <a href="/adminhome" class="nav-item">Dashboard</a>
                <a href="/addstud" class="nav-item active">Add Student</a>
            </div>
            <div class="nav-user dropdown">
                <button class="dropbtn" id="userDropdownBtn">
                    <i class="fa-solid fa-user-shield"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="userDropdownMenu">
                    <a href="/adminlogout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fa-solid fa-user-plus"></i>
                <h2>Add New Student</h2>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/addstud">
                <div class="form-group">
                    <label for="id">Student ID</label>
                    <input type="text" id="id" name="id" placeholder="XX-XXXX-XXXXXX" required>
                    <small class="hint">Format: XX-XXXX-XXXXXX (e.g., 04-2324-0437361)</small>
                </div>
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="student@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="form-actions">
                    <a href="/adminhome" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('id').addEventListener('input', function(e) {
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

        const dropdownBtn = document.getElementById('userDropdownBtn');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        dropdownBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!dropdownMenu?.contains(e.target) && !dropdownBtn?.contains(e.target)) {
                dropdownMenu?.classList.remove('show');
            }
        });
    </script>
</body>
</html>
