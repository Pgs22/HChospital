<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
//Para identificar que todas las funciones estan en la misma carpeta
#[Route('/nurse')]
final class MyController extends AbstractController
{
    //JsonResponse formato estandard para todos los ficheros
    #[Route('/nurse/login', name: 'app_Nurse')]
    public function login(string $name, string $password): JsonResponse
    {
        // get parameter input(user, pw)

        
            //Indicamos ruta del json
        $jsonFilePath = $this->getParameter('kernel.project_dir') . '/public/data/nurses.json';


        // compare input con nurses.json

        //Para leer el contenido del archivo
        $jsonContent = file_get_contents($jsonFilePath);
        //Para añadir los objetos json a un array asociativo
        $users = json_decode($jsonContent, true);
        //Busca valor name
        $nameExists = false;
        foreach ($users as $user) {
            if (isset($user['name'])) {
                $nameExists = true;
                break;
            }
        }

        // si son iguales ret true , si no false
        return new JsonResponse(['exists' => $nameExists], status: Response::HTTP_OK);
        
        /*
        return $this->json([
            'message' => 'true'
        ]);
        */
    }
}
