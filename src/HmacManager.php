<?php

namespace Krak\Hmac;

class HmacManager
{
    private $signer;
    private $hasher;
    private $keypair_provider;

    public function __construct(
        HmacSigner $signer,
        HmacHasher $hasher,
        HmacKeyPairProvider $keypair_provider
    ) {
        $this->signer = $signer;
        $this->hasher = $hasher;
        $this->keypair_provider = $keypair_provider;
    }

    public function signRequest(HmacRequest $req, HmacKeyPair $pair)
    {
        $this->signer->signRequest($req, $pair, $this->hasher);
    }

    public function validateRequest(HmacRequest $req)
    {
        $keypair = $this->keypair_provider->getKeyPairFromPublicKey(
            $req->getPublicKey()
        );

        return $this->signer->validateRequest($req, $keypair, $this->hasher);
    }
}
