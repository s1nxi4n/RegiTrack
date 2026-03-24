<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RegiTrack</title>
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
                <a href="/adminhome" class="nav-item active" data-tab="requests">Requests</a>
                <a href="/adminhome" class="nav-item" data-tab="dashboard">Appointments</a>
                <a href="/adminhome" class="nav-item" data-tab="history">History</a>
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
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <p>Manage requests and appointments</p>
        </div>

        <div id="tab-requests" class="tab-content active">
            <div class="dashboard-section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-inbox"></i> Pending Requests</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Type</th>
                            <th>Student ID</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)): ?>
                            <?php foreach ($requests as $id => $req): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars(substr($id, 0, 8)) ?>...</code></td>
                                    <td><?= htmlspecialchars($req['request_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($req['inquiree_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($req['request_date'] ?? '')) ?? '') ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="/setappointment" method="POST" style="display:inline;">
                                                <input type="hidden" name="stud_id" value="<?= htmlspecialchars($req['inquiree_id'] ?? '') ?>">
                                                <input type="hidden" name="req_type" value="<?= htmlspecialchars($req['request_type'] ?? '') ?>">
                                                <input type="hidden" name="ret_date" value="<?= date('Y-m-d', strtotime('+3 days')) ?>">
                                                <input type="hidden" name="request_id" value="<?= $id ?>">
                                                <button type="submit" class="btn-primary">
                                                    <i class="fa-solid fa-check"></i> Accept
                                                </button>
                                            </form>
                                            <form action="/declineRequest" method="POST" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <input type="hidden" name="reason" id="decline_reason_<?= $id ?>">
                                                <button type="submit" class="btn-delete" onclick="return declineRequest('<?= $id ?>')">
                                                    <i class="fa-solid fa-times"></i> Decline
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No pending requests</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tab-dashboard" class="tab-content">
            <div class="dashboard-section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-calendar-check"></i> Appointment Dashboard</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Type</th>
                            <th>Retrieval Date</th>
                            <th>Handler</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $id => $appt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appt['student_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($appt['type_of_request'] ?? '') ?></td>
                                    <td>
                                        <form action="/updateDate" method="POST" style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="date" name="ret_date" value="<?= htmlspecialchars($appt['retrieval_date'] ?? '') ?>" onchange="this.form.submit()" style="width: 140px;">
                                        </form>
                                    </td>
                                    <td>
                                        <form action="/updateHandler" method="POST" style="margin:0;">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="text" name="handler_id" value="<?= htmlspecialchars($appt['handler_id'] ?? '') ?>" onchange="this.form.submit()" style="width: 100px;">
                                        </form>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="/updateStatus" method="POST" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <input type="hidden" name="status" value="Settled">
                                                <button type="submit" class="btn-primary">
                                                    <i class="fa-solid fa-check"></i> Done
                                                </button>
                                            </form>
                                            <form action="/cancelAppointment" method="POST" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <input type="hidden" name="reason" id="reason_<?= $id ?>">
                                                <button type="submit" class="btn-delete" onclick="return cancelAppointment('<?= $id ?>')">
                                                    <i class="fa-solid fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No appointments found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tab-history" class="tab-content">
            <div class="dashboard-section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-clock-rotate-left"></i> History</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Type</th>
                            <th>Retrieval Date</th>
                            <th>Handler</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($history)): ?>
                            <?php foreach ($history as $id => $appt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appt['student_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($appt['type_of_request'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($appt['retrieval_date'] ?? '')) ?? '') ?></td>
                                    <td><?= htmlspecialchars($appt['handler_id'] ?? '') ?></td>
                                    <td><span class="status <?= strtolower($appt['status'] ?? 'settled') ?>"><?= htmlspecialchars($appt['status'] ?? '') ?></span></td>
                                    <td><?= htmlspecialchars($appt['cancel_reason'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No history found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function cancelAppointment(id) {
            const reason = prompt('Enter reason for cancellation:');
            if (reason === null) return false;
            document.getElementById('reason_' + id).value = reason || '';
            return true;
        }

        function declineRequest(id) {
            const reason = prompt('Enter reason for declining:');
            if (reason === null) return false;
            document.getElementById('decline_reason_' + id).value = reason || '';
            return true;
        }

        const tabLinks = document.querySelectorAll('.nav-links .nav-item');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href === '/addstud') return;
                e.preventDefault();
                tabLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                link.classList.add('active');
                document.getElementById('tab-' + link.dataset.tab).classList.add('active');
            });
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
