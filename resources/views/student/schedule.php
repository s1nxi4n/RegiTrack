<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment - RegiTrack</title>
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
                <a href="/schedap" class="nav-item active">New Request</a>
                <a href="/about" class="nav-item">About</a>
                <a href="/contact" class="nav-item">Contact</a>
            </div>
            <div class="nav-user dropdown">
                <button class="dropbtn" id="userDropdownBtn">
                    <i class="fa-solid fa-user"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="userDropdownMenu">
                    <a href="/change-password">
                        <i class="fa-solid fa-key"></i> Change Password
                    </a>
                    <a href="/logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-header">
            <h1>Schedule an Appointment</h1>
            <p>Select the type of document you need</p>
        </div>

        <div class="appointment-cards">
            <a href="/tor" class="appointment-card">
                <i class="fa-solid fa-file-lines"></i>
                <h3>Transcript of Records</h3>
                <p>Request your official academic transcript</p>
            </a>

            <a href="/diploma" class="appointment-card">
                <i class="fa-solid fa-graduation-cap"></i>
                <h3>Diploma</h3>
                <p>Request your graduate diploma</p>
            </a>

            <a href="/rf" class="appointment-card">
                <i class="fa-solid fa-arrows-rotate"></i>
                <h3>RF</h3>
                <p>RF request form</p>
            </a>

            <a href="/certificate" class="appointment-card">
                <i class="fa-solid fa-certificate"></i>
                <h3>Certification</h3>
                <p>Request various certifications</p>
            </a>
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
