google.charts.load("current", {
	packages: ["corechart"]
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/TotalTransfersByBiller?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) {
			var billerTransferTotals = [
				['Biller', 'Transfers']
			];

			for (i = 0; i < data.length; i++) {
				billerTransferTotals.push([data[i].BillerName, data[i].Total]);
			}

			var billerTransferTotalsData = google.visualization.arrayToDataTable(billerTransferTotals);

			var billerTransferTotalsOptions = {
				title: 'Total Transfers By Biller',
				titleTextStyle: {
					color: '#39444E',
					fontName: 'Helvetica',
					fontSize: 12,
					bold: true
				},
				pieHole: 0.4,
			};

			var billerTransferTotalsChart = new google.visualization.PieChart(document.getElementById('billerTransferTotalsChart'));
			billerTransferTotalsChart.draw(billerTransferTotalsData, billerTransferTotalsOptions);
		}
	});

	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/TotalFundsTransferedByBiller?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) {
			var billerTransferFundsTotals = [
				['Biller', 'Transfers']
			];

			for (i = 0; i < data.length; i++) {
				billerTransferFundsTotals.push([data[i].BillerName, data[i].Total]);
			}

			var billerTransferFundsTotalsData = google.visualization.arrayToDataTable(billerTransferFundsTotals);

			var billerTransferFundsTotalsOptions = {
				title: 'Total Funds Transferred By Biller',
				titleTextStyle: {
					color: '#39444E',
					fontName: 'Helvetica',
					fontSize: 12,
					bold: true
				},
				pieHole: 0.4,
			};

			var billerTransferFundsTotalsChart = new google.visualization.PieChart(document.getElementById('billerTransferFundsTotalsChart'));
			billerTransferFundsTotalsChart.draw(billerTransferFundsTotalsData, billerTransferFundsTotalsOptions);
		}
	});

	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/TotalBillerTransfersByYear?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) {
			console.log(data);
			var billerTransferTotalsByYearTotals = [];

			var billerTransferTotalsByYearHeaders = ['Year'];
			for (i = 0; i < data.length; i++) {
				billerTransferTotalsByYearHeaders.push(data[i].BillerName);
			}
			
			//FUNCTION TO REMOVE DUPLICATE NAMES IN ARRAY
			function removeDuplicateUsingFilter(arr){
				let unique_array = arr.filter(function(elem, index, self) {
					return index == self.indexOf(elem);
				});
				return unique_array
			}
			
			console.log(removeDuplicateUsingFilter(billerTransferTotalsByYearHeaders));
			billerTransferTotalsByYearHeaders = removeDuplicateUsingFilter(billerTransferTotalsByYearHeaders);

			billerTransferTotalsByYearTotals.push(billerTransferTotalsByYearHeaders);

			var firstYear = "" + data[0].Year + "";
			var years = [firstYear];
			for (i = 0; i < data.length; i++) {
				if (!years.includes("" + data[i].Year + "")) {
					years.push("" + data[i].Year + "");
				}
			}

			for (i = 0; i < years.length; i++) {
				var yearRow = [years[i]];
				for (r = 0; r < data.length; r++) {
					if (data[r].Year == years[i]) {
						yearRow.push(data[r].Total);
					}
				}

				while (yearRow.length < billerTransferTotalsByYearHeaders.length) { //make header and year row columns same length, fill undefined columns with 0
					yearRow.push(0);
				}

				billerTransferTotalsByYearTotals.push(yearRow);
			}

			console.log(billerTransferTotalsByYearTotals);

			var billerTransferTotalsByYearData = google.visualization.arrayToDataTable(billerTransferTotalsByYearTotals);

			var billerTransferTotalsByYearOptions = {
				title: 'Biller Transfers By Year',
				titleTextStyle: {
					color: '#39444E',
					fontName: 'Helvetica',
					fontSize: 12,
					bold: true
				},
				vAxis: {
					title: 'Transfers'
				},
				hAxis: {
					title: 'Years'
				},
				seriesType: 'bars',
				series: {
					5: {
						type: 'line'
					}
				}
			};

			//var billerTransferTotalsByYearChart = new google.visualization.ComboChart(document.getElementById('billerTransferTotalsByYearChart'));
			//billerTransferTotalsByYearChart.draw(billerTransferTotalsByYearData, billerTransferTotalsByYearOptions);
		}
	});

	/*
	var combodata = google.visualization.arrayToDataTable([
		['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
		['2004/05',  165,      938,         522,             998,           450,      614.6],
		['2005/06',  135,      1120,        599,             1268,          288,      682],
		['2006/07',  157,      1167,        587,             807,           397,      623],
		['2007/08',  139,      1110,        615,             968,           215,      609.4],
		['2008/09',  136,      691,         629,             1026,          366,      569.6]
	]);

	var combooptions = {
		title : 'Monthly Coffee Production by Country',
		vAxis: {title: 'Cups'},
		hAxis: {title: 'Month'},
		seriesType: 'bars',
		series: {5: {type: 'line'}}
    };


  
    var combochart = new google.visualization.ComboChart(document.getElementById('combochart'));
    combochart.draw(combodata, combooptions);
*/
}

