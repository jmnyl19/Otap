let PieChart;
let typeData;

function mapTypeToLabel(type) {
    const typeMappings = {
        'Requesting for Ambulance': 'Requesting for Ambulance',
        'Requesting for a Barangay Public Safety Officer': 'Requesting for a Barangay Peacekeeping Action Team',
        'Requesting for a Fire Truck': 'Requesting for a Fire Truck',
    };
    return typeMappings[type] || type; 
}
    function displayChartByMonth1(data) {
        const months = Array.from({ length: 12 }, (_, i) => monthToMonthName(i + 1));
        const statusColors = {
            'Requesting for Ambulance' : 'rgb(255, 99, 132)',
            'Requesting for a Barangay Public Safety Officer': 'rgb(54, 162, 235)',
            'Requesting for a Fire Truck':'rgb(255, 132, 0)',
        };

        const datasets = Array.from(new Set(data.map(item => item.type))).map(type => {
            const counts = months.map(month => {
                const match = data.find(item => item.month === monthToMonthNumber(month) && item.type === type);
                return match ? match.count : 0;
            });

            return {
                label: mapTypeToLabel(type),
                data: counts,
                fill: false, 
                borderColor: statusColors[type],
            };
        });
        renderChart1(months, datasets);
        typeData = { labels: months, datasets: datasets };

    }   
    function displayChartByYear1(data) {
        const years = Array.from(new Set(data.map(item => item.year)));
        const statusColors = {
            'Requesting for Ambulance' : 'rgb(255, 99, 132)',
            'Requesting for a Barangay Public Safety Officer': 'rgb(54, 162, 235)',
            'Requesting for a Fire Truck':'rgb(255, 132, 0)',
        };

        const datasets = Array.from(new Set(data.map(item => item.type))).map(type => {
            const counts = years.map(year => {
                const match = data.find(item => item.year === year && item.type === type);
                return match ? match.count : 0;
            });

            return {
                label: mapTypeToLabel(type),
                data: counts,
                fill: false, 
                borderColor: statusColors[type],
            };
        });
        renderChart1(years, datasets);
        typeData = { labels: years, datasets: datasets };

    } 

    function renderChart1(labels, datasets) {
        if (PieChart) {
            PieChart.destroy();
        }
     
        var ctx = document.getElementById('PieChart').getContext('2d');
        PieChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: datasets,
              },
              options: {
                  
              },
          });
        }
    function updateChart1() {
        const selectedFilter = document.getElementById('pieFilter').value;
        fetch('/getPieData')
        .then(response => response.json())
        .then(data => {
            if (selectedFilter === 'month') {
                displayChartByMonth1(data);
            } else if (selectedFilter === 'year') {
                displayChartByYear1(data);
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    }
    document.addEventListener("DOMContentLoaded", function () {
        updateChart1();
    });

function monthToMonthName(month) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    if (Array.isArray(month)) {
        return month.map(m => monthNames[m - 1]);
    } else {
        return monthNames[month - 1];
    }}

function monthToMonthNumber(monthName) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return monthNames.indexOf(monthName) + 1;
}

function downloadtypeChart() {
    var canvas = document.getElementById('PieChart');
    var anchor = document.createElement('a');
    anchor.href = canvas.toDataURL('image/png');
    anchor.download = 'chart for type of incident.png';
    anchor.click();
}

window.printtypeChart = function () {
    var canvas = document.getElementById('PieChart');

    // Open a new window and append the canvas
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write('<div style="text-align: center;">');
    printWindow.document.write('<canvas id="printCanvas1" style="max-width: 100%;" width="' + canvas.width + '" height="' + canvas.height + '"></canvas>');
    printWindow.document.write('</div></body></html>');
    printWindow.document.close();

    // Get the canvas element in the print window
    var printCanvas1 = printWindow.document.getElementById('printCanvas1');
    var printContext = printCanvas1.getContext('2d');

    // Copy the content of the original canvas to the print canvas
    printContext.drawImage(canvas, 0, 0);

    // Wait for the image to load, then trigger the print dialog
    printWindow.onload = function () {
        printWindow.print();
    };
};

function exportTypeToExcel() {
    const worksheet = XLSX.utils.aoa_to_sheet([['Type of Request', ...typeData.labels], ...typeData.datasets.map(dataset => [dataset.label, ...dataset.data])]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Chart Data');
    XLSX.writeFile(workbook, 'emergency_count.xlsx');
}