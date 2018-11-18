<?php
/**
 * User: arjeta
 * Date: 18/11/18
 * Time: 12:45
 */

namespace App\Controller;

use App\Entity\Album;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AlbumController extends FOSRestController
{
    /**
     * @param $token
     * @return JsonResponse|Response
     * @Rest\Get(path="/albums/{token}")
     */
    public function getAlbumAction($token)
    {
        $albums = $this->getDoctrine()
            ->getRepository(Album::class)
            ->findBy([
                'token' => $token
            ]);

        if (count($albums)==0) {
            return new JsonResponse([
                "status" => "error",
                "message" => "Could not find album."
            ], 404, [
                'Content-type' => 'application/json'
            ]);
        }

        $albums = $albums[0];

        $data = $this->container->get('jms_serializer')
            ->serialize($albums, 'json');

        $data = json_decode($data, true);

        unset($data["artist"]["albums"]);

        $data = json_encode($data);

        return new Response($data, 200, [
            'Content-type' => 'application/json'
        ]);
    }
}