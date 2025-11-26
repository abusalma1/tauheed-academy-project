<?php
session_start();
header("Content-Type: application/json");
include(__DIR__ . '/../../../includes/db-connect.php');

// CSRF CHECK
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(["status" => "error", "message" => "Invalid CSRF token"]);
    exit;
}

// Check if 'fees' JSON is provided
if (!isset($_POST['fees'])) {
    echo json_encode(["status" => "error", "message" => "No fees data provided"]);
    exit;
}

// Decode JSON payload
$feesData = json_decode($_POST['fees'], true);
if (!is_array($feesData)) {
    echo json_encode(["status" => "error", "message" => "Invalid fees data"]);
    exit;
}

// Prepare statements outside loop for efficiency
$checkStmt = $conn->prepare("SELECT id FROM fees WHERE class_id=?");
$updateStmt = $conn->prepare("UPDATE fees SET first_term=?, second_term=?, third_term=?, uniform=?, transport=?, materials=? WHERE class_id=?");
$insertStmt = $conn->prepare("INSERT INTO fees (class_id, first_term, second_term, third_term, uniform, transport, materials) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Loop through classes
foreach ($feesData as $classId => $fee) {
    $cid = (int)$classId;
    $ft  = isset($fee['first_term']) ? floatval($fee['first_term']) : 0;
    $st  = isset($fee['second_term']) ? floatval($fee['second_term']) : 0;
    $tt  = isset($fee['third_term']) ? floatval($fee['third_term']) : 0;
    $un  = isset($fee['uniform']) ? floatval($fee['uniform']) : 0;
    $tp  = isset($fee['transport']) ? floatval($fee['transport']) : 0;
    $mat = isset($fee['materials']) ? floatval($fee['materials']) : 0;

    // Check if exists
    $checkStmt->bind_param("i", $cid);
    $checkStmt->execute();
    $exists = $checkStmt->get_result()->num_rows > 0;

    if ($exists) {
        $updateStmt->bind_param("ddddddi", $ft, $st, $tt, $un, $tp, $mat, $cid);
        $updateStmt->execute();
    } else {
        $insertStmt->bind_param("idddddd", $cid, $ft, $st, $tt, $un, $tp, $mat);
        $insertStmt->execute();
    }
}

echo json_encode(["status" => "success", "message" => "Fees updated successfully"]);
exit;
