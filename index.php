<?php
  require_once('src/config.php');

  $human = false;
  $captchaResponse = null;
  $hCaptcha = new HCaptcha(
    "your_public_key",
    "your_private_key",
    HCaptchaTheme::DARK
  );
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['h-captcha-response'])) {
      $hCaptcha->verify($_POST['h-captcha-response']);
      $captchaResponse = $hCaptcha->getResponse();
      $human = (boolean)$hCaptcha->isHuman();
    }
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>hCaptcha example</title>
    <?= $hCaptcha->getScript() ?>
  </head>
  <body>
    <form method="POST">
      <?php
        $hCaptcha->display();
        var_dump($human);
      ?>
      <input type="submit" name="submit" value="Submit">
    </form>
  </body>
</html>
