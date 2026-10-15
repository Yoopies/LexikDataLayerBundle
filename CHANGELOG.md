# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-10-15

This release contains backward compatibility breaks, see [UPGRADE.md](UPGRADE.md).

### Added

- Symfony 5.4 and 6.x support.
- Twig 3 support.
- GitHub Actions CI testing PHP 7.4 to 8.3 against Symfony 5.4 and 6.4.

### Changed

- `DataLayerManager` now receives the `request_stack` service instead of the `session` service,
  which no longer exists in Symfony 6.
- `UserIdCollector` uses `UserInterface::getUserIdentifier()` when available, and falls back to
  `getUsername()` on Symfony 5.4.
- `DataLayerExtension` extends `Twig\Extension\AbstractExtension` instead of `\Twig_Extension`.
- Service definitions moved from `Resources/config/services.xml` to `Resources/config/services.php`.
- Native return types added to `LexikDataLayerBundle::build()`, `LexikDataLayerExtension::load()`,
  `Configuration::getConfigTreeBuilder()`, `CollectorCompilerPass::process()` and
  `DataLayerExtension::getFunctions()`.
- `symfony/twig-bundle` is now a required dependency.

### Removed

- Support for PHP < 7.2.5.
- Support for Symfony < 5.4.
- Support for Twig 1.x and Twig < 2.10.
- `DataLayerExtension::getName()`.

### Fixed

- Container compilation on Symfony 6 (missing `session` service).
- `UserIdCollector` on Symfony 6 (`getUsername()` removed from `UserInterface`).
