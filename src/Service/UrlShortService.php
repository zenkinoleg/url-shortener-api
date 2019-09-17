<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\UrlShort;
use App\Repository\UrlShortRepository;

class UrlShortService
{
    private $repository;
    private $em;
    private $validator;

    public function __construct(
        UrlShortRepository $repository,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->em = $em;
        $this->validator = $validator;
    }

    public function loadAll($page = 0)
    {
        return $this->repository->findAllPaginated($page);
    }

    public function loadModel(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function counterUp(string $short)
    {
        return $this->repository->clicksUp($short);
    }

    public function persistModel($model)
    {
        $this->em->persist($model);
        $this->em->flush();
    }

    public function validateModelFromRequest(Request $request)
    {
        $json = $this->requestToData($request);

        $validatorErrors = $this->validator->validate(
            (new UrlShort())
                ->setUrl($json->url)
        );

        foreach ($validatorErrors as $violation) {
            $errors[] = $violation->getMessage();
        }

        return $errors ?? null;
    }

    public function loadModelFromRequest(Request $request)
    {
        $json = $this->requestToData($request);

        return $this->loadModel([
            'url' => $json->url
        ]);
    }

    public function createModelFromRequest(Request $request)
    {
        $json = $this->requestToData($request);

        $model = (new UrlShort())
            ->setUrl($json->url)
            ->setShort($this->getRandomStr());
        $this->persistModel($model);

        return $model;
    }

    /**
     * Random crypto-save string generator.
     * !!! Doesn't really belong here and must be
     * !!! carry out some place else at some point
     *
     * @return string
     */
    public function getRandomStr(int $length = 3) : string
    {
        return base64_encode(bin2hex(random_bytes($length)));
    }

    /**
     * Request to JSON/array helper.
     * !!! Doesn't really belong here and must be
     * !!! carry out some place else at some point
     *
     * @return mixed
     */
    public function requestToData(Request $request, $as_array = 0)
    {
        return json_decode(
            $request->getContent(),
            $as_array
        );
    }
}
