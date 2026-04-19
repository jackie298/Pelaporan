// === 📊 STATUS DOKUMEN PIE CHART ===
var ctxPie = document.getElementById("chart-status-dokumen");

if (ctxPie) {
    // ✅ Ambil data dari controller
    var statusData = {!! json_encode($statuscount) !!};
    
    // ✅ Mapping status & warna
    var statusMapping = [
        { key: 'open', label: 'Open', color: '#11cdef' },
        { key: 'close', label: 'Close', color: '#2dce89' },
        { key: 'pending', label: 'Pending', color: '#fb6340' },
        { key: 'proses finance', label: 'Proses Finance', color: '#5e72e4' },
        { key: 'hold', label: 'Hold', color: '#f5365c' }
    ];
    
    // ✅ Filter hanya status yang punya data > 0
    var filteredData = [];
    var filteredLabels = [];
    var filteredColors = [];
    
    statusMapping.forEach(function(item) {
        var val = statusData[item.key];
        var value = (typeof val === 'number') ? val : 0;
        if (value > 0) {
            filteredLabels.push(item.label);
            filteredData.push(value);
            filteredColors.push(item.color);
        }
    });
    
    // ✅ Fallback jika semua 0
    if (filteredData.length === 0) {
        filteredLabels = ['Belum Ada Data'];
        filteredData = [1];
        filteredColors = ['#e9ecef'];
    }
    
    // ✅ INIT CHART
    new Chart(ctxPie.getContext("2d"), {
        type: "pie",
        data: {  // 🟢 KEY INI WAJIB ADA!
            labels: filteredLabels,
            datasets: [{
                data: filteredData, // 🟢 Explicit key "data:"
                backgroundColor: filteredColors,
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(33, 37, 41, 0.9)',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.parsed || 0;
                            var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                            var percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
    
    console.log('✅ Pie chart berhasil di-render!');
}