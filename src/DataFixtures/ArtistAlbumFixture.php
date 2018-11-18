<?php
/**
 * Created by PhpStorm.
 * User: visar
 * Date: 18/11/18
 * Time: 12:12
 */

namespace App\DataFixtures;


use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Utils\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtistAlbumFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $json_string = file_get_contents(realpath(__DIR__."/../../data/artist-albums.json"));

        $data = json_decode($json_string, true);

        foreach ($data as $artistList) {
            $artist = new Artist();
            $artist->setName($artistList["name"]);
            $artist->setToken(TokenGenerator::generate(6));

            foreach ($artistList["albums"] as $albums) {
                $album = new Album();
                $album->setTitle($albums['title']);
                $album->setCover($albums['cover']);
                $album->setDescription($albums['description']);
                $album->setToken(TokenGenerator::generate(6));
                $album->setArtist($artist);

                foreach ($albums["songs"] as $songs) {
                    $song = new Song();
                    $song->setTitle($songs['title']);
                    $song->setLength(Song::humanToSeconds($songs["length"]));
                    $song->setArtist($artist);
                    $song->setAlbum($album);

                    $manager->persist($song);
                }

                $manager->persist($album);
            }

            $manager->persist($artist);
        }

        $manager->flush();
    }
}