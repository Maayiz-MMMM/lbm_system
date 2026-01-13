document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // SAFE CHART RENDER FUNCTION
    // =========================
    function renderChart(selector, options) {
        const el = document.querySelector(selector);
        if (!el) return; // IMPORTANT: stops "Element not found"
        new ApexCharts(el, options).render();
    }

    // =========================
    // CHART OPTIONS
    // =========================

    const optionsProfileVisit = {
        chart: { type: 'bar', height: 300 },
        series: [{
            name: 'sales',
            data: [9,20,30,20,10,20,30,20,10,20,30,20]
        }],
        xaxis: {
            categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
        }
    };

    const optionsVisitorsProfile = {
        chart: { type: 'donut' },
        series: [70, 30],
        labels: ['Male', 'Female']
    };

    const optionsEurope = {
        chart: { type: 'area', height: 80 },
        series: [{
            data: [310,800,600,430,540,340,605,805,430,540,340,605]
        }]
    };

    const optionsAmerica = { ...optionsEurope };
    const optionsIndonesia = { ...optionsEurope };

    // =========================
    // SAFE RENDER CALLS
    // =========================

    renderChart("#chart-profile-visit", optionsProfileVisit);
    renderChart("#chart-visitors-profile", optionsVisitorsProfile);
    renderChart("#chart-europe", optionsEurope);
    renderChart("#chart-america", optionsAmerica);
    renderChart("#chart-indonesia", optionsIndonesia);

});
