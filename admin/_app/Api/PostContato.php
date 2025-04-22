<?php 
require_once("../Config.inc.php");


$nome    = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
$email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone   = filter_input(INPUT_POST, 'phone', FILTER_DEFAULT);
$service = filter_input(INPUT_POST, 'service', FILTER_DEFAULT);
$message = filter_input(INPUT_POST, 'message', FILTER_DEFAULT);


$Mailsubject = "Nova Solicitação de Contato - " . SITE_NAME;
$MailContent = "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$Mailsubject}</title>
</head>
<body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;'>
    <div style='max-width: 600px; margin: 0 auto; background: #fff; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;'>
        <div style='background: #16162c; padding: 20px; text-align: center;'>
            <img src='" . BASE . "/assets/img/logo.png' alt='" . SITE_NAME . "' style='max-width: 150px;'>
        </div>
        <div style='padding: 20px;'>
            <h1 style='color: #16162c; font-size: 24px; margin-bottom: 20px;'>{$Mailsubject}</h1>
            <p><strong>Nome:</strong> {$nome}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Telefone:</strong> {$phone}</p>
            <p><strong>Serviço:</strong> {$service}</p>
            <p><strong>Mensagem:</strong></p>
            <p style='background: #f1f1f1; padding: 10px; border-radius: 5px;'>{$message}</p>
        </div>
        <div style='background: #f1f1f1; padding: 10px; text-align: center; font-size: 12px; color: #666;'>
            <p>Este e-mail foi enviado através do formulário de contato do site <strong>" . SITE_NAME . "</strong>.</p>
        </div>
    </div>
</body>
</html>";


// Cadastra o contato no banco de dados
$create = new Create;
$create->ExeCreate('site_crm_leads', [
    'lead_nome'         => $nome,
    'lead_telefone'     => $phone,
    'lead_email'        => $email,
    'lead_mensagem'     => $service . PHP_EOL . PHP_EOL . $message,
    'lead_dataCadastro' => date('Y-m-d H:i:s'),
    'lead_pagina'       => "Formulário de Contato",
]);

// Envia o e-mail para o responsável pelo contato
$Email = new Email;
$Email->EnviarMontando($Mailsubject, $MailContent, $nome, $email, MAIL_SENDER, MAIL_ADDRESS);


if(!$Email->getError()):
    echo json_encode([
        'classe' => 'popup-success',
        'mensagem' => 'Sua mensagem foi enviada com sucesso, entraremos em contato com você em breve!'
    ]);
else:
    echo json_encode([
        'classe' => 'popup-error',
        'mensagem' => 'Desculpe não foi possível enviar sua mensagem. Entre em contato atráves do e-mail ' . MAIL_ADDRESS . '. Obrigado!' . $Email->getError()
    ]);
endif;
