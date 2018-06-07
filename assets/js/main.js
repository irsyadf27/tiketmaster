var firstSeatLabel = 1;
// On document ready
$(document).ready(function() {
  // executes when HTML-Document is loaded and DOM is ready
  $(".form2").hide();
  $(".sidebar-menu").hide();


  var $cart = $('#selected-seats'),
    $counter = $('#counter'),
    $total = $('#total'),
    sc = $('#seat-map').seatCharts({
      map: [
        'ff_ff',
        'ff_ff',
        'ee_ee',
        'ee_ee',
        'ee___',
        'ee_ee',
        'ee_ee',
        'ee_ee',
        'eeeee',
      ],
      seats: {
        f: {
          price: 100,
          classes: 'first-class', //your custom CSS class
          category: 'First Class'
        },
        e: {
          price: 40,
          classes: 'economy-class', //your custom CSS class
          category: 'Economy Class'
        }

      },
      naming: {
        top: false,
        getLabel: function(character, row, column) {
          return firstSeatLabel++;
        },
      },
      legend: {
        node: $('#legend'),
        items: [
          ['f', 'available', 'First Class'],
          ['e', 'available', 'Economy Class'],
          ['f', 'unavailable', 'Already Booked']
        ]
      },
      click: function() {
        if (this.status() == 'available') {
          //let's create a new <li> which we'll add to the cart items
          $('<li>' + this.data().category + ' Seat # ' + this.settings.label + ': <b>$' + this.data().price + '</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
            .attr('id', 'cart-item-' + this.settings.id)
            .data('seatId', this.settings.id)
            .appendTo($cart);

          /*
           * Lets update the counter and total
           *
           * .find function will not find the current seat, because it will change its stauts only after return
           * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
           */
          $counter.text(sc.find('selected').length + 1);
          $total.text(recalculateTotal(sc) + this.data().price);

          return 'selected';
        } else if (this.status() == 'selected') {
          //update the counter
          $counter.text(sc.find('selected').length - 1);
          //and total
          $total.text(recalculateTotal(sc) - this.data().price);

          //remove the item from our cart
          $('#cart-item-' + this.settings.id).remove();

          //seat has been vacated
          return 'available';
        } else if (this.status() == 'unavailable') {
          //seat has been already booked
          return 'unavailable';
        } else {
          return this.style();
        }
      }
    });

  //this will handle "[cancel]" link clicks
  $('#selected-seats').on('click', '.cancel-cart-item', function() {
    //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
    sc.get($(this).parents('li:first').data('seatId')).click();
  });

  //let's pretend some seats have already been booked
  sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');


  /* Select2 */
  $('.select-stasiun').select2({
    ajax: {
      url: BASE_URL + 'stasiun/cari_json',
      data: function (params) {
        var query = {
          q: params.term,
        }

        // Query parameters will be ?search=[term]&type=public
        return query;
      }
    }
  });
});

// Carousel

var $item = $('.carousel .item');
var $wHeight = '450px';
$item.eq(0).addClass('active');
$item.height($wHeight);
$item.addClass('full-screen');

$('.carousel img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image': 'url(' + $src + ')',
    'background-color': $color
  });
  $(this).remove();
});

$(window).on('resize', function() {
  $wHeight = '450px';
  $item.height($wHeight);
});

$('.carousel').carousel({
  interval: 6000,
  pause: "false"
});


// Link2

function pageRedirect1() {
  window.location.replace("login.html");
};

function pageRedirect2() {
  window.location.replace("kereta.html");
};

function pageRedirect3() {
  window.location.replace("seats.html");
};

function pageRedirect4() {
  window.location.replace("index-login.html");
};

function pageRedirect5() {
  window.location.replace("index.html");
};

function pageRedirect6() {
  window.location.replace("kereta-login.html");
};

function pageRedirect7() {
  window.location.replace("seats-login.html");
};
function pageRedirect8() {
  window.location.replace("daftar.html");
};

function recalculateTotal(sc) {
  var total = 0;

  //basically find every selected seat and sum its price
  sc.find('selected').each(function() {
    total += this.data().price;
  });

  return total;
}

// Barcode
$("#barcode").JsBarcode("CYK202 0000335457");
$("#barcode2").JsBarcode("CYK202 0000335458");
$("#barcode3").JsBarcode("CYK202 0000335459");
$("#barcode4").JsBarcode("CYK202 0000335460");
$("#barcode5").JsBarcode("CYK202 0000335461");

// sidebar
function sidebar() {
  $(".sidebar-menu").show();
};

function responsiveFn() {
  width = $(window).width();
  height = $(window).height();


  // Do a custom code here
  if (width >= 768) {
    $(".sidebar-menu").hide();
    $(".thilang").show();
    $(".tbarcode").show();
  }
  if (width <= 768) {
    $(".tbarcode").hide();
    $(".thilang").hide();
  }
}

// Window resize
$(window).ready(responsiveFn).resize(responsiveFn);


// Cari Ulang
function form2Toggle() {
  $(".form2").fadeToggle("fast");
};
