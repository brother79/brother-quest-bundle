<?php

namespace Brother\QuestBundle\Controller;

use Brother\QuestBundle\Model\EntryManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Brother\QuestBundle\Entity\Entry;
use Brother\QuestBundle\Form\QuestType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Entry controller.
 *
 */
class EntryController extends Controller
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
        $entries = $manager->getPaginatedList($page, $limit, array('state' => 1));
        $pagerHtml = $manager->getPaginationHtml();

        $view = $this->getView('frontend.list');
        $form = $this->getFormFactory('entry');

        return $this->render($view, array(
                'entries' => $entries,
                'form' => $form->createView(),
                'pagination_html' => $pagerHtml,
                'date_format' => $this->container->getParameter('brother_quest.date_format')
            )
        );

    }

    /**
     * Creates a new Quest entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Entry();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('brother_quest_show', array('id' => $entity->getId())));
        }

        return $this->render('BrotherQuestBundle:Quest:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Quest entity.
     *
     * @param Entry $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entry $entity)
    {
        $form = $this->createForm(new QuestType(), $entity, array(
            'action' => $this->generateUrl('quest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Quest entity.
     *
     */
    public function newAction()
    {
        $entity = new Entry();
        $form = $this->createCreateForm($entity);

        return $this->render('BrotherQuestBundle:Quest:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function preExecute()
    {
        $this->configuration = new svModelGeneratorConfiguration('Quest', $this->getModuleName(), array(
            'list' => array(
                'title' => 'Ранее заданные вопросы(список)',
                'is_partial' => true,
                'layout' => 'stacked',
                'batch_actions' => false,
                'actions' => false,
                'object_actions' => false,
                'display' => array('q', 'a', 'created_at', 'updated_at'),
                'params' => '
			        <p class="p0" id="qqq%%id%%">
			            <strong>Вопрос</strong>: <span class="quest">%%q%%</span><br/>
			            <strong>Ответ</strong>: <span class="answer">%%a%%</span>
					</p>
				'
            ),
            'filter' => array(
                'class' => false
            ),
            'partials' => array('form_fieldset' => '', 'form_field' => '', 'breadcrumbs' => ''),
            'uri' => array('edit' => 'index', 'new' => 'index')
        ));
        parent::preExecute();
    }


    /**
     * Executes index action
     * @param \sfWebRequest $request
     *
     * @return string|void
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->form = new QuestForm();
        parent::executeIndex($request);
        parent::executeNew($request);
        if ($t = sfConfig::get('app_sv_quest_plugin_template_index', false)) {
            $this->setTemplate($t['template'], $t['module']);
        }
    }

    /**
     * @return Doctrine_Query
     */

    protected function buildQuery()
    {
        $query = parent::buildQuery();
        if (!sfConfig::get('app_sv_quest_plugin_enable_null_answer')) {
            $query->andWhere($query->getRootAlias() . '.a is not null')
                ->andWhere($query->getRootAlias() . '.a<>?', '');
        }
        return $query;
    }

    /**
     * Enter description here...
     *
     * @param sfWebRequest $request
     */

    public function executeCreate(sfWebRequest $request)
    {
        parent::executeCreate($request);
        parent::executeIndex($request);
        $t = sfConfig::get('app_sv_quest_plugin_template_index', array('module' => 'quest', 'template' => 'index'));
        $this->setTemplate($t['template'], $t['module']);
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
     * Adds a new Entry/Show quest form.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $form = $this->container->get('brother_quest.form_factory.entry');

        if ('POST' == $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $entry = $form->getData();

                // check for spam
                if ($this->container->getParameter('brother_quest.enable_spam_detection')) {
                    $spamDetector = $this->container->get('brother_quest.spam_detector');

                    if ($spamDetector->isSpam($entry)) {
                        $this->setFlashMessage('flash.error.spam_detected', array(), 'error');

                        return $this->renderPage('new', array('form' => $form->createView()));
                    }
                }

                // save entry
                if ($this->getManager()->save($entry) !== false) {
                    $this->setFlashMessage('flash.save.success');

                    if (!$this->container->getParameter('brother_quest.auto_publish')) {
                        $this->setFlashMessage('flash.awaiting_approval');
                    }

                    // notify admin
                    if ($this->container->getParameter('brother_quest.notify_admin')) {
                        $this->get('brother_quest.mailer')->sendAdminNotification($entry);
                    }

                    return $this->redirect($this->generateUrl('brother_quest_list'));
                } else {
                    $this->setFlashMessage('flash.error.bad_request', array(), 'error');
                }
            }
        }

        $view = $this->getView('frontend.new');

        return $this->render($view, array('form' => $form->createView()));
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
    public function getManager()
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
    public function getFormFactory($name)
    {
        return $this->container->get('brother_quest.form_factory.' . $name);
    }

    /**
     * Returns the requested View
     *
     * @param string $name
     *
     * @return string
     */
    public function getView($name)
    {
        return $this->container->getParameter('brother_quest.view.' . $name);
    }

    /**
     * Returns the quest entry for a given id
     *
     * @param $id
     *
     * @return EntryInterface
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getEntry($id)
    {
        $quest = $this->getManager()->findOneById($id);

        if (null === $quest) {
            throw new NotFoundHttpException(sprintf("Quest entry with id '%s' does not exists.", $id));
        }

        return $quest;
    }

    /**
     * Translate and set Flash bag message
     *
     * @param string $msg
     * @param array $args
     * @param string $type
     */
    public function setFlashMessage($msg, $args = array(), $type = 'notice')
    {
        $msg = $this->get('translator')->trans($msg, $args, 'BrotherQuestBundle');
        $this->get('session')->getFlashBag()->add($type, $msg);
    }

    /**
     * Set Flash bag message
     *
     * @param string $msg
     * @param string $type
     */
    public function setFlashBag($msg, $type = 'notice')
    {
        $this->get('session')->getFlashBag()->add($type, $msg);
    }


}