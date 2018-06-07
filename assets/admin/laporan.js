/* Document ready function */
$(document).ready(function(){
    $.getJSON(BASE_URL + '/laporan/get_data_pemesanan/' + $('#hidden_tahun').val(), function (data) {
        chart_pemesanan(data);
    });
});
function chart_pemesanan(data) {
  Highcharts.chart('chartPemesanan', {
      chart: {
          type: 'line'
      },
      title: {
          text: 'Laporan Pemesanan &amp; Penumpang Tahun ' + data.tahun
      },
      xAxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      yAxis: {
          title: {
              text: 'Jumlah'
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: true
          }
      },
      series: [{
          name: 'Pemesanan',
          data: data.pemesanan
      }, {
          name: 'Penumpang',
          data: data.penumpang
      }]
  });
}