<!DOCTYPE html>
<html>
<head>
	<title>Postulacion Exitosa</title>
</head>
<body>
	<h2>Hola {{ $name}}, te haz postulado exitosamente por medio de  <strong>Solicitud de Empleo</strong> !</h2>
    <p>a la vacante {{ $name_vacante }}. de la empresa {{ $name_company }}.</p>
    <p>Favor de revisar su postulacion en el portal  <a href="{{ url('/details') }}">Solicitud de empleo </a></p>
</body>
</html>
