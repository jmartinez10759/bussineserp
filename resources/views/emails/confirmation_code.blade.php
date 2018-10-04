<!DOCTYPE html>
<html>
<head>
	<title>Confirmar correo</title>
</head>
<body>
	<h2>Hola {{ $name }}, gracias por registrarte en <strong>Solicitud de Empleo</strong> !</h2>
    <p>Por favor confirma tu correo electrónico,</p>
    <p>y tener a la mano tu CURP y NSS, estos ultimos unicamante para el registro de tu informacion.</p>
    <p>Si no cuentas con NSS no te preocupes.</p>
    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

    <a href="{{ url('/register/verify/' . $confirmed_code) }}">
        Clic para confirmar tu email
    </a>
    
</body>
</html>
