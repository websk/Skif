<?php
?>

<form action="<?php echo \Skif\Users\UserController::getLoginUrl(); ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-md-2 control-label">Email</label>
        <div class="col-md-10">
            <input type="text" name="email" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Пароль</label>
        <div class="col-md-10">
            <input type="password" name="password" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="save_auth" value="1"> Запомнить меня
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-primary">Войти</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <a href="<?php echo \Skif\Users\UserController::getForgotPasswordUrl(); ?>">Забыли пароль</a> /
            <a href="<?php echo \Skif\Users\UserController::getRegistrationFormUrl(); ?>">Регистрация</a>
        </div>
    </div>
    <input type="hidden" name="destination" value="/">
</form>
