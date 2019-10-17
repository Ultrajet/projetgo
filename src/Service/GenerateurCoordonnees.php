<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

// ça c'est mon service perso "GenerateurCoordonnees", je vais mettre dedans des fonctions qu'on pourra réutiliser partout ailleurs dans le projet (voire même dans d'autres projets)
class GenerateurCoordonnees
{
    public function generer($ville)
    {
        $client = HttpClient::create();

        try {
            $json = $client->request("GET", "https://nominatim.openstreetmap.org/search.php?city=$ville&format=json", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ])->getContent();

            $json = json_decode($json);

            // $user->setCoordonnees("Bonsoir");
            return $json[0]->lat . ", " . $json[0]->lon;
            
        } catch (Exception $e) {
            return false;
        }
    }
}
