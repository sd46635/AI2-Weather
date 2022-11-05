<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-and-city',
    description: 'Add a short description for your command',
)]
class WeatherCountryAndCityCommand extends Command
{
    public function __construct(WeatherUtil $weatherUtil, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country_code', InputArgument::REQUIRED,
                'Country code for which to get the measurements')
            ->addArgument('city_name', InputArgument::REQUIRED,
                'City for which to get the measurements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('country_code');
        $cityName = $input->getArgument('city_name');

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $cityName);
        foreach ($measurements as $measurement)
            $io->text($measurement);

        return Command::SUCCESS;
    }
}
