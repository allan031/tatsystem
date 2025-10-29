<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAT Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <style>
    @keyframes pulse-green {

        0%,
        100% {
            background-color: #dcfce7;
            /* light green */
            box-shadow: 0 0 10px 5px rgba(34, 197, 94, 0.4);
        }

        50% {
            background-color: #bbf7d0;
            box-shadow: 0 0 10px 5px rgba(34, 197, 94, 0.6);
        }
    }

    @keyframes pulse-red {

        0%,
        100% {
            background-color: #fee2e2;
            /* light red */
            box-shadow: 0 0 10px 5px rgba(239, 68, 68, 0.4);
        }

        50% {
            background-color: #fecaca;
            box-shadow: 0 0 10px 5px rgba(239, 68, 68, 0.6);
        }
    }

    .pulse-green {
        animation: pulse-green 1.5s infinite;
        transition: background-color 0.3s ease;
    }

    .pulse-red {
        animation: pulse-red 1.5s infinite;
        transition: background-color 0.3s ease;
    }
    </style>

</head>

<body class="bg-gray-100 min-h-screen">
    <div class="w-full  backdrop-blur-sm shadow-xs fixed top-0 left-0 z-50 shadow-gray-500 shadow-md">
        <h1 class="font-poppins italic text-3xl font-bold self-center text-gray-800 text-center my-2">ER Turn Around
            Time
            Dashboard
        </h1>
    </div>
    <div id="tatDashboard" class="mt-16 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
    </div>
    <!-- 🟢 Floating Legend -->
    <div id="legend"
        class="fixed bottom-4 right-4 bg-white shadow-lg border border-gray-300 rounded-xl p-4 text-sm font-medium z-50 space-y-2">
        <h3 class="font-semibold text-gray-700 border-b pb-1 mb-1 text-base">Legend</h3>
        <div class="flex items-center space-x-2">
            <span class="w-4 h-4 rounded-full bg-green-400 animate-pulse"></span>
            <span>Ongoing</span>
        </div>
        <div class="flex items-center space-x-2">
            <span class="w-4 h-4 rounded-full bg-red-400 animate-pulse"></span>
            <span>Exceeded</span>
        </div>
        <div class="flex items-center space-x-2">
            <span class="w-4 h-4 rounded-full bg-gray-400 animate-pulse"></span>
            <span>Incomplete</span>
        </div>
    </div>


    <script>
    // 🕒 Format seconds into HH:MM:SS
    function formatHMS(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = Math.floor(seconds % 60);
        return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
    }

    // 🧩 Normalize timestamp (accepts ms or s)
    function normalizeTS(raw) {
        if (!raw || raw === 'null' || raw === '') return null;
        const n = Number(raw);
        if (!isFinite(n)) return null;
        return n > 1e12 ? Math.floor(n / 1000) : Math.floor(n);
    }

    // ⏱ Time limits per procedure (seconds)
    const timeLimits = {
        "Triage": 5 * 60,
        "Clerk": 10 * 60,
        "Doctors Order": 30 * 60,
        "Carry Out": 90 * 60,
        "Finalized SOA": 15 * 60,
        "Payment Settlement": 10 * 60,
        "Ready To Transfer": 60 * 60,
        "Transfer To Room": 15 * 60,
        "Disposition": 15 * 60
    };

    // 🧠 Render Dashboard
    function renderDashboard(data) {
        let html = '';

        data.forEach(patient => {
            const lastProc = patient.Procedures[patient.Procedures.length - 1];
            // 🔸 Skip patients fully completed (Disposition or Transfer To Room ended)
            if (lastProc && ["Disposition", "Transfer To Room"].includes(lastProc.ProcedureType) && lastProc
                .EndTime) {
                return;
            }

            let pulseClass = '';
            let emoji = '';

            // Sort: ongoing first, then by latest start time
            patient.Procedures.sort((a, b) => {
                const aEnded = !!a.EndTime;
                const bEnded = !!b.EndTime;
                if (aEnded && !bEnded) return 1;
                if (!aEnded && bEnded) return -1;
                const aStart = normalizeTS(a.StartTS) || 0;
                const bStart = normalizeTS(b.StartTS) || 0;
                return bStart - aStart;
            });

            // Determine pulse color
            for (const proc of patient.Procedures) {
                const startTS = normalizeTS(proc.StartTS);
                const endTS = normalizeTS(proc.EndTS);
                if (!startTS) continue;
                const now = Math.floor(Date.now() / 1000);
                let diff = endTS ? (endTS - startTS) : (now - startTS);
                if (diff < 0) diff = 0;
                const limit = timeLimits[proc.ProcedureType] || null;

                if (!proc.EndTime && limit && diff > limit) {
                    pulseClass = 'pulse-red';
                    emoji = '😢';
                    break;
                }
                if (!proc.EndTime && !pulseClass) {
                    pulseClass = 'pulse-green';
                    emoji = '😊';
                }
            }

            html += `
      <div class="font-semibold rounded-2xl shadow-md hover:shadow-lg transition-all p-5 ${pulseClass}">
        <h2 class="text-[25px] font-bold text-gray-800 mb-1 flex items-center justify-between">
          Patient #${patient.PatientNumber}
          <span class="ml-3 text-5xl">${emoji}</span>
        </h2>
        <p class="text-lg text-gray-600 mb-4">
          Age Group: <span class="text-[20px]">${patient.AgeGroup}</span>
        </p>
        <div class="border-t border-gray-200 pt-2">
          <h3 class="font-semibold text-gray-700 mb-2 text-lg">Procedures:</h3>
          <ul class="text-lg text-gray-600 space-y-2 max-h-40 overflow-y-auto">
    `;

            patient.Procedures.forEach(proc => {
                const subProc = proc.SubProcedureType && proc.SubProcedureType !== 'N/A' ?
                    ` - ${proc.SubProcedureType}` : '';
                const endDisplay = proc.EndTime ? proc.EndTime :
                    `<span class='text-green-600 font-semibold'>Ongoing</span>`;
                const startTS = normalizeTS(proc.StartTS);
                const endTS = normalizeTS(proc.EndTS);
                const now = Math.floor(Date.now() / 1000);
                let diff = startTS ? (endTS ? (endTS - startTS) : (now - startTS)) : 0;
                if (diff < 0) diff = 0;

                html += `
        <li class="border-b border-gray-100 pb-1">
          <p><span class="text-[20px]">${proc.ProcedureType}</span>${subProc}</p>
          <p class="text-[20px] text-gray-500">
            Duration: ${proc.StartTime || '—'} → ${endDisplay}<br>
            <span class="italic">${proc.FullName}</span><br>
            <span class="text-blue-700 font-semibold timer text-[20px]"
                  data-start="${startTS ?? ''}"
                  data-end="${endTS ?? ''}"
                  data-type="${proc.ProcedureType}">
              ${formatHMS(diff)}${endTS ? ' (Done)' : ''}
            </span>
          </p>
        </li>`;
            });

            html += `</ul></div></div>`;
        });

        $('#tatDashboard').html(html);
        console.log("✅ Dashboard rendered at:", new Date().toLocaleTimeString());
    }

    // 🕓 Timer Updater
    function updateTimers() {
        const now = Math.floor(Date.now() / 1000);

        $('.timer').each(function() {
            const startTS = normalizeTS($(this).attr('data-start'));
            const endTS = normalizeTS($(this).attr('data-end'));
            const type = $(this).data('type');
            const card = $(this).closest('.rounded-2xl');

            if (!startTS) return;

            let diff;
            if (endTS && endTS > startTS) {
                diff = endTS - startTS; // Completed
            } else {
                diff = now - startTS; // Counting up
            }

            if (diff < 0) diff = 0;

            // Only update if changed to prevent flicker
            const newText = formatHMS(diff) + ((endTS && endTS > startTS) ? ' (Done)' : '');
            if ($(this).text() !== newText) {
                $(this).text(newText);
            }

            const limit = timeLimits[type] || null;
            if ((!endTS || endTS <= startTS) && limit) {
                if (diff > limit) {
                    card.removeClass('pulse-green').addClass('pulse-red');
                } else {
                    card.removeClass('pulse-red').addClass('pulse-green');
                }
            }
        });
    }

    // 🧮 Data Loader
    let dashboardData = [];

    function fetchData() {
        $.ajax({
            url: '../include/transaction.inc.php',
            method: 'POST',
            dataType: 'json',
            data: {
                data: JSON.stringify({
                    Action: 'LoadTATDashboard'
                })
            },
            success: function(response) {
                if (response.data) {
                    const newData = JSON.stringify(response.data);
                    if (newData !== JSON.stringify(dashboardData)) {
                        dashboardData = response.data;
                        renderDashboard(dashboardData);
                    }
                }
            },
            error: function(err) {
                console.error('❌ Fetch failed:', err);
            }
        });
    }

    // 🚀 Start everything
    fetchData();
    setInterval(fetchData, 30000);
    setInterval(updateTimers, 1000);
    </script>

</