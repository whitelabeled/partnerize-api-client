<?php

namespace whitelabeled\PartnerizeApi;

use DateTime;
use Psr\Http\Message\ResponseInterface;

class PartnerizeClient
{

    private $username;
    private $password;

    protected $publisherId;
    protected $endpoint = 'https://api.partnerize.com';

    /**
     * DaisyconClient constructor.
     * @param $username    string Partnerize application key
     * @param $password    string User api key
     * @param $publisherId string Publisher ID
     */
    public function __construct($username, $password, $publisherId)
    {
        $this->username = $username;
        $this->password = $password;
        $this->publisherId = $publisherId;
    }

    /**
     * Get all transactions from $startDate until $endDate.
     *
     * @param DateTime $startDate Start date
     * @param DateTime|null $endDate End date, optional.
     * @param string $timezone Timezone, optional. Enforces timezone.
     * @return array Transaction objects. Each part of a transaction is returned as a separate Transaction.
     * @throws PartnerizeApiException
     */
    public function getTransactions(DateTime $startDate, DateTime $endDate = null, $timezone = "Europe/Paris")
    {
        $params = [
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'timezone' => $timezone,
        ];

        if ($endDate != null) {
            $params['end_date'] = $endDate->format('Y-m-d H:i:s');
        }

        $query = '?' . http_build_query($params);
        $response = $this->makeRequest("/reporting/report_publisher/publisher/{$this->publisherId}/conversion.json", $query);

        $transactions = [];

        // Decode JSON response:
        $transactionsData = json_decode($response->getBody()->getContents(), true);

        if ($transactionsData == null) {
            throw new PartnerizeApiException('Invalid data (could not decode JSON)');
        }

        foreach ($transactionsData['conversions'] as $singleTransactionData) {
            $transaction = Transaction::createFromJson($singleTransactionData['conversion_data']);
            $transactions[] = $transaction;
        }

        return $transactions;
    }

    /**
     * @param        $resource
     * @param string $query
     * @return ResponseInterface
     * @throws PartnerizeApiException
     */
    protected function makeRequest($resource, $query = "")
    {
        $uri = $this->endpoint . $resource;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $uri . $query, [
            'auth' => [$this->username, $this->password],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() != 200) {
            if ($response->getStatusCode() == 401) {
                throw new PartnerizeApiException('Invalid credentials');
            }
            throw new PartnerizeApiException('Invalid response: HTTP status ' . $response->getStatusCode());
        }

        return $response;
    }
}
