let myChart;
let chartData;

function displayChartByMonth(data) {
    const months = Array.from({ length: 12 }, (_, i) => monthToMonthName(i + 1));
    const statusColors = {
        'Pending': '#d25b46',
        'Responding': '#d3cc3a',
        'Completed': '#84ec6a',
        'Que': 'rgb(224, 128, 17)',
    };

    const datasets = Array.from(new Set(data.map(item => item.status))).map(status => {
        const counts = months.map(month => {
            const match = data.find(item => item.month === monthToMonthNumber(month) && item.status === status);
            return match ? match.count : 0;
        });

        return {
            label: status,
            data: counts,
            fill: false,
            borderColor: statusColors[status],
        };
    });

    renderChart(months, datasets);
    chartData = { labels: months, datasets: datasets };
}

function displayChartByYear(data) {
    const years = Array.from(new Set(data.map(item => item.year)));
    const statusColors = {
        'Pending': '#d25b46',
        'Responding': '#d3cc3a',
        'Completed': '#84ec6a',
        'Que': 'rgb(224, 128, 17)',
    };

    const datasets = Array.from(new Set(data.map(item => item.status))).map(status => {
        const counts = years.map(year => {
            const match = data.find(item => item.year === year && item.status === status);
            return match ? match.count : 0;
        });

        return {
            label: status,
            data: counts,
            fill: false,
            borderColor: statusColors[status],
        };
    });

    renderChart(years, datasets);
    chartData = { labels: years, datasets: datasets };
}

function renderChart(labels, datasets) {
    if (myChart) {
        myChart.destroy();
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    myChart  = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            
        },
    });
}

function updateChart() {
    const selectedFilter = document.getElementById('dateFilter').value;

    fetch('/getChartData')
        .then(response => response.json())
        .then(data => {
            if (selectedFilter === 'month') {
                displayChartByMonth(data);
            } else if (selectedFilter === 'year') {
                displayChartByYear(data);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

document.addEventListener("DOMContentLoaded", function () {
    updateChart();
});

function monthToMonthName(month) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    if (Array.isArray(month)) {
        return month.map(m => monthNames[m - 1]);
    } else {
        return monthNames[month - 1];
    }
}
function monthToMonthNumber(monthName) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return monthNames.indexOf(monthName) + 1;
}

function downloadChart() {
    var canvas = document.getElementById('myChart');
    var anchor = document.createElement('a');
    anchor.href = canvas.toDataURL('image/png');
    anchor.download = 'chart.png';
    anchor.click();
}

window.printChart = function () {
    var canvas = document.getElementById('myChart');

    // Open a new window and append the canvas
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write('<div style="text-align: center;">');
    printWindow.document.write('<canvas id="printCanvas" style="max-width: 100%;" width="' + canvas.width + '" height="' + canvas.height + '"></canvas>');
    printWindow.document.write('</div></body></html>');
    printWindow.document.close();

    // Get the canvas element in the print window
    var printCanvas = printWindow.document.getElementById('printCanvas');
    var printContext = printCanvas.getContext('2d');

    // Copy the content of the original canvas to the print canvas
    printContext.drawImage(canvas, 0, 0);

    // Wait for the image to load, then trigger the print dialog
    printWindow.onload = function () {
        printWindow.print();
    };
};

function exportToExcel() {
    const worksheet = XLSX.utils.aoa_to_sheet([['Incident Status', ...chartData.labels], ...chartData.datasets.map(dataset => [dataset.label, ...dataset.data])]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Chart Data');
    XLSX.writeFile(workbook, 'emergency_status.xlsx');
}