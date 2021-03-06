# BankID SDK library

A SDK for providing BankID services as a RP (Relying party).
Supports the latest v5 features.
  
[![PHP7.1 Ready](https://img.shields.io/badge/PHP71-ready-green.svg)][link-packagist]
[![Latest Stable Version](https://poser.pugx.org/nicklasw/bankid-sdk/v/stable)](https://packagist.org/packages/nicklasw/bankid-sdk)
[![Latest Unstable Version](https://poser.pugx.org/nicklasw/bankid-sdk/v/unstable)](https://packagist.org/packages/nicklasw/bankid-sdk)
[![Build Status](https://travis-ci.org/NicklasWallgren/bankid-sdk.svg?branch=master)](https://travis-ci.org/NicklasWallgren/bankid-sdk)
[![License](https://poser.pugx.org/nicklasw/bankid-sdk/license)](https://packagist.org/packages/nicklasw/bankid-sdk)

# Installation
The library can be installed through `composer` 
```bash
composer require nicklasw/bankid-sdk
```

# Features
- Supports all v5 features
- Supports asynchronous and parallel requests

# Examples 

## Initiate authenticate request
```php
$client = new Client(new Config(<CERTFICATE>));

$authenticationResponse = $client->authenticate(new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>));

if (!$authenticationResponse->isSuccess()) {
    var_dump($authenticationResponse->getErrorCode(), $authenticationResponse->getDetails());

    return;
}

$collectResponse = $authenticationResponse->collect(); 
```

## Execute parallel requests
```php
$client = new ClientAsynchronous(new Config(<CERTFICATE>));

$promises[] = $client->authenticate(new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>));
$promises[] = $client->authenticate(new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>));

// Parallel requests, authenticate users
foreach (unwrap($promises) as $result) {
    /**
     * @var AuthenticationResponse $result
     */
    var_dump($result->isSuccess());
}
```

# Certificates
The web service API can only be accessed by a RP that has a valid SSL client certificate. The RP certificate is obtained from the
bank that the RP has purchased the BankID service from.

## Generate PEM certificate
```bash
openssl pkcs12 -in <filename>.pfx -out <cert>.pem -nodes
```

## Docker 
```bash
make && make bash
```

## Unit tests
```bash
composer run test
```

## Contributing
  - Fork it!
  - Create your feature branch: `git checkout -b my-new-feature`
  - Commit your changes: `git commit -am 'Useful information about your new features'`
  - Push to the branch: `git push origin my-new-feature`
  - Submit a pull request

## Contributors
  - [Nicklas Wallgren](https://github.com/NicklasWallgren)
  - [All Contributors][link-contributors]

[ico-downloads]: https://img.shields.io/packagist/dt/nicklasw/bankid-sdk.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/nicklasw/bankid-sdk
[link-contributors]: ../../contributors