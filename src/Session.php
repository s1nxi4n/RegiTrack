<?php

function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isStudentLoggedIn() {
    startSession();
    return isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'] === true;
}

function isAdminLoggedIn() {
    startSession();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getCurrentStudent() {
    startSession();
    return isset($_SESSION['student']) ? $_SESSION['student'] : null;
}

function getCurrentAdmin() {
    startSession();
    return isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
}

function getCurrentAdminId() {
    startSession();
    return isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '1';
}

function studentLogin($student) {
    startSession();
    $_SESSION['student_logged_in'] = true;
    $_SESSION['student'] = $student;
}

function adminLogin($admin, $adminId = '1') {
    startSession();
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin'] = $admin;
    $_SESSION['admin_id'] = $adminId;
}

function logout() {
    startSession();
    session_destroy();
    header('Location: /');
    exit;
}

function redirectIfNotStudent() {
    if (!isStudentLoggedIn()) {
        header('Location: /');
        exit;
    }
}

function redirectIfNotAdmin() {
    if (!isAdminLoggedIn()) {
        header('Location: /adminlogin');
        exit;
    }
}

function validateStudentId($id) {
    return preg_match('/^\d{2}-\d{4}-\d{6}$/', $id);
}