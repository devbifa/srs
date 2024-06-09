am4core.useTheme(am4themes_animated);

var chart = am4core.createFromConfig({
  "data": [{
    "country": "Lithuania",
    "litres": 4
  }, {
    "country": "Czech Republic",
    "litres": 2
  }, {
    "country": "Ireland",
    "litres": 2
  }, ],
  "legend": {},
  "labelRadius": -11,
  "innerRadius": "40%",
  "series": [{
    "type": "PieSeries3D",
    "dataFields": {
      "value": "litres",
      "category": "country"
    }
  }]
}, "chartdiv", "PieChart3D");
