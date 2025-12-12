<?php require_once __DIR__ . '/inc/config.php'; $bundles = get_bundles(); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=htmlspecialchars(SITE_NAME)?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <div class="brand">
      <div class="logo">JB</div>
      <div>
        <div class="sitename"><?=htmlspecialchars(SITE_NAME)?></div>
        <div class="tagline">Cheap • Fast • Reliable — Pay to <?= PAYMENT_NUMBER ?> (<?= PAYMENT_NAME ?>)</div>
      </div>
    </div>
  </div>
</header>

<main class="container">
  <div class="banner-warning">
    <h2>🔥 USE REFERENCE: BUNDLE 🔥</h2>
    <p>Your payment will NOT be processed if you use any other reference.</p>
  </div>

  <div class="grid">
    <section class="card main-card">
      <h2>Quick Order</h2>

      <form id="orderForm" action="process_order.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="network" id="networkInput" value="mtn">

        <label>Choose network</label>
        <select id="networkSelect" name="network_select">
          <option value="mtn">MTN (Available)</option>
          <option value="telecel">Vodafone / Telecel (Coming soon)</option>
          <option value="airteltigo">AirtelTigo (Coming soon)</option>
          <option value="glo">Glo (Coming soon)</option>
        </select>

        <label>Choose bundle</label>
        <select id="bundleSelect" name="bundle_code" required>
          <?php foreach($bundles['mtn'] as $code=>$b): ?>
            <option value="<?=htmlspecialchars($code)?>" data-price="<?=number_format($b['price'],2)?>"><?=htmlspecialchars($b['label'])?> — ₵<?=number_format($b['price'],2)?></option>
          <?php endforeach; ?>
        </select>

        <div class="two-col">
          <div>
            <label>Recipient number (where bundle will be sent)</label>
            <input id="recipient" type="tel" name="recipient_number" placeholder="e.g. 024xxxxxxxx" required>
          </div>
          <div>
            <label>Number that paid (payer)</label>
            <input id="payer" type="tel" name="payer_number" placeholder="Number used to pay (e.g. 054xxxxxxx)" required>
          </div>
        </div>

        <label>Payment reference (enter exactly: <strong>BUNDLE</strong>)</label>
        <input id="reference" type="text" name="reference" placeholder="BUNDLE" required>

        <label>Upload screenshot (optional)</label>
        <input type="file" name="screenshot" accept="image/*">

        <div class="pay-instr">
          <div><strong>Pay to:</strong> <span class="pay-number"><?= PAYMENT_NUMBER ?> (<?= PAYMENT_NAME ?>)</span></div>
          <div class="small">After payment, use reference <strong>BUNDLE</strong> exactly (all caps). Orders with wrong reference will be rejected.</div>
        </div>

        <div class="actions">
          <button class="btn" type="submit">Submit Order</button>
        </div>
      </form>

      <div class="delivery-note">
        <h3>⏳ Delivery Time</h3>
        <p>Bundles are usually delivered within <strong>30 to 45 minutes</strong>. If your order delays, it is still processing — please wait and contact support if it takes longer.</p>

        <h3>💬 Need Help?</h3>
        <p>If you experience any delay or problem, contact support immediately:</p>
        <a class="whatsapp big" href="https://wa.me/233533833889" target="_blank">💬 Chat on WhatsApp</a>
        <a class="call-button" href="tel:+233533833889">📞 Call Support</a>
      </div>

    </section>

    <aside class="card side-card">
      <h3>Your Support</h3>
      <p>Email: <a href="mailto:joebtech1@gmail.com">joebtech1@gmail.com</a></p>
      <p>WhatsApp Group: <a href="https://chat.whatsapp.com/DqTxuXfcw1kLtJSTKdzrRl" target="_blank">Join our WhatsApp</a></p>

      <h3 style="margin-top:14px">Why choose us?</h3>
      <ul class="muted">
        <li>Instant verification & quick delivery</li>
        <li>Clear prices — no hidden charges</li>
        <li>Fast support on WhatsApp</li>
      </ul>

      <h3 style="margin-top:14px">Network auto-detect</h3>
      <p class="muted">Enter the payer number and we will detect the network automatically (format check only).</p>
      <div id="detected" class="muted">Network: —</div>
    </aside>
  </div>
</main>

<footer class="site-footer">
  <div class="container">© <?=date('Y')?> <?=SITE_NAME?> — Contact: <?=ADMIN_EMAIL?> • <?=PAYMENT_NUMBER?></div>
</footer>

<script>
// client-side: enforce exact BUNDLE, detect network by prefix, fill amount
(function(){
  const prefixes = {
    mtn: ['024','054','055','059'],
    vodafone: ['020','050'],
    airteltigo: ['026','056'],
    glo: ['027','057','028']
  };

  function detectNetwork(num){
    if(!num) return null;
    num = num.replace(/\D/g,'');
    if(num.length === 12 && num.startsWith('233')) num = num.slice(3);
    if(num.length === 10 && num.startsWith('0')) num = num.slice(1);
    const pre = num.slice(0,3);
    for(const k in prefixes){
      if(prefixes[k].includes(pre)) return k;
    }
    return null;
  }

  const payer = document.getElementById('payer');
  const detected = document.getElementById('detected');
  const bundleSelect = document.getElementById('bundleSelect');
  const amountField = document.createElement('div');
  amountField.style.marginTop='8px';
  amountField.style.fontWeight='700';
  bundleSelect.parentNode.insertBefore(amountField, bundleSelect.nextSibling);
  function updateAmount(){ 
    const opt = bundleSelect.options[bundleSelect.selectedIndex];
    amountField.textContent = 'Amount: ₵' + (opt ? opt.dataset.price : '0.00');
  }
  updateAmount();
  bundleSelect.addEventListener('change', updateAmount);

  payer && payer.addEventListener('input', function(){
    const n = payer.value;
    const net = detectNetwork(n);
    let label = '—';
    if(net === 'mtn') label = 'MTN (detected)';
    if(net === 'vodafone') label = 'Vodafone';
    if(net === 'airteltigo') label = 'AirtelTigo';
    if(net === 'glo') label = 'Glo';
    detected.textContent = 'Network: ' + label;
  });

  document.getElementById('orderForm').addEventListener('submit', function(e){
    const ref = (document.getElementById('reference').value || '').trim();
    if(ref !== 'BUNDLE'){ e.preventDefault(); alert('Please enter BUNDLE (exactly, all caps) as payment reference. Your order was rejected.'); document.getElementById('reference').focus(); return false; }
    document.getElementById('networkInput').value = document.getElementById('networkSelect').value;
    return true;
  });

})();
</script>
</body>
</html>
