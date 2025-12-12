<?php require_once __DIR__ . '/inc/config.php'; $id = isset($_GET['order']) ? htmlspecialchars($_GET['order']) : ''; ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Order Received</title></head>
<body style="font-family:Arial;padding:20px">
  <h2>Order Received</h2>
  <p>Thank you — we received your order. Order ID: <strong><?= $id ?></strong></p>
  <p>We will verify that payment was received to <strong><?= PAYMENT_NUMBER ?></strong> with reference <strong>BUNDLE</strong> and deliver your data within minutes (30–45 mins usual delivery time).</p>
  <p><a href="index.php">Return Home</a></p>
</body></html>