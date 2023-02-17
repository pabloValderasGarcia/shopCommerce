/* global $ */

// LOADER
window.addEventListener('load', () => {
    const loader = document.querySelector('.loader-container');
    setTimeout(() => {
      document.documentElement.style.overflowY = 'scroll';
      loader.classList.add('loader-hidden');
    }, 300);
    
    
    // Filters
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries());
    let urlParams = {}, priceMinValue = 0, priceMaxValue = 999999999;
    for (var param in params){
      if (param.includes('-')) $('#' + param).attr('checked', 'checked');
      else {
        var match, pl = /\+/g, search = /([^&=]+)=?([^&]*)/g, decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); }, query = window.location.search.substring(1);
        urlParams = {};
        while (match = search.exec(query)) {
          urlParams[decode(match[1])] = decode(match[2]);
          
          if (urlParams.priceMin) priceMinValue = urlParams.priceMin;
          if (urlParams.priceMax) priceMaxValue = urlParams.priceMax;
        }
        
        if (priceMinValue != 0) $('#priceMin').attr('value', priceMinValue);
        if (priceMaxValue != 999999999) $('#priceMax').attr('value', priceMaxValue);
      }
      
      if (params.orderby) {
        $('#' + params.orderby + params.ordertype).attr('selected', 'selected');
      }
    }
});

// DELETE ELEMENT
let deletesElement = document.querySelectorAll('.deleteLinkElement');
deletesElement.forEach(deletes => {
    let url = deletes.dataset.url;
    let typeElement = deletes.dataset.type;
    let element = deletes.dataset.name;
    deletes.addEventListener("click", () => {
        document.getElementById('deleteFormElement').action = url;
        document.getElementById('deleteElementType').innerHTML = typeElement;
        document.getElementById('deleteElementTypeInput').setAttribute('value', 'Delete ' + typeElement);
        document.getElementById('deleteElementName').innerHTML = element;
    });
});



jQuery(document).ready(function () {
  ImgUpload();
});

var cont = 0;
function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];
  var imgs = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      let first = true;
      $('.upload__img-box').each(function () {
        if (!first) {
          $(this).css('display', 'none');
        }
        first = false;
      });
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {
        if (!imgs.includes(f.name)) {
          imgs.push(f.name);
          if (!f.type.match('image.*')) {
            return;
          }
  
          if (imgArray.length > maxLength) {
            return false;
          } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i] !== undefined) {
                len++;
              }
            }
            if (len > maxLength) {
              return false;
            } else {
              imgArray.push(f);
  
              var reader = new FileReader();
              reader.onload = function (e) {
                if (imgWrap.children().length < 8) {
                  var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                  imgWrap.append(html);
                  iterator++;
                }
              }
              reader.readAsDataURL(f);
            }
          }
        }
      });
    });
  });
  
  $('.upload__thumbnail').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              imgWrap.empty();
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        imgs.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}


$('#createForm').on("click", () => {
  if($('#thumbnail_wrap').children().length == 0) {
    $('#thumbnail_input').val('');
  }
  if($('#images_wrap').children().length == 0) {
    $('#images_input').val('');
  }
  if(tinymce.get("messageReview").getContent()) {
    $('#hidden_message').removeAttr('required');
  } else {
    $('#hidden_message').attr('required', 'required');
  }
});


// THUMBNAIL
$('#thumbnail_label').on('click', () => {
  $('#thumbnail_input').trigger('click'); 
});




// QUICK VIEW MODAL
$(document).on("click", ".quick-view", function () {
     var name = $(this).data('name');
     var price = $(this).data('price') + '€';
     var excerpt = $(this).data('excerpt');
     var photo = $(this).data('photo');
     $("#name-product").html(name);
     $("#name-product").attr('href', $("#name-product").attr('href') + '/' + $(this).data('id'));
     $("#price-product").html(price);
     $("#excerpt-product").html(excerpt);
     $("#photo-product").attr('style', 'background-image: url(data:image/jpeg;base64,' + photo + '); width: 100%; aspect-ratio: 1/1;');
     $("#go-to").attr('href', $("#go-to").attr('href') + '/' + $(this).data('id'));
});



// FILTERS
function clearAllFilters() {
  window.location.assign(window.location.href.replace(window.location.search,''));
}

function checkBox(target) {
  $("#" + target.id).attr('checked', function(index, attr){
    return attr == 'checked' ? null : 'checked';
  });
}


// DELETE IMAGE
let buttons = document.querySelectorAll(".deleteImageClass");
for (button of buttons) {
  button.addEventListener("click", (e) =>{
    let url = button.parentElement.dataset.url;
    let form = document.getElementById("deleteImageForm");
    form.action = url;
    form.submit();
  });
}


// ADD TO CART
let addCarts = document.querySelectorAll(".add-to-cart");
for (addCart of addCarts) {
  addCart.addEventListener("click", (e) =>{
    if (!addCart.dataset.exists) {
      Swal.fire({
        title: 'Add To Cart!',
        text: addCart.dataset.name,
        icon: 'success',
        showConfirmButton: false,
        allowOutsideClick: false
      });
      
      setTimeout(() => {
        let prod_id = $('.prod-id').val();
        let prod_qty = $('.prod-qty').val();
        
        let url = addCart.dataset.url + '/' + prod_qty;
        let form = document.getElementById("addCartForm");
        form.action = url;
        form.submit();
      }, 1500);
    } else {
      let prod_id = $('.prod-id').val();
      let prod_qty = $('.prod-qty').val();
      
      let url = addCart.dataset.url + '/' + prod_qty;
      let form = document.getElementById("addCartForm");
      form.action = url;
      form.submit();
    }
  });
}


// ORDER BY
function orderByFunction(target) {
  // if (!target.value.split('?')[1].includes('orderby')) {
  //   window.location.href += '&' + target.value.split('?')[1];
  // } else {
  //   window.location.href += '&' + target.value.split('?')[1];
  // }
  let orderBy = target.value.split('?')[1].split('=')[1].split('&')[0];
  let orderType = target.value.split('?')[1].split('=')[2];
  let queryString = window.location.search;  // get url parameters
  let params = new URLSearchParams(queryString);  // create url search params object
  params.delete('orderby');  // delete city parameter if it exists, in case you change the dropdown more then once
  params.delete('ordertype');  // delete city parameter if it exists, in case you change the dropdown more then once
  params.append('orderby', orderBy);
  params.append('ordertype', orderType);
  document.location.href = "?" + params.toString();
}