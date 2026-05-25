<?php
// =============================================================
// CONFIGURAÇÃO — preencher após subir na Hostinger
// =============================================================
$destinatario  = 'contato@escutaris.com.br';   // e-mail que recebe o contato
$assunto_base  = '[Site Escutaris] Novo contato';

// SMTP via Hostinger (preencher com os dados do painel)
// Deixar como '' para usar o mail() nativo (funciona na maioria dos planos Hostinger)
$smtp_host = '';      // ex: smtp.hostinger.com
$smtp_user = '';      // ex: contato@escutaris.com.br
$smtp_pass = '';      // senha do e-mail
$smtp_port = 587;
// =============================================================

// Segurança: só aceita POST com header correto
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    http_response_code(403);
    exit('Forbidden');
}

// Captura e sanitiza campos
$name    = strip_tags(trim($_POST['name']    ?? ''));
$email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
$phone   = strip_tags(trim($_POST['phone']   ?? ''));
$company = strip_tags(trim($_POST['company'] ?? ''));
$service = strip_tags(trim($_POST['service'] ?? ''));
$source  = strip_tags(trim($_POST['source']  ?? ''));
$message = strip_tags(trim($_POST['message'] ?? ''));

// Validação dos campos obrigatórios
if (!$name || !$email || !$phone || !$company || !$service || !$source) {
    http_response_code(400);
    exit('Preencha todos os campos obrigatórios.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('E-mail inválido.');
}

// Monta o corpo do e-mail
$corpo = "
<html>
<body style='font-family: Arial, sans-serif; color: #333; max-width: 600px;'>
  <h2 style='color: #1D4E6B; border-bottom: 2px solid #C8913A; padding-bottom: 8px;'>Novo contato pelo site Escutaris</h2>
  <table cellpadding='8' width='100%'>
    <tr><td width='180'><strong>Nome</strong></td><td>{$name}</td></tr>
    <tr style='background:#f5f5f5'><td><strong>E-mail</strong></td><td><a href='mailto:{$email}'>{$email}</a></td></tr>
    <tr><td><strong>WhatsApp</strong></td><td>{$phone}</td></tr>
    <tr style='background:#f5f5f5'><td><strong>Empresa</strong></td><td>{$company}</td></tr>
    <tr><td><strong>Serviço de interesse</strong></td><td>{$service}</td></tr>
    <tr style='background:#f5f5f5'><td><strong>Como nos conheceu</strong></td><td>{$source}</td></tr>
    <tr><td><strong>Mensagem</strong></td><td>" . ($message ?: '—') . "</td></tr>
  </table>
  <p style='margin-top:24px; font-size:12px; color:#999;'>Enviado pelo formulário de contato em escutaris.com.br</p>
</body>
</html>
";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: Site Escutaris <{$destinatario}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$assunto = "{$assunto_base} — {$service}";

if (mail($destinatario, $assunto, $corpo, $headers)) {
    echo 'OK';
} else {
    http_response_code(500);
    exit('Erro ao enviar. Tente novamente ou entre em contato pelo WhatsApp.');
}
