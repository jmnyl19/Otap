document.addEventListener("DOMContentLoaded", function () {
    fetch('/getChartData')
        .then(response => response.json())
        .then(data => {
           
            const months = Array.from({ length: 12 }, (_, i) => i + 1);
            const statusColors = {
                'Pending': '#d25b46',
                'Responding': '#d3cc3a',
                'Completed': '#84ec6a',
                'Unavailable': 'rgb(224, 128, 17)',
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

            
            var ctx = document.getElementById('myChart').getContext('2d');
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