<?php

namespace Traits;

trait CryptoTrait
{
    public function crypt(string $passwd): string
    {
        return base64_encode($passwd);
        /** new project */
        //return crypt($passwd, "rl");
    }

    public function validate($passwd, $hash)
    {
        return $passwd === base64_decode($hash->Senha);
        /** new project */
        //return crypt($passwd, $hash) == $hash;
    }
}
