<?php
$request_form_sent   = false;
$request_form_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_form_submit'])) {
    // Honeypot: real users never fill this hidden field.
    if (!empty($_POST['website'])) {
        $request_form_sent = true; // silently pretend success to bots
    } else {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $people  = trim($_POST['people'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name === '') {
            $request_form_errors[] = 'الرجاء إدخال الاسم.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $request_form_errors[] = 'الرجاء إدخال بريد إلكتروني صحيح.';
        }
        if ($message === '') {
            $request_form_errors[] = 'الرجاء إدخال رسالتك.';
        }

        if (!$request_form_errors) {
            $d  = site_data();
            $to = $d['contact']['email'];
            $subject = 'طلب خدمة جديد من الموقع - ' . $name;
            $body  = "اسم: {$name}\n";
            $body .= "البريد الإلكتروني: {$email}\n";
            if ($people !== '') {
                $body .= "عدد الأشخاص: {$people}\n";
            }
            $body .= "الرسالة:\n{$message}\n";
            $headers = "Content-Type: text/plain; charset=UTF-8\r\n" . 'Reply-To: ' . $email;

            @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);
            $request_form_sent = true;
        }
    }
}
?>
<style>
.request-form{width:100%;display:flex;flex-direction:column;gap:18px;box-sizing:border-box;}
.request-form input[type=text],.request-form input[type=email],.request-form textarea{
    width:100%;border:none;border-radius:0;padding:14px 20px;font-family:inherit;font-size:15px;
    background:#fafafa;color:#1b2437;box-sizing:border-box;
}
.request-form textarea{min-height:138px;resize:vertical;}
.request-form button{
    align-self:flex-start;border:none;border-radius:0;padding:11px 34px;font-size:16px;font-weight:700;
    background:#d97d68;color:#212d45;cursor:pointer;font-family:inherit;
}
.request-form button:hover{opacity:.9;}
.request-form .rf-notice{padding:12px 16px;border-radius:0;margin-bottom:6px;font-size:15px;}
.request-form .rf-success{background:#e6f4ea;color:#1e4620;}
.request-form .rf-error{background:#fdecea;color:#611a15;}
.request-form .rf-hp{position:absolute;left:-9999px;opacity:0;}
</style>
<form class="request-form" method="post" action="#request-form" id="request-form">
<?php if ($request_form_sent): ?>
    <div class="rf-notice rf-success">تم استلام طلبك بنجاح، سنتواصل معك قريبًا.</div>
<?php elseif ($request_form_errors): ?>
    <div class="rf-notice rf-error"><?= implode('<br>', array_map('h', $request_form_errors)) ?></div>
<?php endif; ?>
    <input class="rf-hp" type="text" name="website" tabindex="-1" autocomplete="off">
    <input type="text" name="name" placeholder="محمد" required>
    <input type="email" name="email" placeholder="info@skilledcart.com" required>
    <input type="text" name="people" placeholder="6">
    <textarea name="message" placeholder="رسالتك" required></textarea>
    <button type="submit" name="request_form_submit" value="1">إرسال</button>
</form>
