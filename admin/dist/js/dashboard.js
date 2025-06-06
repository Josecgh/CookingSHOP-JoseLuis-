const sales_chart_options = {
  series: [{
    name: "€ por dia",
    data: datosVentas,
  }],
  chart: {
    height: 300,
    type: "area",
    toolbar: {
      show: false,
    },
  },
  legend: {
    show: false,
  },
  colors: ["#0d6efd"],
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: "smooth",
  },
  xaxis: {
    type: "category",  // <- CAMBIO AQUÍ
    categories: labelVentas,
  },
};
const sales_chart = new ApexCharts(
  document.querySelector("#revenue-chart"),
  sales_chart_options,
);
sales_chart.render();