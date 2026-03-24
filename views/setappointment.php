<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Appointment - RegiTrack</title>
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
                <a href="/adminhome" class="nav-item active">Dashboard</a>
                <a href="/addstud" class="nav-item">Add Student</a>
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
                <i class="fa-solid fa-calendar-check"></i>
                <h2>Set Appointment</h2>
            </div>

            <form method="POST" action="/setappointment">
                <div class="form-group">
                    <label for="stud_id">Student ID</label>
                    <input type="text" id="stud_id" name="stud_id" placeholder="Student ID" required>
                </div>
                
                <div class="form-group">
                    <label for="req_type">Request Type</label>
                    <select id="req_type" name="req_type" required>
                        <option value="">Select Type</option>
                        <option value="TOR">Transcript of Records</option>
                        <option value="DIPLOMA">Diploma</option>
                        <option value="RF">Request for Enrollment</option>
                        <option value="CERTIFICATION">Certification</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ret_date">Retrieval Date</label>
                    <input type="date" id="ret_date" name="ret_date" required>
                </div>

                <div class="form-actions">
                    <a href="/adminhome" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">Set Appointment</button>
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
