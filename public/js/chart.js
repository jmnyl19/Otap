let PieChart;

    function displayChartByMonth1(data) {
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
        renderChart1(months, datasets);
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
                label: type,
                data: counts,
                fill: false, 
                borderColor: statusColors[type],
            };
        });
        renderChart1(years, datasets);
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
        // Call the updateChart function initially
        updateChart1();
    });

function monthToMonthName(month) {
  const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  return monthNames[month - 1];
}