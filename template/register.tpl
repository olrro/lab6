<div class="container">
    <form class="form-signin" method="POST">
        <h1 class="h1 my-5 mt-2">Регистрация</h1>

        <label for="inputLogin" class="sr-only">Логин</label>
        <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Введите логин" minlength="6" maxlength="25" required autofocus autocomplete="off" data-toggle="popover" data-trigger="hover" data-content="Введен неверный логин или либо он уже занят - от 6 до 25 символов" />

        <label for="inputEmail" class="sr-only">E-mail</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="E-mail" minlength="3" maxlength="255" required autocomplete="off" data-toggle="popover" data-trigger="hover" data-content="Введен неверный E-mail или такой адрес уже зарегистрирован - от 3 до 255 символов" />

        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Введите пароль" minlength="6" maxlength="50" required autocomplete="off" data-toggle="popover" data-trigger="hover" data-content="Слижком простой пароль - от 6 символов и не более 50" />

        <label for="inputRepeat" class="sr-only">Повторите пароль</label>
        <input type="password" id="inputRepeat" name="repeat" class="form-control" placeholder="Повторите пароль" minlength="6" maxlength="50" required autocomplete="off" data-toggle="popover" data-trigger="hover" data-content="Пароли не совпадают" />

        <div class="checkbox my-3">
            <label> <input type="checkbox" required> Я принимаю <a href="#">правила сайта</a> </label>
        </div>

        <script src="https://www.google.com/recaptcha/api.js?render={recaptcha-public}"></script>
        <input id="g-recaptcha-response" type="hidden" name="g-recaptcha-response">

        <button class="btn btn-lg btn-primary btn-block mt-3" type="submit" id="sendBtn">Вперед</button>

        <a class="my-3 text-decoration-none d-block" href="/login">Авторизация <i class="fas fa-sign-in-alt align-middle"></i></a>
        <p class="text-muted">&copy; 2017-2020 - CourseBox</p>
    </form>
</div>

<script type="text/javascript">

  grecaptcha.ready( function () {
      grecaptcha.execute( '{recaptcha-public}', {action: 'register'} ).then( function( token ) {
          $('#g-recaptcha-response').val( token )
      });
  });

  $( '#inputLogin' ).change( function() {
    $.getJSON( '/ajax/register.php', { login: $( '#inputLogin' ).val() } ).done( function( data ) {
      if ( !data.status ) {
        $( '#inputLogin' ).addClass( 'is-invalid' ).removeClass( 'is-valid' ).popover( 'enable' );
      }
      else {
        $( '#inputLogin' ).removeClass( 'is-invalid' ).addClass( 'is-valid' ).popover( 'dispose' );
      }
    });
  });

  $( '#inputEmail' ).change( function() {
     $.getJSON( '/ajax/register.php', { email: $(this).val() } ).done( function( data ) {
       if ( !data.status ) {
         $( '#inputEmail' ).addClass( 'is-invalid' ).removeClass( 'is-valid' ).popover( 'enable' );
       }
       else {
         $( '#inputEmail' ).removeClass( 'is-invalid' ).addClass( 'is-valid' ).popover( 'dispose' );
       }
     });
  });

  $( '#inputPassword' ).change( function() {
    if ( $( '#inputPassword' ).val().length < 6 || $( '#inputPassword' ).val().length > 50 ) {
      $( '#inputPassword' ).addClass( 'is-invalid' ).removeClass( 'is-valid' ).popover( 'enable' );
    }
    else {
      $( '#inputPassword' ).removeClass( 'is-invalid' ).addClass( 'is-valid' ).popover( 'dispose' );
    }
  });

  $( '#inputRepeat' ).change( function() {
     if ( $( '#inputRepeat' ).val() != $( '#inputPassword' ).val() ) {
         $( '#inputRepeat' ).addClass( 'is-invalid' ).removeClass( 'is-valid' ).popover( 'enable' );
     }
     else {
       $( '#inputRepeat' ).removeClass( 'is-invalid' ).addClass( 'is-valid' ).popover( 'dispose' );
     }
  });

  $( 'form' ).submit( function ( event ) {

    event.preventDefault();

    if ( $( '.is-valid' ).length > 3 ) {
      this.submit();
    }

  });

</script>

<style media="screen">
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 3;
    }
    .form-signin input[id="inputLogin"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[id="inputEmail"] {
        border-radius: 0;
        margin-bottom: -1px;
    }
    .form-signin input[id="inputPassword"] {
        border-radius: 0;
        margin-bottom: -1px;
    }
    .form-signin input[id="inputRepeat"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
