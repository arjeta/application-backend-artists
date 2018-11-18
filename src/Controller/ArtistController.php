<?php
/**
 * User: arjeta
 * Date: 18/11/18
 * Time: 12:45
 */

namespace App\Controller;

use App\Entity\Artist;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends FOSRestController
{
    /**
     * @return Response
     * @Rest\Get(path="/artists")
     */
    public function listAction()
    {
        $artists = $this->getDoctrine()
            ->getRepository(Artist::class)
            ->findAll();

        if (count($artists)==0) {
            return new JsonResponse([
                "status" => "success",
                "message" => "Artist list is empty"
            ], 204, [
                'Content-type' => 'application/json'
            ]);
        }

        $data = $this->container->get('jms_serializer')
            ->serialize($artists, 'json');

        return new Response($data, 200, [
            'Content-type' => 'application/json'
        ]);
    }

    /**
     * @param string $token
     * @return Response
     * @Rest\Get(path="/artists/{token}")
     */
    public function getArtistAction($token)
    {
        $artist = $this->getDoctrine()
            ->getRepository(Artist::class)
            ->findBy([
                'token' => $token
            ]);

        if (count($artist)==0) {
            return new JsonResponse([
                "status" => "error",
                "message" => "Could not find artist"
            ], 404, [
                'Content-type' => 'application/json'
            ]);
        }

        $data = $this->container->get('jms_serializer')
            ->serialize($artist, 'json');

        return new Response($data, 200, [
            'Content-type' => 'application/json'
        ]);
    }
}