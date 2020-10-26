<?php
namespace S3Bucket;

use Aws\S3\S3Client;
use Exception;

class S3CreateBucket
{
    /**
     * @var string
     */
    protected $bucketName;

    /**
     * @var S3Client
     */
    protected $s3Client;

    /**
     * S3CreateBucket constructor.
     * @param $bucketName
     */
    public function __construct($bucketName)
    {
        $this->bucketName = $bucketName;

        $client = new AwsS3Client();
        $this->s3Client = $client->getS3Client();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function createS3Bucket()
    {
        $client = $this->s3Client;
        $name = $this->bucketName;

        $exists = $client->doesBucketExist($name);

        if ($exists) {
            throw new Exception("Já existe um bucket com o nome $name");
        }

        try {
            $client->createBucket([
                'Bucket' => $name,
                'ACL' => 'public-read'
            ]);

            return true;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu um erro ao criar o bucket: $name");
        }
    }
}