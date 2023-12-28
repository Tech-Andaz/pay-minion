# Pay Minion

Pay Minion is a PHP library developed by Tech Andaz for handling payment gateways across multiple companies.

## Table of Contents

- [Installation](#installation)
- [Integrations](#integrations)
- [License](#license)

## Installation

To install Pay Minion, you can use [Composer](https://getcomposer.org/). Run the following command:

```bash
composer require tech-andaz/pay-minion
```

## Integrations

| Provider | Usage Guide | Version | Type | API Doc |
| -------- | ------- | ------- | ------- | ------- |
|Safe Pay|[Safe Pay Usage Guide](src/SafePay/Usage%20Guide%20SafePay.md)| v1.0.0 | Hosted |[Safe Pay API Docs](https://github.com/getsafepay/safepay-php)|
|UBL|[UBL Usage Guide](src/UBL/Usage%20Guide%20UBL.md)| v1.6 | Hosted| [UBL API Docs](src/UBL/Api%20Docs%20UBL.pdf)|
|PayFast|[PayFast Usage Guide](src/PayFast/Usage%20Guide%20PayFast.md)| - | Hosted| -|
|Alfalah IPG|[Alfalah IPG Usage Guide](src/AlfalahIPG/Usage%20Guide%20AlfalahIPG.md)|  v77 | Hosted|[Alfalah IPG API Docs](https://test-bankalfalah.gateway.mastercard.com/api/documentation/integrationGuidelines/index.html)|
|Alfalah APG|[Alfalah APG Usage Guide](src/AlfalahAPG/Usage%20Guide%20AlfalahAPG.md)| v1.1 | Hosted| [Alfalah APG API Docs](src/AlfalahAPG/Api%20Docs%20Alfalah%20APG.pdf)|

## License

[MIT](https://choosealicense.com/licenses/mit/)

