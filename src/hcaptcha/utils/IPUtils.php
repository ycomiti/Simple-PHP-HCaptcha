<?php
namespace hcaptcha\utils;

class IPUtils {

  public function getRemoteIP(): ?string {
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) return $this->getValid($_SERVER['HTTP_CF_CONNECTING_IP']);
	if (isset($_SERVER['HTTP_CLIENT_IP'])) return $this->getValid($_SERVER['HTTP_CLIENT_IP']);
	return $this->getValid($_SERVER['REMOTE_ADDR']);
  }

  protected function getValid(?string $ip): ?string {
    if ($ip === null) return null;
    return (
      filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
      filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
    ) ? $ip : null;
  }
  
}