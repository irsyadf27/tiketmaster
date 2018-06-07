$(document).ready(function () {
  if(jQuery.fn.select2) {
    // check select2 loaded
    init_select2();
  }
  $('#stasiun').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        cache: false,
        url: BASE_URL + "/stasiun/stasiun",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "kode" },
          { "data": "nama" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });

  $('#kereta').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/kereta/kereta",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "kode" },
          { "data": "nama" },
          { "data": "kelas" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });
  
  $('#jadwal').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/jadwal/semua",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "kode" },
          { "data": "nama" },
          { "data": "jumlah" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });
  
  $('#pengguna').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/user/user",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "nama_depan" },
          { "data": "nama_belakang" },
          { "data": "email" },
          { "data": "no_hp" },
          { "data": "jenis" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });
  
  $('#slideshow').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/slideshow/slideshow",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "judul" },
          { "data": "deskripsi" },
          { "data": "tampil" },
          { "data": "gambar" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1, -2] }
      ]
  });

  $('#pemesanan').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/pemesanan/pemesanan",
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "pemesan" },
          { "data": "kereta" },
          { "data": "tanggal" },
          { "data": "jumlah" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });

  $('#detail-pemesanan').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/pemesanan/detail_pemesanan/" + $('#id_pemesanan').val(),
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "no_identitas" },
          { "data": "nama_lengkap" },
          { "data": "nama_gerbong" },
          { "data": "kursi" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ]
  });

  $('#tabel-kelola-jadwal').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: BASE_URL + "/jadwal/kelola_jadwal/" + $('#kode_kereta').val(),
        dataType: "json",
        type: "POST",
      },
      columns: [
          { "data": "nama_stasiun_asal" },
          { "data": "waktu_berangkat" },
          { "data": "nama_stasiun_tujuan" },
          { "data": "waktu_tiba" },
          { "data": "aksi" },
      ],
      columnDefs: [
           { orderable: false, targets: [-1] }
      ],
      "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        /* Asal */
        $($('td:eq(0) a', nRow)).editable({
          params: function(params) {
            var data = {};
            data['id'] = params.pk;
            data['asal'] = params.value;
            return data;
          },
          validate: function(value) {
              if(value == '') {
                return 'Tidak boleh kosong';
              }
          },
          success: function(response, newValue) {
            $('.btn-toggle-xedit').show();
            //if(!response.success) return response.msg;
          },
          select2: {
            placeholder: 'Stasiun Pemberangkatan',
            allowClear: true,
            id: function (item) {
              //console.log(item);
                return item.id;
            },
            ajax: {
                cache: false,
                url: BASE_URL + '/../stasiun/cari_json',
                dataType: 'json',
            },
            formatResult: function (item) {
                return item.text;
            },
            formatSelection: function (item) {
                return item.id;
            },
            initSelection: function (element, callback) {
                return $.getJSON(BASE_URL + '/../stasiun/cari_json', { q: element.val() }, function (data) {
                    callback(data.results);
                });
            } 
        } 
        }).on('hidden', function(e, reason) {
          $('.btn-toggle-xedit').show();
        });
        /* Waktu Berangkat */
        $($('td:eq(1) a', nRow)).editable({
          params: function(params) {
            var data = {};
            data['id'] = params.pk;
            //data['waktu_berangkat'] = params.value;
            data['waktu_berangkat'] = $('#wkt-brnkt').val();
            return data;
          },
          validate: function(value) {
              if(value == '') {
                return 'Tidak boleh kosong';
              }
          },
          success: function(response, newValue) {
            $('.btn-toggle-xedit').show();
            //if(!response.success) return response.msg;
          },
          display: function (value, sourceData, response) {
            if(sourceData) {
              var obj = jQuery.parseJSON( sourceData );
              $(this).html(obj.data.waktu_berangkat);
            }
          },
          tpl: "<input type='text' class='form-control' id='wkt-brnkt'>",
          format: "hh:ii",    
          viewformat: "hh:ii",    
          datetimepicker: {
            pickDate: false,
            minuteStep: 1,
            pickerPosition: 'bottom-right',
            format: 'HH:ii',
            autoclose: true,
            showMeridian: false,
            startView: 1,
            maxView: 1,
          }
        }).on('hidden', function(e, reason) {
          $('.btn-toggle-xedit').show();
        });
        /* Tujuan */
        $($('td:eq(2) a', nRow)).editable({
          params: function(params) {
            var data = {};
            data['id'] = params.pk;
            data['tujuan'] = params.value;
            return data;
          },
          validate: function(value) {
              if(value == '') {
                return 'Tidak boleh kosong';
              }
          },
          success: function(response, newValue) {
            $('.btn-toggle-xedit').show();
            //if(!response.success) return response.msg;
          },
          select2: {
            placeholder: 'Stasiun Tujuan',
            allowClear: true,
            id: function (item) {
              //console.log(item);
                return item.id;
            },
            ajax: {
                cache: false,
                url: BASE_URL + '/../stasiun/cari_json',
                dataType: 'json',
            },
            formatResult: function (item) {
                return item.text;
            },
            formatSelection: function (item) {
                return item.id;
            },
            initSelection: function (element, callback) {
                return $.getJSON(BASE_URL + '/../stasiun/cari_json', { q: element.val() }, function (data) {
                    callback(data.results);
                });
            } 
        } 
        }).on('hidden', function(e, reason) {
          $('.btn-toggle-xedit').show();
        });
        /* Waktu Tiba */
        $($('td:eq(3) a', nRow)).editable({
          params: function(params) {
            var data = {};
            data['id'] = params.pk;
            //data['waktu_tiba'] = params.value;
            data['waktu_tiba'] = $('#wkt-tb').val();
            return data;
          },
          validate: function(value) {
              if(value == '') {
                return 'Tidak boleh kosong';
              }
          },
          success: function(response, newValue) {
            $('.btn-toggle-xedit').show();
            //if(!response.success) return response.msg;
          },
          display: function (value, sourceData, response) {
            if(sourceData) {
              var obj = jQuery.parseJSON( sourceData );
              $(this).html(obj.data.waktu_tiba);
            }
          },
          tpl: "<input type='text' class='form-control' id='wkt-tb'>",
          format: "hh:ii",    
          viewformat: "hh:ii",    
          datetimepicker: {
            pickDate: false,
            minuteStep: 1,
            pickerPosition: 'bottom-right',
            format: 'HH:ii',
            autoclose: true,
            showMeridian: false,
            startView: 1,
            maxView: 1,
          }
        }).on('hidden', function(e, reason) {
          $('.btn-toggle-xedit').show();
        });
      }
  });

  $('#form-ubah-stasiun').submit(function(event) {
    event.preventDefault();

    var nama = $('#namast').val();

    if(nama == '' || nama == null) {
      notif_warning('Nama Stasiun masih kosong.');
    } else if(nama.length < 2) {
      notif_warning('Nama Stasiun minimal 2 huruf.');
    } else if(nama.length > 50) {
      notif_warning('Nama Stasiun maksimal 50 huruf.');
    } else {
      $(this).unbind('submit').submit();
    }
  });

  var i_kelas = 1;
  $('#tambah-kelas').click(function() {
    var html = $('<div class="form-group" id="kelas-' + i_kelas + '"><label for="kelas" class="col-sm-2 control-label">Kelas</label><div class="col-sm-9"><select name="kelas[]" class="form-control"><option value="Ekonomi">Ekonomi</option><option value="Bisnis">Bisnis</option><option value="Eksekutif">Eksekutif</option></select></div><button type="button" id="hapus-kelas" data-id="' + i_kelas + '" class="btn btn-sm btn-danger"><i class="fa fa-close"></i></button></div>');
    $('#body-kelas').append(html);
    i_kelas++;
  });

  $('#body-kelas').on('click', '#hapus-kelas', function() {
    var i = $(this).data('id');
    $('#kelas-' + i).remove();
  });

  var i_gerbong = 2;
  $('#tambah-gerbong').click(function() {
    var html = $('<tr id="tr-gerbong-' + i_gerbong + '"><td><div class="form-group" id="fg-nama-gerbong-' + i_gerbong + '"><input type="text" class="form-control nama-gerbong" name="nama_gerbong[]" placeholder="Nama Gerbong" data-id="' + i_gerbong + '"><span class="help-block" id="hb-nama-gerbong-' + i_gerbong + '" style="display: none;"></span></div></td><td><select name="kelas_gerbong[]" class="form-control"><option value="EKO">Ekonomi</option><option value="EKO_AC">Ekonomi AC</option><option value="BIS">Bisnis</option><option value="EKS">Eksekutif</option></select></td><td><div class="form-group" id="fg-no-gerbong-' + i_gerbong + '"><input type="number" class="form-control no-gerbong" name="no_gerbong[]" data-id="' + i_gerbong + '"><span class="help-block" id="hb-no-gerbong-' + i_gerbong + '" style="display: none;"></span></div></td><td><button type="button" id="hapus-gerbong" class="btn btn-sm btn-danger pull-right" data-id="' + i_gerbong + '"><i class="fa fa-close"></i></button></td></tr>');
    $('#tabel-gerbong').append(html);
    i_gerbong++;
  });

  $('#tabel-gerbong').on('click', '#hapus-gerbong', function() {
    var i = $(this).data('id');
    $('#tr-gerbong-' + i).remove();
  });

  if(jQuery.fn.editable) {
    $.fn.editable.defaults.mode = 'inline';
  }
  /* X-editable kelola gerbong */
  $('a[id*=kelola-gerbong-nama-]').each(function() {
    $('#' + $(this).attr('id')).editable({
        params: function(params) {
          var data = {};
          data['id'] = params.pk;
          data['nama'] = params.value;
          return data;
        },
        validate: function(value) {
            if(value == '') {
              return 'Tidak boleh kosong';
            } else if(value.length < 2) {
              return 'Minimal 2 karakter';
            } else if(value.length > 20) {
              return 'Maksimal 20 karakter';
            }
        },
        success: function(response, newValue) {
          $('.btn-toggle-xedit').show();
          if(!response.success) return response.msg;
        }
    }).on('hidden', function(e, reason) {
      $('.btn-toggle-xedit').show();
    });
  });
  $('a[id*=kelola-gerbong-kelas-]').each(function() {
    $('#' + $(this).attr('id')).editable({
      params: function(params) {
        var data = {};
        data['id'] = params.pk;
        data['kelas'] = params.value;
        return data;
      },
      source: [
          {value: 'EKO', text: 'Ekonomi'},
          {value: 'EKO_AC', text: 'Ekonomi AC'},
          {value: 'BIS', text: 'Bisnis'},
          {value: 'EKS', text: 'Eksekutif'}
      ],
      success: function(response, newValue) {
        $('.btn-toggle-xedit').show();
        if(!response.success) return response.msg;
      }
    }).on('hidden', function(e, reason) {
      $('.btn-toggle-xedit').show();
    });
  });
  $('a[id*=kelola-gerbong-no-]').each(function() {
    $('#' + $(this).attr('id')).editable({
        params: function(params) {
          var data = {};
          data['id'] = params.pk;
          data['nomor'] = params.value;
          return data;
        },
        validate: function(value) {
            var regex = /^[0-9]+$/;
            if(! regex.test(value)) {
                return 'Hanya Angka';
            } else if(value > 999) {
              return 'Maksimal 3 digit';
            }
        },
        success: function(response, newValue) {
          $('.btn-toggle-xedit').show();
          if(!response.success) return response.msg;
        }
      }).on('hidden', function(e, reason) {
        $('.btn-toggle-xedit').show();
      });
  });

  $(document).on('click', '.btn-toggle-xedit', function(e){    
    e.stopPropagation();
    $('#' + $(this).data('id')).editable('toggle');
    $(this).hide();
  });

  $(document).on('click', '.editable-click', function() {
    console.log('#btn-' + $(this).attr('id'));
    $('#btn-' + $(this).attr('id')).hide();
  });

  if(jQuery.fn.datetimepicker) {
    $('#waktu-berangkat').datetimepicker({
      pickDate: false,
      minuteStep: 1,
      pickerPosition: 'bottom-right',
      format: 'hh:ii',
      autoclose: true,
      showMeridian: false,
      startView: 1,
      maxView: 1,
    });
    $('#waktu-tiba').datetimepicker({
      pickDate: false,
      minuteStep: 1,
      pickerPosition: 'bottom-right',
      format: 'hh:ii',
      autoclose: true,
      showMeridian: false,
      startView: 1,
      maxView: 1,
    });
  }

  $('#form-ubah-penumpang').submit(function(event) {
    event.preventDefault();

    var id_penumpang = $('#id_penumpang').val();
    var no_identitas = $('#no_identitas').val();
    var nama_lengkap = $('#nama_lengkap').val();

    if(id_penumpang == '' || id_penumpang == null) {
      notif_warning('ID Penumpang tidak ditemukan.');
    } else if(nama_lengkap == '' || nama_lengkap == null) {
      notif_warning('Nama lengkap masih kosong.');
    } else if(nama_lengkap.length < 2) {
      notif_warning('Nama lengkap minimal 2 huruf.');
    } else if(nama_lengkap.length > 50) {
      notif_warning('Nama lengkap maksimal 50 huruf.');
    } else if(no_identitas == '' || no_identitas == null) {
      notif_warning('No. identitas masih kosong.');
    } else if(no_identitas.length < 2) {
      notif_warning('No. identitas minimal 2 huruf.');
    } else if(no_identitas.length > 30) {
      notif_warning('No. identitas maksimal 30 huruf.');
    } else {
      $(this).unbind('submit').submit();
    }
  });

  $('#detail-pemesanan').on('click', '.edit-identitas', function() {
    $('#id_penumpang').val($(this).data('id'));
    $('#no_identitas').val($(this).data('identitas'));
    $('#nama_lengkap').val($(this).data('nama'));
    $('#modal-edit').modal('show');
  });
});


