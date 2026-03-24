<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - RegiTrack</title>
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
                <a href="/home?tab=requests" class="nav-item active" data-tab="requests">My Requests</a>
                <a href="/home?tab=appointments" class="nav-item" data-tab="appointments">Appointments</a>
                <a href="/home?tab=history" class="nav-item" data-tab="history">History</a>
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
        <div class="dashboard-header">
            <h1>Welcome back, <?= htmlspecialchars($user['name'] ?? 'Student') ?></h1>
            <p>Manage your requests and appointments</p>
        </div>

        <div id="tab-requests" class="tab-content active">
            <div class="dashboard-section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-file-alt"></i> Pending Requests</h2>
                    <a href="/schedap" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> New Request
                    </a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Request Type</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendingRequests)): ?>
                            <?php foreach ($pendingRequests as $id => $req): ?>
                                <tr>
                                    <td><?= htmlspecialchars($req['request_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($req['request_date'] ?? '')) ?? '') ?></td>
                                    <td>
                                        <?php $status = $req['status'] ?? 'Pending'; ?>
                                        <span class="status <?= strtolower($status) ?>"><?= htmlspecialchars($status) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($req['cancel_reason'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">No pending requests</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tab-appointments" class="tab-content">
            <div class="dashboard-section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-calendar-check"></i> Current Appointments</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Request Type</th>
                            <th>Retrieval Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $id => $appt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appt['type_of_request'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($appt['retrieval_date'] ?? '')) ?? '') ?></td>
                                    <td>
                                        <span class="status <?= strtolower($appt['status'] ?? 'pending') ?>">
                                            <?= htmlspecialchars($appt['status'] ?? 'Pending') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (($appt['status'] ?? '') !== 'Settled'): ?>
                                        <a href="/cancel?id=<?= $id ?>" 
                                           class="btn-delete" 
                                           onclick="return confirm('Cancel this appointment?')">
                                            <i class="fa-solid fa-times"></i> Cancel
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No current appointments</td>
                            </tr>
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
                            <th>Request Type</th>
                            <th>Retrieval Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($history)): ?>
                            <?php foreach ($history as $id => $appt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appt['type_of_request'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('M d, Y', strtotime($appt['retrieval_date'] ?? '')) ?? '') ?></td>
                                    <td>
                                        <?php $status = $appt['status'] ?? 'Settled'; ?>
                                        <span class="status <?= strtolower($status === 'Settled' ? 'complete' : $status) ?>">
                                            <?= htmlspecialchars($status === 'Settled' ? 'Complete' : $status) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($appt['cancel_reason'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No history</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const tabLinks = document.querySelectorAll('.nav-links .nav-item[data-tab]');
        const tabContents = document.querySelectorAll('.tab-content');

        function activateTab(tabName) {
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            const link = document.querySelector(`.nav-links .nav-item[data-tab="${tabName}"]`);
            const content = document.getElementById('tab-' + tabName);
            if (link) link.classList.add('active');
            if (content) content.classList.add('active');
        }

        const urlParams = new URLSearchParams(window.location.search);
        const initialTab = urlParams.get('tab');
        if (initialTab) {
            activateTab(initialTab);
        }

        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                activateTab(link.dataset.tab);
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
