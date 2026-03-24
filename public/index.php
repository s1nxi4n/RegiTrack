<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Session.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$path = parse_url($requestUri, PHP_URL_PATH);
$path = rtrim($path, '/');
if (empty($path)) $path = '/';

function render($view, $data = []) {
    extract($data);
    $viewFile = __DIR__ . '/../views/' . $view . '.php';
    if (file_exists($viewFile)) {
        require $viewFile;
    } else {
        echo "View not found: $view";
    }
}

switch ($path) {
    case '/':
    case '/index.php':
        if ($requestMethod === 'POST') {
            $stud_id = $_POST['stud_id'] ?? '';
            $pass = $_POST['pass'] ?? '';

            if (empty($stud_id) || empty($pass)) {
                render('index', ['error' => 'Please fill in all fields']);
                break;
            }

            if (!validateStudentId($stud_id)) {
                render('index', ['error' => 'Invalid ID format. Use XX-XXXX-XXXXXX']);
                break;
            }

            $student = db()->get("student_list/$stud_id");
            if ($student && isset($student['password']) && $student['password'] === $pass) {
                studentLogin($student);
                header('Location: /home');
                exit;
            } else {
                render('index', ['error' => 'Invalid ID number or password']);
            }
        } else {
            render('index');
        }
        break;

    case '/home':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        $allAppointments = db()->get('appointment_dashboard') ?: [];
        $currentAppointments = array_filter($allAppointments, function($appt) use ($student) {
            return isset($appt['student_id']) && $appt['student_id'] === $student['id'] 
                && ($appt['status'] ?? '') !== 'Settled'
                && ($appt['status'] ?? '') !== 'Cancelled';
        });
        $historyAppointments = array_filter($allAppointments, function($appt) use ($student) {
            return isset($appt['student_id']) && $appt['student_id'] === $student['id'] 
                && (($appt['status'] ?? '') === 'Settled' || ($appt['status'] ?? '') === 'Cancelled');
        });
        $allRequests = db()->get('requests') ?: [];
        $pendingRequests = array_filter($allRequests, function($req) use ($student) {
            return isset($req['inquiree_id']) && $req['inquiree_id'] === $student['id']
                && ($req['status'] ?? 'Pending') === 'Pending';
        });
        $declinedRequests = array_filter($allRequests, function($req) use ($student) {
            return isset($req['inquiree_id']) && $req['inquiree_id'] === $student['id']
                && ($req['status'] ?? '') === 'Declined';
        });
        render('home', ['user' => $student, 'appointments' => $currentAppointments, 'history' => $historyAppointments, 'pendingRequests' => array_merge($pendingRequests, $declinedRequests)]);
        break;

    case '/logout':
        logout();
        break;

    case '/adminlogin':
        if ($requestMethod === 'POST') {
            $name = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($password)) {
                render('adminlogin', ['error' => 'Please fill in all fields']);
                break;
            }

            $admins = db()->get('admin') ?: [];
            $admin = null;
            foreach ($admins as $a) {
                if ($a['name'] === $name && $a['password'] === $password) {
                    $admin = $a;
                    break;
                }
            }

            if ($admin) {
                adminLogin($admin);
                header('Location: /adminhome');
                exit;
            } else {
                render('adminlogin', ['error' => 'Invalid name or password']);
            }
        } else {
            render('adminlogin');
        }
        break;

    case '/adminlogout':
        logout();
        break;

    case '/adminhome':
        redirectIfNotAdmin();
        $admin = getCurrentAdmin();
        $requests = db()->get('requests') ?: [];
        $allAppointments = db()->get('appointment_dashboard') ?: [];
        $appointments = array_filter($allAppointments, function($appt) {
            return ($appt['status'] ?? '') !== 'Settled' && ($appt['status'] ?? '') !== 'Cancelled';
        });
        $history = array_filter($allAppointments, function($appt) {
            return ($appt['status'] ?? '') === 'Settled' || ($appt['status'] ?? '') === 'Cancelled';
        });
        render('adminhome', ['user' => $admin, 'requests' => $requests, 'appointments' => $appointments, 'history' => $history]);
        break;

    case '/schedap':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        render('schedap', ['user' => $student]);
        break;

    case '/tor':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        if ($requestMethod === 'POST') {
            $contact_num = $_POST['contact_num'] ?? '';
            $purpose = $_POST['purpose'] ?? '';
            $copy_qty = $_POST['copy_qty'] ?? 1;
            $msg = $_POST['msg'] ?? '';

            $requestData = [
                'request_type' => 'TOR',
                'inquiree_id' => $student['id'],
                'request_date' => date('Y-m-d H:i:s')
            ];
            $reqRef = db()->push('requests', $requestData);
            $reqKey = $reqRef->getKey();

            $torData = [
                'request_id' => $reqKey,
                'student_id' => $student['id'],
                'contact_number' => $contact_num,
                'purpose_of_transaction' => $purpose,
                'copy_qty' => (int)$copy_qty,
                'message_concern' => $msg
            ];
            db()->push('transcript_of_records', $torData);
            
            header('Location: /home');
            exit;
        }
        render('tor', ['user' => $student]);
        break;

    case '/diploma':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        if ($requestMethod === 'POST') {
            $yr_grad = $_POST['yr_grad'] ?? '';
            $msg = $_POST['msg'] ?? '';

            $requestData = [
                'request_type' => 'DIPLOMA',
                'inquiree_id' => $student['id'],
                'request_date' => date('Y-m-d H:i:s')
            ];
            $reqRef = db()->push('requests', $requestData);
            $reqKey = $reqRef->getKey();

            $dipData = [
                'request_id' => $reqKey,
                'student_id' => $student['id'],
                'year_graduated' => (int)$yr_grad,
                'message_concern' => $msg
            ];
            db()->push('diploma', $dipData);
            
            header('Location: /home');
            exit;
        }
        render('diploma', ['user' => $student]);
        break;

    case '/rf':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        if ($requestMethod === 'POST') {
            $contact_num = $_POST['contact_num'] ?? '';
            $sem = $_POST['sem'] ?? '';
            $schl_yr = $_POST['schl_yr'] ?? '';
            $msg = $_POST['msg'] ?? '';

            $requestData = [
                'request_type' => 'RF',
                'inquiree_id' => $student['id'],
                'request_date' => date('Y-m-d H:i:s')
            ];
            $reqRef = db()->push('requests', $requestData);
            $reqKey = $reqRef->getKey();

            $rfData = [
                'request_id' => $reqKey,
                'student_id' => $student['id'],
                'contact_number' => $contact_num,
                'semester' => $sem,
                'school_year' => $schl_yr,
                'message_concern' => $msg
            ];
            db()->push('rf', $rfData);
            
            header('Location: /home');
            exit;
        }
        render('rf', ['user' => $student]);
        break;

    case '/certificate':
        redirectIfNotStudent();
        $student = getCurrentStudent();
        if ($requestMethod === 'POST') {
            $contact_num = $_POST['contact_num'] ?? '';
            $course = $_POST['course'] ?? '';
            $type_cert = $_POST['type_cert'] ?? '';
            $purpose = $_POST['purpose'] ?? '';
            $copy_qty = $_POST['copy_qty'] ?? 1;

            $requestData = [
                'request_type' => 'CERTIFICATION',
                'inquiree_id' => $student['id'],
                'request_date' => date('Y-m-d H:i:s')
            ];
            $reqRef = db()->push('requests', $requestData);
            $reqKey = $reqRef->getKey();

            $certData = [
                'request_id' => $reqKey,
                'student_id' => $student['id'],
                'contact_number' => $contact_num,
                'course' => $course,
                'type_of_certification' => $type_cert,
                'purpose_of_transaction' => $purpose,
                'copy_qty' => (int)$copy_qty
            ];
            db()->push('certification', $certData);
            
            header('Location: /home');
            exit;
        }
        render('certificate', ['user' => $student]);
        break;

    case '/addstud':
        redirectIfNotAdmin();
        $admin = getCurrentAdmin();
        if ($requestMethod === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($id) || empty($name) || empty($email) || empty($password)) {
                render('adduser', ['user' => $admin, 'error' => 'Please fill in all fields']);
                break;
            }

            if (!validateStudentId($id)) {
                render('adduser', ['user' => $admin, 'error' => 'Invalid ID format. Use XX-XXXX-XXXXXX']);
                break;
            }

            $existing = db()->get("student_list/$id");
            if ($existing) {
                render('adduser', ['user' => $admin, 'error' => 'Student ID already exists']);
                break;
            }

            $studentData = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'added_by' => $admin['admin_id'] ?? '1'
            ];
            db()->set("student_list/$id", $studentData);
            
            header('Location: /adminhome');
            exit;
        }
        render('adduser', ['user' => $admin]);
        break;

    case '/setappointment':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $stud_id = $_POST['stud_id'] ?? '';
            $req_type = $_POST['req_type'] ?? '';
            $ret_date = $_POST['ret_date'] ?? '';
            $request_id = $_POST['request_id'] ?? '';
            $handlerId = getCurrentAdmin()['admin_id'] ?? '1';

            $apptData = [
                'student_id' => $stud_id,
                'type_of_request' => $req_type,
                'retrieval_date' => $ret_date,
                'handler_id' => $handlerId,
                'status' => 'Processing'
            ];
            db()->push('appointment_dashboard', $apptData);
            
            if ($request_id) {
                db()->remove("requests/$request_id");
            }
            
            header('Location: /adminhome');
            exit;
        }
        $admin = getCurrentAdmin();
        $requests = db()->get('requests') ?: [];
        render('setappointment', ['user' => $admin, 'requests' => $requests]);
        break;

    case '/declineRequest':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $reqId = $_POST['id'] ?? '';
            $reason = $_POST['reason'] ?? '';
            if ($reqId) {
                db()->update("requests/$reqId", [
                    'status' => 'Declined',
                    'cancel_reason' => $reason
                ]);
            }
        }
        header('Location: /adminhome');
        exit;

    case '/cancelAppointment':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $apptId = $_POST['id'] ?? '';
            $reason = $_POST['reason'] ?? '';
            if ($apptId) {
                db()->update("appointment_dashboard/$apptId", [
                    'status' => 'Cancelled',
                    'cancel_reason' => $reason
                ]);
            }
        }
        header('Location: /adminhome');
        exit;

    case '/cancel':
        if (!isStudentLoggedIn() && !isAdminLoggedIn()) {
            header('Location: /');
            exit;
        }
        $apptId = $_GET['id'] ?? '';
        if ($apptId) {
            db()->remove("appointment_dashboard/$apptId");
        }
        if (isAdminLoggedIn()) {
            header('Location: /adminhome');
        } else {
            header('Location: /home');
        }
        exit;

    case '/deleteRequest':
        redirectIfNotAdmin();
        $reqId = $_POST['id'] ?? '';
        if ($reqId) {
            db()->remove("requests/$reqId");
            db()->remove("transcript_of_records/$reqId");
            db()->remove("diploma/$reqId");
            db()->remove("rf/$reqId");
            db()->remove("certification/$reqId");
        }
        header('Location: /adminhome');
        exit;

    case '/updateStatus':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $apptId = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';
            if ($apptId && $status) {
                db()->update("appointment_dashboard/$apptId", ['status' => $status]);
            }
        }
        header('Location: /adminhome');
        exit;

    case '/updateDate':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $apptId = $_POST['id'] ?? '';
            $retDate = $_POST['ret_date'] ?? '';
            if ($apptId && $retDate) {
                db()->update("appointment_dashboard/$apptId", ['retrieval_date' => $retDate]);
            }
        }
        header('Location: /adminhome');
        exit;

    case '/updateHandler':
        redirectIfNotAdmin();
        if ($requestMethod === 'POST') {
            $apptId = $_POST['id'] ?? '';
            $handlerId = $_POST['handler_id'] ?? '';
            if ($apptId && $handlerId) {
                db()->update("appointment_dashboard/$apptId", ['handler_id' => $handlerId]);
            }
        }
        header('Location: /adminhome');
        exit;

    case '/about':
        render('about');
        break;

    case '/contact':
        render('contact');
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}