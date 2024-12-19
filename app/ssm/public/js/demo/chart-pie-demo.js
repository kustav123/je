
    // Extracting the PHP variables and converting them to JavaScript variables

    // Retrieving the values from the HTML elements by their IDs
    var openJobs = document.getElementById("openJobs").innerText;
    var assignedJobs = document.getElementById("assignedJobs").innerText;
    var holdJobs = document.getElementById("holdJobs").innerText;
    var pendingJobs = document.getElementById("pendingJobs").innerText;
    var readyJobs = document.getElementById("ready").innerText;


    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.font.family = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.color = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Open", "Assigned", "Hold", "Pending", "Ready"],
            datasets: [{
                data: [openJobs, assignedJobs, holdJobs, pendingJobs,readyJobs],
                backgroundColor: ['#FF1493', '#1cc88a', '#36b9cc', '#f6c23e', '#0a0a0a'],
                hoverBackgroundColor: ['#FC8EAC', '#17a673', '#2c9faf', '#f4b619', '#858796'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
            },
            legend: {
                display: false
            },
            cutout: '80%',
        },
    });

