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
|Safe Pay Embedded|[Safe Pay Embedded Usage Guide](src/SafePayEmbedded/Usage%20Guide%20SafePayEmbedded.md)| v2.0.0 | Embedded |[Safe Pay Embedded API Docs](https://github.com/getsafepay/sfpy-php)|
|UBL|[UBL Usage Guide](src/UBL/Usage%20Guide%20UBL.md)| v1.6 | Hosted| [UBL API Docs](src/UBL/Api%20Docs%20UBL.pdf)|
|PayFast|[PayFast Usage Guide](src/PayFast/Usage%20Guide%20PayFast.md)| - | Hosted| -|
|Alfalah IPG|[Alfalah IPG Usage Guide](src/AlfalahIPG/Usage%20Guide%20AlfalahIPG.md)|  v77 | Hosted|[Alfalah IPG API Docs](https://test-bankalfalah.gateway.mastercard.com/api/documentation/integrationGuidelines/index.html)|
|Alfalah APG|[Alfalah APG Usage Guide](src/AlfalahAPG/Usage%20Guide%20AlfalahAPG.md)| v1.1 | Hosted| [Alfalah APG API Docs](src/AlfalahAPG/API%20Docs%20Alfalah%20APG.pdf)|
|JazzCash|[JazzCash Usage Guide](src/JazzCash/Usage%20Guide%20JazzCash.md)| v2.0 | Both | [JazzCash API Docs](src/JazzCash/API%20Docs%20JazzCash.pdf)|
|AbhiPay|[AbhiPay Usage Guide](src/AbhiPay/Usage%20Guide%20AbhiPay.md)| v3.0 | Hosted | [AbhiPay API Docs](https://docs.abhipay.com.pk/)|
|BaadMay|[BaadMay Usage Guide](src/BaadMay/Usage%20Guide%20BaadMay.md)| v1.0 | Hosted | [BaadMay API Docs](src/BaadMay/API%20Docs%20BaadMay.pdf)|

## License

[MIT](https://choosealicense.com/licenses/mit/)

