$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', '.fileAttach:file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

//   We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $('.fileAttach:file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'), log = '';
//          log = numFiles > 1 ? numFiles + ' files selected' : label;

            switch (numFiles) {
                case 1:
                log = label;
                break;
                case 2: case 3: case 4:
                  log = numFiles + ' файла выбрано';
                  break;
                default:
                  log = numFiles + ' файлов выбрано';
            }

          if( input.length ) {
              input.val(log);
              $(this).parents('.input-group').find('.eraseAttachment').css('visibility','visible');
          }
//          else {
//              if( log ) alert(log);
//          }

      });

      if ($('.fileAttach:file').parents('.input-group').find(':text').val()) {
          $('.fileAttach:file').parents('.input-group').find('.eraseAttachment').css('visibility','visible');
      }
  });

    $('.eraseAttachment').on('click', function(){
        var input = $(this).parents('.input-group').find(':text'),
              log = '';
        input.val(log);
        $(this).css('visibility','hidden');
        $('.fileAttach:file').prop('value', null);
//        console.log($('.fileAttach:file').val());
//        $(':file').trigger('fileselect', [0, '']);
    });

});