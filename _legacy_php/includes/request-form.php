<?php
$request_form_sent   = false;
$request_form_errors = [];
$name    = '';
$email   = '';
$people  = '';
$message = '';

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
            // Clear on success so the redisplayed form doesn't look like it re-submitted.
            $name = $email = $people = $message = '';
        }
    }
}
?>
<style>
.request-form{width:100%;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;box-sizing:border-box;}
.request-form .rf-field{display:flex;flex-direction:column;gap:7px;color:#fff;font-size:14px;font-weight:700;}
.request-form .rf-field--full,.request-form .rf-notice{grid-column:1/-1;}
.request-form input[type=text],.request-form input[type=email],.request-form textarea{
    width:100%;border:1px solid rgba(33,45,69,.12);border-radius:12px;padding:14px 16px;font-family:inherit;font-size:15px;
    background:#fff;color:#1b2437;box-sizing:border-box;box-shadow:0 6px 18px rgba(15,25,43,.08);
    transition:border-color 150ms ease,box-shadow 150ms ease,background-color 150ms ease;
}
.request-form input::placeholder,.request-form textarea::placeholder{color:#687386;opacity:1;}
.request-form input:focus,.request-form textarea:focus{
    border:1px solid #d97d68;outline:2px solid rgba(217,125,104,.22);outline-offset:2px;
    box-shadow:0 8px 24px rgba(15,25,43,.12);
}
.request-form textarea{min-height:150px;resize:vertical;}
.request-form button{
    grid-column:1/-1;justify-self:start;border:1px solid rgba(255,255,255,.12);border-radius:12px;padding:12px 36px;font-size:16px;font-weight:700;
    background:#d97d68;color:#212d45;cursor:pointer;font-family:inherit;
}
.request-form .rf-notice{padding:12px 16px;border-radius:12px;margin-bottom:4px;font-size:15px;}
.request-form .rf-success{background:#e6f4ea;color:#1e4620;}
.request-form .rf-error{background:#fdecea;color:#611a15;}
.request-form .rf-hp{position:absolute;left:-9999px;opacity:0;}
@media(max-width:600px){
    .request-form{grid-template-columns:1fr;}
    .request-form .rf-field,.request-form .rf-field--full,.request-form button,.request-form .rf-notice{grid-column:1;}
    .request-form button{justify-self:stretch;}
}
</style>
<form class="request-form" method="post" action="#request-form" id="request-form">
<?php if ($request_form_sent): ?>
    <div class="rf-notice rf-success">تم استلام طلبك بنجاح، سنتواصل معك قريبًا.</div>
<?php elseif ($request_form_errors): ?>
    <div class="rf-notice rf-error"><?= implode('<br>', array_map('h', $request_form_errors)) ?></div>
<?php endif; ?>
    <input aria-hidden="true" class="rf-hp" type="text" name="website" tabindex="-1" autocomplete="off">
    <label class="rf-field">
        <span>الاسم</span>
        <input type="text" name="name" placeholder="اكتب اسمك" autocomplete="name" value="<?= h($name) ?>" required>
    </label>
    <label class="rf-field">
        <span>البريد الإلكتروني</span>
        <input type="email" name="email" placeholder="name@example.com" autocomplete="email" value="<?= h($email) ?>" required>
    </label>
    <label class="rf-field rf-field--full">
        <span>عدد الأشخاص <small>(اختياري)</small></span>
        <input type="text" name="people" placeholder="مثال: 6" inputmode="numeric" value="<?= h($people) ?>">
    </label>
    <label class="rf-field rf-field--full">
        <span>تفاصيل الطلب</span>
        <textarea name="message" placeholder="اكتب تفاصيل العربة أو الخدمة المطلوبة" required><?= h($message) ?></textarea>
    </label>
    <button type="submit" name="request_form_submit" value="1">إرسال</button>
</form>
