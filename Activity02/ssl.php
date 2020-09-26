<?php

class ssl
{
    public function decryptItem($item, $key, $status = 'public')
    {
        switch ($status) {
            case 'private':
                $data = openssl_private_decrypt($item, $decrypted, $key);
                break;
            case 'public':
                $data = openssl_public_decrypt($item, $decrypted, $key);
                break;
        }

        if ($data) {
            $item = $decrypted;
        } else {
            $item = '';
        }
        return $item;
    }
}
