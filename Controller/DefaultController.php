<?php

namespace Ferchoz\WebEntityBundle\Controller;

use Ferchoz\WebEntityBundle\Entity\Entity;
use Ferchoz\WebEntityBundle\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

class DefaultController extends Controller
{
    /**
     * @Route("/new")
     */
    public function indexAction(Request $request)
    {
        $entity = new Entity();

        $form = $this->createForm(new EntityType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $kernel = $this->get('kernel');
            $application = new Application($kernel);
            $application->setAutoExit(false);
            $fields = array();

            foreach ($entity->getFields() as $field) {
                $fields[] = $field->getString();
            }

            $input = new ArrayInput(array(
                'command'               => 'doctrine:generate:entity',
                '--no-interaction'      => '',
                '--entity'              => $entity->getName(),
                '--fields'              => implode(" ", $fields),
            ));
            // You can use NullOutput() if you don't need the output
            $output = new StreamOutput(tmpfile(), StreamOutput::VERBOSITY_NORMAL);
            $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            rewind($output->getStream());
            $content = stream_get_contents($output->getStream());
            fclose($output->getStream());
            var_dump($content);die;
           var_dump($entity);die;
        }

        return $this->render("FerchozWebEntityBundle:Default:new.html.twig", array(
            'form' => $form->createView(),
        ));
    }
}
