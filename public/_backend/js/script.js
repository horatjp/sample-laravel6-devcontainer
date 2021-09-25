
$(function(){

    $('.datetimepicker').datetimepicker({
        dayViewHeaderFormat: 'YYYY年 M月',
        tooltips: {

        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check-o',
            clear: 'far fa-trash',
            close: 'far fa-times'
        },

        format: 'YYYY-MM-DD HH:mm',
        locale: 'ja',
    });

    $('.datepicker').datetimepicker({
        dayViewHeaderFormat: 'YYYY年 M月',
        tooltips: {

        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check-o',
            clear: 'far fa-trash',
            close: 'far fa-times'
        },
        format: 'YYYY-MM-DD',
        locale: 'ja',
    });

    $('.select2').select2();

    $('[data-toggle="tooltip"]').tooltip();

    // 確認
    $('[data-toggle="confirm"]').on('click', function (event) {

        let clickElm = this;

        modalConfirm($(clickElm).data('message'), (ans) => {

            if (ans) {
                $(clickElm).off('click');
                clickElm.click();
            }
        });

        return false;
    });

    // 削除確認
    $('[data-toggle="delete-confirm"]').on('click', function (event) {

        let clickElm = this;

        modalConfirm('削除しますか？', (ans) => {

            if (ans) {
                $(clickElm).off('click');
                clickElm.click();
            }
        });

        return false;
    });

    // 一覧遷移
    $('tbody tr[data-href]').addClass('clickable').click( function() {

        window.location = $(this).attr('data-href');

    }).find('a').hover( function() {

        $(this).parents('tr').unbind('click');

    }, function() {

        $(this).parents('tr').click( function() {

            window.location = $(this).attr('data-href');

        });

    });

    // 画像オーバーレイ
    $('.imageOverlay').on('click', function () {
        return imageOverlay(this.src)
    });

    $('.upload-image').each(function() {

        let uploadImage = $(this);

        let name = uploadImage.data('name');
        let url = uploadImage.data('url');
        let asset = uploadImage.data('asset');
        let loadOptions = uploadImage.data('load-options');


        // default
        let options = {
             canvas: true
            ,maxWidth: 1024
            ,maxHeight: 1024
            ,crop: false
        };

        options = Object.assign(options, loadOptions);

        // Dropzone
        new Dropzone(uploadImage.find('.drop').get(0), {

            url: 'dummy',
            autoProcessQueue: false,
            maxFiles: 1,
            clickable : uploadImage.find('.clickable').get(),
            acceptedFiles: 'image/*',

            addedfile: (file) => {

              if(!/image/.test(file.type)) {
                  alert('画像を選択してください。');
                  return;
              }

              loadImage.parseMetaData(file, (data) => {

                  if (data.exif) {
                      options.orientation = data.exif.get('Orientation')
                  }

                  loadImage(file, (canvas) => {

                      const dataUri = canvas.toDataURL('image/png');

                      const params = new FormData();

                      params.append('base64', dataUri);

                      axios.post(url, params, {onUploadProgress: (e) => {

                          console.log(e.loaded + ' ' + e.total);

                      }})
                      .then((result) => {

                          let data = result.data;

                          if (data['error']) {

                              alert(data['error'])

                          } else {

                              uploadImage.find('input[name=' + name + ']').val(data['path']);

                              uploadImage.find('.preview img').attr('src', asset + data['path']);
                              uploadImage.find('.preview').show();
                          }

                      })
                      .catch((error) => {

                          alert(error)
                      });

                  }, options);
              });

            }
        });

        // Delete
        uploadImage.find('.preview img').on('click', function () {

            uploadImage.find('input[name=' + name + ']').val('');

            uploadImage.find('.preview img').attr('src', '');

            uploadImage.find('.preview').hide();

        });
    });


});


/**
 * 確認画面
 */
function modalConfirm(message, handler) {

    let domName = 'modal-confirm';

    let dom = $(`<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">${message}</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm btn-no" data-dismiss="modal">いいえ</button>
                    <button type="button" class="btn btn-info btn-sm btn-yes">はい</button>
                </div>
            </div>
        </div>
    </div>`);

    $('body').prepend(dom);

    dom.modal({
        backdrop: 'static',
        keyboard: false
    });

    dom.find('.btn-yes').click(function () {
        handler(true);
        dom.modal('hide');
    });

    dom.find('.btn-no').click(function () {
        handler(false);
        dom.modal("hide");
    });

    dom.on('hidden.bs.modal', function () {
        this.remove();
    });
}


/**
 * 画像をオーバーレイ
 */
function imageOverlay(url) {

    if (!url) {
        return;
    }

    var img = new Image();
    img.src = url;

    $(img).on('load', function() {

        var margin = 20;

        var width = img.width;
        var height = img.height;

        var maxWidth = $(window).width() - margin;
        var maxHeight = $(window).height() - margin;


        var raitoA = maxWidth / maxHeight;
        var raitoB = img.width / img.height;

        if ( (img.width > maxWidth || img.height > maxHeight) && raitoA <= raitoB ) {

            var raito = img.width / maxWidth;
            width = img.width / raito;
            height = img.height / raito;

        } else if ( (img.width > maxWidth || img.height > maxHeight) && raitoA >= raitoB ) {

            var raito = img.height / maxHeight;
            height = img.height / raito;
            width = img.width / raito;
        }


        var left = (maxWidth / 2) - width / 2 + margin / 2;
        var top = (maxHeight / 2) - height / 2 + margin / 2;


        var overlayDom = $('<div/>')
        .css({
            position: 'fixed'
            ,display: 'none'
            ,top: '0'
            ,width: '100%'
            ,height: '100%'
            ,zIndex: '100'
            ,backgroundColor: 'rgba(0,0,0,0.4)'
        });

        var overlayImageDom = $('<img/>')
        .css({
            display: 'inline-block'
            ,position: 'absolute'
            ,left: left
            ,top: top
            ,width: width
            ,height: height

            ,padding: '4px'
            ,backgroundColor: '#fff'
            ,border: '1px solid #ddd'
            ,borderRadius: '4px'
        })
        .attr('src', url);


        overlayDom.append(overlayImageDom);


        $('body').prepend(overlayDom);

        overlayDom.fadeIn();

        overlayDom.on('click', function(){
            overlayDom.remove()
        });

    });
  }
