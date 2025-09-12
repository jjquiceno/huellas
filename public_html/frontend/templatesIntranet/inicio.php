<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1 class="regular x2">Bienvenido de vuelta <span class="bold" style="letter-spacing: 2px"><?php echo $_SESSION['username']; ?></span></h1>
    <p class="regular x1-5" style="padding: 10px; border-radius: 10px; width: fit-content; background-color:rgba(242, 202, 0, 0.16); ">¿Que deseas hacer hoy?</p>
    <div class="sliderInicio">
        <button class="slider-control prev" aria-label="Anterior"><i class="fa-solid fa-angle-left fa-xl"></i></button>
        <div class="slider-track">
            <div class="sliderInt">Slide 1</div>
            <div class="sliderInt">Slide 2</div>
            <div class="sliderInt">Slide 3</div>
            <div class="sliderInt">Slide 4</div>
            <div class="sliderInt">Slide 5</div>
            <div class="sliderInt">Slide 6</div>
        </div>
        <button class="slider-control next" aria-label="Siguiente"><i class="fa-solid fa-angle-right fa-xl"></i></button>
        <div class="slider-indicators"></div>
    </div>
</body>
</html>
<?php
$conexion->close();
?>
