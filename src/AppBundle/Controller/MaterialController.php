<?php

/**************************************************************************
 * MaterialController.php, eSoftLink
 *
 * Mickael Gaillard Copyright 2017
 * Description :
 * Author(s)   : Jonathan Poncy <jonathan.poncy@tactfactory.com>
 * Licence     : All right reserved.
 * Last update : 4 déc. 2017
 *
 **************************************************************************/
namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Repository\MaterialRepository;

/**
 * Controller for Material.
 * @Route("/material")
 */
class MaterialController extends Controller
{

    /**
     * @Route("/")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return ['entities' => $this->getRepository()->findAll(), 'fake' => []];
    }

    /**
     * @Route("/fill")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fill()
    {
        $manager = $this->getManager();

        foreach (['PC E550', 'bloc notes', 'crayon'] as $name) {
            $entity = (new Material())->setName($name)->setType('test');

            $manager->persist($entity);
        }

        $manager->flush();

        return $this->redirectToRoute('app_material_index');
    }

    private function getManager(): \Doctrine\ORM\EntityManager
    {
        return $this->getDoctrine()->getManager();
    }
    private function getRepository(): MaterialRepository
    {
        return $this->getManager()->getRepository(Material::class);
    }
}
