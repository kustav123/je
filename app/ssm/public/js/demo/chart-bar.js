    // Sample data for the chart
    const topDueClientsData = document.getElementById('topDueClients').getAttribute('data-top-due-clients');
    
    const topDueClients = JSON.parse(topDueClientsData);
console.log(topDueClients); // Check the output

// Extract labels and data
const labels = topDueClients.map(client => client.name);
const dataValues = topDueClients.map(client => client.due_ammount);

// Chart data configuration
const data = {
    labels: labels,
    datasets: [{
        label: 'Due Amount (in ₹)',
        data: dataValues, // Y-axis values
        backgroundColor: [
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
    }]
};

// Configuration options for the chart
const config = {
    type: 'bar', // Bar chart type
    data: data,
    options: {
        scales: {
            x: {
                display: false // Hide X-axis labels
            },
            y: {
                beginAtZero: true // Start Y-axis from 0
            }
        },
        plugins: {
            datalabels: {
                color: 'black', // Text color inside the bar
                anchor: 'end',  // Positioning of the text inside the bar
                align: 'start', // Align text at the start of the bar (inside)
                rotation: 90,   // Rotate text vertically
                formatter: function(value, context) {
                    if (value > 0) {
                        return context.chart.data.labels[context.dataIndex]; // Show the label (client name) only if value is not 0
                    }
                    return ''; // Return empty if value is 0
                }
            }
        }
    },
    plugins: [ChartDataLabels] // Activate the datalabels plugin
};

// Render the chart in the canvas
const myBarChart = new Chart(
    document.getElementById('myBarChart'),
    config
);