function init_select2() {
  /* Select2 */
  $('#kota-asal').select2({
    placeholder: $(this).data('placeholder'),
    theme: "bootstrap",
    ajax: {
        cache: false,
        url: BASE_URL + '/../stasiun/cari_json',
        dataType: 'json'
    },
    matcher: matchStart
  });
  $('#kota-tujuan').select2({
    placeholder: $(this).data('placeholder'),
    theme: "bootstrap",
    ajax: {
        cache: false,
        url: BASE_URL + '/../stasiun/cari_json',
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
function validasi_form_kereta() {

  var nama = $('#namakt').val();
  var kode = $('#kodekt').val();
  var error_nama_gerbong = false;
  var error_no_gerbong = false;

  var error = false;

  $('.nama-gerbong').each(function() {
    var i = $(this).data('id');
    if($(this).val() == '') {
      error_nama_gerbong = true;
      error = true;
      $('#fg-nama-gerbong-' + i).addClass('has-error');
      $('#hb-nama-gerbong-' + i).text('Nama Gerbong masih kosong.');
      $('#hb-nama-gerbong-' + i).show();
    } else {
      $('#fg-nama-gerbong-' + i).removeClass('has-error');
      $('#hb-nama-gerbong-' + i).text('');
      $('#hb-nama-gerbong-' + i).hide();
    }
  });

  $('.no-gerbong').each(function() {
    var i = $(this).data('id');
    if($(this).val() == '') {
      error_no_gerbong = true;
      error = true;

      $('#fg-no-gerbong-' + i).addClass('has-error');
      $('#hb-no-gerbong-' + i).text('No. Gerbong masih kosong.');
      $('#hb-no-gerbong-' + i).show();
    } else {
      $('#fg-no-gerbong-' + i).removeClass('has-error');
      $('#hb-no-gerbong-' + i).text('');
      $('#hb-no-gerbong-' + i).hide();
    }
  });

  if(error_nama_gerbong) {
    notif_warning('Nama Gerbong masih kosong.');
  }
  if(error_no_gerbong) {
    notif_warning('No. Gerbong masih kosong.');
  }

  if(nama == '' || nama == null) {
    error = true;
    notif_warning('Nama Kereta masih kosong.');
  } else if(nama.length < 2) {
    error = true;
    notif_warning('Nama Kereta minimal 2 huruf.');
  } else if(nama.length > 50) {
    error = true;
    notif_warning('Nama Kereta maksimal 50 huruf.');
  } else if(kode == '' || kode == null) {
    error = true;
    notif_warning('Kode Kereta masih kosong.');
  } else if(nama.length > 10) {
    error = true;
    notif_warning('Kode Kereta maksimal 10 huruf.');
  }


  if(!error) {
    return true;
  } else {
    return false;
  }
}

function validasi_tambah_gerbong() {

  var nama = $('#namagerbong').val();
  var kelas = $('#kelasgerbong').val();
  var no_gerbong = $('#nogerbong').val();

  var error = false;
  var error_nama = false;
  var error_no = false;

  if(nama == '' || nama == null) {
    error = true;
    error_nama = true;
    notif_warning('Nama Gerbong masih kosong.');
  } else if(nama.length < 2) {
    error = true;
    error_nama = true;
    notif_warning('Nama Gerbong minimal 2 huruf.');
  } else if(nama.length > 50) {
    error = true;
    error_nama = true;
    notif_warning('Nama Gerbong maksimal 50 huruf.');
  } else if(no_gerbong == '' || no_gerbong == null) {
    error = true;
    error_no = true;
    notif_warning('No. Kereta masih kosong.');
  } else if(kelas == '' || kelas == null) {
    error = true;
    notif_warning('Kelas masih kosong.');
  } 

  if(error_nama) {
    $('#fg-nama').addClass('has-error');
  } else {
    $('#fg-nama').removeClass('has-error');
  }

  if(error_no) {
    $('#fg-no').addClass('has-error');
  } else {
    $('#fg-no').removeClass('has-error');
  }

  if(!error) {
    return true;
  } else {
    return false;
  }
}

function hapus_stasiun(kode) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus stasiun ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/stasiun/hapus/' + kode;
    })
}

function edit_stasiun(kode, nama) {
  $('#kodest').val(kode);
  $('#namast').val(nama);

  $("#modal-ubah-stasiun").modal('show');
}

function hapus_kereta(kode) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus kereta ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/kereta/hapus/' + kode;
    })
}

function hapus_gerbong(id) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus gerbong ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/gerbong/hapus/' + id;
    })
}

function hapus_jadwal(id) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus jadwal ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/jadwal/hapus/' + id;
    })
}

function hapus_user(id) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus pengguna ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/user/hapus/' + id;
    })
}

function hapus_slideshow(id) {
    swal({
        title: 'Konfirmasi',
        text: "Apa anda yakin ingin menghapus slideshow ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
    }).then(function () {
        window.location.href = BASE_URL + '/slideshow/hapus/' + id;
    })
}