<?php
namespace S3Bucket;

use Aws\S3\S3Client;

/**
 * Class AwsS3Client
 * @package S3Bucket
 */
class AwsS3Client
{
    /**
     * @return S3Client
     */
    public function getS3Client()
    {
        $configs = $this->getConfigs();

        $client = new S3Client([
            'region' => $configs['region'],
            'version' => '2006-03-01',
            'credentials' => [
                'key'    => $configs['key'],
                'secret' => $configs['secret']
            ]
        ]);

        return $client;
    }

    /**
     * return array
     */
    public function getConfigs()
    {
        $config = include 'config/local.php';

        return [
            'key' => $config['aws']['s3']['key'],
            'secret' => $config['aws']['s3']['secret'],
            'region' => $config['aws']['s3']['region']
        ];
    }
}