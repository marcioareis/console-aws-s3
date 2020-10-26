<?php
namespace S3Bucket;

use Aws\S3\S3Client;
use Exception;

/**
 * Class S3UploadFiles
 * @package S3Bucket
 */
class S3UploadFiles
{
    /**
     * @var string
     */
    protected $bucketName;

    /**
     * @var string
     */
    protected $uploadPath;

    /**
     * @var string
     */
    protected $pathToSave;

    /**
     * @var S3Client
     */
    protected $s3Client;

    /**
     * S3UploadFiles constructor.
     * @param $bucketName
     * @param $uploadPath
     * @param $pathToSave
     */
    public function __construct($bucketName, $uploadPath, $pathToSave)
    {
        $this->bucketName = $bucketName;

        $this->uploadPath = $uploadPath;

        $this->pathToSave = $pathToSave;

        $client = new AwsS3Client();
        $this->s3Client = $client->getS3Client();
    }

    /**
     * @throws Exception
     */
    public function upload()
    {
        $path = $this->uploadPath;

        $client = $this->s3Client;
        $exists = $client->doesBucketExist($this->bucketName);

        if (!$exists) {
            throw new Exception("O bucket informado não existe");
        }

        try {
            if (is_dir($path)) {
                $this->uploadFolder($path);
            }

            if (is_file($path)) {
                $this->uploadFile($path);
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

    }

    /**
     * @param $path
     * @throws Exception
     */
    public function uploadFile($path)
    {
        $client = $this->s3Client;
        $name = basename($path);
        $pathToSave = $this->pathToSave;

        if (substr($pathToSave, -1) != '/') {
            $pathToSave = $pathToSave . '/';
        }

        $pathToSave = $pathToSave . $name;

        try {
            $client->putObject([
                'Bucket' => $this->bucketName,
                'Key' => $pathToSave,
                'SourceFile' => $path,
                'ACL' => 'public-read'
            ]);
        } catch (Exception $exception) {
            throw new Exception('Ocorreu um erro ao fazer o upload do arquivo');
        }
    }

    /**
     * @param $path
     * @throws Exception
     */
    public function uploadFolder($path)
    {
        $client = $this->s3Client;

        try {
            $client->uploadDirectory(
                $path,
                $this->bucketName,
                $this->pathToSave,
                ['params' => ['ACL' => 'public-read']]
            );
        } catch (Exception $exception) {
            throw new Exception('Ocorreu um erro ao fazer o upload da pasta');
        }
    }
}