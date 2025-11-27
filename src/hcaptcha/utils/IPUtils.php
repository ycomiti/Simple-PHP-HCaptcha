<?php
namespace hcaptcha\utils;

class IPUtils {

  public function getRemoteIP() : ?string {
    return $this->validate(
      isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :
      (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] :
      (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] :
      (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null)))
    );
  }

  protected function validate(string $remoteIp): ?string {
    return (
      (filter_var($remoteIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
      filter_var($remoteIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ?
      $remoteIp : null
    );
  }

}
