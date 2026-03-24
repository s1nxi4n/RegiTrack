<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certification Request - RegiTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/home" class="nav-logo"><i class="fa-solid fa-school"></i> RegiTrack</a>
            <div class="nav-links">
                <a href="/home" class="nav-item">Dashboard</a>
                <a href="/schedap" class="nav-item">New Request</a>
                <a href="/about" class="nav-item">About</a>
                <a href="/contact" class="nav-item">Contact</a>
            </div>
            <div class="nav-user dropdown">
                <button class="dropbtn" id="userDropdownBtn"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-caret-down"></i></button>
                <div class="dropdown-content" id="userDropdownMenu">
                    <a href="/change-password"><i class="fa-solid fa-key"></i> Change Password</a>
                    <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="form-container">
            <div class="form-header"><i class="fa-solid fa-certificate"></i><h2>Certification Request</h2></div>
            <form method="POST" action="/certificate">
                <div class="form-group"><label>Student ID</label><input type="text" value="<?= htmlspecialchars($user['id'] ?? '') ?>" readonly></div>
                <div class="form-group"><label for="contact_num">Contact Number</label><input type="text" id="contact_num" name="contact_num" placeholder="09XXXXXXXXX" required></div>
                <div class="form-group"><label for="course">Course</label><input type="text" id="course" name="course" placeholder="e.g., BS Computer Science" required></div>
                <div class="form-group">
                    <label for="type_cert">Type of Certification</label>
                    <select id="type_cert" name="type_cert" required>
                        <option value="">Select Type</option>
                        <option value="Enrollment">Enrollment Certification</option>
                        <option value="Graduation">Graduation Certification</option>
                        <option value="Good Moral">Good Moral Certification</option>
                        <option value="Course Completion">Course Completion</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group"><label for="purpose">Purpose</label><input type="text" id="purpose" name="purpose" placeholder="e.g., Job Application" required></div>
                <div class="form-group"><label for="copy_qty">Copies</label><input type="number" id="copy_qty" name="copy_qty" min="1" value="1" required></div>
                <div class="form-actions"><a href="/schedap" class="btn-cancel">Cancel</a><button type="submit" class="btn-submit">Submit</button></div>
            </form>
        </div>
    </div>
    <script>
        const btn = document.getElementById('userDropdownBtn'), menu = document.getElementById('userDropdownMenu');
        btn?.addEventListener('click', e => { e.stopPropagation(); menu.classList.toggle('show'); });
        document.addEventListener('click', e => { if (!menu?.contains(e.target) && !btn?.contains(e.target)) menu?.classList.remove('show'); });
    </script>
</body>
</html>
