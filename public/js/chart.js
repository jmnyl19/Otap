document.addEventListener("DOMContentLoaded", function () {
  fetch('/getPieData')
      .then(response => response.json())
      .then(data => {
         
          const months = Array.from({ length: 12 }, (_, i) => i + 1);
          const statusColors = {
              'Requesting for Ambulance' : 'rgb(255, 99, 132)',
              'Requesting for a Barangay Public Safety Officer': 'rgb(54, 162, 235)',
              'Requesting for a Fire Truck':'rgb(255, 132, 0)',
          };

          const datasets = Array.from(new Set(data.map(item => item.type))).map(type => {
              const counts = months.map(month => {
                  const match = data.find(item => item.month === month && item.type === type);
                  return match ? match.count : 0;
              });

              return {
                  label: type,
                  data: counts,
                  fill: false, 
                   borderColor: statusColors[type],
              };
          });

          
          var ctx = document.getElementById('PieChart').getContext('2d');
          var chart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: months.map(month => monthToMonthName(month)),
                  datasets: datasets,
              },
              options: {
                  
              },
          });
      })
      .catch(error => console.error('Error fetching data:', error));
});

function monthToMonthName(month) {
  const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  return monthNames[month - 1];
}



