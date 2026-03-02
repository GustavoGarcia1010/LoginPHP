<?php
class HashId {
    private static $chave = "8f5e1c2a3b4d5e6f7a8b9c0d1e2f3a4b"; 
    private static $metodo = "aes-256-cbc";

    public static function criptografar($id) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$metodo));
        $criptografado = openssl_encrypt($id, self::$metodo, self::$chave, 0, $iv);
        return bin2hex($iv) . '.' . base64_encode($criptografado);
    }

    public static function descriptografar($hash) {
        try {
            $partes = explode('.', $hash);
            if (count($partes) !== 2) return false;

            $iv = hex2bin($partes[0]);
            $criptografado = base64_decode($partes[1]);
            return openssl_decrypt($criptografado, self::$metodo, self::$chave, 0, $iv);
        } catch (Exception $e) {
            return false;
        }
    }
}