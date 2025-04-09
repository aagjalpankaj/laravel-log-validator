# Laravel Log Validator

<p align="left">
<a href="https://github.com/aagjalpankaj/laravel-log-validator/actions/workflows/ci.yml">
  <img src="https://github.com/aagjalpankaj/laravel-log-validator/actions/workflows/ci.yml/badge.svg" alt="ci">
</a>
</p>

## About

**Laravel Log Validator** validates logs at runtime without adding any overhead on production environment, helps making logs more concise and consistent across your applications.

It not only validates logs but also adds additional application metadata (such as APP_ENV, APP_NAME, etc) that makes log aggregation, searching, and analysis more efficient.

✨ **Monolog power:** It is built on top of [Monolog](https://github.com/Seldaek/monolog), so you don't lose power of monolog.

✨ **No vendor-lock-in:** At any time, you can plug-in and plug-out this package easily without any refactoring.

## Quick-start

- [Installation](./docs/100-INSTALLATION.md)
- [Usage](./docs/200-USAGE.md)
- [Validations](./docs/300-VALIDATIONS.md)
