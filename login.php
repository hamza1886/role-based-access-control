<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Company</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a><b>Company</b>
            <small>Login</small>
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $u = filter_input(INPUT_GET, "u", FILTER_VALIDATE_INT);
        if (!is_null($u) && $u !== false && $u == 2) { ?>
            <h3 class="text-danger" id="login-error-message">User is blocked, please contact administrator.</h3>
        <?php } ?>

        <form id="login-form">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                       required/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <span class="text-danger" id="login-error-message" style="display:none;"><small>Invalid login credentials, please try again.</small></span>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember_me" id="remember_me" value="1"> Remember Me
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>
        <hr>

        <a href="#">I forgot my password</a><br>
        <!--<a href="register.php" class="text-center">Register a new membership</a>-->

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="js/jquery-2.2.2.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="js/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $('document').ready(function () {
        $('#login-form').submit(function (e) {
            e.preventDefault();

            var email = $('#email').val();
            var password = $('#password').val();
            var remember_me = $('div[aria-checked=true]').hasClass('checked');

            console.log(email + ':' + password + ':' + remember_me);

            $.post('controller/ProcessLogin.php', {
                email: email,
                password: password,
                remember_me: remember_me
            }, function (data) {
                console.log(data);
                if (data.error === false) {
                    $('#login-error-message').slideUp('slow');
                    window.location.assign('index.php');
                } else {
                    $('#email').val(data.session.email).focus().parent().addClass('has-error');
                    $('#password').val('').parent().addClass('has-error');
                    $('#login-error-message').slideDown('slow');
                }
            }, 'json').error(function (e) {
                $('#email').focus().parent().addClass('has-error');
                $('#password').val('').parent().addClass('has-error');
                $('#login-error-message').slideDown('slow');
                console.log(e.responseText);
            });
        });
    });
</script>
</body>
</html>