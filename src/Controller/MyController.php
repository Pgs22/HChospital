<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; //Para salida de datos de un json
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; //Para la entrada de datos


final class MyController extends AbstractController
{
    //JsonResponse formato estandard para todos los ficheros
    #[Route('/nurse/login', name: 'app_Nurse')]

    public function login(Request $request): JsonResponse
    {

        //************************************************************************************************
        //RECUPERAR PARAMETROS
        //ejemplo: http://localhost:8080/nurse/login?user=valor1&password=valor2
        // GET parameter input(user, password)
        $user = $request->request->get('user');
        $password = $request->request->get('password',"");  
      
        //************************************************************************************************
        //RECUPERAR FICHERO JSON
        //Indicamos ruta del json
        $jsonFilePath = $this->getParameter('kernel.project_dir') . '/public/data/nurses.json';
        //Para leer el contenido del json
        $jsonContent = file_get_contents($jsonFilePath);
        //Para añadir los objetos json a un array asociativo
        $usersData = json_decode($jsonContent, true);

        //************************************************************************************************
        //PARA BUSCAR Y COMPARAR        
        // Para buscar y comparar datos en la url con datos del array extraídos del json
        $loginSuccess = false; // Para que sea falso por defecto antes de buscar en el array del json
        //Comparamos y si coincide cambiamos la variable $loginSuccess a true
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
    
    }
}
