<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../services/SpecializationService.php';

header('Content-Type: application/json');

if (isset($_GET['spec_id'])) {
    $specId = sanitize($_GET['spec_id']);
    $specService = new SpecializationService($con);
    $doctors = $specService->getDoctorsBySpecialization($specId);
    echo json_encode($doctors);
} else {
    echo json_encode([]);
}
?>