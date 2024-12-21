// Sales & Purchase - Bar chart
const barctx = document.getElementById("barchart");

new Chart(barctx, {
  type: "bar",
  data: {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    datasets: [
      {
        label: "Sales",
        data: [12, 19, 3, 5, 2, 3, 4, 8, 7, 10, 6, 9], // Replace with database values
        backgroundColor: "rgba(129, 122, 243, 1)", // Custom color for Sales
        borderColor: "rgba(129, 122, 243, 1)",
        borderWidth: 1,
        barThickness: 15,
        borderRadius: 4,
      },
      {
        label: "Purchase",
        data: [15, 10, 8, 7, 6, 9, 12, 13, 14, 10, 11, 5], // Replace with database values
        backgroundColor: "rgba(87, 218, 101, 1)", // Custom color for Purchase
        borderColor: "rgba(87, 218, 101, 1)",
        borderWidth: 1,
        barThickness: 15,
        borderRadius: 4,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});
// Sales & Purchase - Bar chart

// Order Summary - Line chart
const lineCtx = document.getElementById("line-chart");

new Chart(lineCtx, {
  type: "line",
  data: {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    datasets: [
      {
        label: "Ordered",
        data: [50, 50, 70, 40, 80, 10, 0, 50, 40, 20, 30, 60], // Replace with database values
        borderColor: "rgb(173, 107, 32)", // Line color
        backgroundColor: "rgba(219, 163, 98, 1)", // Fill color under the line
        borderWidth: 2,
        tension: 0.4, // Smoothness of the line
        pointRadius: 5, // Size of data points
        pointBackgroundColor: "rgb(173, 107, 32)", // Point color
        fill: true, // Enable fill under the line
      },
      {
        label: "Delivered",
        data: [110, 140, 160, 130, 170, 200, 190, 240, 230, 210, 220, 250], // Replace with database values
        borderColor: "rgb(64, 121, 196)", // Line color
        backgroundColor: "rgba(182, 211, 250, 1)", // Fill color under the line
        borderWidth: 2,
        tension: 0.4,
        pointRadius: 5,
        pointBackgroundColor: "rgb(64, 121, 196)",
        fill: true, // Enable fill under the line
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: true, // Show legend
        position: "top", // Legend position
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Amount (£)", // Label for the Y-axis
        },
      },
    },
  },
});
// Order Summary - Line chart
