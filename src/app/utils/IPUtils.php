<?php
  class IPUtils {
      public function getUserIP() : ?string {
        $userIP = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :
                 (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] :
                 (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] :
                 (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null)));
        return (filter_var($userIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
                filter_var($userIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? $userIP : null;
      }
  }