$(function () {
	//GET TOTAL NUMBER OF TRANSFERS FOR TODAY
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	
	if(dd<10) { dd = '0'+dd } //add leading 0 to single digit days
	if(mm<10) { mm = '0'+mm } //add leading 0 to single digit months
	
	today = mm + '/' + dd + '/' + yyyy;

	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/TransferSummaryByDate?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715&transferDate="+today,
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) { 
			console.log(data);
			var transferCount = 0;
			if(data.BillerSummaries.length > 0){ 
				for(i=0;i<data.BillerSummaries.length;i++){
					console.log("Transfers Today" +data.BillerSummaries[i].BillerName);
					transferCount += data.BillerSummaries[i].TransferCount;
				}
			}

			$("<div></div>")
				.addClass("infoItem green")
				//.append(
				//	$("<a></a>")
				//	.attr("href", "https://cobadmin.azurewebsites.net/loggedin/summarydate.php")
					.append(
						$("<p></p>")
						.addClass("heading")
						.text("Today's Total Transactions"),
						$("<p></p/>")
						.addClass("data")
						.text(" "+transferCount)
					)
				//)
				.appendTo("#quickInfo");
		}
	});

	//GET TOTAL NUMBER OF TRANSFERS FOR CURRENT MONTH
	var d = new Date();
	var transferYear = d.getFullYear();
	var transferMonth =  d.getMonth() + 1;

	console.log(transferMonth+" "+transferYear);

	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/TransferSummaryByMonth?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715&transferYear="+transferYear+"&transferMonth="+transferMonth,
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) { 
			console.log(data);
			var transferCount = 0;
			if(data.BillerSummaries.length > 0){ 
				for(i=0;i<data.BillerSummaries.length;i++){
					console.log("Transfer By Month " +data.BillerSummaries[i].BillerName);
					transferCount += data.BillerSummaries[i].TransferCount;
				}
			}

			$("<div></div>")
				.addClass("infoItem blue")
				//.append(
				//	$("<a></a>")
				//	.attr("href", "https://cobadmin.azurewebsites.net/loggedin/summarymonth.php")
					.append(
						$("<p></p>")
						.addClass("heading")
						.text("This Month's Total Transactions"),
						$("<p></p/>")
						.addClass("data")
						.text(" "+transferCount)
					)
				//)
				.appendTo("#quickInfo");
		}
	});

	//GET TOTAL NUMBER OF PENDING REVIEWS 
	$.ajax({
		url: "https://e-solutionsgroup.com:8080/api/Account/PendingUsers",
		crossDomain: true,
		dataType: 'json',
		cache: false,
		contentType: "application/json; charset=utf-8",
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Authorization", "Bearer " + token);
		},
		success: function (data) {
			var count = 0;
			if(data.length > 0){ 
				count = data.length
			}

			$("<div></div>")
				.addClass("infoItem")
				//.append(
				//	$("<a></a>")
				//	.attr("href", "https://cobadmin.azurewebsites.net/loggedin/pendingreviews.php")
					.append(
						$("<p></p>")
						.addClass("heading")
						.text("Pending Reviews"),
						$("<p></p/>")
						.addClass("data")
						.text(" "+count)
					)
				//)
				.appendTo("#quickInfo");
		}
	});
});