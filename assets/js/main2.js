var selected = [];
$(document).ready(function() {
  init_select2();

  $(".form2").hide();
  $(".sidebar-menu").hide();

  $(".btn-reverse").on('click', function() {
      var org =  $('#kota-asal').select2('data')[0];
      var des = $('#kota-tujuan').select2('data')[0];
      $('#kota-tujuan').html('<option value="' + org.id + '">' + org.text + '</option>');
      $('#kota-asal').html('<option value="' + des.id + '">' + des.text + '</option>');
  });

  //Date picker
  $('#tgl-brngkat').datepicker({
    autoclose: true,
    startDate: '-0d',
    changeMonth: true,
    format: 'dd/mm/yyyy',
    defaultDate: new Date()
  })
  $('#btn-kalender').click(function() {
    $('#tgl-brngkat').datepicker('show');
  });

  $('#form-cari-jadwal').submit(function(event) {
   event.preventDefault();

   var org = $('#kota-asal').val();
   var des = $('#kota-tujuan').val();
   var tgl = $('#tgl-brngkat').val();
   var seat = $('#sel1').val();

   var validasi_tgl = moment(tgl, "DD/MM/YYYY");
   if(org == '' || org == null) {
    notif_warning('Kota Asal Masih Kosong.');
   } else if(des == '' || des == null) {
    notif_warning('Kota Tujuan Masih Kosong.');
   } else if(tgl == '') {
    notif_warning('Tanggal Pemberangkatan Masih Kosong.');
   } else if(!validasi_tgl) {
    notif_warning('Tanggal Pemberangkatan Tidak Valid.');
   } else if(seat == '' || seat < 1) {
    notif_warning('Jumlah Kursi Tidak Valid.');
   } else {
    $(this).unbind('submit').submit();
   }
  });

  $('.btn-pilih-kursi').click(function() {
    var i = $(this).data('i');
    if($('.gerbong-' + i).is(':visible')) {
      $('.gerbong-' + i).hide('fast');
    } else {
      $('.gerbong-' + i).show('fast');
      $('.txt-nama-gerbong-' + i).text('Loading...');
      get_map_kursi(i, $('.pilih-gerbong-' + i).val());
      $('tr[class*="gerbong-"]').each(function() {
        var patt = /gerbong-([0-9+])/i;
        var x = $(this).attr('class').match(patt)[1];
        if(i != x) {
          $('.gerbong-' + x).hide('fast');
        }
      });
    }
  });

  $('select[class*="pilih-gerbong-"]').change(function() {
    var patt = /pilih-gerbong-([0-9+])/i;
    var i = $(this).attr('class').match(patt)[1];
    get_map_kursi(i, $(this).val());
  });


  $('.div-seat-map').on('click', '.reset-kursi', function() {
    var id_gerbong = $(this).data('id');
    var i = $(this).data('i');

    $.ajax({
      cache: false,
      url: BASE_URL + '/gerbong/reset_kursi/' + id_gerbong,
      type: 'GET',
      dataType: 'json',
    }).done(function() {
      get_map_kursi(i, id_gerbong);
    })
  });

  $('select[class*="pilih-gerbong-"]').each(function() {
    var patt = /pilih-gerbong-([0-9+])/i;
    var i = $(this).attr('class').match(patt)[1];
    console.log($(this).val());
  });

});

// Cari Ulang
function form2Toggle() {
  $(".form2").fadeToggle("fast");
};

