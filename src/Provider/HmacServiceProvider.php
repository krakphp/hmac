<?php

namespace Krak\Hmac\Provider;

use Krak\Hmac,
    Pimple\Container,
    Pimple\ServiceProviderInterface,
    RuntimeException;

class HmacServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['krak.hmac.manager'] = function(Container $app) {
            $p = 'krak.hmac.manager.';

            if (!isset($app[$p.'signer'])) {
                $app[$p.'signer'] = $app['krak.hmac.content_signer'];
            }
            if (!isset($app[$p.'hasher'])) {
                $app[$p.'hasher'] = $app['krak.hmac.std_hasher'];
            }
            if (!isset($app[$p.'key_pair_provider'])) {
                $app[$p.'key_pair_provider'] = $app['krak.hmac.array_key_pair_provider'];
            }

            return new Hmac\HmacManager(
                $app[$p.'signer'],
                $app[$p.'hasher'],
                $app[$p.'key_pair_provider']
            );
        };
        $app['krak.hmac.content_signer'] = function(Container $app) {
            return new Hmac\ContentHmacSigner();
        };
        $app['krak.hmac.std_hasher'] = function(Container $app) {
            $p = 'krak.hmac.std_hasher.';
            if (!isset($app[$p.'alg'])) {
                $app[$p.'alg'] = 'sha256';
            }

            return new Hmac\StdHmacHasher($app[$p.'alg']);
        };
        $app['krak.hmac.array_key_pair_provider'] = function(Container $app) {
            $p = 'krak.hmac.array_key_pair_provider.';

            if (!isset($app[$p.'key_pairs'])) {
                throw new RuntimeException(sprintf('%s is not set', $p.'key_pairs'));
            }

            return new Hmac\ArrayHmacKeyPairProvider($app[$p.'key_pairs']);
        };
    }
}

