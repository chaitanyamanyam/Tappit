//console.log(user_data);

/*var start = 1414071900000; //10/23/2014 9:45:00
var end = 1418136300000;

var start_dates = [];
var end_dates = [];

for (var i = 0; i < 50; i++) {
    var date = start + (end-start)*Math.random();
    start_dates.push(Math.round(date));
}

for (var i = 0; i < start_dates.length; i++) {
    var end_date = Math.round(start_dates[i]+(7800000*Math.random()));
    console.log(start_dates[i],end_date);
}*/

//d3.csv("ndx.csv", function(data) {
    d3.csv("ndx2.csv", function(user_data) {
        var dateFormat = d3.time.format("%m/%d/%Y");
        var numberFormat = d3.format(".2f");
        
        user_data.forEach(function (d) {
            d.dedicated_time = d.stop_task-d.start_task; // time spent on this project/activity
            d.start_task = new Date(+d.start_task);
            d.stop_task = new Date(+d.stop_task);
            d.month = d3.time.month(d.start_task); // pre-calculate month for better performance
            d.day = d3.time.day(d.start_task); // pre-calculate day for better performance
            d.estimated_time = +d.estimated_time; // coerce to number
        });
        console.log(user_data);

        var user_data_cf = crossfilter(user_data);
        var all_user_data = user_data_cf.groupAll();
        console.log(user_data_cf.size());
        
        var project_dedication = dc.pieChart("#project-dedication-chart");
        var activity_dedication = dc.pieChart("#activity-dedication-chart");
        var work_history = dc.barChart("#work-history-chart");
        var project_history = dc.seriesChart("#project-history-chart");
        var project_estimated = dc.seriesChart("#project-estimated-chart");

        //### DIMENSIONS
        var moveDays = user_data_cf.dimension(function (d) {
            return d.day;
        });

        var startDateDimension = user_data_cf.dimension(function (d) {
            return d.start_task;
        });

        var projectDimension = user_data_cf.dimension(function (d) {
            return d.project_name;
        });

        var activityDimension = user_data_cf.dimension(function (d) {
            return d.category;
        });

        var moveDaysByProject = user_data_cf.dimension(function (d) {
            return [d.day,d.project_name];
        });

        //### GROUPS
        var projectByDayGroup = moveDays.group().reduceSum(
            function(d){
                return d.dedicated_time/60000; //minutes
            }
        );

        var projectGroup = projectDimension.group();

        var activityGroup = activityDimension.group();

        var moveDaysByProjectGroup = moveDaysByProject.group().reduceSum(
            function(d){
                return d.dedicated_time/60000; //minutes
            }
        );

        var moveDaysByProject_estimated_Group = moveDaysByProject.group().reduceSum(
            function(d){
                return d.estimated_time; //minutes
            }
        );

        //### CHARTS
        work_history.width(990)
            .height(40)
            .margins({top: 0, right: 50, bottom: 20, left: 40})
            .dimension(moveDays)
            .group(projectByDayGroup)
            .centerBar(true)
            .gap(1)
            .x(d3.time.scale().domain([new Date(2014, 10, 1), new Date(2014, 11, 31)]))
            .round(d3.time.day.round)
            .alwaysUseRounding(true)
            .xUnits(d3.time.days)
            .on('preRedraw', function(chart, filter){
                console.log(chart.extendBrush());
                if(chart.extendBrush()[1] - chart.extendBrush()[0] === 0){
                    project_estimated.x(d3.time.scale().domain([new Date(2014, 10, 1), new Date(2014, 11, 31)]));
                }
            });

        project_history
            .chart(function(c) { return dc.lineChart(c).interpolate('basis'); })
            //.renderArea(true)
            .width(990)
            .height(200)
            .transitionDuration(1000)
            .margins({top: 30, right: 50, bottom: 25, left: 40})
            .dimension(moveDays)
            .mouseZoomable(false)
            // Specify a range chart to link the brush extent of the range with the zoom focue of the current chart.
            .rangeChart(work_history)
            .x(d3.time.scale().domain([new Date(2014, 10, 1), new Date(2014, 11, 31)]))
            .y(d3.scale.linear().domain([0, 180]))
            .round(d3.time.day.round)
            .xUnits(d3.time.days)
            //.elasticY(true)
            .renderHorizontalGridLines(true)
            .legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
            .brushOn(false)
            // Add the base layer of the stack with group. The second parameter specifies a series name for use in the legend
            // The `.valueAccessor` will be used for the base layer
            .group(moveDaysByProjectGroup, "Daily hours trend")
            .seriesAccessor(function(d) {return d.key[1];})
            .keyAccessor(function(d) {return d.key[0];})
            .valueAccessor(function (d) {
                return d.value;
            });

        project_estimated
            .chart(function(c) { return dc.lineChart(c).interpolate('basis').dashStyle([3,1,1,1]); })
            //.renderArea(true)
            .width(990)
            .height(200)
            .transitionDuration(1000)
            .margins({top: 30, right: 50, bottom: 25, left: 40})
            .dimension(moveDays)
            .mouseZoomable(false)
            // Specify a range chart to link the brush extent of the range with the zoom focue of the current chart.
            .rangeChart(project_history)
            .x(d3.time.scale().domain([new Date(2014, 10, 1), new Date(2014, 11, 31)]))
            .y(d3.scale.linear().domain([0, 180]))
            .round(d3.time.day.round)
            .xUnits(d3.time.days)
            //.elasticY(true) // axis.orient(
            .renderHorizontalGridLines(true)
            //.legend(dc.legend().x(800).y(10).itemHeight(13).gap(5))
            .brushOn(false)
            // Add the base layer of the stack with group. The second parameter specifies a series name for use in the legend
            // The `.valueAccessor` will be used for the base layer
            .group(moveDaysByProject_estimated_Group, "Daily hours trend")
            .seriesAccessor(function(d) {return d.key[1];})
            .keyAccessor(function(d) {return d.key[0];})
            .valueAccessor(function (d) {
                return d.value;
            });

        project_dedication
            .width(180) // (optional) define chart width, :default = 200
            .height(180) // (optional) define chart height, :default = 200
            .radius(80) // define pie radius
            .dimension(projectDimension) // set dimension
            .group(projectGroup) // set group
            /* (optional) by default pie chart will use group.key as its label
             * but you can overwrite it with a closure */
            .label(function (d) {
                if (project_dedication.hasFilter() && !project_dedication.hasFilter(d.key))
                    return d.key.substring(0, 5) + "(0%)";
                var label = d.key.substring(0, 5);
                if(all_user_data.value())
                    label += "(" + Math.floor(d.value / all_user_data.value() * 100) + "%)";
                return label;
            });

        activity_dedication
            .width(180) // (optional) define chart width, :default = 200
            .height(180) // (optional) define chart height, :default = 200
            .radius(80) // define pie radius
            .dimension(activityDimension) // set dimension
            .group(activityGroup) // set group
            /* (optional) by default pie chart will use group.key as its label
             * but you can overwrite it with a closure */
            .label(function (d) {
                if (activity_dedication.hasFilter() && !activity_dedication.hasFilter(d.key))
                    return d.key + "(0%)";
                var label = d.key;
                if(all_user_data.value())
                    label += "(" + Math.floor(d.value / all_user_data.value() * 100) + "%)";
                return label;
            });

        dc.dataTable(".dc-data-table")
            .dimension(startDateDimension)
            // data table does not use crossfilter group but rather a closure
            // as a grouping function
            .group(function (d) {
                var format = d3.format("02d");
                return format(d.month.getMonth()+1) + "/" + (d.day.getDate());
            })
            .size(10) // (optional) max number of records to be shown, :default = 25
            // dynamic columns creation using an array of closures
            .columns([
                function (d) {
                    return d.start_task;
                },
                function (d) {
                    return d.project_name;
                },
                function (d) {
                    return d.category;
                },
                function (d) {
                    return d.estimated_time;
                },
                function (d) {
                    return Math.round(d.dedicated_time/60000);
                }
            ])
            // (optional) sort using the given field, :default = function(d){return d;}
            .sortBy(function (d) {
                return d.start_task;
            })
            // (optional) sort order, :default ascending
            .order(d3.descending)
            // (optional) custom renderlet to post-process chart using D3
            .renderlet(function (table) {
                table.selectAll(".dc-table-group").classed("info", true);
            });
            
        dc.renderAll();

        //Download reports
        
        d3.select('#download_report').on('click', function() {
            var csv = d3.csv.format(user_data),
                link = document.createElement('a');
            link.href = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
            link.target = '_blank';
            link.download = 'report.csv';
            link.click();
        });
    });

//});