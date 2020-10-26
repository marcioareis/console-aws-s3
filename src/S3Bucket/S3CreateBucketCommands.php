<?php
namespace S3Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Exception;

class S3CreateBucketCommands extends Command
{
    protected function configure()
    {
        $this->setName('s3:create-bucket')
            ->setDescription('Cria um novo bucket na amazon')
            ->setHelp('Cria um novo bucket na Amazon com o nome informado.')
            ->addArgument(
                'bucket-name',
                InputArgument::REQUIRED,
                'Nome do bucket para ser criado'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getArgument('bucket-name');
        $service = new S3CreateBucket($bucketName);

        $io = new SymfonyStyle($input, $output);
        $io->title('Criação de Bucket');

        try {
            $service->createS3Bucket();

            $io->success("Bucket $bucketName criado com sucesso!");
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
        }
    }
}