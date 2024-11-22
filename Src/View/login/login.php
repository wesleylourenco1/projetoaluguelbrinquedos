<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="../../dist/img/logo.png" alt="Logo" style="border-radius: 10px; max-width: 100px;" class="img-fluid">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm" onsubmit="return submitForm()">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuario" id="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                        <div class="row mt-2">
                            <div id="error-message" class="alert alert-danger" style="display: none;">
                                <!-- Mensagem de erro será exibida aqui -->
                            </div>
                        </div>
                    </div>
                </form>


                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function submitForm() {

            fetch('/confirmlogin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        usuario: document.getElementById('email').value,
                        senha: document.getElementById('password').value,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirecione apenas se o login for bem-sucedido
                        window.location.href = '/';
                    } else {
                        // Exibir a mensagem de erro na div
                        const errorMessageDiv = document.getElementById('error-message');
                        errorMessageDiv.style.display = 'block';
                        errorMessageDiv.innerHTML = 'Login failed. Please check your credentials.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            // Evite o envio do formulário tradicional
            return false;
        }
    </script>
</body>

</html>