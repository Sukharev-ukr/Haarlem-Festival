<?php

$_ENV["DB_HOST"] = "mysql";
$_ENV["DB_NAME"] = "haarlem_festival_v3";
$_ENV["DB_USER"] = "root";
$_ENV["DB_PASSWORD"] = "secret123";
$_ENV["DB_CHARSET"] = "utf8mb4";
$_ENV["ENV"] = "LOCAL";

$_ENV["RECAPTCHA_SITE_KEY"]   = "6LdgFegqAAAAADCVNMziPYYmcKfyKV6KurbKZpVB";
$_ENV["RECAPTCHA_SECRET_KEY"] = "6LdgFegqAAAAAI1s0cI-sx9RdmqHppYCodNH_Ztt";

// Stripe Keys
define('STRIPE_SECRET_KEY', 'sk_test_51R6YXiKSaEzVdkx07KtfrDdrQI52tMJ9WmlSgkY5WrQKa73VmiLWnKWmWYVzFSVuQZTCzeG1PgLfeOrFN1VvUnLF00aA2Gx9VM');
define('STRIPE_PUBLIC_KEY', 'pk_test_51R6YXiKSaEzVdkx0g44YaFiMgLr73SLdZwj2Vlgu5S81SIlluez6s0PNeDh6bhHbsyeSfgEX0jCykyrtidaRK5Q7008Lx9DzfG');