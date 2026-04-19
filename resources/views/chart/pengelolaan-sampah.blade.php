    console.log('📊 Initializing Waste Chart...');
    
    var ctxRencana = document.getElementById("chart-pengelolaan-sampah");
    
    if (!ctxRencana) {
        console.error('❌ Canvas element "chart-pengelolaan-sampah" not found!');
        return;
    }
    
    console.log('✅ Canvas found');
    console.log('Data Kantor:', {!! json_encode($wasteKantorValues) !!});
    console.log('Data Site:', {!! json_encode($wasteSiteValues) !!});
    
    var ctx = ctxRencana.getContext("2d");
    
    // Destroy existing chart if any
    if (window.wasteChartInstance) {
        window.wasteChartInstance.destroy();
    }
    
    // Gradient Area Kantor
    var gradientKantor = ctx.createLinearGradient(0, 0, 0, 250);
    gradientKantor.addColorStop(0, 'rgba(18, 203, 137, 0.6)');
    gradientKantor.addColorStop(1, 'rgba(18, 203, 137, 0.05)');

    // Gradient Area Site
    var gradientSite = ctx.createLinearGradient(0, 0, 0, 250);
    gradientSite.addColorStop(0, 'rgba(23, 193, 232, 0.6)');
    gradientSite.addColorStop(1, 'rgba(23, 193, 232, 0.05)');

    window.wasteChartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: {!! json_encode($monthsFull) !!},
            datasets: [
                {
                    label: "Area Kantor",
                    data: {!! json_encode($wasteKantorValues) !!},
                    borderColor: "#12cb89",
                    backgroundColor: gradientKantor,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#12cb89",
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: "Area Site",
                    data: {!! json_encode($wasteSiteValues) !!},
                    borderColor: "#17c1e8",
                    backgroundColor: gradientSite,
                    borderDash: [6, 4],
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#17c1e8",
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: { 
                legend: { 
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(33, 37, 41, 0.9)',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let value = context.parsed.y;
                            return context.dataset.label + ': ' + 
                                new Intl.NumberFormat('id-ID').format(value) + ' kg';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID') + ' kg';
                        },
                        font: { size: 11 }
                    }
                },
                x: { 
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            }
        }
    });
    
    console.log('✅ Chart initialized successfully!');