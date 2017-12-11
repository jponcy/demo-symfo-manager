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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Repository\MaterialRepository;
use AppBundle\Form\MaterialType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Personel;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as Doc;

/**
 * Controller for Material.
 * @Route("/material")
 */
class MaterialController extends FOSRestController
{
    
    /* Try to serialize with jms + nelmio*/
    /**
     * @Rest\Get("/serializeShow/{id}", name="seria1")
     * 
     * @Doc\ApiDoc(
     *                  ressource=true,
     *                  description="single"
     *                  )
     * 
     * @return \AppBundle\Controller\Response
     */
    public function showAction(Material $data)
    {
        $seria = $this->get('jms_serializer')->serialize($data, 'json');
        $response = new Response($seria);
        $response->headers->set('Content-Type', 'application/json');       
        return $response;
    }
    
    
    /**
     * @Route("/serializeList", name="seria2")
     * 
     * @Doc\Apidoc(ressources=true, description="list")
     * @Method({"GET"})
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $data = $this->getRepository()->findAll();
        $seria = $this->get('jms_serializer')->serialize($data, 'json');
        $response = new Response($seria);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    
    
    
    
    
    
    
    
    /*Action befor serialize*/

    /**
     * Creates then create/edit form.
     */
    public function form(Material $entity)
    {
        /*
         * $formBuilder = $this->createFormBuilder($entity);
         * $formBuilder->add('name', 'text', [
         * 'label' => 'Nom',
         * 'attr' => [
         * 'style' => 'color: red'
         * ]
         * ]);
         * $formBuilder->add('type');
         * $formBuilder->add('submit', 'submit');
         */
        $form = $this->createForm(MaterialType::class, $entity);
        $form->add('submit', 'submit');
        
        return $form;
    }

    /**
     * @Route("/{id}/view")
     * 
     * @method ({"GET", "POST"})
     *         @Template("AppBundle:Material:view.html.twig")
     */
    public function viewAction(Request $request, Material $entity)
    {
        return [
            'entities' => $entity
        ];
    }

    /**
     * @Route("/{id}/update")
     * 
     * @method ({"GET", "POST"})
     *         @Template("AppBundle:Material:create.html.twig")
     */
    public function updateAction(Request $request, Material $entity)
    {
        return $this->newOrEdit($request, $entity);
    }

    /**
     * @Route("/{id}/delete")
     * 
     * @method ({"GET", "POST"})
     */
    public function deleteAction(Material $entity)
    {
        $this->getManager()->remove($entity);
        $this->getManager()->flush();
        return $this->redirectToRoute('app_material_index');
    }

    /**
     * @Route("/create")
     * 
     * @method ({"GET", "POST"})
     *         @Template()
     */
    public function createAction(Request $request)
    {
        return $this->newOrEdit($request, new Material());
    }

    /**
     * @Route("/")
     *
     * @method ("GET")
     *         @Template()
     */
    public function indexAction()
    {
        $data = $this->getRepository()->findAll();
        
        
        return [
            'entities' => $data
        ];
    }

    /**
     * @Route("/fill")
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fill()
    {
        $manager = $this->getManager();
        
        foreach ([
            'PC E550',
            'bloc notes',
            'crayon'
        ] as $name) {
            $pers = (new Personel())->setName($name);
            $entity = (new Material())->setName($name)
                ->setType('test')
                ->setNumber(20)
                ->setPersonel($pers);
            
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

    private function newOrEdit(Request $request, Material $entity)
    {
        $form = $this->form($entity);
        $form->handleRequest($request);
        
        if ($request->getMethod() == 'POST' && $form->isValid()) {
            $manager = $this->getManager();
            
            $manager->persist($entity);
            $manager->flush();
            
            return $this->redirectToRoute('app_material_index');
        }
        
        return [
            'form' => $form->createView()
        ];
    }
}
