
$(document).ready(function(){
d3.csv("yx_axices.csv",function(lrows){
        dosmth(lrows);
    });
function dosmth(ro){
    array = ro.map(function(d) { return [ +d["yv"], +d["xv"] ]; });
    var fa=[];
    for (var i in array){
        fa[i]=array[i][0];
    }
    window.rows=fa;
    window.arr=array;
    plotv(fa);
}
function plotv(data){
    var x = d3.scale.linear()
        .domain([0, d3.max(data)])
        .range(["0px", "420px"]);
    var y = d3.scale.ordinal()
        .domain(data)
        .rangeBands([0, 300]);
        
    var chart = d3.select("#chart1").append("svg")
        .attr("class", "chart")
        .attr("width", 420)
        .attr("height", 3 * data.length+40)
        .append("g").attr("transform","translate(10,15)");
    
    /*chart.selectAll("rect")
        .data(data)
      .enter().append("rect")
        .attr("y", function(d, i) { return i * 20; })
        .attr("width", x)
        .attr("height", 20);
    */
    chart.selectAll("rect")
        .data(data)
      .enter().append("rect")
        .attr("y", y)
        .attr("width", x)
        .attr("height", y.rangeBand());
        
    chart.selectAll("text")
        .data(data)
        .enter().append("text")
        .attr("x", x)
        .attr("y", function(d) { return y(d) + y.rangeBand() / 2; })
        .attr("dx", 14) // padding-right
        .attr("dy", ".35em") // vertical-align: middle
        .attr("text-anchor", "end") // text-align: right
        .attr("font-size","10px")
        //.attr("fill","white")
        .text(String);
        
    chart.selectAll("line")
        .data(x.ticks(10))
      .enter().append("line")
        .attr("x1", x)
        .attr("x2", x)
        .attr("y1", 0)
        .attr("y2", 300)
        .style("stroke", "#ccc");
    chart.selectAll(".rule")
    .data(x.ticks(10))
        .enter().append("text")
          .attr("class", "rule")
          .attr("x", x)
          .attr("y", 300)
          .attr("dy", 10)
          .attr("text-anchor", "middle")
          .attr("font-size","10px")
          .text(String);
    chart.append("line")
    .attr("y1", 0)
    .attr("y2", 300)
    .style("stroke", "#000");
    chart.append("rect")
    .attr("class","new")
    .attr("y",150)
    .attr("width",420)
    .attr("x",0)
    .attr("height",150).attr("fill","red").attr("opacity",0.3);
    chart.append("text")
    .attr("text-anchor","middle")
    .attr("y",230)
    .attr("x",200)
    .attr("fill","rgb(253, 100, 100)")
    .text("1.18%");
    
    //chart.attr("transform","translate(10,420) rotate(-90)");
}

    
});