function get_map_kursi(i, id_gerbong) {
  var data = {
    'tanggal': $('#tgl').val()
  }
  $.ajax({
     url: BASE_URL + '/gerbong/get_kelas/' + id_gerbong,
     type: 'POST',
     data: data,
     dataType: 'json',
     success: function(data) {
        $('.seat-map-' + i + ' .seatCharts-row').remove();
        $('.seat-map-' + i + ' .seatCharts-legendItem').remove();
        $('.seat-map-' + i).unbind().removeData();
        $('.txt-nama-gerbong-' + i).html('Gerbong: ' + data.gerbong.nama + ' <button type="button" class="btn btn-sm reset-kursi" data-i="' + i + '" data-id="' + data.gerbong.id + '"><i class="fa fa-refresh"></i> Reset Kursi</button>');
        var map = [];
        var rows = [];
        selected = data.penumpang;

        if(data.gerbong.kelas == 'EKS') {
            map = [
              'eeeeeeeeeeeee',
              '_eeeeeeeeeeee',
              '_____________',
              'eeeeeeeeeeee_',
              'eeeeeeeeeeeee',
            ];
            rows = ['A', 'B', '', 'C', 'D'];
        } else if(data.gerbong.kelas == 'BIS') {
            map = [
              'eeeeeeeeeeeeeeee_',
              'eeeeeeeeeeeeeeee_',
              '_________________',
              '_eeeeeeeeeeeeeeee',
              '_eeeeeeeeeeeeeeee',
            ];
            rows = ['A', 'B', '', 'C', 'D'];
        } else if(data.gerbong.kelas == 'EKO_AC') {
            map = [
              'eeeeeeeeeeeeeeeeeeee__',
              'eeeeeeeeeeeeeeeeeeee__',
              '_______________________',
              '__eeeeeeeeeeeeeeeeeeee',
              '__eeeeeeeeeeeeeeeeeeee',
            ];
            rows = ['A', 'B', '', 'C', 'D'];
        } else {
            map = [
              'eeeeeeeeeeeeeeeeeeeee__',
              'eeeeeeeeeeeeeeeeeeeee__',
              '___eeeeeeeeeeeeeeeeee__',
              '_______________________',
              '__eeeeeeeeeeeeeeeeeeeee',
              '__eeeeeeeeeeeeeeeeeeeee',
            ];
            rows = ['A', 'B', 'C', '', 'D', 'E'];
        }

        var sc = $('.seat-map-' + i).seatCharts({
          map: map,
          naming: {
            top: true,
            getLabel: function(character, row, column) {
              return row;
            },
            rows: rows
          },
          legend: {
            node: $('#legend'),
            items: [
              ['f', 'available', 'First Class'],
              ['e', 'available', 'Economy Class'],
              ['f', 'unavailable', 'Already Booked']
            ]
          },
          click   : function() {
            if (this.status() == 'available') {
              //do some custom stuff
              if(selected.indexOf(i + '') >= 0) {
                notif_warning('Anda sudah memilih kursi untuk penumpang ' + i + '.');
                return 'available';
              } else {
                pilih_kursi(data.gerbong, id_gerbong, i, this);
              }
            } else if (this.status() == 'selected') {
              return delete_kursi(data.gerbong, id_gerbong, i, this);
            } else {
              //i.e. alert that the seat's not available
              return this.style();
            }
            
          },
        });
        $.each(data.kursi, function (index, booking) {
          sc.get(booking).status('unavailable');
        });
        $.each(data.selected, function (index, booking) {
          $('#hgerbong-' + index).val(id_gerbong);
          $('#hgerbongnama-' + index).val(data.gerbong.nama);
          $('#hrow-' + index).val(booking.split('_')[0]);
          $('#hseat-' + index).val(booking.split('_')[1]);

          $('#kursi-' + index).text(data.gerbong.nama + '; ' + booking.split('_')[1] + booking.split('_')[0]);
          sc.get(booking).status('selected');
        });
     }
  });
}

async function pilih_kursi(gerbong, id_gerbong, i, th) {
  const dataset = await $.ajax({
    cache: false,
    url: BASE_URL + '/gerbong/set_kursi/' + id_gerbong + '/' + i + '/' + th.settings.id,
    type: 'GET',
    dataType: 'json',
  });
  if(dataset.sukses == 1) {
    selected.push(i + '');
    th.style('selected');

    $('#hgerbong-' + i).val(id_gerbong);
    $('#hgerbongnama-' + i).val(gerbong.nama);
    $('#hrow-' + i).val(th.settings.id.split('_')[0]);
    $('#hseat-' + i).val(th.settings.id.split('_')[1]);

    $('#kursi-' + i).text(gerbong.nama + '; ' + th.settings.id.split('_')[1] + th.settings.id.split('_')[0]);

    return true;
  } else {
    th.style('available');
    return false;
  }
}

async function delete_kursi(gerbong, id_gerbong, i, th) {
  const dataset = await $.ajax({
    cache: false,
    url: BASE_URL + '/gerbong/del_kursi/' + id_gerbong + '/' + i + '/' + th.settings.id,
    type: 'GET',
    dataType: 'json',
  });
  if(dataset.sukses == 1) {
    delete selected[selected.indexOf(i + '')];
    th.style('available');

    $('#hgerbong-' + i).val('');
    $('#hgerbongnama-' + i).val('');
    $('#hrow-' + i).val('');
    $('#hseat-' + i).val('');

    $('#kursi-' + i).text('(No Kursi)');

    return true;
  } else {
    th.style('selected');
    return false;
  }
}

function init_select2() {
  /* Select2 */
  $('#kota-asal').select2({
    placeholder: $(this).data('placeholder'),
    theme: "bootstrap",
    minimumInputLength: 3,
    ajax: {
        cache: false,
        url: BASE_URL + '/stasiun/cari_json',
        dataType: 'json'
    },
    matcher: matchStart
  });
  $('#kota-tujuan').select2({
    placeholder: $(this).data('placeholder'),
    theme: "bootstrap",
    minimumInputLength: 3,
    ajax: {
        cache: false,
        url: BASE_URL + '/stasiun/cari_json',
        dataType: 'json'
    },
    matcher: matchStart
  });
}

function matchStart(params, data) {
  // If there are no search terms, return all of the data
  if ($.trim(params.term) === '') {
    return data;
  }

  // Skip if there is no 'children' property
  if (typeof data.children === 'undefined') {
    return null;
  }

  // `data.children` contains the actual options that we are matching against
  var filteredChildren = [];
  $.each(data.children, function (idx, child) {
    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
      filteredChildren.push(child);
    }
  });

  // If we matched any of the timezone group's children, then set the matched children on the group
  // and return the group object
  if (filteredChildren.length) {
    var modifiedData = $.extend({}, data, true);
    modifiedData.children = filteredChildren;

    // You can return modified objects from here
    // This includes matching the `children` how you want in nested data sets
    return modifiedData;
  }

  // Return `null` if the term should not be displayed
  return null;
}


function batal_pesan(id) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin akan membatalkan pemesanan ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/';
    })
}