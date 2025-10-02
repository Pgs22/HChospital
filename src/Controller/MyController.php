<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; //Para salida de datos de un json
use Symfony\Component\HttpFoundation\Response; //Para salida de datos de un boolean
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; //Para la entrada de datos
//use Symfony\Component\HttpFoundation\JsonRequest; //Para entrada de datos de un json si vienen de fuera

//Para identificar que todas las funciones estan en la misma carpeta
//#[Route('/nurse')]
final class MyController extends AbstractController
{
    //JsonResponse formato estandard para todos los ficheros
    #[Route('/nurse/login/', name: 'app_Nurse')]
    //public function login(string $name, string $password): JsonResponse
    public function login(Request $request): JsonResponse
    {

        //************************************************************************************************
        //RECUPERAR PARAMETROS
        //ejemplo: http://localhost:8080/nurse/login?nombreparametro=valor&nombreparametro2=valor2
        // get parameter input(user, password)
        $user = $request->query->get('user');
        $password = $request->query->get('password');                


        //************************************************************************************************
        //RECUPERAR FICHERO JSON
        //Indicamos ruta del json
        $jsonFilePath = $this->getParameter('kernel.project_dir') . '/public/data/nurses.json';
        // compare input con nurses.json
            //Para leer el contenido del archivo
        $jsonContent = file_get_contents($jsonFilePath);
            //Para añadir los objetos json a un array asociativo
        $usersData = json_decode($jsonContent, true);

        //************************************************************************************************
        //PARA BUSCAR Y COMPARAR        
        // Para buscar y comparar datos en la url con datos del array extraídos del json
        foreach ($usersData as $userData) {
            if ($userData['user'] === $user && 
                $userData['password'] === $password) {
                
                $loginSuccess = true;
                break;
            }
        }

        //************************************************************************************************
        //DEVUELVE RESULTADO        
        // Retorna true si coinciden y false sino
        if ($loginSuccess) {
            return new JsonResponse(
                ['success' => true, 'message' => 'True'], 
                status: Response::HTTP_OK // Código 200 OK
            );
        } else {
            // Error 401 Unauthorized o 400 Bad Request
            return new JsonResponse(
                ['success' => false, 'message' => 'False'], 
                status: Response::HTTP_UNAUTHORIZED 
            ); 
        }
        
        /*
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
        //return $nameExists; //Si quiero que me devuelva un boolean en vez de un json
        */
        
    }
}
