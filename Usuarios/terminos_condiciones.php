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
    <h1>Términos y Condiciones</h1>
    <p>Última actualización: 20/04/24</p>
    <h2>1. Introducción</h2>
    <p>Bienvenido a Diseñart. Estos términos y condiciones describen las reglas y regulaciones para el uso del sitio web de Diseñart, ubicado en diseñart.</p>
    <p>Al acceder a este sitio web, asumimos que aceptas estos términos y condiciones. No continúes usando Diseñart si no estás de acuerdo con todos los términos y condiciones establecidos en esta página.</p>
    
    <h2>2. Cookies</h2>
    <p>El sitio web utiliza cookies para ayudar a personalizar tu experiencia en línea. Al acceder a Diseñart, aceptaste utilizar las cookies necesarias.</p>
    <p>Una cookie es un archivo de texto que un servidor de páginas web coloca en tu disco duro. Las cookies no se pueden usar para ejecutar programas o enviar virus a tu computadora. Las cookies se te asignan de manera única y solo pueden ser leídas por un servidor web en el dominio que emitió la cookie para ti.</p>
    <p>Podemos usar cookies para recopilar, almacenar y rastrear información con fines estadísticos o de marketing para operar nuestro sitio web. Tienes la capacidad de aceptar o rechazar cookies opcionales. Hay algunas cookies obligatorias que son necesarias para el funcionamiento de nuestro sitio web. Estas cookies no requieren tu consentimiento ya que siempre funcionan. Ten en cuenta que al aceptar cookies requeridas, también aceptas cookies de terceros, que podrían usarse a través de servicios proporcionados por terceros si utilizas dichos servicios en nuestro sitio web, por ejemplo, una ventana de visualización de video proporcionada por terceros e integrada en nuestro sitio web.</p>
    
    <h2>3. Licencia</h2>
    <p>A menos que se indique lo contrario, Diseñart y/o sus licenciantes poseen los derechos de propiedad intelectual de todo el material en Diseñart. Todos los derechos de propiedad intelectual están reservados. Puedes acceder a esto desde Diseñart para tu uso personal sujeto a las restricciones establecidas en estos términos y condiciones.</p>
    <p>No debes:</p>
    <ul>
        <li>Copiar o volver a publicar material de Diseñart</li>
        <li>Vender, alquilar o sublicenciar material de Diseñart</li>
        <li>Reproducir, duplicar o copiar material de Diseñart</li>
        <li>Redistribuir contenido de Diseñart</li>
    </ul>
    
    <h2>4. Comentarios y opiniones</h2>
    <p>Partes de este sitio web ofrecen a los usuarios la oportunidad de publicar e intercambiar opiniones e información en ciertas áreas del sitio web. Diseñart no filtra, edita, publica ni revisa los comentarios antes de su presencia en el sitio web. Los comentarios no reflejan los puntos de vista ni las opiniones de Diseñart, sus agentes y/o afiliados. Los comentarios reflejan los puntos de vista y opiniones de la persona que publica sus puntos de vista y opiniones. En la medida en que lo permitan las leyes aplicables, Diseñart no será responsable de los comentarios ni de ninguna responsabilidad, daños o gastos causados y/o sufridos como resultado de cualquier uso y/o publicación y/o aparición de los comentarios en este sitio web.</p>
    <p>Diseñart se reserva el derecho de monitorear todos los comentarios y eliminar cualquier comentario que pueda considerarse inapropiado, ofensivo o que cause el incumplimiento de estos Términos y Condiciones.</p>
    
    <h2>5. Hipervínculos a nuestro contenido</h2>
    <p>Las siguientes organizaciones pueden enlazar a nuestro sitio web sin aprobación previa por escrito:</p>
    <ul>
        <li>Agencias gubernamentales;</li>
        <li>Motores de búsqueda;</li>
        <li>Organizaciones de noticias;</li>
        <li>Los distribuidores de directorios en línea pueden enlazar a nuestro sitio web de la misma manera que hacen hipervínculos a los sitios web de otras empresas listadas; y</li>
        <li>Empresas acreditadas en todo el sistema, excepto la solicitud de organizaciones sin fines de lucro, centros comerciales de caridad y grupos de recaudación de fondos de caridad que no pueden tener hipervínculos a nuestro sitio web.</li>
    </ul>
    <p>Estas organizaciones pueden enlazar a nuestra página de inicio, a publicaciones o a otra información del sitio web, siempre y cuando el enlace: (a) no sea de ninguna manera engañoso; (b) no implique falsamente patrocinio, respaldo o aprobación de la parte vinculante y sus productos y/o servicios; y (c) se ajuste al contexto del sitio de la parte vinculante.</p>
    
    <h2>6. Responsabilidad del contenido</h2>
    <p>No seremos responsables de ningún contenido que aparezca en tu sitio web. Aceptas protegernos y defendernos contra todas las reclamaciones que están surgiendo en tu sitio web. Ningún enlace(s) debe aparecer en ningún sitio web que pueda interpretarse como difamatorio, obsceno o criminal, o que infrinja, de otra manera viole o defienda la infracción u otra violación de, cualquier derecho de terceros.</p>
    
    <h2>7. Reserva de derechos</h2>
    <p>Nos reservamos el derecho de solicitar que elimines todos los enlaces o cualquier enlace particular a nuestro sitio web. Apruebas eliminar de inmediato todos los enlaces a nuestro sitio web a solicitud. También nos reservamos el derecho de modificar estos términos y condiciones y su política de enlaces en cualquier momento. Al vincular continuamente a nuestro sitio web, aceptas estar obligado a seguir estos términos y condiciones de vinculación.</p>
    
    <h2>8. Eliminación de enlaces de nuestro sitio web</h2>
    <p>Si encuentras algún enlace en nuestro sitio web que sea ofensivo por cualquier motivo, eres libre de contactarnos e informarnos en cualquier momento. Consideraremos las solicitudes para eliminar enlaces, pero no estamos obligados a hacerlo ni a responderte directamente.</p>
    <p>No aseguramos que la información en este sitio web sea correcta, no garantizamos su integridad o exactitud; ni prometemos asegurarnos de que el sitio web permanezca disponible o que el material en el sitio web se mantenga actualizado.</p>
    
    <h2>9. Descargo de responsabilidad</h2>
    <p>En la medida máxima permitida por la ley aplicable, excluimos todas las representaciones, garantías y condiciones relacionadas con nuestro sitio web y el uso de este sitio web. Nada en este descargo de responsabilidad:</p>
    <ul>
        <li>Limitará o excluirá nuestra o tu responsabilidad por muerte o lesiones personales;</li>
        <li>Limitará o excluirá nuestra o tu responsabilidad por fraude o tergiversación fraudulenta;</li>
        <li>Limitará cualquiera de nuestras o tus responsabilidades de cualquier manera que no esté permitida por la ley aplicable; o</li>
        <li>Excluya cualquiera de nuestras o tus responsabilidades que no puedan estar excluidas bajo la ley aplicable.</li>
    </ul>
    <p>Las limitaciones y prohibiciones de responsabilidad establecidas en esta Sección y en otras partes de este descargo de responsabilidad: (a) están sujetas al párrafo anterior; y (b) regirán todas las responsabilidades que surjan bajo la exoneración de responsabilidad, incluidas las responsabilidades que surjan en el contrato, en agravio y por incumplimiento del deber legal.</p>
    <p>Siempre que el sitio web y la información y los servicios en el sitio web se proporcionen de forma gratuita, no seremos responsables de ninguna pérdida o daño de cualquier naturaleza.</p>
</body>
</html>
    </html>