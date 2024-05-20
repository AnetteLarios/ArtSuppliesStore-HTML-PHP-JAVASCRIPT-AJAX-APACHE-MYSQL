<html lang = es>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel="stylesheet" href="css/contactFormCss.css" type="text/css">
        <link rel="icon" href="images/justbackground.png">
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <title>Diseñart</title>
        <script>
            function checkEmail(){
            var correo = document.contact_form.correo.value;

            $.ajax({
            url: 'funciones/contacto_envia.php',
            type: 'post',
            dataType: 'text',
            data: {correo: correo},
            success: function(response) {
                if (response == 'Correo enviado correctamente'){
                    $('#message').show(); 
                    $('#message').html('Comentario enviado correctmente');
                    setTimeout(function(){
                        $('#message').html('');
                    }, 5000);
                }
            },
            error: function() {
                alert("Error al procesar el correo");
            }
        });

    }
        </script>
    </head>
    <body>
        <header id="navegation_bar">
            <a href="index.php">
                        <img id="logo" src="images/diseñart.png" alt = "logo">
            </a>
            <?php
                include('menu.php');
            ?>
        </header>
        <p id="title">Formulario de Contacto</p>
        <form name="contact_form" id="contact_form" method="post" action="funciones/contacto_envia.php">
            <label>
                Nombre:
                <br>
                <input type="text" name="nombre" required>
            </label>
            <br>
            <label>
                Apellidos:
                <br>
                <input type="text" name="apellidos" required>
            </label>
            <br>
            <label>
                Correo:
                <br>
                <input type="email" name="correo" placeholder="@" required> 
            </label>
            <br>
            <label>
                Comentario:
                <br>
                <input type="text" name="comentario" id="comment" required>
            </label>
            <br><br>
            <input id="submit_button" type="submit" name="button">Enviar</input>
            <div id="message"></div>
        </form>
        <footer>
            <?php
                include ('footer.php'); 
            ?>
        </footer>
    </body>
</html>