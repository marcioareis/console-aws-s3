<?php
namespace S3Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Exception;

class S3UploadFilesCommands extends Command
{
    protected function configure()
    {
        $this->setName('s3:upload-files')
            ->setDescription('Faz o upload de pasta/arquivo para um bucket na amazon')
            ->setHelp('Faz o upload de pasta/arquivo para um bucket na Amazon com o nome informado.')
            ->addArgument(
                'bucket-name',
                InputArgument::REQUIRED,
                'Nome do bucket para ser criado'
            )
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Caminho da pasta/arquivo que vai ser feito o upload'
            )
            ->addArgument(
                'upload-path',
                InputArgument::REQUIRED,
                'Caminho onde a pasta/arquivo será salvo no bucket'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getArgument('bucket-name');
        $path = $input->getArgument('path');
        $uploadPath = $input->getArgument('upload-path');
        $service = new S3UploadFiles($bucketName, $path, $uploadPath);

        $io = new SymfonyStyle($input, $output);
        $io->title('Upload de pasta/arquivo');

        try {
            $service->upload();

            $io->success("Upload concluído com sucesso");
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
        }
    }
}