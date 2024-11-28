<?php

namespace whitelabeled\PartnerizeApi;

use DateTime;

/**
 * Class Transaction
 * @package whitelabeled\PartnerizeApi
 */
class Transaction
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var DateTime
     */
    public $transactionDate;

    /**
     * @var DateTime
     */
    public $clickDate;

    /**
     * @var DateTime
     */
    public $lastModifiedDate;

    /**
     * @var string
     */
    public $program;

    /**
     * @var
     */
    public $campaignId;

    /**
     * @var string
     */
    public $deviceType;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $publisherReference;

    /**
     * @var
     */
    public $conversionReference;

    /**
     * @var
     */
    public $sourceReferer;

    /**
     * @var double Effective commission for this sale
     */
    public $commissionAmount;


    /**
     * Create a Transaction object from two JSON objects
     * @param array $transData Transaction data
     * @return Transaction
     */
    public static function createFromJson($transData)
    {
        $transaction = new Transaction();

        $transaction->id = (string)$transData['conversion_id'];
        $transaction->campaignId = (string)$transData['campaign_id'];
        $transaction->program = (string)$transData['campaign_title'];
        $transaction->ipAddress = (string)$transData['click']['set_ip'];
        $transaction->publisherReference = (string)$transData['publisher_reference'];
        $transaction->conversionReference = (string)$transData['conversion_reference'];
        $transaction->sourceReferer = (string)$transData['source_referer'];
        $transaction->deviceType = (string)$transData['ref_device'];

        $transaction->transactionDate = self::parseDate($transData['conversion_time']);
        $transaction->clickDate = self::parseDate($transData['click']['set_time']);
        $transaction->lastModifiedDate = self::parseDate($transData['last_modified']);

        $transaction->status = (string)$transData['conversion_value']['conversion_status'];
        $transaction->commissionAmount = (double)$transData['conversion_value']['publisher_commission'];

        return $transaction;
    }

    /**
     * Parse a date
     * @param $date string Date/time string
     * @return DateTime|null
     */
    private static function parseDate($date)
    {
        if ($date == null) {
            return null;
        } else {
            return new \DateTime($date);
        }
    }
}
