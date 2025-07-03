<?php
namespace think\migration\command\migrate;

use think\console\input\Argument as InputArgument;
use think\console\Input;
use think\console\Output;
use think\migration\command\Migrate;

class Create extends Migrate
{
    protected function configure()
    {
        $this->setName('migrate:create')
             ->setDescription('Create a new migration')
             ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the migration?')
             ->setHelp(sprintf('%sCreates a new database migration%s', PHP_EOL, PHP_EOL));
    }

    protected function execute(Input $input, Output $output)
    {
        $path = $this->getPath();

        if (!file_exists($path)) {
            if ($this->output->confirm($this->input, 'Create migrations directory? [y]/n')) {
                mkdir($path, 0755, true);
            }
        }

        $this->verifyMigrationDirectory($path);

        $path = realpath($path);
        $className = $input->getArgument('name');

        if (!preg_match('/^[A-Z][A-Za-z0-9]*$/', $className)) {
            throw new \InvalidArgumentException(sprintf('The migration class name "%s" is invalid. Please use CamelCase format.', $className));
        }

        // ✅ Custom implementation to avoid deprecated implode() usage
        $fileName = date('YmdHis') . '_' . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className)) . '.php';
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($filePath)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" already exists', $filePath));
        }

        $template = $this->getTemplate();
        $contents = file_get_contents($template);

        $contents = strtr($contents, [
            '$className' => $className,
        ]);

        if (false === file_put_contents($filePath, $contents)) {
            throw new \RuntimeException(sprintf('The file "%s" could not be written to', $filePath));
        }

        $output->writeln('<info>created</info> .' . str_replace(getcwd(), '', $filePath));
    }

    protected function getTemplate()
    {
        return __DIR__ . '/../stubs/migrate.stub';
    }
}
