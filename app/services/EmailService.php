<?php

require_once ROOT_PATH . '/libraries/src/Exception.php';
require_once ROOT_PATH . '/libraries/src/PHPMailer.php';
require_once ROOT_PATH . '/libraries/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    public static function enviarRegistro($correo, $nombre, $usuario)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'nutricontrollasallista@gmail.com';
            $mail->Password = 'nzyv nudw tzkt ecqj';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(
                'nutricontrollasallista@gmail.com',
                'NutriControl La Sallista'
            );

            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);

            $mail->Subject = 'Registro exitoso - NutriControl La Sallista';

            $mail->Body = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Registro exitoso</title>
            </head>

            <body style="
                margin:0;
                padding:0;
                background:#f3f4f6;
                font-family:Arial, Helvetica, sans-serif;
            ">

                <div style="
                    width:100%;
                    padding:40px 0;
                ">

                    <div style="
                        max-width:600px;
                        margin:0 auto;
                        background:#ffffff;
                        border-radius:16px;
                        overflow:hidden;
                        box-shadow:0 8px 30px rgba(0,0,0,0.08);
                    ">

                        <div style="
                            background:#111827;
                            padding:35px;
                            text-align:center;
                        ">

                            <h1 style="
                                margin:0;
                                color:#ffffff;
                                font-size:28px;
                            ">
                                NutriControl La Sallista
                            </h1>

                            <p style="
                                color:#d1d5db;
                                margin:10px 0 0;
                                font-size:15px;
                            ">
                                Plataforma académica
                            </p>

                        </div>

                        <div style="
                            padding:35px;
                            color:#374151;
                        ">

                            <h2 style="
                                margin-top:0;
                                color:#111827;
                            ">
                                ¡Registro exitoso!
                            </h2>

                            <p style="
                                font-size:16px;
                                line-height:1.7;
                            ">
                                Hola,
                                <strong>' . htmlspecialchars($nombre) . '</strong>.
                            </p>

                            <p style="
                                font-size:16px;
                                line-height:1.7;
                            ">
                                Tu registro en
                                <strong>NutriControl La Sallista</strong>
                                se realizó correctamente.
                            </p>

                            <div style="
                                background:#f3f4f6;
                                border-radius:10px;
                                padding:20px;
                                margin:25px 0;
                            ">

                                <p style="margin:0 0 10px;">
                                    <strong>Usuario:</strong>
                                    ' . htmlspecialchars($usuario) . '
                                </p>

                                <p style="margin:0;">
                                    <strong>Correo:</strong>
                                    ' . htmlspecialchars($correo) . '
                                </p>

                            </div>

                            <p style="
                                font-size:16px;
                                line-height:1.7;
                            ">
                                Tu cuenta ya está lista. Puedes ingresar a
                                la plataforma utilizando los datos
                                que registraste.
                            </p>

                            <div style="
                                text-align:center;
                                margin:30px 0;
                            ">

                                <a
                                    href="' . BASE_URL . '"
                                    style="
                                        display:inline-block;
                                        padding:14px 28px;
                                        background:#111827;
                                        color:#ffffff;
                                        text-decoration:none;
                                        border-radius:8px;
                                        font-size:16px;
                                        font-weight:bold;
                                    "
                                >
                                    Ingresar a la plataforma
                                </a>

                            </div>

                            <p style="
                                font-size:14px;
                                line-height:1.6;
                                color:#6b7280;
                            ">
                                Si tú no realizaste este registro,
                                puedes ignorar este mensaje.
                            </p>

                        </div>

                        <div style="
                            background:#f9fafb;
                            padding:20px;
                            text-align:center;
                            border-top:1px solid #e5e7eb;
                        ">

                            <p style="
                                margin:0;
                                font-size:13px;
                                color:#6b7280;
                            ">
                                © ' . date('Y') . '
                                NutriControl La Sallista
                            </p>

                        </div>

                    </div>

                </div>

            </body>
            </html>
            ';

            $mail->AltBody =
                "Hola {$nombre}. Tu registro en NutriControl La Sallista se realizó correctamente. Tu usuario es: {$usuario}";

            return $mail->send();

        } catch (Exception $e) {

            error_log(
                'Error enviando correo: ' . $mail->ErrorInfo
            );

            return false;
        }
    }
}