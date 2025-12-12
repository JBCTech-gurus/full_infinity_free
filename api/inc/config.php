<?php
session_start();
define('SITE_NAME','JOE.B.TECH Bundle Site');
define('PAYMENT_NUMBER','0533833889');
define('PAYMENT_NAME','NANA OYE DARKO');
define('ADMIN_USER','admin');
define('ADMIN_PASS','(joebwoykao1)');
define('ADMIN_EMAIL','joebtech1@gmail.com');

define('DATA_DIR', __DIR__ . '/../data');
define('ORDERS_FILE', DATA_DIR . '/orders.csv');
define('UPLOADS_DIR', DATA_DIR . '/uploads');

$BUNDLES = array(
  'mtn' => array(
    '1gb'   => array('label'=>'1GB','price'=>5.50,'agent_cost'=>4.00),
    '2gb'   => array('label'=>'2GB','price'=>11.20,'agent_cost'=>8.00),
    '3gb'   => array('label'=>'3GB','price'=>15.50,'agent_cost'=>11.00),
    '4gb'   => array('label'=>'4GB','price'=>20.80,'agent_cost'=>15.00),
    '5gb'   => array('label'=>'5GB','price'=>25.70,'agent_cost'=>18.50),
    '6gb'   => array('label'=>'6GB','price'=>30.50,'agent_cost'=>23.50),
    '8gb'   => array('label'=>'8GB','price'=>39.50,'agent_cost'=>29.00),
    '10gb'  => array('label'=>'10GB','price'=>47.00,'agent_cost'=>34.00),
    '15gb'  => array('label'=>'15GB','price'=>65.50,'agent_cost'=>45.00),
    '20gb'  => array('label'=>'20GB','price'=>88.00,'agent_cost'=>60.00),
    '25gb'  => array('label'=>'25GB','price'=>115.00,'agent_cost'=>90.00),
    '30gb'  => array('label'=>'30GB','price'=>136.50,'agent_cost'=>100.00),
    '40gb'  => array('label'=>'40GB','price'=>177.20,'agent_cost'=>140.00),
    '50gb'  => array('label'=>'50GB','price'=>218.00,'agent_cost'=>170.00),
    '100gb' => array('label'=>'100GB','price'=>425.00,'agent_cost'=>350.00)
  ),
  'telecel' => array(),
  'airteltigo' => array(),
  'glo' => array()
);

if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0755, true);
if (!is_dir(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0755, true);

function get_bundles(){ global $BUNDLES; return $BUNDLES; }
?>
