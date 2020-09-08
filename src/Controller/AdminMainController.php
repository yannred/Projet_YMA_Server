<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminMainController extends AbstractController
{
    const ACCES_ERROR_CODE = 403;

    /**
     * @Route("/admin/adminMain", name="admin_main")
     */
    public function index()
    {
        $roles = $this->getUser()->getRoles();
        for ($i = 0; $i < count($roles); $i++) {
            if ($roles[$i] == "ROLE_ADMIN") {
                return new JsonResponse(['reponse' => 'Adminnistrateur vérifié']);
            }
        }
        return new JsonResponse(['L\'utilisateur n\'est pas un administrateur'], self::ACCES_ERROR_CODE);
    }
}
