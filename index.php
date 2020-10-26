#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use S3Bucket\S3CreateBucketCommands;
use S3Bucket\S3UploadFilesCommands;

$app = new Application('Console PHP CLI S3', 'v1.0');

$app->addCommands([
    new S3CreateBucketCommands(),
    new S3UploadFilesCommands()
]);

$app->run();

