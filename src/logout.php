<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

session_start();
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id']) || isset($_SESSION['doctor_id'])) {
  session_destroy();
  redirect('/');
}
