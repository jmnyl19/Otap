$(document).ready(function () {
  getPieChartData();
});

function getPieChartData() {
  $.ajax({
      url: '/getPieData', // Replace with your actual route
      method: 'GET',
      dataType: 'json',
      success: function (chartData) {
          console.log(chartData.labels);
         
          updatePieChart(chartData);
      },
      error: function (error) {
          console.error('Error fetching chart data:', error);
      }
  });
}

function updatePieChart(chartData) {
  const pieChartConfig = {
    type: 'pie',
    data: {
      labels: chartData.labels,
      datasets: chartData.datasets,
    },
    options: {
      responsive: true, // This allows the chart to be responsive
      maintainAspectRatio: false,
    },
  };

  new Chart(document.getElementById('PieChart'), pieChartConfig);
}


  
