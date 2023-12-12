$(document).ready(function () {
    getBarChartData();
});

function getBarChartData() {
    $.ajax({
        url: '/getChartData',
        method: 'GET',
        dataType: 'json',
        success: function (chartData) {
            console.log("Successfully Displayed Bar Graph");
           
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
        options: {
           
        },
    };
    

    new Chart(document.getElementById('myChart'), barChartConfig);
}
