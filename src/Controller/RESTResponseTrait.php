<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

trait RESTResponseTrait
{
    private function respond($model, int $status = RESPONSE::HTTP_OK)
    {
        $data = SerializerBuilder::create()
            ->build()
            ->toArray($model);

        return $this->json($data, $status);
    }

    protected function success($model)
    {
        $result = [
            'Status' => '200 OK',
            'Message' => 'Successfully fetched',
            'Result' => $model
        ];
        return $this->respond($result);
    }

    protected function created($model)
    {
        $result = [
            'Status' => '201 Created',
            'Message' => 'Successfully added',
            'Result' => $model
        ];
        return $this->respond($result, RESPONSE::HTTP_CREATED);
    }

    protected function bad_request($errors)
    {
        $result = [
            'Status' => '400 Bad Request',
            'Message' => 'Incorrect post data',
            'Errors' => $errors
        ];
        return $this->respond($result, RESPONSE::HTTP_BAD_REQUEST);
    }

    protected function not_found()
    {
        $result = [
            'Status' => '404 Not Found',
            'Message' => 'Nothing to show you buddy',
        ];
        return $this->respond($result, RESPONSE::HTTP_NOT_FOUND);
    }

    protected function no_content()
    {
        $result = [
            'Status' => '204 No Content',
            'Message' => 'Request is ok, but there is no data',
        ];
        return $this->respond($result);
    }
}
