<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAT Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* Pulsing Background Animations */
        @keyframes pulse-green {

            0%,
            100% {
                background-color: #dcfce7;
                box-shadow: 0 0 10px 5px rgba(34, 197, 94, 0.4);
            }

            50% {
                background-color: #bbf7d0;
                box-shadow: 0 0 10px 5px rgba(34, 197, 94, 0.6);
            }
        }

        @keyframes pulse-yellow {

            0%,
            100% {
                background-color: #fef9c3;
                box-shadow: 0 0 10px 5px rgba(234, 179, 8, 0.4);
            }

            50% {
                background-color: #fef08a;
                box-shadow: 0 0 10px 5px rgba(234, 179, 8, 0.6);
            }
        }

        @keyframes pulse-red {

            0%,
            100% {
                background-color: #fee2e2;
                box-shadow: 0 0 10px 5px rgba(239, 68, 68, 0.4);
            }

            50% {
                background-color: #fecaca;
                box-shadow: 0 0 10px 5px rgba(239, 68, 68, 0.6);
            }
        }

        @keyframes pulse-orange {

            0%,
            100% {
                background-color: #ffedd5;
                box-shadow: 0 0 10px 5px rgba(249, 115, 22, 0.4);
            }

            50% {
                background-color: #fed7aa;
                box-shadow: 0 0 10px 5px rgba(249, 115, 22, 0.6);
            }
        }

        .pulse-green {
            animation: pulse-green 1.5s infinite;
        }

        .pulse-yellow {
            animation: pulse-yellow 1.5s infinite;
        }

        .pulse-red {
            animation: pulse-red 1.5s infinite;
        }

        .pulse-orange {
            animation: pulse-orange 1.5s infinite;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="w-full fixed top-0 left-0 z-50 bg-white shadow-md">
        <h1 class="font-poppins italic text-3xl font-bold text-gray-800 text-center my-3">
            ER Turn Around Time Dashboard
        </h1>
    </div>

    <!-- Dashboard -->
    <div id="tatDashboard"
        class="mt-16 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl1:grid-cols-5 gap-10"></div>

    <!-- Floating Legend -->
    <div id="legend"
        class="fixed bottom-4 right-4 bg-white shadow-lg border border-gray-300 rounded-xl p-4 text-sm font-medium z-50 space-y-2">
        <h3 class="font-semibold text-gray-700 border-b pb-1 mb-1 text-base">Legend</h3>
        <div class="flex items-center space-x-2"><span
                class="w-4 h-4 rounded-full bg-green-400 animate-pulse"></span><span>Below 1h – Ongoing</span></div>
        <div class="flex items-center space-x-2"><span
                class="w-4 h-4 rounded-full bg-yellow-400 animate-pulse"></span><span>1–2h – Follow-up Labs</span></div>
        <div class="flex items-center space-x-2"><span
                class="w-4 h-4 rounded-full bg-red-400 animate-pulse"></span><span>2–4h – Warning (Disposition)</span>
        </div>
        <div class="flex items-center space-x-2"><span
                class="w-4 h-4 rounded-full bg-orange-400 animate-pulse"></span><span>4h+ – Needed Admission</span>
        </div>
    </div>

    <script>
        function formatHMS(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = Math.floor(seconds % 60);
            return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        function normalizeTS(raw) {
            if (!raw || raw === 'null' || raw === '') return null;
            const n = Number(raw);
            if (!isFinite(n)) return null;
            return n > 1e12 ? Math.floor(n / 1000) : Math.floor(n);
        }

        // Thresholds in seconds
        const thresholds = {
            green: 3600, // < 1 hour
            yellow: 7200, // 1–2 hours
            red: 14400 // 2–4 hours, >4h orange
        };

        function getPulseClass(diff) {
            if (diff < thresholds.green) return 'pulse-green';
            if (diff < thresholds.yellow) return 'pulse-yellow';
            if (diff < thresholds.red) return 'pulse-red';
            return 'pulse-orange';
        }

        function getStatusColorAndEmoji(diff) {
            if (diff < 3600) return ['pulse-green', '😊']; // < 1 hour
            if (diff < 7200) return ['pulse-yellow', '😐']; // 1–2 hours
            if (diff < 14400) return ['pulse-red', '😢']; // 2–4 hours
            return ['pulse-orange', '😭']; // 4+ hours
        }


        function renderDashboard(data) {
            let html = '';

            data.forEach(patient => {
                const triageProc = patient.Procedures.find(p => p.ProcedureType === "Triage");
                if (!triageProc) return; // Skip patients without triage

                // Identify Disposition or Transfer to Room
                const disposition = patient.Procedures.find(p => p.ProcedureType === "Disposition");
                const transfer = patient.Procedures.find(p => p.ProcedureType === "Transfer To Room");

                // If either has an EndTime, patient is done → exclude
                if ((disposition && disposition.EndTS) || (transfer && transfer.EndTS)) return;

                // Compute total stay since triage start
                const startTS = normalizeTS(triageProc.StartTS);
                const now = Math.floor(Date.now() / 1000);
                const diff = now - startTS;

                // Get pulse + emoji based on total stay
                const [pulseClass, emoji] = getStatusColorAndEmoji(diff);

                html += `
      <div class="font-semibold rounded-2xl shadow-md hover:shadow-lg transition-all p-5 ${pulseClass}">
        <h2 class="text-[25px] font-bold text-gray-800 mb-1 flex items-center justify-between">
          Patient #${patient.PatientNumber}
          <span class="ml-3 text-5xl">${emoji}</span>
        </h2>
        <p class="text-lg text-gray-600 mb-4">Age Group: <span class="text-[20px]">${patient.AgeGroup}</span></p>
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
                    let duration = startTS ? (endTS ? endTS - startTS : now - startTS) : 0;
                    if (duration < 0) duration = 0;

                    html += `
        <li class="border-b border-gray-100 pb-1">
          <p><span class="text-[20px]">${proc.ProcedureType}</span>${subProc}</p>
          <p class="text-[20px] text-gray-500">
            Duration: ${proc.StartTime || '—'} → ${endDisplay}<br>
            <span class="italic">${proc.FullName}</span><br>
            <span class="text-blue-700 font-semibold timer text-[20px]"
                  data-start="${startTS ?? ''}" data-end="${endTS ?? ''}">
              ${formatHMS(duration)}${endTS ? ' (Done)' : ''}
            </span>
          </p>
        </li>`;
                });

                html += `
          </ul>
          <div class="mt-3 text-center font-semibold text-gray-700">
            Total Stay: <span class="text-blue-800 text-xl">${formatHMS(diff)}</span>
          </div>
        </div>
      </div>`;
            });

            // If no patients left
            if (html === '') {
                html = `<div class="text-center text-gray-500 text-xl col-span-full">
              ✅ All patients have been disposed or transferred.
            </div>`;
            }

            $('#tatDashboard').html(html);
        }



        function updateTimers() {
            const now = Math.floor(Date.now() / 1000);

            $('.timer').each(function() {
                const startTS = normalizeTS($(this).attr('data-start'));
                const endTS = normalizeTS($(this).attr('data-end'));
                const card = $(this).closest('.rounded-2xl');
                if (!startTS) return;

                let diff = endTS ? (endTS - startTS) : (now - startTS);
                if (diff < 0) diff = 0;

                const newText = formatHMS(diff) + (endTS ? ' (Done)' : '');
                if ($(this).text() !== newText) $(this).text(newText);

                if (!endTS) {
                    const pulseClass = getPulseClass(diff);
                    card.removeClass('pulse-green pulse-yellow pulse-red pulse-orange').addClass(pulseClass);
                }
            });
        }

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
                error: err => console.error('❌ Fetch failed:', err)
            });
        }

        fetchData();
        setInterval(fetchData, 30000);
        setInterval(updateTimers, 1000);
    </script>
</body>

</html>