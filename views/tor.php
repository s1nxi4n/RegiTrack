<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript of Records - RegiTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/home" class="nav-logo">
                <i class="fa-solid fa-school"></i>
                RegiTrack
            </a>
            <div class="nav-links">
                <a href="/home" class="nav-item">Dashboard</a>
                <a href="/schedap" class="nav-item">New Request</a>
                <a href="/about" class="nav-item">About</a>
                <a href="/contact" class="nav-item">Contact</a>
            </div>
            <div class="nav-user dropdown">
                <button class="dropbtn" id="userDropdownBtn">
                    <i class="fa-solid fa-user"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="userDropdownMenu">
                    <a href="/logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fa-solid fa-file-lines"></i>
                <h2>Transcript of Records (TOR)</h2>
            </div>

            <form method="POST" action="/tor">
                <div class="form-group">
                    <label for="stud_id">Student ID</label>
                    <input type="text" id="stud_id" value="<?= htmlspecialchars($user['id'] ?? '') ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="contact_num">Contact Number</label>
                    <input type="text" id="contact_num" name="contact_num" placeholder="09XXXXXXXXX" required>
                </div>

                <div class="form-group">
                    <label for="purpose">Purpose of Transaction</label>
                    <input type="text" id="purpose" name="purpose" placeholder="e.g., Employment, Further Studies" required>
                </div>

                <div class="form-group">
                    <label for="copy_qty">Number of Copies</label>
                    <input type="number" id="copy_qty" name="copy_qty" min="1" value="1" required>
                </div>

                <div class="form-group">
                    <label for="msg">Message / Concern</label>
                    <textarea id="msg" name="msg" rows="4" placeholder="Any additional information..."></textarea>
                </div>

                <div class="form-actions">
                    <a href="/schedap" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
