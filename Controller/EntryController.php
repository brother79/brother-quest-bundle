<?php

namespace Brother\QuestBundle\Controller;

use Brother\CommonBundle\AppTools;
use Brother\CommonBundle\Controller\BaseController;
use Brother\CommonBundle\Model\BaseApi;
use Brother\CommonBundle\Model\Status;
use Brother\QuestBundle\Form\EntryType;
use Brother\QuestBundle\Model\EntryManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Brother\QuestBundle\Entity\Entry;

/**
 * Entry controller.
 *
 */
class EntryController extends BaseController
{

    /**
     * Shows the entries.
     *
     * @param int $page query offset
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page = 1)
    {
        $manager = $this->getManager();
        $limit = $this->container->getParameter('brother_quest.entry_per_page');
        $entries = $manager->getPaginatedList($page, $limit, array(
            'a' => 'is not null', 
            'state' => Status::STATUS_VALID)
        );
        
        
//        $pagerHtml = $manager->getPaginationHtml();

        
        $form = $this->getFormFactory('entry');

        return $this->render('BrotherQuestBundle:Entry:index.html.twig', array(
                'entries' => $entries,
                'form' => $form->createView(),
//                'pagination_html' => '',//$pagerHtml,
                'date_format' => $this->container->getParameter('brother_quest.date_format')
            )
        );

    }

    /**
     * Creates a new Quest entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Entry();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $result = new BaseApi();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            // notify admin
            if ($this->container->getParameter('brother_quest.notify_admin')) {
                $this->get('brother_quest.mailer')->sendAdminNotification($entity);
            }
            return $this->ajaxResponse($result->addMessage('Ваш вопрос получен. Вы можете задать ещё один.')
                ->addRenderDom('#quest_new_dialog', array('modal' => 'hide'))
                ->result());
        }
        $result->setErrors(AppTools::getFormErrors($form));
        return $this->ajaxResponse($result->result());
    }


    /**
     * Creates a form to create a Entry entity.
     *
     * @param Entry $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entry $entity)
    {
        $form = $this->createForm(new EntryType(get_class($entity)), $entity, array(
            'action' => $this->generateUrl('brother_quest_create_ajax'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Отправить вопрос'));

        return $form;
    }

    /**
     * Displays a form to create a new Quest entity.
     *
     */
    public function newDialogAction()
    {
        $entity = new Entry();
        $form = $this->createCreateForm($entity);

        $result = new BaseApi();

        return $this->ajaxResponse($result
            ->addRenderDom('body', array('appendModal' => $this->render('BrotherQuestBundle:Entry:_new_dialog.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ))->getContent()))
            ->result());
    }

    /**
     * shows login / signup form
     *
     */
    public function executeLast()
    {
        $this->quests = dinCacheManager::getInstance()
            ->getContent('query', 'Quest',
                array(
                    'method' => 'createQueryLast',
                    'limit' => sfConfig::get('app_sv_quest_plugin_last_count')));
    }

    /**
     * @var EntryManagerInterface
     */
    protected $manager = null;

    /**
     * Returns the quest entry manager
     *
     * @return EntryManagerInterface | \Brother\QuestBundle\Entity\EntryManager
     */
    private function getManager()
    {
        if (null === $this->manager) {
            $this->manager = $this->container->get('brother_quest.entry_manager');
        }

        return $this->manager;
    }

    /**
     * Returns the requested Form Factory service
     *
     * @param string $name
     *
     * @return \Symfony\Component\Form\Form
     */
    private function getFormFactory($name)
    {
        return $this->container->get('brother_quest.form_factory.' . $name);
    }

}
