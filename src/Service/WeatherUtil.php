<?php
namespace App\Service;

use App\Repository\CountryRepository;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    private CountryRepository $countryRepository;
    private LocationRepository $locationRepository;
    private MeasurementRepository $measurementRepository;

    public function __construct(CountryRepository $countryRepository, LocationRepository $locationRepository,
                                MeasurementRepository $measurementRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    public function getWeatherForCountryAndCity($countryCode, $cityName)
    {
        $countryId = $this->countryRepository->findSingleIdByCode($countryCode);
        $location = $this->locationRepository->findByCountryAndCity($countryId, $cityName);

        $measurements = $this->getWeatherForLocation($location);

        return $measurements;
    }

    public function getWeatherForLocation($location)
    {
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }
}
