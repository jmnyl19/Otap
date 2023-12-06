
$(document).ready(function () {
    pieChart()
});

const pieChartdata = {
    labels: [
      'Ambulance',
      'Fire Truck',
      'BPSO'
    ],
    datasets: [{
      label: 'Total Incidents',
      data: [300, 50, 100],
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 205, 86)',
        'rgb(54, 162, 235)'
      ],
      hoverOffset: 4
    }]
  };

function pieChart() {
    new Chart(
        document.getElementById('lineChart'),
        {
            type: 'doughnut',
            data: pieChartdata,
          }
      );
}  

  
