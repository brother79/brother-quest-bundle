<?php

/*
 * This file is part of the BrotherQuestBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Brother\QuestBundle\Pager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Pagerfanta\Pagerfanta;
use WhiteOctober\PagerfantaBundle\Twig\PagerfantaExtension;
use Pagerfanta\Exception\NotValidCurrentPageException;

/**
 * Pagerfanta Pager.
 */
abstract class PagerfantaPager implements PagerInterface
{
    /**
     * @var PagerfantaExtension
     */
    protected $pagerExtension = null;

    /**
     * @var string
     */
    protected $html = '';

    /**
     * Constructor.
     *
     * @param PagerfantaExtension $pagerExtension
     */
    public function __construct(PagerfantaExtension $pagerExtension)
    {
        $this->pagerExtension = $pagerExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml()
    {
        return $this->html;
    }


    /**
     * Returns Pager
     *
     * @var \Pagerfanta\Adapter\AdapterInterface   $adapter     Pagerfanta adapter
     * @var integer                                 $offset     query offset
     * @var integer                                 $limit      query limit
     *
     * @return \Pagerfanta\Pagerfanta
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getPager($adapter, $offset, $limit)
    {
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($limit);

        /*
         * If offset is greater than total,
         * set offset to the last page of the results
         */
        $nbPages = $pager->getNbPages();
        $offset = $offset > $nbPages ? $nbPages : $offset;

        try {
            $pager->setCurrentPage($offset);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        // create and set the html links
        $this->html = $this->createPagerHtml($pager);

        return $pager;
    }

    /**
     * Creates the pager html links
     *
     * @param \Pagerfanta\Pagerfanta $pager
     *
     * @return string
     */
    private function createPagerHtml($pager)
    {
        if (null === $pager) {
            return '';
        }

        $html = '';
        if ($pager->haveToPaginate()) {
            $html = '<div class="pagerfanta">'
                .$this->pagerExtension->renderPagerfanta($pager, 'twitter_bootstrap3')
                .'</div>';
        }

        return $html;
    }

}
