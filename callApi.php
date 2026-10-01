<?php
// URL API yang ingin dipanggil
$apiUrl = 'http://fs-mvc.test/index.php?action=apiAll';

// Inisialisasi cURL
$ch = curl_init();

// Tetapan cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pulangkan hasil sebagai string, bukan terus cetak
curl_setopt($ch, CURLOPT_TIMEOUT, 10);          // Had masa 10 saat
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Ikut sebarang redirect jika ada

// Laksanakan cURL request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

// Pengendalian ralat
$students = [];
$errorMessage = null;

if ($curlError) {
    $errorMessage = "Ralat cURL: " . $curlError;
} elseif ($httpCode !== 200) {
    $errorMessage = "Ralat HTTP: Status code " . $httpCode;
} else {
    $students = json_decode($response, true);
    if (!is_array($students)) {
        $errorMessage = "Gagal memproses JSON dari API.";
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Senarai Pelajar (PHP cURL)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background-color: #f8f9fa;
      color: #333;
    }
    h1 {
      color: #2c3e50;
    }
    .status {
      margin-bottom: 15px;
      padding: 12px 15px;
      border-radius: 4px;
      font-weight: 500;
    }
    .error {
      background-color: #fce4d6;
      color: #c65911;
      border: 1px solid #f8cbad;
    }
    .info {
      background-color: #e2f0d9;
      color: #385723;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      border-radius: 6px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }
    th {
      background-color: #007bff;
      color: white;
      text-transform: uppercase;
      font-size: 13px;
      letter-spacing: 0.5px;
    }
    tr:hover {
      background-color: #f1f5f9;
    }
    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 12px;
    }
    .badge-pass {
      background-color: #d4edda;
      color: #155724;
    }
    .badge-fail {
      background-color: #f8d7da;
      color: #721c24;
    }
    .badge-curl {
      background-color: #17a2b8;
      color: #fff;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
      vertical-align: middle;
    }
  </style>
</head>
<body>

  <h1>Senarai Pelajar <span class="badge-curl">cURL PHP</span></h1>

  <?php if ($errorMessage): ?>
    <div class="status error">
      <strong>Gagal Memuatkan Data:</strong> <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
    </div>
  <?php elseif (empty($students)): ?>
    <div class="status info">Tiada rekod pelajar dijumpai.</div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>NRIC</th>
          <th>Program</th>
          <th>CGPA</th>
          <th>Gred</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $student): ?>
          <?php 
            $isFail = isset($student['gred']) && strtoupper($student['gred']) === 'F';
            $badgeClass = $isFail ? 'badge-fail' : 'badge-pass';
          ?>
          <tr>
            <td><?= htmlspecialchars($student['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><strong><?= htmlspecialchars($student['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong></td>
            <td><?= htmlspecialchars($student['nric'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['program'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= isset($student['cgpa']) ? number_format((float)$student['cgpa'], 2) : '-' ?></td>
            <td>
              <span class="badge <?= $badgeClass ?>">
                <?= htmlspecialchars($student['gred'] ?? '', ENT_QUOTES, 'UTF-8') ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</body>
</html>