$(document).ready(function () {
    getBarChartData();
});

function getBarChartData() {
    $.ajax({
        url: '/getChartData', // Replace with your actual route
        method: 'GET',
        dataType: 'json',
        success: function (chartData) {
            console.log(chartData.datasets);
           
            updateBarChart(chartData);
        },
        error: function (error) {
            console.error('Error fetching chart data:', error);
        }
    });
}

function updateBarChart(chartData) {


    const barChartConfig = {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets,
        },
        
    };
    

    new Chart(document.getElementById('myChart'), barChartConfig);
}
