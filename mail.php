<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://artmarque.in');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$to      = 'artmarquepune@gmail.com, raut.vitthal@gmail.com';
$name    = strip_tags(trim($_POST['name']    ?? ''));
$phone   = strip_tags(trim($_POST['phone']   ?? ''));
$email   = strip_tags(trim($_POST['email']   ?? ''));
$project = strip_tags(trim($_POST['project'] ?? ''));
$message = strip_tags(trim($_POST['message'] ?? ''));
$source  = strip_tags(trim($_POST['source']  ?? 'Contact Form'));

if (empty($name) || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Name and phone are required']);
    exit;
}

$subject = "New Enquiry from artmarque.in – $name";

$body  = "You have received a new enquiry from artmarque.in\n";
$body .= str_repeat('-', 40) . "\n";
$body .= "Source  : $source\n";
$body .= "Name    : $name\n";
$body .= "Phone   : $phone\n";
if ($email)   $body .= "Email   : $email\n";
if ($project) $body .= "Project : $project\n";
if ($message) $body .= "\nMessage :\n$message\n";
$body .= str_repeat('-', 40) . "\n";
$body .= "Sent from artmarque.in\n";

$headers  = "From: Artmarque Website <noreply@artmarque.in>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Mail could not be sent']);
}
