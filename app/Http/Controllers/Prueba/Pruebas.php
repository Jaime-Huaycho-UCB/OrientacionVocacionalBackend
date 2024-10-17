<?php
use App\Http\Controllers\Usuario\PreguntaController;
$con = new PreguntaController();
$con->obtenerPreguntas(1);