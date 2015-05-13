<?php

namespace Brother\QuestBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;

class QuestAdminController extends CRUDController
{

	/**
	 * Enter description here...
	 *
	 * @param sfWebRequest $request
	 */

    public function executeListShowOpen(sfWebRequest $request)
    {
    	$filters = $this->getFilters();
    	$filters['a'] = array('text' => '', 'is_empty' => 1);
    	$filters['status'] = array('created');
    	$this->setFilters($filters);
    	$this->redirect('questAdmin/index');
    }

    public function executeListShowNew(sfWebRequest $request)
    {
    	$filters = $this->getFilters();
    	$filters['a'] = array('text' => '', 'is_empty' => 1);
    	$filters['status'] = array('need_moderate');
    	$this->setFilters($filters);
    	$this->redirect('questAdmin/index');
    }
    
    
    public function executeListShowInProgress(sfWebRequest $request)
    {
    	$filters = $this->getFilters();
    	$filters['a'] = array('text' => '', 'is_empty' => 1);
    	$filters['status'] = array('in_progress');
    	$this->setFilters($filters);
    	$this->redirect('questAdmin/index');
    }

    public function executeListShowResolved(sfWebRequest $request)
    {
    	$filters = $this->getFilters();
    	$filters['a'] = array('text' => '', 'is_empty' => 1);
    	$filters['status'] = array('resolved');
    	$this->setFilters($filters);
    	$this->redirect('questAdmin/index');
    }
    
    public function executeListUpdate(sfWebRequest $request)
    {
    	$object = $this->getRoute()->getObject();
        $object->setUpdatedAt(svUtils::getDate(time()));
        $object->save();
        $this->redirect('questAdmin/index');
    }

    public function executeListApprove(sfWebRequest $request)
    {
    	$object = $this->getRoute()->getObject();
    	$object->setStatus('created');
    	$object->save();
    	$this->redirect('questAdmin/index');
    }    

    /**
     * Set status to freeze
     *
     * @param sfWebRequest $request
     */
    
    public function executeListFreeze(sfWebRequest $request)
    {
    	$object = $this->getRoute()->getObject();
    	$object->setStatus('freeze');
    	$object->save();
    	$this->redirect('questAdmin/index');
    }    
    
    public function executeListInProgress(sfWebRequest $request)
    {
    	$object = $this->getRoute()->getObject();
    	$object->setStatus('in_progress');
    	$object->save();
    	$this->redirect('questAdmin/index');
    }    
    
    public function executeListResolved(sfWebRequest $request)
    {
    	$object = $this->getRoute()->getObject();
    	$object->setStatus('resolved');
    	$object->save();
    	$this->redirect('questAdmin/index');
    }    
    
    
    /**
     * Shows the entries.
     *
     * @param int $page	query offset
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page=1)
    {
        $manager = $this->getManager();
        $limit = $this->container->getParameter('brother_quest.entry_per_page');

        //save current page to reuse later
        $this->get('request')->getSession()->set('brother_quest_page', $page);

        $view = $this->getView('admin.list');
        $form = $this->getFormFactory('entry');

        return $this->render($view, array(
                'form' => $form->createView(),
                'entries'=> $manager->getPaginatedList($page, $limit),
                'pagination_html' => $manager->getPaginationHtml(),
                'date_format' => $this->container->getParameter('brother_quest.date_format')
            )
        );
    }

    /**
     * Edits a entry/Show admin form
     *
     * @param Request	$request	Current request
     * @param int       $id			Guestbook id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Request $request, $id)
    {
        $entry = $this->getEntry($id);
        $form = $this->getFormFactory('edit');
        $form->setData($entry);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $entry = $form->getData();

                if ($this->getManager()->save($entry) !== false) {
                    $this->setFlashMessage('flash.update.success');

                    return $this->redirectToList();
                } else {
                    $this->setFlashMessage('flash.update.error', array(), 'error');
                }
            }
        }

        $view = $this->getView('admin.edit');

        return $this->render($view, array('form' => $form->createView(), 'id'=>$id,) );
    }

    /**
     * Reply a entry/Show reply form
     *
     * @param Request   $request	Current request
     * @param int   	$id			Guestbook id
     *
     * @return Response
     */
    public function replyAction(Request $request, $id)
    {
        $entry = $this->getEntry($id);

        $form = $this->getFormFactory('reply');
        $form->setData($entry);

        $message = $this->get('translator')->trans(
            'email.reply',
            array(
                '%name%'=> $entry->getName(),
                '%comment%'=> $entry->getComment(),
                '%id%'=> $id
            ),
            'BrotherQuestBundle'
        );

        $form->get('message')->setData($message);
        $form->get('senderEmail')->setData($this->container->getParameter('brother_quest.mailer.admin_email'));

        if('POST' == $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                // send reply
                if($this->get('brother_quest.mailer')->sendReply($form, $entry) !== false) {

                    // update reply fields
                    $this->getManager()->updateReplyFields($entry, $form);

                    $this->setFlashMessage('flash.reply.success', array(
                        '%name%'=>$entry->getName(),
                        '%email%'=>$entry->getEmail(),
                    ));

                    return $this->redirectToList();
                } else {
                    $this->setFlashMessage('flash.reply.error', array(), 'error');
                }
            }

        }

