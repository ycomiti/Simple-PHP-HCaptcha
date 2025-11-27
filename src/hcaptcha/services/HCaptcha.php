<?php
namespace hcaptcha\services;

use \hcaptcha\enums\HCaptchaSize;
use \hcaptcha\enums\HCaptchaTheme;
use \hcaptcha\utils\IPUtils;

class HCaptcha extends IPUtils {

  private string $url;
  private HCaptchaTheme $theme;
  private HCaptchaSize $size;
  private string $scriptUrl;
  private string $publicKey;
  private string $secretKey;
  private ?string $remoteIp;
  private ?string $response;
  private bool $human;

  public function __construct(
    string $publicKey,
    string $secretKey,
    ?HCaptchaTheme $theme = null,
    ?HCaptchaSize $size = null,
    ?string $url = null,
    ?string $scriptUrl = null
  ) {
    $this->theme = $theme ?? HCaptchaTheme::LIGHT;
    $this->size = $size ?? HCaptchaSize::NORMAL;
    $this->url = $url ?? "https://hcaptcha.com/siteverify";
    $this->scriptUrl = $scriptUrl ?? "https://hcaptcha.com/1/api.js";
    $this->publicKey = $publicKey;
    $this->secretKey = $secretKey;
    if (($this->remoteIp = $this->getUserIP()) === null)
      throw new Exception("Unable to retrieve the real user's IP address.");
  }

  public function verify($response): void {
    try {
      $data = [
        'secret' => $this->secretKey,
        'response' => $response,
        'remoteip' => $this->getRemoteIp()
      ];
      $options = [
        'http' => [
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data),
        ],
      ];
      $context  = stream_context_create($options);
      $result = file_get_contents($this->url, false, $context);
      $resultJson = json_decode($result);
      $this->response = json_encode($resultJson, JSON_PRETTY_PRINT);
      $this->human = (boolean)$resultJson->success;
      return;
    } catch (Exception $e) {
      throw new Exception(sprintf("Failed to verify Captcha: %s", $e));
    }
    $this->human = false;
  }

  public function getTheme(): HCaptchaTheme { return $this->theme; }

  public function getSize(): HCaptchaSize { return $this->size; }

  public function getScript(): string { return sprintf("<script src=\"%s\" async defer></script>", htmlspecialchars($this->getScriptUrl())); }

  public function getScriptUrl(): string { return $this->scriptUrl; }

  public function display(): void { echo($this->getHtml()); }

  public function getHtml(): string {
    return sprintf(
      "<div class=\"h-captcha\" data-theme=\"%s\" data-size=\"%s\" data-sitekey=\"%s\"></div>",
      strtolower($this->getTheme()->name),
      strtolower($this->getSize()->name),
      htmlspecialchars($this->getPublicKey())
    );
  }

  public function getRemoteIp(): ?string { return $this->remoteIp; }

  public function getPublicKey(): string { return $this->publicKey; }

  public function getSecretKey(): string { return $this->secretKey; }

  public function getResponse(): ?string { return $this->response; }

  public function isHuman(): bool { return $this->human; }

}
