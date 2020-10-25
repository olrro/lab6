<div class="container">
    <form class="form-signin" method="POST">
        <h1 class="h1 my-5 mt-2">Вход</h1>

        <label for="inputLogin" class="sr-only">Логин или E-mail</label>
        <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Логин или E-mail" minlength="6" maxlength="25" required autofocus autocomplete="off" />

        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Введите пароль" minlength="6" maxlength="50" required autocomplete="off" />

        <div class="checkbox my-3">
            <label> <input type="checkbox" value="remember-me" /> Чужой компьютер </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>

        <a href="{vk-auth}" class="btn btn-lg btn-outline-primary btn-block">
          <i class="fab fa-vk"></i>
        </a>

        <a class="my-3 text-decoration-none d-block" href="/register">Регистрация <i class="fas fa-user-plus align-middle"></i></a>
        <p class="text-muted">&copy; 2017-2020 - CourseBox</p>
    </form>
</div>

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
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
