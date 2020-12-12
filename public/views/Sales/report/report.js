$(document).ready(function () {
	loadCharts();

	$("#date_range").daterangepicker(
		{
			locale: {
				format: "YYYY-MM-DD",
				separator: " - ",
				applyLabel: "Aplicar",
				cancelLabel: "Cancelar",
				fromLabel: "Desde",
				toLabel: "Hasta",
				customRangeLabel: "Personalizar",
				daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],

				monthNames: [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Agosto",
					"Setiembre",
					"Octubre",
					"Noviembre",
					"Diciembre",
				],
				firstDay: 1,
			},
			ranges: {
				Hoy: [moment(), moment()],
				Ayer: [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"Últimos 7 días": [moment().subtract(6, "days"), moment()],
				"Últimos 30 días": [moment().subtract(29, "days"), moment()],
				"Este mes": [moment().startOf("month"), moment().endOf("month")],
				"Último mes": [
					moment().subtract(1, "month").startOf("month"),
					moment().subtract(1, "month").endOf("month"),
				],
			},
			startDate: moment().subtract(29, "days"),
			endDate: moment(),
		},
		function (start, end) {
			$("#date_range span").html(
				start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD")
			);
			startDate = start.format("YYYY-MM-DD");
			endDate = end.format("YYYY-MM-DD");

			loadCharts(startDate, endDate);
		}
	);

	$("#date_range span").html(
		moment().subtract(29, "days").format("YYYY-MM-DD") +
			" - " +
			moment().format("YYYY-MM-DD")
	);

});

function loadCharts(startDate, endDate) {
	fetch(`./sale/reportData?startDate=${startDate}&endDate=${endDate}`)
		.then((res) => res.json())
		.then((response) => {
			if (response.error) {
				alert.errorAlert(response.message);
			} else {
				buildSaleMonthChart(response.data.SalesMonth);
				buildTopProductsChart(response.data.TopProducts);
				buildTopSellers(response.data.TopSellers);
			}
		})
		.catch((error) => alert.errorAlert(error));
}

function buildSaleMonthChart(SalesMonth = []) {
	$("#saleMonthChart").remove();
	$("#saleMonthChartContainer").append(
		'<canvas id="saleMonthChart" class="animated fadeIn"></canvas>'
	);
	var chart = document.getElementById("saleMonthChart").getContext("2d");

	new Chart(chart, {
		type: "line",

		data: {
			labels: SalesMonth.map((data) => getMonthName(data.Month)),
			datasets: [
				{
					label: "Ventas por mes",
					backgroundColor: "rgb(44, 159, 235)",
					borderColor: "rgb(44, 159, 235)",
					data: SalesMonth.map((data) => data.Total),
					fill: false,
				},
			],
		},

		options: {
			scales: {
				yAxes: [
					{
						ticks: {
							beginAtZero: true,
							userCallback: function (value, index, values) {
								return "$ " + $.number(value, 2);
							},
						},
					},
				],
			},
			tooltips: {
				callbacks: {
					label: function (t, d) {
						var xLabel = d.datasets[t.datasetIndex].label;
						var yLabel = "$ " + $.number(t.yLabel, 2);
						return xLabel + ": " + yLabel;
					},
				},
			},
		},
	});
}

function getMonthName(month) {
	var months = [
		"Enero",
		"Febrero",
		"Marzo",
		"Abril",
		"Mayo",
		"Junio",
		"Julio",
		"Agosto",
		"Septiembre",
		"Octubre",
		"Noviembre",
		"Diciembre",
	];
	return months[month - 1];
}

function buildTopProductsChart(TopProducts = []) {
	$("#topProductsChart").remove();
	$("#topProductsChartContainer").append(
		'<canvas id="topProductsChart" class="animated fadeIn"></canvas>'
	);
	var chart = document.getElementById("topProductsChart").getContext("2d");

	Chart.defaults.global.defaultFontSize = 18;
	chart = new Chart(chart, {
		type: "pie",
		data: {
			labels: TopProducts.map((data) => data.Description),
			datasets: [
				{
					data: TopProducts.map((data) => data.ProductQuantity),
					backgroundColor: [
						"#25CCF7",
						"#FD7272",
						"#54a0ff",
						"#00d2d3",
						"#1abc9c",
						"#2ecc71",
						"#3498db",
						"#9b59b6",
						"#34495e",
					],
					borderColor: "black",
					borderWidth: 2,
				},
			],
		},
		options: {
			responsive: true,

			legend: {
				position: "left",
			},
			animation: {
				animateRotate: false,
				animateScale: false,
			},
		},
	});
}

function buildTopSellers(TopSellers = []) {
	ranking = [];

	for (var i = 0; i < 3; i++) {
		if (i < TopSellers.length) {
			ranking[i] = cardRanking(
				i + 1,
				TopSellers[i].Name,
				TopSellers[i].photo || "public/img/profile.png"
			);
		} else {
			ranking[i] = cardRanking(i + 1, "?", "public/img/profile.png");
		}
	}
	$("#ranking").html("");
	$("#ranking").append(
		`<div class="row p-3">
			<div class="col">
				${ranking[0]}
			</div>
		</div>
		<div class="row p-3">
			<div class="col">
			${ranking[1]}
			</div>
			<div class="col">
			${ranking[2]}
			</div>
		</div>`
	);
}

function cardRanking(number, name, photoURL) {
	return `
	<div class="col">
		<span class="rounded-circle bg-primary position-absolute"><strong class="p-2">${number}</strong></span>
		<img src="${photoURL}" class='img-thumbnail' width='100' data-action='zoom'>
		<div class="card-body">
			<p class="card-text">${name}</p>
		</div>
	</div>`;
}
