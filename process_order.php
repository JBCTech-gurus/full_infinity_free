<?php
require_once __DIR__ . '/inc/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }

$network = preg_replace('/[^a-z0-9_-]/i','', $_POST['network'] ?? 'mtn');
$bundle_code = $_POST['bundle_code'] ?? '';
$payer_number = trim($_POST['payer_number'] ?? '');
$recipient_number = trim($_POST['recipient_number'] ?? '');
$reference = trim($_POST['reference'] ?? '');

// strict server-side validation (exact match)
if ($reference !== 'BUNDLE') {
  http_response_code(400);
  echo "<p style='color:red;padding:20px;'>Invalid reference. Please enter exactly <strong>BUNDLE</strong> as the payment reference. <a href='index.php'>Return</a></p>";
  exit;
}

$bundles = get_bundles();
$bundle = $bundles['mtn'][$bundle_code] ?? null;
if (!$bundle) { header('Location: index.php'); exit; }

// handle screenshot upload (optional)
$screenshot_path = '';
if (!empty($_FILES['screenshot']['name']) && is_uploaded_file($_FILES['screenshot']['tmp_name'])) {
  $ext = pathinfo($_FILES['screenshot']['name'], PATHINFO_EXTENSION);
  $fn = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
  if (!is_dir(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0755, true);
  $target = UPLOADS_DIR . '/' . $fn;
  if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
    $screenshot_path = 'data/uploads/' . $fn;
  }
}

// prepare and save order
$order = array(
  'id' => time() . rand(100,999),
  'created_at' => date('Y-m-d H:i:s'),
  'network' => $network,
  'bundle_code' => $bundle_code,
  'bundle_label' => $bundle['label'],
  'price' => number_format($bundle['price'],2),
  'agent_cost' => number_format($bundle['agent_cost'] ?? 0,2),
  'payer_number' => $payer_number,
  'recipient_number' => $recipient_number,
  'reference' => $reference,
  'screenshot' => $screenshot_path,
  'status' => 'pending'
);

$csvFile = ORDERS_FILE;
$exists = file_exists($csvFile);
if (($fp = fopen($csvFile,'a')) !== false) {
  if (!$exists) fputcsv($fp, array_keys($order));
  fputcsv($fp, $order);
  fclose($fp);
}

// optional email notification
if (!empty(ADMIN_EMAIL) && filter_var(ADMIN_EMAIL, FILTER_VALIDATE_EMAIL)) {
  $subject = "New Order #{$order['id']} - {$order['bundle_label']}";
  $body = "New order received:\n\n" . print_r($order, true);
  $headers = "From: no-reply@joebtech.local\r\n";
  @mail(ADMIN_EMAIL, $subject, $body, $headers);
}

header('Location: success.php?order=' . $order['id']);
exit;
?>