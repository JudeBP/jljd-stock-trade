
// Sample chart for display only. Not responsive

let Returns = [ 6000, 7000, 6500, 6500, 9000, 9000, 10000 ]
let Earnings = [ 5000, 6000, 7500, 7500, 8500, 8500, 9000 ];

const days = ["Monday", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"];

new Chart("chart", {
  type: "line",
  data: {
    labels: days,
    datasets: [
      {
        label: 'Returns',
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(0,0,255,1.0)",
        borderColor: "rgba(0,0,255,0.3)",
        data: Returns
      },
      {
        label: 'Earnings',
        fill: false,
        lineTension: 0,
        backgroundColor: "rgba(255,0,0,1.0)",
        borderColor: "rgba(255,0,0,0.3)",
        data: Earnings
      }]
  },
  options: {
    legend: {
      display: true,
      position: 'top'
    },
    scales: {
      yAxes: [{ ticks: { min: 5000, max: 10000 } }],
    }
  }
});