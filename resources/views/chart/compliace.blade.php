// --- CHART 1: STATUS COMPLIANCE (KIRI) ---
const ctxStatusComp = document.getElementById('chart-status-compliance');
if (ctxStatusComp) {
    new Chart(ctxStatusComp.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Open', 'Pending', 'Resolved', 'Escalated'],
            datasets: [{
                data: [
                    {{ $complianceCounts['open'] ?? 0 }},
                    {{ $complianceCounts['pending'] ?? 0 }},
                    {{ $complianceCounts['resolved'] ?? 0 }},
                    {{ $complianceCounts['escalated'] ?? 0 }}
                ],
                // Open: Blue, Pending: Yellow, Resolved: Green, Escalated: Red
                backgroundColor: ['#11cdef', '#ffd400', '#2dce89', '#f5365c'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 20, bottom: 20, left: 10, right: 10 } },
            plugins: { legend: { display: false } },
            cutout: '70%',
            radius: '85%'
        }
    });
}

// --- CHART 2: TINGKAT KEPARAHAN / SEVERITY (KANAN) ---
const ctxSeverity = document.getElementById('chart-severity-compliance');
if (ctxSeverity) {
    new Chart(ctxSeverity.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Critical', 'High', 'Medium', 'Low'],
            datasets: [{
                data: [
                    {{ $severityStats['critical'] ?? 0 }},
                    {{ $severityStats['high'] ?? 0 }},
                    {{ $severityStats['medium'] ?? 0 }},
                    {{ $severityStats['low'] ?? 0 }}
                ],
                // Warna berdasarkan tingkat bahaya
                backgroundColor: ['#f5365c', '#fb6340', '#11cdef', '#adb5bd'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 20, bottom: 20, left: 10, right: 10 } },
            plugins: { legend: { display: false } },
            cutout: '70%',
            radius: '85%'
        }
    });
}