let myChart;
function displayChartByMonth(data) {
    const months = Array.from({ length: 12 }, (_, i) => i + 1);
    const statusColors = {
        'Pending': '#d25b46',
        'Responding': '#d3cc3a',
        'Completed': '#84ec6a',
        'Que': 'rgb(224, 128, 17)',
    };

    const datasets = Array.from(new Set(data.map(item => item.status))).map(status => {
        const counts = months.map(month => {
            const match = data.find(item => item.month === month && item.status === status);
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
}

function displayChartByYear(data) {
    const years = Array.from(new Set(data.map(item => item.year)));
    const statusColors = {
        'Pending': '#d25b46',
        'Responding': '#d3cc3a',
        'Completed': '#84ec6a',
        'Unavailable': 'rgb(224, 128, 17)',
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
    return monthNames[month - 1];
}