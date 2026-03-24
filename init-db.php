<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Database.php';

echo "Initializing RegiTrack Firebase Database...\n\n";

$admins = [
    'admin_1' => [
        'admin_id' => '1',
        'name' => 'admin',
        'password' => '1'
    ]
];

$students = [
    '04-2324-0437361' => [
        'id' => '04-2324-0437361',
        'name' => 'Robul Grantosa',
        'email' => '123@yahoo.com',
        'password' => '1234',
        'added_by' => '1'
    ]
];

echo "Setting up admin users...\n";
foreach ($admins as $key => $admin) {
    db()->set("admin/$key", $admin);
    echo "- Admin: {$admin['name']} (ID: {$admin['admin_id']})\n";
}

echo "\nSetting up sample students...\n";
foreach ($students as $key => $student) {
    db()->set("student_list/$key", $student);
    echo "- Student: {$student['name']} (ID: {$student['id']})\n";
}

echo "\n✓ Database initialization complete!\n";
echo "\nDefault Admin Login:\n";
echo "  Name: admin\n";
echo "  Password: 1\n";
echo "\nDefault Student Login:\n";
echo "  ID: 04-2324-0437361\n";
echo "  Password: 1234\n";