$(document).ready(function () {
  getPieChartData();
});

function getPieChartData() {
  $.ajax({
      url: '/getPieData',
      method: 'GET',
      dataType: 'json',
      success: function (chartData) {
          console.log("Successfully Displayed Pie Chart");
         
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
      responsive: true, 
      maintainAspectRatio: false,
    },
  };

  new Chart(document.getElementById('PieChart'), pieChartConfig);
}


  
