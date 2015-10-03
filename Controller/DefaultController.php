<?php

namespace Ferchoz\WebEntityBundle\Controller;

use Ferchoz\WebEntityBundle\Entity\Entity;
use Ferchoz\WebEntityBundle\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Doctrine\DBAL\Types\Type;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;


class DefaultController extends Controller
{
    /**
     * @Route("/new")
     */
    public function indexAction(Request $request)
    {
        $entity  = new Entity();
        $bundles = $this->getBundles();
        $types   = $this->getTypes();
        $form    = $this->createForm(new EntityType($bundles, $types), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $response = $this->createEntity($entity);
            $request->getSession()->getFlashBag()->add(
                'notice',
                $response
            );
        }

        return $this->render("FerchozWebEntityBundle:Default:new.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    private function createEntity(Entity $entity)
    {
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $fields = array();

        foreach ($entity->getFields() as $field) {
            $fields[] = $field->getString();
        }

        $entityName     = $entity->getBundle().":".$entity->getName();
        $entityFields   = implode(" ", $fields);

        $input = new ArrayInput(array(
            'command'               => 'doctrine:generate:entity',
            '--no-interaction'      => '',
            '--entity'              => $entityName,
            '--fields'              => $entityFields,
        ));

        $output = new StreamOutput(tmpfile(), StreamOutput::VERBOSITY_NORMAL, true);
        $application->run($input, $output);

        $converter = new AnsiToHtmlConverter();
        rewind($output->getStream());
        $content = stream_get_contents($output->getStream());
        fclose($output->getStream());

        return $converter->convert($content);
    }

    private function getBundles()
    {
        $finder = new Finder();
        $scrDir = $this->get('kernel')->getRootDir() . "/../src";
        $finder->files()->in($scrDir)->name('*Bundle.php');
        $bundles = array();
        foreach ($finder as $file) {
            $bundleName = str_replace("\\", "", $file->getRelativePath());
            $bundles[$bundleName] = $bundleName;
        }

        return $bundles;
    }

    private function getTypes()
    {
        $typesArray = array_keys(Type::getTypesMap());
        $types = array();
        foreach ($typesArray as $type) {
            $types[$type] = $type;
        }

        return $types;
    }
}
