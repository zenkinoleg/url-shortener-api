<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Service\UrlShortService;

class IndexController extends AbstractController
{
    use RESTResponseTrait;

    private $service;

    public function __construct(UrlShortService $service)
    {
        $this->service = $service;
    }

    /**
     * About.
     *
     * @return Response
     */
    public function index()
    {
        return $this->success('Url-shortener-api v1.0');
    }

    /**
     * Redirects to original url via UrlShort.
     * Increase clicks counter
     *
     * @return Response
     */
    public function shortRedirect(string $short)
    {
        if ($model = $this->service->loadModel(['short'=>$short])) {
            $this->service->counterUp($model[0]->getShort());

            return new RedirectResponse($model[0]->getUrl());
        }

        return $this->not_found();
    }

    /**
     * Add new UrlShort or return existed.
     *
     * @return Response
     */
    public function postUrl(Request $request)
    {
        if ($errors = $this->service->validateModelFromRequest($request)) {
            return $this->bad_request($errors);
        }

        if ($model = $this->service->loadModelFromRequest($request)) {
            return $this->success($model);
        }

        return $this->created(
            $this->service->createModelFromRequest($request)
        );
    }

    /**
     * Lists all UrlShort.
     *
     * @return Response
     */
    public function getUrlsList(int $page)
    {
        $model = $this->service->loadAll($page-1);
        return $model ? $this->success($model) : $this->no_content();
    }
}
