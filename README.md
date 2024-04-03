
<p align="center">
    <img src="https://raw.githubusercontent.com/yanalshoubaki/loqui/main/art/logo.svg" width="400" />
</p>

<p align="center">
    <a href="https://github.com/yanalshoubaki/loqui/actions?query=workflow%3ATests">
        <img src="https://github.com/yanalshoubaki/loqui/workflows/Tests/badge.svg" alt="Tests" />
    </a>
    <a href="https://github.com/yanalshoubaki/loqui/actions/workflows/coding-standards.yml">
        <img src="https://github.com/yanalshoubaki/loqui/actions/workflows/coding-standards.yml/badge.svg" alt="Coding Standards" />
    </a>
</p>

## About Loqui

Laravel is a web application to send messages anonymously and connect with others while protecting your identity. simple, secure messaging.
The code is entirely open source and licensed under [the MIT license](LICENSE.md).


## Requirements

The following tools are required in order to start the installation.

- PHP +8.2
- [Composer](https://getcomposer.org/download/)
- [PNPM](https://pnpm.io/installation)
- [Redis](https://redis.io/docs/install/install-redis/)

## Installation


1. Clone this repository with `git clone git@github.com:yanalshoubaki/loqui.git`
2. Run `composer install` to install the PHP dependencies
3. Set up a local database called `loqui_backend`
4. Run `composer setup` to setup the application
5. Set up a working e-mail driver like smtp
6. Run `pnpm install` to install node modules
7. run `pnpm run build` to build the assets 
8. run `php artisan migrate --seed` to migrate the tables and create required data
9. run `php artisan queue:listen` to listen to jobs that have been fired
10. run `php artisan reverb:start --debug` to start realtime connection
    
## Maintainers

The Loqui application is currently maintained by [Yanal Shoubaki](https://github.com/yanalshoubaki). If you have any questions please don't hesitate to create an issue on this repo.

## Contributing

Please read [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in discussions.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## License

The MIT License. Please see [the license file](LICENSE.md) for more information.