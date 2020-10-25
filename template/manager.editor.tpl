<div class="container">
    <h1 class="mt-5">
        Редактор <a href="/manager/editor#start" id="start"><i class="fas fa-highlighter"></i></a>
    </h1>
    <p class="lead mb-5">
        На данной странице вы можете редактировать объекты содержащиеся в базе данных
    </p>

    <form method="POST">
        <div class="row">
          <div class="col-md">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputType">Показать</label>
                </div>

                <select class="custom-select" name="editor_type" id="inputType">
                    <option value="1" selected>Показать список преподавателей</option>
                    <option value="0">Показать список студентов</option>
                </select>
            </div>
          </div>
          <div class="col-md">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputSort">Сортировка</label>
                </div>

                <select class="custom-select" name="editor_sort" id="inputSort">
                    <option value="0" selected>Сначала старые</option>
                    <option value="1">Сначала новые</option>
                </select>
            </div>
          </div>
          <div class="col-12">
            <div class="input-group mb-3">
                <input type="text" name="editor_search" class="form-control" id="inputSearch" placeholder="Поиск информации">
            </div>
            <button type="submit" class="btn btn-primary">Выполнить</button>
          </div>

        </div>
    </form>

    <h4 class="my-5 text-center border-left py-4 border-separator"><span class="text-primary">О</span>бъекты</h4>

    <div style="display: none;" id="placeholder">
        <div class="d-flex justify-content-center align-items-center my-5">
            <i class="fas display-4 fa-circle-notch fa-spin"></i>
            <h5 class="ml-3">Выполняется поиск</h5>
        </div>
    </div>

    <div id="results">
        {results}
    </div>

    <a href="/manager" class="btn btn-lg btn-outline-primary w-100 mb-4 animate__animated animate__headShake"> <i class="fas fa-arrow-left"></i> </a>

    <p>Вернуться на <a href="/">главную страницу</a></p>
</div>

<script type="text/javascript">

$( 'form' ).submit( function( event ){

  event.preventDefault();

  $( 'form' ).find( ':input:not(:disabled)' ).prop( 'disabled', 1 );
  $( '#placeholder' ).fadeIn( 'fast' );
  $( '#results' ).html('').hide();

  $.ajax({
      type: 'POST',
      url: '/ajax/search.php',
      data: { editor_search: $('#inputSearch').val(), editor_sort: $('#inputSort').val(), editor_type: $('#inputType').val() },
      success: function( data ){
        $( '#placeholder' ).fadeOut( 'fast', function(){
          $( 'form' ).find( ':input(:disabled)' ).prop( 'disabled', 0 );
          $( '#results' ).prepend( data ).fadeIn( 'fast' );
        });
      },
      error: function() {
          alert( 'Произошла ошибка, попробуйте позже' );
      }
  });

});

</script>