        $view = $this->getView('admin.reply');

        return $this->render($view, array('form' => $form->createView(), 'id'=>$id,) );
    }

    /**
     * Delete entry
     *
     * @param int $id Guestbook id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $entry = $this->getEntry($id);

        if($this->getManager()->remove($entry) !== false) {
            $this->setFlashMessage('flash.remove.success');
        } else {
            $this->setFlashMessage('flash.remove.error', array('%id%'=>$id), 'error');
        }

        return $this->redirectToList();
    }

    /**
     * Delete a list of entries
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $ids = $request->get('ids', array());

        if (empty($ids)) {
            $this->setFlashMessage('flash.select_error.delete');

            return $this->redirectToList();
        }

        if ($this->getManager()->delete($ids) !== false) {
            $nbEntries = count($ids);
            $translated = $this->get('translator')->transChoice(
                'flash.delete.success',
                $nbEntries,
                array('%count%' => $nbEntries),
                'BrotherQuestBundle'
            );

            $this->get('session')->getFlashBag()->add('notice', $translated);
        } else {
            $this->setFlashMessage('flash.delete.error', array('%ids%'=>implode(', ', $ids)), 'error');
        }

        return $this->redirectToList();
    }

    /**
     * Publish/Unpublish a list of entries
     *
     * @param Request   $request
     * @param integer   $state
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeStateAction(Request $request, $state)
    {
        $ids = $request->get('ids', array());

        if (!is_array($ids)) {
            $ids = array($ids);
        }

        $task = $state ? 'publish' : 'unpublish';

        if (empty($ids)) {
            $this->setFlashMessage('flash.select_error.' . $task);
        } else {
            if ($this->getManager()->updateState($ids, $state) !== false) {
                $nbEntries = count($ids);
                $translated = $this->get('translator')->transChoice(
                    'flash.' . $task . '.success',
                    $nbEntries,
                    array('%count%' => $nbEntries),
                    'BrotherQuestBundle'
                );

                $this->get('session')->getFlashBag()->add('notice', $translated);

            } else {
                $this->setFlashMessage('flash.' . $task . 'error', array('%ids%'=>implode(', ', $ids)));
            }
        }

        return $this->redirectToList();
    }

    /**
     * Cancel edit
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function cancelAction()
    {
        return $this->redirectToList();
    }

    /**
     * Redirect to last viewed list page
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    function redirectToList()
    {
        return $this->redirect(
            $this->generateUrl(
                'brother_quest_admin',
                array('page' => $this->get('request')->getSession()->get('brother_quest_page', 1))
            ));
    }
}
