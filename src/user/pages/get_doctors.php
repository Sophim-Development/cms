<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php'; // For sanitize()
require_once dirname(__DIR__, 2) . '/services/SpecializationService.php';

header('Content-Type: application/json');

if (isset($_GET['spec_id'])) {
  $specId = sanitize($_GET['spec_id']);
  $specService = new SpecializationService($con);
  $doctors = $specService->getDoctorsBySpecialization($specId);
  echo json_encode($doctors);
} else {
  echo json_encode([]);
}
