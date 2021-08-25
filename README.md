# Partnerize API client

[![Latest Stable Version](https://img.shields.io/packagist/v/whitelabeled/partnerize-api-client.svg)](https://packagist.org/packages/whitelabeled/partnerize-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/whitelabeled/partnerize-api-client.svg)](https://packagist.org/packages/whitelabeled/partnerize-api-client)
[![License](https://img.shields.io/packagist/l/whitelabeled/partnerize-api-client.svg)](https://packagist.org/packages/whitelabeled/partnerize-api-client)

Library to retrieve sales from the Partnerize publisher API.

Usage:

```php
<?php
require 'vendor/autoload.php';

$client = new \whitelabeled\PartnerizeApi\PartnerizeClient('username', 'password', '1000l1234');

$transactions = $client->getTransactions(new DateTime('2021-08-24 00:00:00'));

/*
 * Returns:
Array
(
    [0] => whitelabeled\PartnerizeApi\Transaction Object
        (
            [id] => 1000l100000000
            [transactionDate] => DateTime Object
                (
                    [date] => 2021-08-25 09:30:00.000000
                    [timezone_type] => 3
                    [timezone] => Europe/Amsterdam
                )
        
            [clickDate] => DateTime Object
                (
                    [date] => 2021-08-25 09:00:00.000000
                    [timezone_type] => 3
                    [timezone] => Europe/Amsterdam
                )
        
            [approvalDate] =>
            [lastModifiedDate] => DateTime Object
                (
                    [date] => 2021-08-25 10:00:00.000000
                    [timezone_type] => 3
                    [timezone] => Europe/Amsterdam
                )
        
            [program] => Advertisement Campaign
            [campaignId] =>
            [deviceType] =>
            [ipAddress] =>
            [status] => pending
            [publisherReference] => akshdjkashdkjasf
            [conversionReference] => 000000000.000000000
            [sourceReferer] => domain
            [commissionAmount] => 50
        )

)
*/
```

## License

© Goldlabeled BV

MIT license, see [LICENSE.txt](LICENSE.txt) for details.
