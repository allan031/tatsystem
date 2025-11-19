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

    <!-- Floating Legend Wrapper -->
    <div class="fixed bottom-4 right-4 z-50 group">

        <!-- Floating Icon -->
        <div
            class="w-12 h-12  text-white rounded-full flex items-center justify-center shadow-xl cursor-pointer hover:bg-blue-700 transition">
            ℹ️
        </div>

        <!-- Legend Panel (hidden by default, appears on hover) -->
        <div
            class="absolute bottom-14 right-0 w-60 bg-white shadow-lg border border-gray-300 rounded-xl p-4 text-sm font-medium 
               opacity-0 scale-90 pointer-events-none transform transition-all duration-300 
               group-hover:opacity-100 group-hover:scale-100 group-hover:pointer-events-auto">

            <h3 class="font-semibold text-gray-700 border-b pb-1 mb-2 text-base">Legend</h3>

            <div class="flex items-center space-x-2 mb-1">
                <span class="w-4 h-4 rounded-full bg-green-400 animate-pulse"></span>
                <span>Below 1h – Ongoing</span>
            </div>

            <div class="flex items-center space-x-2 mb-1">
                <span class="w-4 h-4 rounded-full bg-yellow-400 animate-pulse"></span>
                <span>1–2h – Follow-up Labs</span>
            </div>

            <div class="flex items-center space-x-2 mb-1">
                <span class="w-4 h-4 rounded-full bg-red-400 animate-pulse"></span>
                <span>2–4h – Warning (Disposition)</span>
            </div>

            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 rounded-full bg-orange-400 animate-pulse"></span>
                <span>4h+ – Needed Admission</span>
            </div>
        </div>
    </div>


    <script>
        /* ---------- Utilities ---------- */

        // Format seconds to HH:MM:SS
        function formatHMS(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = seconds % 60;
            return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        // Normalize timestamps (string/number → unix seconds)
        function normalizeTS(raw) {
            if (raw === null || raw === undefined) return null;
            if (raw === "null" || raw === "") return null;

            const n = Number(raw);
            if (!isFinite(n)) return null;

            // Convert ms → sec
            return n > 1e12 ? Math.floor(n / 1000) : n;
        }

        // Color thresholds in seconds
        const thresholds = {
            green: 3600, // <1h
            yellow: 7200, // <2h
            red: 14400 // <4h
        };

        function getStatusColorAndEmoji(diff) {
            if (diff < thresholds.green) return ["pulse-green", "😊"];
            if (diff < thresholds.yellow) return ["pulse-yellow", "😐"];
            if (diff < thresholds.red) return ["pulse-red", "😢"];
            return ["pulse-orange", "😭"];
        }

        /* ---------- Main Renderer ---------- */

        function renderDashboard(data) {
            let html = "";

            data.forEach(patient => {
                const triageProc = patient.Procedures.find(p => p.ProcedureType === "Triage");
                if (!triageProc) return;

                const triageStartTS = normalizeTS(triageProc.StartTS);

                // Debug: Show triage timestamps coming from PHP
                console.log("Patient", patient.PatientNumber, "Triage StartTS =", triageProc.StartTS);

                if (!triageStartTS) {
                    console.warn("❌ Missing or invalid Triage StartTS for patient:", patient);
                }

                const now = Math.floor(Date.now() / 1000);
                const diff = now - triageStartTS;

                const [pulseClass, emoji] = getStatusColorAndEmoji(diff);

                const patientID = patient.ExtractedRemarks?.trim() || patient.PatientNumber;

                html += `
            <div class="font-semibold rounded-2xl shadow-md hover:shadow-lg transition-all p-5 ${pulseClass}"
                 data-triage-start="${triageStartTS}">
                 
                <h2 class="text-[25px] font-bold flex justify-between">
                    Patient #${patientID}
                    <span class="text-5xl emoji">${emoji}</span>
                </h2>

                <p class="text-lg text-gray-600 mb-4">
                    Age Group: <span class="text-[20px]">${patient.AgeGroup}</span>
                </p>

                <div class="border-t border-gray-200 pt-2">
                    <h3 class="font-semibold text-lg mb-2">Procedures:</h3>
                    <ul class="text-lg text-gray-600 space-y-2 max-h-40 overflow-y-auto">
        `;

                patient.Procedures.forEach(proc => {
                    const startTS = normalizeTS(proc.StartTS);
                    const endTS = normalizeTS(proc.EndTS);
                    const now2 = Math.floor(Date.now() / 1000);

                    let duration = startTS ? (endTS ? endTS - startTS : now2 - startTS) : 0;
                    if (duration < 0) duration = 0;

                    html += `
                <li class="border-b pb-1">
                    <p class="text-[20px]">${proc.Department}</p>
                    <p class="text-[20px]">${proc.ProcedureType} - ${proc.SubProcedureType}</p>
                    <p class="text-gray-500 text-[20px]">
                        Duration: ${proc.StartTime || '—'} → ${proc.EndTime || '<span class="text-green-600">Ongoing</span>'}<br>
                        <span class="italic">${proc.FullName}</span><br>
                        <span class="timer text-blue-700 font-semibold text-[20px]"
                              data-start="${startTS}" data-end="${endTS}">
                            ${formatHMS(duration)}${endTS ? ' (Done)' : ''}
                        </span>
                    </p>
                </li>`;
                });

                html += `
                    </ul>

                    <div class="mt-3 text-center font-semibold text-gray-700">
                        Total Stay:
                        <span class="total-stay text-blue-800 text-xl">${formatHMS(diff)}</span>
                    </div>

                </div>
            </div>`;
            });

            if (html === "") {
                html = `
            <div class="text-center text-gray-500 text-xl col-span-full">
                ✅ All patients discharged or admitted
            </div>
        `;
            }

            $("#tatDashboard").html(html);

            // Debug: show all cards and timestamps
            document.querySelectorAll("[data-triage-start]").forEach(el => {
                console.log("Rendered card → triage-start:", el.getAttribute("data-triage-start"));
            });
        }

        /* ---------- Timers + Color Updates ---------- */

        function updateTimers() {
            const now = Math.floor(Date.now() / 1000);

            // Update all durations
            $(".timer").each(function() {
                const startTS = normalizeTS($(this).data("start"));
                const endTS = normalizeTS($(this).data("end"));

                if (!startTS) return;

                const diff = endTS ? endTS - startTS : now - startTS;
                $(this).text(formatHMS(diff) + (endTS ? " (Done)" : ""));
            });

            // Update card colors
            $(".rounded-2xl").each(function() {
                const triageStart = normalizeTS($(this).data("triage-start"));

                if (!triageStart) {
                    console.warn("⚠ Card missing triage-start attribute →", this);
                    return;
                }

                const diff = now - triageStart;
                const [colorClass, emoji] = getStatusColorAndEmoji(diff);

                $(this)
                    .removeClass("pulse-green pulse-yellow pulse-red pulse-orange")
                    .addClass(colorClass)
                    .find(".emoji").text(emoji);

                $(this).find(".total-stay").text(formatHMS(diff));
            });
        }

        /* ---------- AJAX Loader ---------- */

        let dashboardData = [];

        function fetchData() {
            $.ajax({
                url: "../include/transaction.inc.php",
                method: "POST",
                dataType: "json",
                data: {
                    data: JSON.stringify({
                        Action: "LoadTATDashboard"
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

                error: err => console.error("❌ Fetch error:", err)
            });
        }

        fetchData();
        setInterval(fetchData, 30000);
        setInterval(updateTimers, 1000);
    </script>

</body>

</html>