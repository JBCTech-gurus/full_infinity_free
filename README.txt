JOE.B.TECH Bundle Site - Quick Deploy

1) Upload the contents of the 'htdocs' folder to your webhost (InfinityFree -> htdocs) OR a local folder for testing.
2) Edit inc/config.php if you want to change PAYMENT_NUMBER, PAYMENT_NAME, ADMIN_PASS, ADMIN_EMAIL.
3) Ensure data/ folder is writable. orders.csv will store orders.
4) Visit /index.php to use the site. Admin panel: /admin/login.php (use ADMIN_USER and ADMIN_PASS from inc/config.php).
5) When an order is placed, it is saved to data/orders.csv. Use Admin -> mark Paid -> mark Delivered.
6) For security, consider adding a .htaccess inside data/ with 'Deny from all' to prevent direct web access.
