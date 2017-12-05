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
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Repository\MaterialRepository;
use AppBundle\Form\MaterialType;

/**
 * Controller for Material.
 * @Route("/material")
 */
class MaterialController extends Controller
{

    /** Creates then create/edit form. */
    public function form(Material $entity)
    {
      /*
      $formBuilder = $this->createFormBuilder($entity);
      $formBuilder->add('name', 'text', [
        'label' => 'Nom',
        'attr' => [
          'style' => 'color: red'
        ]
      ]);
      $formBuilder->add('type');
      $formBuilder->add('submit', 'submit');
      */
      $form = $this->createForm(MaterialType::class, $entity);
      $form->add('submit', 'submit');

      return $form;
    }

    /**
     * @Route("/create", defaults={"id"=null})
     * @Route("/{id}/update")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request, string $id = null)
    {
        $entity = ($id == null ? new Material() : $this->getRepository()->find($id));

        if ($entity == null) {
          throw $this->createNotFoundException();
        }

        $form = $this->form($entity);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST' && $form->isValid()) {
          $manager = $this->getManager();

          $manager->persist($entity);
          $manager->flush();

          return $this->redirectToRoute('app_material_index');
        }

        return ['form' => $form->createView()];
    }

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
