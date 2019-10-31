<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

// ça c'est mon service perso "GenerateurCoordonnees", je vais mettre dedans des fonctions qu'on pourra réutiliser partout ailleurs dans le projet (voire même dans d'autres projets)
class GenerateurCoordonnees
{
    public function generer($ville)
    {
        if (!is_null($ville)) {
            $client = HttpClient::create();

            try {
                if ($ville == 'sqdfsdfsdsdfdf') {
                    throw new Exception('sqdfsdfsdsdfdf');
                }

                $json = $client->request("GET", "https://nominatim.openstreetmap.org/search.php?city=$ville&country=France&format=json", [
                    'timeout' => 15,
                ])->getContent();

                if (empty($json)) {
                    throw new Exception("La requête n'a rien retourné.");
                }
    
                $json = json_decode($json);

                if (!array_key_exists(0, $json)) {
                    throw new Exception("La ville que vous avez renseigné n'a pas été trouvée.", 2);
                }

                return [$json[0]->lat, $json[0]->lon];
                
            }
            catch (TransportExceptionInterface $e) {
                return "La requête n'a pas pu être terminée à temps. Veuillez réessayer d'envoyer le formulaire, ou laissez ce champ vide.";
            }
            catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
