<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Canvas JS -->
<script src="{{ URL::asset('assets/js/canvasjs-1.7.0/jquery.canvasjs.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        // Get chart data from server
        $.get("{{ URL::to('/ajax/chart-traffic-data') }}", function( data ) {
            var chart_data = JSON.parse(data);
            console.log(chart_data);
            for(var i=0;i<chart_data.length;i++) {
                chart_data[i].x = new Date(chart_data[i].x);
            }

            // Better to construct options first and then pass it as a parameter
            var options = {
                title: {
                    text: "Spline Chart using jQuery Plugin"
                },
                axisX:{
                    title: "timeline",
                    gridThickness: 2
                },
                axisY: {
                    title: "Balance"
                },
                animationEnabled: true,
                data: [
                    {
                        type: "area", //change it to line, area, column, pie, etc
                        dataPoints: chart_data
                    }
                ]
            };

            $("#chartContainer").CanvasJSChart(options);
        });
    });
</script>
