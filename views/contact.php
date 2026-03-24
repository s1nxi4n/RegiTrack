<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - RegiTrack</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <?php if (isStudentLoggedIn()): ?>
                <a href="/home" class="nav-logo">
                    <i class="fa-solid fa-school"></i>
                    RegiTrack
                </a>
                <div class="nav-links">
                    <a href="/home?tab=requests" class="nav-item">My Requests</a>
                    <a href="/home?tab=appointments" class="nav-item">Appointments</a>
                    <a href="/home?tab=history" class="nav-item">History</a>
                    <a href="/about" class="nav-item">About</a>
                    <a href="/contact" class="nav-item active">Contact</a>
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
            <?php else: ?>
                <a href="/" class="nav-logo">
                    <i class="fa-solid fa-school"></i>
                    RegiTrack
                </a>
                <div class="nav-links">
                    <a href="/" class="nav-item">Home</a>
                    <a href="/about" class="nav-item">About</a>
                    <a href="/contact" class="nav-item active">Contact</a>
                </div>
                <div class="nav-user">
                    <a href="/adminlogin" class="admin-link">Admin Login</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div class="contact-section">
            <h1>Contact Us</h1>
            <p class="contact-intro">We're here to help! Whether you're a student, faculty member, or part of the registrar's office, the RegiTrack team is ready to assist you.</p>

            <div class="contact-cards">
                <div class="contact-card">
                    <i class="fa-solid fa-location-dot"></i>
                    <h3>Address</h3>
                    <p>Phinma University of Iloilo<br>General Luna St, Iloilo City<br>Philippines</p>
                </div>

                <div class="contact-card">
                    <i class="fa-solid fa-envelope"></i>
                    <h3>Email</h3>
                    <p>support@regitrack.edu.ph</p>
                </div>

                <div class="contact-card">
                    <i class="fa-solid fa-phone"></i>
                    <h3>Phone</h3>
                    <p>+63 912 345 6789</p>
                </div>
            </div>
        </div>
    </div>

    <?php if (isStudentLoggedIn()): ?>
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
    <?php endif; ?>
</body>
</html>
