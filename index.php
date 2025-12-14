<?php
/**
 * Main Router / Entry Point
 * E-Rapor PAUD Application
 */

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base paths
define('BASE_PATH', __DIR__);
define('BASE_URL', '/erapor');
define('UPLOAD_PATH', BASE_PATH . '/uploads/');

// Load configuration and helpers
require_once BASE_PATH . '/config/session.php';
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/helpers/helpers.php';
require_once BASE_PATH . '/helpers/auth.php';

// Simple Router
$request = $_SERVER['REQUEST_URI'];
$basePath = BASE_URL;

// Remove base path and query string
$path = parse_url($request, PHP_URL_PATH);
$path = str_replace($basePath, '', $path);
$path = $path ?: '/';

// Routing table
$routes = [
    // Auth routes
    '/' => 'controllers/AuthController.php@login',
    '/login' => 'controllers/AuthController.php@login',
    '/logout' => 'controllers/AuthController.php@logout',

    // Admin routes
    '/admin/dashboard' => 'controllers/AdminController.php@dashboard',
    '/admin/school' => 'controllers/AdminController.php@school',
    '/admin/academic-year' => 'controllers/AdminController.php@academicYear',
    '/admin/teachers' => 'controllers/AdminController.php@teachers',
    '/admin/teachers/create' => 'controllers/AdminController.php@teacherCreate',
    '/admin/teachers/edit' => 'controllers/AdminController.php@teacherEdit',
    '/admin/teachers/delete' => 'controllers/AdminController.php@teacherDelete',
    '/admin/students' => 'controllers/AdminController.php@students',
    '/admin/students/create' => 'controllers/AdminController.php@studentCreate',
    '/admin/students/edit' => 'controllers/AdminController.php@studentEdit',
    '/admin/students/delete' => 'controllers/AdminController.php@studentDelete',
    '/admin/students/import' => 'controllers/AdminController.php@studentImport',
    '/admin/classes' => 'controllers/AdminController.php@classes',
    '/admin/classes/create' => 'controllers/AdminController.php@classCreate',
    '/admin/classes/edit' => 'controllers/AdminController.php@classEdit',
    '/admin/classes/delete' => 'controllers/AdminController.php@classDelete',
    '/admin/classes/students' => 'controllers/AdminController.php@classStudents',
    '/admin/curriculum' => 'controllers/AdminController.php@curriculum',
    '/admin/curriculum/aspects' => 'controllers/AdminController.php@aspects',
    '/admin/curriculum/indicators' => 'controllers/AdminController.php@indicators',
    '/admin/users' => 'controllers/AdminController.php@users',
    '/admin/users/create' => 'controllers/AdminController.php@userCreate',
    '/admin/users/edit' => 'controllers/AdminController.php@userEdit',
    '/admin/users/delete' => 'controllers/AdminController.php@userDelete',

    // Teacher routes
    '/guru/dashboard' => 'controllers/TeacherController.php@dashboard',
    '/guru/profile' => 'controllers/TeacherController.php@profile',
    '/guru/students' => 'controllers/TeacherController.php@students',
    '/guru/assessment' => 'controllers/TeacherController.php@assessment',
    '/guru/assessment/input' => 'controllers/TeacherController.php@assessmentInput',
    '/guru/assessment/delete-photo' => 'controllers/TeacherController.php@assessmentDeletePhoto',
    '/guru/attendance' => 'controllers/TeacherController.php@attendance',
    '/guru/portfolio' => 'controllers/TeacherController.php@portfolio',
    '/guru/portfolio/upload' => 'controllers/TeacherController.php@portfolioUpload',
    '/guru/portfolio/delete' => 'controllers/TeacherController.php@portfolioDelete',
    '/guru/reports' => 'controllers/TeacherController.php@reports',
    '/guru/reports/preview' => 'controllers/TeacherController.php@reportPreview',
    '/guru/reports/upload-border' => 'controllers/TeacherController.php@uploadBorder',
    '/guru/reports/submit' => 'controllers/TeacherController.php@reportSubmit',

    // Principal routes
    '/kepala/dashboard' => 'controllers/PrincipalController.php@dashboard',
    '/kepala/approval' => 'controllers/PrincipalController.php@approval',
    '/kepala/approval/action' => 'controllers/PrincipalController.php@approvalAction',
    '/kepala/reports' => 'controllers/PrincipalController.php@reports',
    '/kepala/print' => 'controllers/PrincipalController.php@printMass',

    // Parent routes
    '/orangtua/dashboard' => 'controllers/ParentController.php@dashboard',
    '/orangtua/report' => 'controllers/ParentController.php@report',

    // Report routes
    '/report/view' => 'controllers/ReportController.php@view',
    '/report/print' => 'controllers/ReportController.php@printReport',
    '/report/pdf' => 'controllers/ReportController.php@pdf',
];

// Match route
if (isset($routes[$path])) {
    list($controllerFile, $method) = explode('@', $routes[$path]);
    require_once BASE_PATH . '/' . $controllerFile;
    $method();
} else {
    // 404 Not Found
    http_response_code(404);
    include BASE_PATH . '/views/errors/404.php';
}
