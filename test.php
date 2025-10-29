<?php
// ensure correct timezone
date_default_timezone_set('Asia/Manila');

include_once dirname(__DIR__, 1) . '/tatsystem/class/transaction.class.php';
$conn = new Transaction();
$pdo = $conn->getConnection();

$query = "
SELECT 
    PatientNumber,
    [Age Group] AS AgeGroup,
    ProcedureType,
    SubProcedureType,
    [Start],
    [End],
    FullName
FROM vw_TATtransaction 
WHERE --CONVERT(date, [Start]) = CONVERT(date, GETDATE()) AND 
PatientNumber = '202510270066'
ORDER BY [Start] DESC
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// helper: robust parse to DateTime
function parse_datetime($s)
{
    if (empty($s)) return null;

    // try some common formats - adjust/add if your DB uses different format
    $formats = [
        'm-d-Y H:i:s', // e.g. 10-27-2025 07:05:31
        'Y-m-d H:i:s', // e.g. 2025-10-27 07:05:31
        'm/d/Y H:i:s',
        DateTime::RFC3339,
    ];

    foreach ($formats as $fmt) {
        $dt = DateTime::createFromFormat($fmt, $s, new DateTimeZone('Asia/Manila'));
        if ($dt && $dt->getLastErrors()['warning_count'] == 0 && $dt->getLastErrors()['error_count'] == 0) {
            return $dt;
        }
    }

    // fallback: try strtotime after replacing dashes with slashes
    $norm = str_replace('-', '/', $s);
    $ts = strtotime($norm);
    if ($ts !== false) {
        $dt = new DateTime('@' . $ts);
        $dt->setTimezone(new DateTimeZone('Asia/Manila'));
        return $dt;
    }

    // final fallback: try DateTime constructor (may fail)
    try {
        $dt = new DateTime($s, new DateTimeZone('Asia/Manila'));
        return $dt;
    } catch (Exception $e) {
        return null;
    }
}

// Group data by patient and parse datetimes
$patients = [];
foreach ($result as $row) {
    $start_dt = parse_datetime($row['Start']);
    $end_dt = parse_datetime($row['End']);

    // store parsed DateTime and timestamps for robust output
    $row['_start_dt'] = $start_dt;
    $row['_end_dt'] = $end_dt;
    $row['_start_ts'] = $start_dt ? $start_dt->getTimestamp() : null; // seconds
    $row['_end_ts'] = $end_dt ? $end_dt->getTimestamp() : null; // seconds

    $patients[$row['PatientNumber']]['AgeGroup'] = $row['AgeGroup'];
    $patients[$row['PatientNumber']]['Procedures'][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TAT Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Turn Around Time Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($patients as $patientNumber => $patientData): ?>
        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow p-5">
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Patient #<?= htmlspecialchars($patientNumber) ?></h2>
            <p class="text-sm text-gray-600 mb-4">Age Group: <span
                    class="font-medium"><?= htmlspecialchars($patientData['AgeGroup']) ?></span></p>

            <div class="border-t border-gray-200 pt-2">
                <h3 class="font-semibold text-gray-700 mb-2 text-sm">Procedures:</h3>
                <ul class="text-sm text-gray-600 space-y-2 max-h-40 overflow-y-auto">
                    <?php foreach ($patientData['Procedures'] as $proc):
                            $start_dt = $proc['_start_dt'];
                            $end_dt = $proc['_end_dt'];
                            $hasEnded = $end_dt !== null && $proc['_end_ts'] !== null;
                            // safe formatted start / end for display
                            $start_display = $start_dt ? $start_dt->format('H:i') : '—';
                            $end_display = $end_dt ? $end_dt->format('H:i') : '—';
                            $timerId = "timer_" . md5($patientNumber . $proc['ProcedureType'] . ($proc['_start_ts'] ?? ''));
                        ?>
                    <li class="border-b border-gray-100 pb-1">
                        <p>
                            <span class="font-medium"><?= htmlspecialchars($proc['ProcedureType']) ?></span>
                            <?= $proc['SubProcedureType'] !== 'N/A' ? ' - ' . htmlspecialchars($proc['SubProcedureType']) : '' ?>
                        </p>

                        <p class="text-xs text-gray-500">
                            Start: <?= $start_display ?> →
                            <?= $hasEnded ? $end_display : '<span class="text-green-600 font-semibold">Ongoing</span>' ?><br>
                            <span class="italic"><?= htmlspecialchars($proc['FullName']) ?></span><br>
                            <!-- Live timer span: data-start expects milliseconds -->
                            <span class="text-blue-700 font-semibold" id="<?= $timerId ?>"
                                <?php if ($proc['_start_ts']): ?> data-start="<?= ($proc['_start_ts'] * 1000) ?>"
                                <?php endif; ?> <?php if ($hasEnded && $proc['_start_ts'] && $proc['_end_ts']): ?>
                                data-end="<?= ($proc['_end_ts'] * 1000) ?>" <?php endif; ?>>
                                <?php
                                        if ($hasEnded && $proc['_start_ts'] !== null && $proc['_end_ts'] !== null) {
                                            // compute elapsed once in PHP for completed processes
                                            $diff = $proc['_end_ts'] - $proc['_start_ts'];
                                            $h = floor($diff / 3600);
                                            $m = floor(($diff % 3600) / 60);
                                            $s = $diff % 60;
                                            echo sprintf('%02d:%02d:%02d (Done)', $h, $m, $s);
                                        } else {
                                            echo $proc['_start_ts'] ? 'Calculating...' : 'No start time';
                                        }
                                        ?>
                            </span>
                        </p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="mt-4">
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">View Patient
                    Details</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    // single global updater for all live timers
    (function() {
        const timers = Array.from(document.querySelectorAll('[id^="timer_"]'));

        function formatHMS(ms) {
            // ms -> total seconds
            const totalSec = Math.floor(ms / 1000);
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function update() {
            const now = Date.now();
            timers.forEach(el => {
                const ds = el.getAttribute('data-start');
                if (!ds) return;
                const startMs = parseInt(ds, 10);
                const de = el.getAttribute('data-end');

                if (de) {
                    // completed: show computed value if not already set (we already set in PHP), but just in case refresh
                    const endMs = parseInt(de, 10);
                    const diff = Math.max(0, endMs - startMs);
                    el.textContent = formatHMS(diff) + ' (Done)';
                } else {
                    // ongoing: now - start
                    let diff = now - startMs;
                    if (diff < 0) diff = 0; // handle clock skew
                    el.textContent = formatHMS(diff);
                }
            });
        }

        // update every 1 second
        setInterval(update, 1000);
        update(); // initial
    })();
    </script>

</body>

</html>