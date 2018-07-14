$(function() {
	Morris.Line({
  element: 'morris-area-chart',
  data: [
    { y: '2012-02-24 15:00:00', a: 30, b: 80 },
    { y: '2012-02-24 15:10:00', a: 28,  b: 78 },
    { y: '2012-02-24 15:20:00', a: 32,  b: 85 },
    { y: '2012-02-24 15:30:00', a: 34,  b: 88 },
    { y: '2012-02-24 15:40:00', a: 26,  b: 75 },
    { y: '2012-02-24 15:50:00', a: 25,  b: 89 },
    { y: '2012-02-24 15:60:00', a: 30, b: 90 }
  ],
  xkey: 'y',
  ykeys: ['a', 'b'],
  labels: ['Temp', 'Humi'],
  pointFillColors:['#ffffff'],
  pointStrokeColors: ['black'],
  lineColors:['red','blue']
  });
 
});
