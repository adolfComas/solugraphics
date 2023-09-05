<?php
if($_POST)
{
    $to_Email       = "contacto@solugraphics-chile.com"; 
    $no_responder   = "web@solugraphics-chile.com";
    
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    
        $output = json_encode(
        array(
            'type'=>'error', 
            'text' => 'Request must come from Ajax'
        ));
        
        die($output);
    } 
    
    if(!isset($_POST["userName"]) || !isset($_POST["userEmail"]) || !isset($_POST["userMessage"]))
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Datos requeridos están vacíos'));
        die($output);
    }

    //Sanitize input data using PHP filter_var().
    $user_Name        = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
    $user_Email       = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
    $user_phone       = filter_var($_POST["userPhone"], FILTER_SANITIZE_STRING);
    $user_Message     = filter_var($_POST["userMessage"], FILTER_SANITIZE_STRING);

    $subject          = 'Contacto WEB '.$_SERVER['SERVER_NAME']; 

    $user_Message = str_replace("\&#39;", "'", $user_Message);
    $user_Message = str_replace("&#39;", "'", $user_Message);
    
    //additional php validation
    if(strlen($user_Name)<4) // If length is less than 4 it will throw an HTTP error.
    {
        $output = json_encode(array('type'=>'error', 'text' => 'El nombre es muy corto o no hay datos'));
        die($output);
    }
    if(!filter_var($user_Email, FILTER_VALIDATE_EMAIL)) //email validation
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Ingrese un email válido'));
        die($output);
    }
    if(strlen($user_Message)<5) //check emtpy message
    {
        $output = json_encode(array('type'=>'error', 'text' => 'Mensaje muy corto, por favor ingrese un mensaje más largo.'));
        die($output);
    }

    $user_Name = replaceSpecials($user_Name);

    $user_Message = replaceSpecials($user_Message);


    $body_Message = '
            <html>
            <head>
              <title>'.$subject.'</title>
            </head>
            <body>
                <img src="https://solugraphics-chile.com/assets/images/logoweb.png" alt="Logo solugraphics-chile">
                <br>
                <br>
                <br>
              <table>
                <tr>
                  <td><strong>Nombre</strong></td>
                  <td>'.$user_Name.'</td>
                </tr>
                <tr>
                  <td><strong>Email</strong></td>
                  <td>'.$user_Email.'</td>
                </tr>
                <tr>
                  <td><strong>Celular</strong></td>
                  <td>'.$user_phone.'</td>
                </tr>
                <tr>
                  <td><strong>Mensaje:</strong></td>
                  <td style="text-align: justify;">'.$user_Message.'</td>
                </tr>
              </table>
              <br>
              <p>NOTA: <span style="color: red">Algunas tildes y caracteres fueron removidas intensionalmente para asegurar la correcta lectura del contenido de este correo.</span></p>
            </body>
            </html>
            ';


            $body_Message_copy = '
            <html>
            <head>
              <title>Hemos Recibido su correo</title>
            </head>
            <body>
                <img src="https://solugraphics-chile.com/assets/images/logoweb.png" alt="Logo solugraphics-chile">
                <br>
                <br>
                <br>
                <h3 style="color: #DD5F02">¡Hemos Recibido su mensaje con exito!</h3>
                <h4 style="color: #DD5F02">Muchas gracias por comunicarse con nosotros, muy pronto nos contactaremos con usted.</h4>
                <p style="color: #DD5F02">A Continuación una copia de su mensaje:</p>                
                <br>
                <br>
                <br>
              <table">
                <tr>
                  <td><strong>Nombre:</strong></td>
                  <td>'.$user_Name.'</td>
                </tr>
                <tr>
                  <td><strong>Email:</strong></td>
                  <td>'.$user_Email.'</td>
                </tr>
                <tr>
                  <td><strong>Celular:</strong></td>
                  <td>'.$user_phone.'</td>
                </tr>
                <tr>
                  <td><strong>Mensaje:</strong></td>
                  <td style="text-align: justify;">'.$user_Message.'</td>
                </tr>
              </table>
              <br>
              <p>NOTA: Este es un mensaje generado automaticamente, por favor no responda a este correo.<br>Esta es una copia de su mensaje enviado a través de la Web de solugraphics-chile.com<br><span style="color: red">Algunas tildes y caracteres fueron removidas intensionalmente para asegurar la correcta lectura del contenido de este correo.</span></p>
            </body>
            </html>
            ';
    
    //proceed with PHP email.
    $headers = 'Content-Type: text/html; charset=UTF-8, From: '.$user_Email.'' . "\r\n" .
    'Reply-To: '.$user_Email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $headersCopy = 'Content-Type: text/html; charset=UTF-8, From: '.$no_responder.'' . "\r\n" .
    'Reply-To: '.$user_Email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $sentMail = @mail($to_Email, $subject,  $body_Message, $headers);


    $sentMail = @mail($user_Email, "Mensaje de Nuestra Web", $body_Message_copy, $headersCopy);
    
    if(!$sentMail)
    {
        $output = json_encode(array('type'=>'error', 'text' => 'No se ha podido enviar el correo.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Hola '. $user_Name .', Muchas Gracias, ¡su correo ha sido enviado!<br />¡Muy pronto nos contactaremos con usted!'));
        die($output);
    }
}

    function replaceSpecials($text){
        $text = str_replace('á','a', $text);
        $text = str_replace('é','e', $text);
        $text = str_replace('í','i', $text);
        $text = str_replace('ó','o', $text);
        $text = str_replace('ú','u', $text);
        $text = str_replace('º','O', $text);
        $text = str_replace('ñ','n', $text);
        $text = str_replace('Á','A', $text);
        $text = str_replace('É','E', $text);
        $text = str_replace('Í','I', $text);
        $text = str_replace('Ó','O', $text);
        $text = str_replace('Ú','U', $text);
        $text = str_replace('Ñ','N', $text);

        return $text;
    }
?>