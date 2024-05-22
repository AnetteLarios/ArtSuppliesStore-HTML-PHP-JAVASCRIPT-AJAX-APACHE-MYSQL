<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/contactFormCss.css" type="text/css">
    <link rel="icon" href="images/justbackground.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <title>Diseñart</title>
</head>
<body>
    <header id="navegation_bar">
        <a href="index.php">
            <img id="logo" src="images/diseñart.png" alt="logo">
        </a>
        <?php ?>
    <a class="link" id="home_link" href = "index.php">
        <p> Home</p>
    </a> 
    <a class="link" href = "productos.php">
        <p> Productos</p>
    </a>
    <a class="link" href = "contacto_formulario.php">
        <p> Contacto</p>
    </a>
    <?php
        if(empty($correoCliente)){
            echo "<a class='link'  href = '../Administración/index.php'>
                     <p> Iniciar Sesión </p>
                </a>";
        }else{
            echo "<a class='link'  href = 'carrito01.php'>
                    <p> Carrito(<span id='cart_count'>0</span>)</p>
                </a>";
        } 
    ?>
    <?php 
        if(!empty($correoCliente)){
            echo "<a class='link' href = 'funciones/cerrar_sesion.php'>
            <p> Cerrar Sesión</p>
        </a>";
        }
    ?>
    </header>
    </body>
    <h1>Políticas de Privacidad</h1>
    <p>Última actualización: 20/04/24</p>

    <h2>1. Introducción</h2>
    <p>Bienvenido a Diseñart. En Diseñart, nos comprometemos a proteger y respetar tu privacidad. Esta política de privacidad explica cómo recopilamos, usamos, divulgamos y protegemos tu información personal cuando visitas nuestro sitio web disseñart. (en adelante, "el Sitio").</p>

    <h2>2. Información que Recopilamos</h2>
    <p>Podemos recopilar y procesar la siguiente información sobre ti:</p>
    <ul>
        <li><strong>Información de Identificación Personal:</strong> Nombre, dirección de correo electrónico, dirección postal, número de teléfono y otros datos de contacto.</li>
        <li><strong>Información Técnica:</strong> Dirección IP, tipo de navegador y versión, configuración de la zona horaria, tipos y versiones de complementos del navegador, sistema operativo y plataforma.</li>
        <li><strong>Información sobre tu Visita:</strong> URLs completas, secuencia de clics hacia, a través y desde nuestro sitio (incluyendo fecha y hora), productos que has visto o buscado, tiempos de respuesta de las páginas, errores de descarga, duración de las visitas a ciertas páginas, información de interacción con la página (como desplazamiento, clics y mouse-overs).</li>
    </ul>

    <h2>3. Uso de la Información</h2>
    <p>Usamos la información que recopilamos sobre ti de las siguientes maneras:</p>
    <ul>
        <li>Para proporcionarte la información, productos y servicios que nos solicitas.</li>
        <li>Para gestionar tu cuenta y procesar tus pedidos.</li>
        <li>Para mejorar nuestro sitio y asegurarnos de que el contenido se presente de la manera más efectiva para ti y tu dispositivo.</li>
        <li>Para permitirte participar en funciones interactivas de nuestro servicio, cuando elijas hacerlo.</li>
        <li>Para mantener nuestro sitio seguro y protegido.</li>
        <li>Para medir o entender la efectividad de la publicidad que te servimos y para ofrecerte publicidad relevante.</li>
        <li>Para hacer sugerencias y recomendaciones sobre productos o servicios que pueden interesarte.</li>
    </ul>

    <h2>4. Divulgación de tu Información</h2>
    <p>Podemos compartir tu información personal con:</p>
    <ul>
        <li>Proveedores de servicios y subcontratistas para la ejecución de cualquier contrato que celebremos contigo.</li>
        <li>Anunciantes y redes publicitarias que necesiten los datos para seleccionar y ofrecer anuncios relevantes para ti y otros.</li>
        <li>Analistas y proveedores de motores de búsqueda que nos ayudan a mejorar y optimizar nuestro sitio.</li>
        <li>Autoridades legales y reguladoras, en caso de que tengamos la obligación de divulgar o compartir tus datos personales para cumplir con cualquier obligación legal.</li>
    </ul>

    <h2>5. Seguridad de los Datos</h2>
    <p>Nos comprometemos a garantizar que tu información esté segura. Para prevenir el acceso no autorizado o la divulgación, hemos implementado procedimientos físicos, electrónicos y administrativos adecuados para proteger y asegurar la información que recopilamos en línea.</p>

    <h2>6. Tus Derechos</h2>
    <p>Tienes derecho a:</p>
    <ul>
        <li>Acceder a la información que tenemos sobre ti.</li>
        <li>Solicitar la corrección de cualquier dato inexacto que tengamos sobre ti.</li>
        <li>Solicitar la eliminación de tu información personal.</li>
        <li>Oponerte al procesamiento de tu información personal.</li>
        <li>Solicitar la restricción del procesamiento de tu información personal.</li>
        <li>Solicitar la transferencia de tu información personal a otra parte.</li>
    </ul>
    <p>Si deseas ejercer alguno de estos derechos, por favor contáctanos a través de [Dirección de correo electrónico de contacto].</p>

    <h2>7. Enlaces a Otros Sitios Web</h2>
    <p>Nuestro sitio puede contener enlaces a otros sitios web de interés. Sin embargo, una vez que hayas utilizado estos enlaces para salir de nuestro sitio, debes tener en cuenta que no tenemos control sobre ese otro sitio web. Por lo tanto, no podemos ser responsables de la protección y la privacidad de cualquier información que proporciones mientras visitas dichos sitios y dichos sitios no se rigen por esta declaración de privacidad. Debes tener cuidado y leer la declaración de privacidad aplicable al sitio web en cuestión.</p>

    <h2>8. Cambios en Nuestra Política de Privacidad</h2>
    <p>Diseñart puede actualizar esta política de privacidad de vez en cuando. Cualquier cambio que hagamos en el futuro se publicará en esta página y, cuando sea apropiado, se te notificará por correo electrónico. Vuelve con frecuencia para ver cualquier actualización o cambio en nuestra política de privacidad.</p>

    <h2>9. Contacto</h2>
    <p>Si tienes alguna pregunta sobre esta política de privacidad, por favor contáctanos a través de:</p>
    <ul>
        <li>Correo electrónico: diseñart@gmail.com</li>
    </ul>
    </html>