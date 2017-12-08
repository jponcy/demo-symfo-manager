<?php

/**************************************************************************
 * PersonelController.php, Controller
 *
 * Mickael Gaillard Copyright 2017
 * Description :
 * Author(s)   : Dereck Daniel <dereck.daniel@tactfactory.com>
 * Licence     : All right reserved.
 * Last update : 6 déc. 2017
 *
 **************************************************************************/

namespace AppBundle\Controller;

use AppBundle\Entity\Personel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Repository\PersonelRepository;
use AppBundle\Form\PersonelType;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Personel Controller
 * 
 * @Route("/personel")
 * @author dereck
 *
 */
class PersonelController extends Controller
{
    public function form(Personel $entity)
    {
        $form = $this->createForm(PersonelType::class, $entity);
        $form->add('submit', 'submit');
        
        return $form;
    }
    
    /**
     * @Route("/{id}/update")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Personel:create.html.twig")
     */
    public function updateAction(Request $request, Personel $entity)
    {
        return $this->newOrEdit($request, $entity);
    }
    
    /**
     * @Route("/create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        return $this->newOrEdit($request, new Personel());
    }
    
    /**
     * @Route("/{id}/delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Personel $entity)
    {
        $this->getManager()->remove($entity);
        $this->getManager()->flush();
        return $this->redirectToRoute('app_personel_index');
    }
    
    /**
     * @Route("/{id}/view")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:Personel:view.html.twig")
     */
    public function viewAction(Request $request, Personel $entity)
    {
        return ['entities' => $entity];
    }
    
    /**
     * @Route("/")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return ['entities' => $this->getRepository()->findAll()];
    }
    
    private function getManager(): \Doctrine\ORM\EntityManager
    {
        return $this->getDoctrine()->getManager();
    }
    private function getRepository(): PersonelRepository
    {
        return $this->getManager()->getRepository(Personel::class);
    }
    
    private function newOrEdit(Request $request, Personel $entity) {
        $form = $this->form($entity);
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST' && $form->isValid()) {
            $manager = $this->getManager();
            
            $manager->persist($entity);
            $manager->flush();
            
            return $this->redirectToRoute('app_personel_index');
        }
        
        return ['form' => $form->createView()];
    }
    
    
    /**
     * @Route("/fill")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fill()
    {
        $manager = $this->getManager();
        
        foreach (['riri', 'fifi', 'toto'] as $name) {
            echo $name;
            $entity = (new Personel())->setName($name);            
            $manager->persist($entity);
        }
        
        $manager->flush();
        
        return $this->redirectToRoute('app_personel_index');
    }
    
}

