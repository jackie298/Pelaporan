    var ctxPie = document.getElementById("chart-status-dokumen");
    
    if (!ctxPie) return;
    
    // Parse JSON dari controller
    var statusData = JSON.parse('{!! $statuscountJson !!}');
    
    new Chart(ctxPie.getContext("2d"), {
        type: "pie",
        data: {
            labels: ["Open", "Close", "Pending", "Proses Finance", "Hold"],
            datasets: [{
                data: [
                    statusData.open || 0,
                    statusData.close || 0,
                    statusData.pending || 0,
                    statusData['proses finance'] || 0,
                    statusData.hold || 0
                ],
                backgroundColor: ["#11cdef", "#2dce89", "#fb6340", "#5e72e4", "#f5365c"],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });